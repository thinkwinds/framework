<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Thinkwinds;
use Thinkwinds\Framework\Model\ApiModel;
use Thinkwinds\Framework\Model\RoleModel;
use Thinkwinds\Framework\Model\ConfigModel;
use Thinkwinds\Framework\Model\ModulesModel;
use Thinkwinds\Framework\Model\RoleUriModel;
use Thinkwinds\Framework\Model\ManageMenuModel;
use Thinkwinds\Framework\Model\ManageUserModel;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThinkwindsCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'thinkwinds:cache {--t=null} {--v=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache';

    /**
     * @var Thinkwinds
     */
    protected $thinkwinds;

    /**
     * Create a new command instance.
     *
     * @param Thinkwinds $thinkwinds
     */
    public function __construct(Thinkwinds $thinkwinds)
    {
        parent::__construct();
        $this->thinkwinds = $thinkwinds;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        RoleModel::setCache('manage', false);
        $this->info('Role Success');
        RoleUriModel::setCache('manage', false);
        $this->info('Role Uri Success');
        ManageMenuModel::setCache('manage', false);
        $this->info('Manage Menu Success');
        ManageUserModel::setCache(false);
        $this->info('Manage User Success');
        ModulesModel::setCache(false);
        $this->info('Modules Success');
        ConfigModel::setAllCache();
        $this->info('Config Success');
        ApiModel::setCache();
        $this->info('Api Success');
        $this->call('thinkwinds:widget:cache', [
            '--p'=>'all'
        ]);
        thinkwinds_widget('s_widget');
        $this->info('Success');
    }
}
