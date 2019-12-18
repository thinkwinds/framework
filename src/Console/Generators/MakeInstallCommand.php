<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Thinkwinds\Framework\Thinkwinds;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Thinkwinds\Framework\Model\ManageUserModel;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:thinkwinds {--d=null} {--a=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thinkwinds Install';

    /**
     * The Thinkwinds instance.
     *
     * @var Thinkwinds
     */
    protected $thinkwinds;

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Thinkwinds    $thinkwinds
     */
    public function __construct(Filesystem $files, Thinkwinds $thinkwinds)
    {
        parent::__construct();

        $this->files  = $files;
        $this->thinkwinds = $thinkwinds;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->container['site_url'] = 'null';
        $this->stepOne();
    }

    /**
     * Step 1: Configure module manifest.
     *
     * @return mixed
     */
    private function stepOne()
    {
        if (file_exists(base_path('thinkwinds.install.lck'))) 
        {
            $this->info(tw_lang('thinkwinds::install.install.already').'HSTCMS'.config('thinkwinds.version').'，'.tw_lang('thinkwinds::install.install.one'));
            return true;
        }
        if (!$this->files->isFile(base_path('.env'))) 
        {
            $this->files->copy(base_path('.env.example'), base_path('.env'));
        }
        $this->container['lang']        = $this->ask('Please enter the site url:', env('locale', 'zh-en'));
        //检查数据库信息是否配置
        if(!tw_checkEnvIsNull('DB_HOST') || !tw_checkEnvIsNull('DB_DATABASE') || !tw_checkEnvIsNull('DB_USERNAME') || !tw_checkEnvIsNull('DB_PASSWORD') || $this->option('d') !== 'null' ) 
        {
            $this->container['db_host']        = $this->ask('Please enter the db host:', 'localhost');
            $this->container['db_username']        = $this->ask('Please enter the db database:', 'root');
            $this->container['db_password']        = $this->ask('Please enter the db password:', '');
            $this->container['db_database']        = $this->ask('Please enter db database:', '');
        }
        $this->container['site_url']        = $this->ask('Please enter the site url:', $this->container['site_url']);
        $this->container['username']        = $this->ask('Please enter the admin username:', 'admin');
        $this->container['password']        = $this->ask('Please enter the admin password:', 'admin888');

        $this->comment('You have provided the following manifest information:');

        if(!tw_checkEnvIsNull('DB_HOST') || !tw_checkEnvIsNull('DB_DATABASE') || !tw_checkEnvIsNull('DB_USERNAME') || !tw_checkEnvIsNull('DB_PASSWORD')  || $this->option('d') !== 'null' ) 
        {
            $this->comment('DbHost:                             '.$this->container['db_host']);
            $this->comment('DbUsername:                         '.$this->container['db_username']);
            $this->comment('DbPassword:                         '.$this->container['db_password']);
            $this->comment('DbDatabase:                         '.$this->container['db_database']);
        }

        $this->comment('SiteUrl:                            '.$this->container['site_url']);
        $this->comment('Username:                           '.$this->container['username']);
        $this->comment('Password:                           '.$this->container['password']);

        Config::set('locale', $this->container['lang']);
        if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
        {
            $envData = [];
            if(isset($this->container['db_host']) && $this->container['db_host']) 
            {
                $envData = [
                    'DB_HOST'=> $this->container['db_host'],
                    'DB_USERNAME'=> $this->container['db_username'],
                    'DB_PASSWORD'=> $this->container['db_password'],
                    'DB_DATABASE'=> $this->container['db_database'],
                ];
                Config::set('database.connections.mysql.host', $this->container['db_host']);
                Config::set('database.connections.mysql.database', $this->container['db_database']);
                Config::set('database.connections.mysql.username', $this->container['db_username']);
                Config::set('database.connections.mysql.password', $this->container['db_password']);
            } else {
                $this->container['db_host']        = env('DB_HOST');
                $this->container['db_username']    = env('DB_USERNAME');
                $this->container['db_password']    = env('DB_PASSWORD');
                $this->container['db_database']    = env('DB_DATABASE');
            }
            if($this->container['site_url'] !== 'null') 
            {
                $envData['APP_URL'] = $this->container['site_url'];
            } else {
                $envData['APP_URL'] = '';
            }
            tw_updateEnvInfo($envData);
            $link = mysqli_connect($this->container['db_host'], $this->container['db_username'], $this->container['db_password']);
            if (!$link) 
            {
                $this->error('Database configuration information error');
                return $this->stepOne();
            }
            if ( !mysqli_select_db($link, $this->container['db_database'])) 
            {
                $sql = "CREATE DATABASE `" . $this->container['db_database'] . "`";
                mysqli_query($link, $sql) or mysqli_error($link);
            }
            DB::reconnect();
            if($this->option('a') !== 'null')
            {
                $this->call('migrate', [
                    '--force' => true
                ]);
                $this->call('db:seed');
            } else {
                $this->call('migrate', [
                    '--path' => 'vendor/thinkwinds/framework/src/database/migrations',
                    '--force' => true
                ]);
            }
            $this->call('thinkwinds:seed', [
                '--force' => true
            ]);
            $status = DB::transaction(function() 
            {
                tw_save_config('site', [
                    ['name'=>'url', 'value'=>$this->container['site_url'], 'issystem'=>1],
                    ['name'=>'debug', 'value'=>1, 'issystem'=>1]
                ]);
                if($this->container['site_url'] === 'null') {
                    tw_save_config('site', [
                        ['name'=>'url', 'value'=>'', 'issystem'=>1],
                        ['name'=>'debug', 'value'=>1, 'issystem'=>1]
                    ]);
                }
                $salt = tw_random(6);
                ManageUserModel::insert([
                    'gid'=>99,
                    'status'=>0,
                    'username' => $this->container['username'],
                    'salt' => $salt,
                    'password' => tw_md5($this->container['password'], $salt)
                ]);
                ManageUserModel::setCache();
            });
            if (!is_null($status)) {
                $this->error(tw_lang('thinkwinds::install.install.error'));
                return $this->stepOne();
            } else {
                $this->call('key:generate');
                $this->call('vendor:publish', [
                    '--tag'=>'config'
                ]);
                $this->call('vendor:publish', [
                    '--tag'=>'public'
                ]);
                $this->call('thinkwinds:cache');
                // $this->call('migrate', [
                //     '--force'=>true
                // ]);
                File::put(base_path('thinkwinds.install.lck'), env('APP_KEY'));
                $this->info('---------Install Success---------');
                if($this->container['site_url'] !== 'null') {
                    $this->comment('Home:          '.env('APP_URL'));
                    $this->comment('Admin:         '.env('APP_URL').'/manage');
                } else {
                    $this->comment('Home:          http(https)://域名(ip)');
                    $this->comment('Admin:         http(https)://域名(ip)/manage');
                }
            }
        }
        return true;
    }
}