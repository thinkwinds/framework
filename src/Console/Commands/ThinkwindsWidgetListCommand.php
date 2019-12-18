<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use Thinkwinds\Framework\Model\WidgetModel;
use Thinkwinds\Framework\Model\WidgetInjectModel;

class ThinkwindsWidgetListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'thinkwinds:widget:list {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Widget All';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $t = $this->option('t');
        if($t == '1') 
        {
            $Widget = WidgetModel::getAll();
            $Widgets = [];
            $Widgets = WidgetModel::getAll(2);
            $headers = ['name', 'description'];
            $this->table($headers, $Widgets);
        } else {
            if (!Cache::has('widgetInject')) 
            {
                $widgetInject = WidgetInjectModel::setCache();
            } else {
                $widgetInject = Cache::get('widgetInject');
            }
            $widgetInjectAll = [];
            foreach ($widgetInject as $key => $value) 
            {
                if($widgetInjectAll)
                {
                    $widgetInjectAll = array_merge($widgetInjectAll, $value);
                } else {
                    $widgetInjectAll = $value;
                }
            }
            $headers = ['widgetName', 'files', 'class', 'fun'];
            $this->table($headers, $widgetInjectAll);
        }
    }
}
