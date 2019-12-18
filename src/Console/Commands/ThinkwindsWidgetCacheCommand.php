<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Thinkwinds;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Thinkwinds\Framework\Model\WidgetModel;
use Thinkwinds\Framework\Model\WidgetInjectModel;


class ThinkwindsWidgetCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'thinkwinds:widget:cache {--p=null} {--f=null} {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thinkwinds Widget Cache';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The Application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $p = $this->option('p');
        $f = $this->option('f');
        $t = $this->option('t');
        $path    = realpath(base_path());
        $appPath    = realpath(app_path());
        if($p !== null && $p !=='all') 
        {
            if($f == 'app') 
            {
                $widgets = $this->files->glob($appPath.'/'.$p.'/Widget/config.php');
            } else {
                $widgets = $this->files->glob($path.'/'.$p.'/Widget/config.php');
            }
            if($widgets)
            {
                $widgetLists = $this->files->getRequire($widgets[0])['widgetList'];
                $widgetInjects = $this->files->getRequire($widgets[0])['widgetInject'];
                $this->initWidget($widgetLists, $t);
                $this->initWidgetInject($widgetInjects, $t);
            }
        } else if($p !== null && $p === 'all') {
            // $defaultWidgetList = config('widget.default.widgetList');
            // $defaulWidgetInject = config('widget.default.widgetInject');
            // $this->initWidget($defaultWidgetList);
            // $this->initWidgetInject($defaulWidgetInject);
            $widgets = $this->files->glob($appPath.'/Widget/config.php');
            if($widgets) 
            {
                $widgetLists = $this->files->getRequire($widgets[0])['widgetList'];
                $widgetInjects = $this->files->getRequire($widgets[0])['widgetInject'];
                $this->initWidget($widgetLists);
                $this->initWidgetInject($widgetInjects);
            }
            $mwidgets = $this->files->glob($appPath.'/Modules/*/Widget/config.php');
            if($mwidgets)
            {
                foreach ($mwidgets as $widget) {
                    $widgetLists = $this->files->getRequire($widget)['widgetList'];
                    $widgetInjects = $this->files->getRequire($widget)['widgetInject'];
                    $this->initWidget($widgetLists);
                    $this->initWidgetInject($widgetInjects);
                }
            }
            $vwidgets = $this->files->glob($path.'/vendor/thinkwinds/*/src/Widget/config.php');
            if($vwidgets) 
            {
                foreach ($vwidgets as $widget) 
                {
                    $widgetLists = $this->files->getRequire($widget)['widgetList'];
                    $widgetInjects = $this->files->getRequire($widget)['widgetInject'];
                    $this->initWidget($widgetLists);
                    $this->initWidgetInject($widgetInjects);
                }
            }
        }
        $data = WidgetModel::setCache();
        $injectAll = WidgetInjectModel::setAllCache();
        $inject = WidgetInjectModel::setCache();
        $this->info('widget cache ok!');
    }

    public function initWidget($widgetLists = [], $t = null) 
    {
        if($widgetLists) 
        {
            foreach ($widgetLists as $key => $value) 
            {
                if(!WidgetModel::where('name', $key)->count()) 
                {
                    WidgetModel::addInfo($key, $value['description'], $value['document'], 1, $value['module']);
                    $this->info('Add Widget: '.$key.'         Success');
                } else {
                    WidgetModel::editInfo($key, $value['description'], $value['document']);
                    $this->info('Edit Widget: '.$key.'         Success');
                }
            }
        }
    }

    public function initWidgetInject($widgetInjects = [], $t = null) 
    {
        if($widgetInjects) 
        {
            foreach ($widgetInjects as $key => $value) 
            {
                foreach ($value as $k => $v) 
                {
                    $info = WidgetInjectModel::where('widget_name', $v['widget_name'])->where('alias', 'mod_'.$v['alias'])->first();
                    if(!$info && ($t === null || $t === 'null')) 
                    {
                        WidgetInjectModel::addInfo($v['widget_name'], $v['alias'], $v['files'], $v['class'], $v['fun'], $v['description'], 1);
                        $this->info('Add WidgetInjetct: '.$v['widget_name']. '   '.$v['alias'].'         Success');
                    } else {
                        if($t == 'delete') 
                        {
                            WidgetInjectModel::del('id', $info['id']);
                            $this->info('Delete WidgetInjetct: '.$v['widget_name']. '   '.$info['alias'].'         Success');
                        } else {
                            WidgetInjectModel::editInfo($info['id'], $v['widget_name'], $v['alias'], $v['files'], $v['class'], $v['fun'], $v['description']);
                            $this->info('Edit WidgetInjetct: '.$v['widget_name']. '   '.$info['alias'].'         Success');
                        }
                    }
                }
            }
        }
    }
}
