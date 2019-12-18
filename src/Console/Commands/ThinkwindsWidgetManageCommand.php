<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Model\WidgetModel;
use Thinkwinds\Framework\Model\WidgetInjectModel;
use Symfony\Component\Console\Input\InputArgument;

class ThinkwindsWidgetManageCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'thinkwinds:widget:manage';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Widget Manage';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $slug = $this->argument('slug');
        $value = $this->argument('value');
        if($slug && $value) 
        {
            if($slug == 'module') 
            {
                WidgetModel::del('', $value);
            } else {
                WidgetModel::del($value);
            }
            $this->call('hook:cache');
            $this->info('Delete Success');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['slug', InputArgument::REQUIRED, 'Widget slug.'],
            ['value', InputArgument::REQUIRED, 'Widget value.']
        ];
    }
}