<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use RuntimeException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

class ThinkwindsEncrypter implements EncrypterContract
{
    /**
     * The encryption key.
     *
     * @var string
     */
    protected $key;

    /**
     * The algorithm used for encryption.
     *
     * @var string
     */
    protected $cipher;

    /**
     * Create a new encrypter instance.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return void
     *
     * @throws \RuntimeException
     */
    public function __construct($key, $cipher = 'AES-128-CBC')
    {
        $key = (string) $key;
        if (static::supported($key, $cipher)) 
        {
            $this->key = $key;
            $this->cipher = $cipher;
        } else {
            throw new RuntimeException('The only supported ciphers are AES-128-CBC and AES-256-CBC with the correct key lengths.');
        }
    }

    /**
     * Determine if the given key and cipher combination is valid.
     *
     * @param  string  $key
     * @param  string  $cipher
     * @return bool
     */
    public static function supported($key, $cipher)
    {
        $length = mb_strlen($key, '8bit');
        return ($cipher === 'AES-128-CBC' && $length === 16) ||
               ($cipher === 'AES-256-CBC' && $length === 32);
    }

    /**
     * Create a new encryption key for the given cipher.
     *
     * @param  string  $cipher
     * @return string
     */
    public static function generateKey($cipher)
    {
        return self::randomString($cipher == 'AES-128-CBC' ? 16 : 32);
    }


    public static function randomString($length = 4, $intmode = false)
    {
        $hash = '';
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $intmode and $chars = "0123456789";
        $max = strlen($chars) - 1;
        PHP_VERSION < '4.2.0' && mt_srand(( double )microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) 
        {
            $hash .= $chars [mt_rand(0, $max)];
        }
        return $hash;
    }

    /**
     * Encrypt the given value.
     *
     * @param  mixed  $value
     * @param  bool  $serialize
     * @return string
     *
     * @throws \Illuminate\Contracts\Encryption\EncryptException
     */
    public function encrypt($value, $serialize = false)
    {
        $iv = self::randomString(openssl_cipher_iv_length($this->cipher));
        if(is_array($value)) 
        {
            $serialize = true;
        }
        // First we will encrypt the value using OpenSSL. After this is encrypted we
        // will proceed to calculating a MAC for the encrypted value so that this
        // value can be verified later as not having been changed by the users.
        $value = \openssl_encrypt(
            $serialize ? serialize($value) : $value,
            $this->cipher, $this->key, 0, $iv
        );
        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }
        // Once we get the encrypted value we'll go ahead and base64_encode the input
        // vector and create the MAC for the encrypted value so we can then verify
        // its authenticity. Then, we'll JSON the data into the "payload" array.
        $mac = $this->hash($iv = base64_encode($iv), $value);
        $sl = $serialize;
        $json = json_encode(compact('iv', 'value', 'mac', 'sl'));
        if (json_last_error() !== JSON_ERROR_NONE) 
        {
            throw new EncryptException('Could not encrypt the data.');
        }
        return base64_encode($json);
    }

    /**
     * Encrypt a string without serialization.
     *
     * @param  string  $value
     * @return string
     */
    public function encryptString($value)
    {
        return $this->encrypt($value, false);
    }

    /**
     * Decrypt the given value.
     *
     * @param  mixed  $payload
     * @param  bool  $unserialize
     * @return string
     *
     * @throws \Illuminate\Contracts\Encryption\DecryptException
     */
    public function decrypt($payload, $unserialize = false)
    {
        $payload = $this->getJsonPayload($payload);
        if(tw_message_verify($payload)) 
        {
            return $payload;
        }
        $iv = base64_decode($payload['iv']);
        // Here we will decrypt the value. If we are able to successfully decrypt it
        // we will then unserialize it and return it out to the caller. If we are
        // unable to decrypt this value we will throw out an exception message.
        $decrypted = \openssl_decrypt(
            $payload['value'], $this->cipher, $this->key, 0, $iv
        );
        if ($decrypted === false) 
        {
            //throw new DecryptException('Could not decrypt the data.');
            return tw_message('Could not decrypt the data.', 'error');
        }
        if(isset($payload['sl'])) 
        {
            $unserialize = $payload['sl'];
        }
        return $unserialize ? unserialize($decrypted) : $decrypted;
    }

    /**
     * Decrypt the given string without unserialization.
     *
     * @param  string  $payload
     * @return string
     */
    public function decryptString($payload)
    {
        return $this->decrypt($payload, false);
    }

    /**
     * Create a MAC for the given value.
     *
     * @param  string  $iv
     * @param  mixed  $value
     * @return string
     */
    protected function hash($iv, $value)
    {
        return hash_hmac('sha256', $iv.$value, $this->key);
    }

    /**
     * Get the JSON array from the given payload.
     *
     * @param  string  $payload
     * @return array
     *
     * @throws \Illuminate\Contracts\Encryption\DecryptException
     */
    protected function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true);
        // If the payload is not valid JSON or does not have the proper keys set we will
        // assume it is invalid and bail out of the routine since we will not be able
        // to decrypt the given value. We'll also check the MAC for this encryption.
        if (! $this->validPayload($payload)) 
        {
            //throw new DecryptException('The payload is invalid.');
            return tw_message('The payload is invalid.', 'error');
        }
        if (! $this->validMac($payload)) 
        {
            //throw new DecryptException('The MAC is invalid.');
            return tw_message('The MAC is invalid.', 'error');
        }
        return $payload;
    }

    /**
     * Verify that the encryption payload is valid.
     *
     * @param  mixed  $payload
     * @return bool
     */
    public function validPayload($payload)
    {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
               strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->cipher);
    }

    /**
     * Determine if the MAC for the given payload is valid.
     *
     * @param  array  $payload
     * @return bool
     */
    public function validMac(array $payload)
    {
        $calculated = $this->calculateMac($payload, $bytes = self::randomString(16));
        return hash_equals(
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated
        );
    }

    /**
     * Calculate the hash of the given payload.
     *
     * @param  array  $payload
     * @param  string  $bytes
     * @return string
     */
    protected function calculateMac($payload, $bytes)
    {
        return hash_hmac(
            'sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true
        );
    }

    /**
     * Get the encryption key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public static function getCipherLength($cipher = '')
    {   
        $cipher = $cipher ? $cipher : $this->cipher;
        return $cipher == 'AES-128-CBC' ? 16 : 32;
    }
}
