<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Model;

use Cache; 
use Illuminate\Database\Eloquent\Model;

class ConfigModel extends Model
{
    protected $table = 'config';
    protected $fillable = [
        'name', 'namespace', 'value', 'vtype', 'desc', 'issystem', 'module'
    ];
    public $timestamps = false;

    /**
     * 根据空间名字获得该配置信息
     *
     * @param stirng $namespace 空间名字
     * @return array
     */
    static function getConfigByNamespace($namespace) 
    {
        $data = ConfigModel::where('namespace', $namespace)->get();
        if (!empty($data)) 
        {
            return $data;
        }
        return [];
    }

    /**
     * 获取某个配置
     *
     * @param string $namespace
     * @param string $name
     * @return array
     */
    static function getConfigByName($namespace, $name) 
    {
        $info = ConfigModel::where('namespace', $namespace)
                                    ->where('name', $name)
                                    ->first();
        if (!empty($info)) 
        {
            return $info;
        }
        return [];
    }
    
    /**
     * 批量设置配置项
     *
     * @param array $data 待设置的配置项
     * @return boolean
     */
    static function storeConfigs($data) 
    {
        foreach ($data as $value) 
        {
            $value['issystem'] = isset($value['issystem']) && $value['issystem'] ? intval($value['issystem']) : 0 ;
            $value['desc'] = isset($value['desc']) && $value['desc'] ? $value['desc'] : '' ;
            $value['value'] = isset($value['value']) && $value['value'] ? $value['value'] : '';
            $value['module'] = isset($value['module']) && $value['module'] ? $value['module'] : '';
            self::storeConfig($value['namespace'], $value['name'], $value['value'], $value['module'], $value['issystem'], $value['desc']);
        }
        return true;
    }

    /**
     * 存储配置项 ok
     * 
     * @param string $namespace 配置项命名空间
     * @param string $name 配置项名
     * @param mixed $value 配置项的值
     * @param string $issystem 是否为系统
     * @param string $desc 配置项描述
     * @return boolean
     */
    static function storeConfig($namespace, $name, $value = '', $module = 'default', $issystem = 0, $desc = null) 
    {
        $data = [];
        list($data['vtype'], $data['value']) = self::_toString($value);
        $data['desc'] = isset($desc) && $desc ? $desc : '' ;
        isset($issystem) && $data['issystem'] = $issystem;
        if (self::getConfigByName($namespace, $name)) 
        {
            $result = ConfigModel::where('namespace', $namespace)
                                        ->where('name', $name)
                                        ->update($data);
        } else {
            $data['name'] = $name;
            $data['namespace'] = $namespace;
            $result = ConfigModel::insert($data);
        }
        self::setCache($namespace);
        return $result;
    }

    /**
     * 删除配置项
     *
     * @param string $namespace 配置项所属空间
     * @return boolean
     */
    static function deleteConfig($namespace) 
    {
        //删除实例
        $result = ConfigModel::where('namespace', $namespace)->delete();
        $cacheName = 'config:'.$namespace;
        Cache::forget($cacheName);//清除缓存
        return $result;
    }

    /**
     * 删除配置项 ok
     *
     * @param string $namespace 配置项所属空间
     * @param string $name 配置项名字
     * @return boolean
     */
    static function deleteConfigByName($namespace, $name) 
    {
        $result = CommonConfigModel::where('namespace', $namespace)
                                    ->where('name', $name)
                                    ->delete();
        self::setCache($namespace);
        return $result;
    }

    /**
     * 将数据转换为字符串
     *
     * @param mixed $value 待处理的数据
     * @return array 返回处理后的数据，第一个代表该数据的类型，第二个代表该数据处理后的数据串
     */
    static function _toString($value) 
    {
        $vtype = 'string';
        if (is_array($value)) 
        {
            $value = serialize($value);
            $vtype = 'array';
        } elseif (is_object($value)) {
            $value = serialize($value);
            $vtype = 'object';
        }
        return [$vtype, $value];
    }

    /**
     * 将字符串转为数据
     *
     * @param string $vtype 数据类型
     * @param mixed $value 待处理的数据
     * @return array|string 返回处理后的数据
     */
    static function _getInfo($vtype, $value) 
    {
        $val = $value;
        if($vtype =='array' || $vtype == 'object') 
        {
            $val = unserialize($value);
        }
        return $val;
    }

    /**
     * 设置数据缓存
     *
     * @param string $namespace
     * @return array 返回处理后的数据
     */
    static function setCache($namespace)
    {
        $cacheData = [];
        $data = ConfigModel::getConfigByNamespace($namespace);
        foreach ($data as $key => $value) 
        {
            $cacheData[$value['name']] = [
                'value'=>self::_getInfo($value['vtype'], $value['value']),
                'issystem'=>$value['issystem'],
                'desc'=>$value['desc']
            ];
        }
        $cacheName = 'config:'.$namespace;
        Cache::forever($cacheName, $cacheData);
        return $cacheData;
    }

    /**
     * 更新全部缓存
     */
    static function setAllCache()
    {
        $list = ConfigModel::select('namespace')->get();
        if($list) 
        {
            foreach ($list as $key => $value) 
            {
                self::setCache($value['namespace']);
            }
        }
        return true;
    }

    static function get($namespace, $name = null, $isall = false)
    {
        $cacheName = 'config:'.$namespace;
        if (!Cache::has($cacheName)) 
        {
            $data = self::setCache($namespace);
        } else {
            $data = Cache::get($cacheName, []);
            if($name) 
            {
                if(!$isall) return isset($data[$name]['value']) ? $data[$name]['value'] : null;
                return isset($data[$name]) ? $data[$name] : [];
            }
        }
        if(!$isall) 
        {
            $rdata = [];
            foreach ($data as $key => $value) 
            {
                $rdata[$key] = $value['value'];
            }
            return $rdata;
        }
        return $data;
    }

    static function del($namespace, $name = null)
    {
        if($name)
        {
            return self::deleteConfigByName($namespace, $name);
        }
        return self::deleteConfig($namespace);
    }

    static function saveVal($namespace, $data)
    { 
        $data['namespace'] = $namespace;
        return self::storeConfigs([
            $data
        ]);
    }

    static function saveVals($namespace, $datas)
    {
        foreach ($datas as $key => $value) 
        {
            self::saveVal($namespace, $value);
        }
    }
}