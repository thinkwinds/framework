<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Thinkwinds\Framework\Thinkwinds;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Thinkwinds\Framework\Model\ManageUserModel;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeManageFounderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:thinkwinds:manage:founder {--t=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thinkwinds Manage Founder';

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
        $this->stepOne();
    }

    /**
     * Step 1: Configure module manifest.
     *
     * @return mixed
     */
    private function stepOne()
    {
        $t = $this->option('t');
        if($t === 'add') 
        {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->container['password']        = $this->ask('Please enter the password:', 'admin888');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            $this->comment('Password:                           '.$this->container['password']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
            {
                if(ManageUserModel::where('username', $this->container['username'])->count()) 
                {
                    $this->error(tw_lang('thinkwinds::manage.founder.username.noone'));
                    return $this->stepOne();
                }
                $salt = tw_random(6);
                $postData = [
                    'username'=>trim($this->container['username']),
                    'password'=>trim(tw_md5(trim($this->container['password']), $salt)),
                    'salt'=>$salt,
                    'status'=>1,
                    'gid'=>99
                ];
                ManageUserModel::insert($postData);
                ManageUserModel::setCache();
                $this->info('Add Success');
            }
        } else if($t === 'edit') {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->container['password']        = $this->ask('Please enter the new password:', 'admin888');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            $this->comment('Password:                           '.$this->container['password']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
            {
                $user = ManageUserModel::where('username', $this->container['username'])->first();
                if(!$user) 
                {
                    $this->error(tw_lang('thinkwinds::manage.no.username'));
                    return true;
                }
                $postData = [
                    'username'=>trim($this->container['username']),
                    'password'=>trim(tw_md5(trim($this->container['password']), $user['salt'])),
                ];
                ManageUserModel::where('username', $this->container['username'])->update($postData);
                ManageUserModel::setCache();
                $this->info('Edit Success');
            }
        } else if($t === 'delete') {
            $this->container['username']        = $this->ask('Please enter the username:', 'admin1');
            $this->comment('You have provided the following manifest information:');
            $this->comment('Username:                           '.$this->container['username']);
            if ($this->confirm('If the provided information is correct, type "yes" to generate.')) 
            {
                $user = ManageUserModel::where('username', $this->container['username'])->first();
                if(!$user) 
                {
                    $this->error(tw_lang('thinkwinds::manage.no.username'));
                    return true;
                }
                ManageUserModel::where('username', $this->container['username'])->delete();
                ManageUserModel::setCache();
                $this->info('Delete Success');
            }
        }   
        return true;
    }
}