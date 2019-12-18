<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Generators;

use Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Thinkwinds\Framework\Thinkwinds;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Thinkwinds\Framework\Model\ApiModel;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:thinkwinds:api {--t=null} {--s=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ThinkWinds Api';

    /**
     * The ThinkWinds instance.
     *
     * @var ThinkWinds
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
        $this->stepOne();
    }

    public function creatAppId()
    {
        $appid = '18'.tw_time2str(tw_time(), 's').tw_random(6, true);
        if(tw_api_app($appid)) 
        {
            return $this->creatAppId();
        }
        return $appid;
    }

    public function creatSecret()
    {
        return strtolower(tw_random(32));
    }

    public function saveCache($vData) 
    {
        $cacheName = 'thinkwinds:api';
        return Cache::forever($cacheName, $vData);
    }

    /**
     * Step 1: Configure module manifest.
     *
     * @return mixed
     */
    private function stepOne()
    {
        $t = $this->option('t');
        $apps = tw_api_app();
        if($t === 'add') 
        {
            $this->container['name']            = $this->ask('Please enter the name:');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Name:                           '.$this->container['name']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
            {
                $appid = $this->creatAppId();
                $secret = $this->creatSecret();
                $vData = [
                    'name'=>$this->container['name'],
                    'appid'=>$appid,
                    'secret'=>$secret,
                    'times'=>tw_time(),
                    'edittimes'=>tw_time(),
                    'status'=>0
                ];
                $apps[$appid] = $vData;
                $this->saveCache($apps);
                ApiModel::insert($vData);
                $this->info('Add Success');
            }
        } else if($t === 'edit') {
            $this->container['appid']        = $this->ask('Please enter the appid:');
            $this->container['name']            = $this->ask('Please enter the name:');
            $this->comment('You have provided the following manifest information:');
            $this->comment('AppId:                           '.$this->container['appid']);
            $this->comment('Name:                           '.$this->container['name']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                if(!isset($apps[$this->container['appid']])) 
                {
                    $this->Error('Edit Error');
                    return true;
                }
                $apps[$this->container['appid']]['name'] = $this->container['name'];
                $apps[$this->container['appid']]['edittimes'] = tw_time();
                $this->saveCache($apps);
                ApiModel::where('appid', $this->container['appid'])->update([
                    'name'=>$this->container['name'],
                    'edittimes'=>$apps[$this->container['appid']]['edittimes']
                ]);
                $this->info('Edit Success');
            }
        } else if($t === 'status') {
            $s = (int)$this->option('s');
            $this->container['appid']        = $this->ask('Please enter the appid:');
            $this->comment('You have provided the following manifest information:');
            $this->comment('AppId:                           '.$this->container['appid']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                if(!isset($apps[$this->container['appid']])) 
                {
                    $this->Error('Edit Error');
                    return true;
                }
                $apps[$this->container['appid']]['status'] = $s;
                $apps[$this->container['appid']]['edittimes'] = tw_time();
                $this->saveCache($apps);
                ApiModel::where('appid', $this->container['appid'])->update([
                    'status'=>$s,
                    'edittimes'=>$apps[$this->container['appid']]['edittimes']
                ]);
                $this->info('Edit Success');
            }
        } else if($t === 'delete') {
            $this->container['appid']        = $this->ask('Please enter the appid:');
            $this->comment('You have provided the following manifest information:');
            $this->comment('AppId:                           '.$this->container['appid']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
            {
                unset($apps[$this->container['appid']]);
                $this->saveCache($apps);
                ApiModel::where('appid', $this->container['appid'])->delete();
                $this->info('Delete Success');
            }
        } else if($t === 'clear') {
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) {
                $this->saveCache([]);
                ApiModel::where('id', '>', 0)->delete();
                $this->info('Clear Success');
            }
        } else {
            $headers = ['Name', 'AppId', 'Secret', 'AddTimes', 'EditTimes', 'Status'];
            $this->table($headers, $apps);
        }
        return true;
    }
}
