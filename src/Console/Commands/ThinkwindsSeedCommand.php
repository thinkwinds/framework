<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Thinkwinds;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ThinkwindsSeedCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'thinkwinds:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with records for a specific or all thinkwinds';

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
        $seeder = ['ManageUser', 'Config', 'Role', 'RoleUri', 'ManageMenu'];
        if($seeder) 
        {
            if($this->option('table'))
            {
                if(in_array($this->option('table'), $seeder)) 
                {
                    $fullPath = 'Thinkwinds\Framework\Database\Seeds\\'.$this->option('table').'TableSeeder';
                    $this->seed($fullPath, $this->option('table'));
                }
            } else {
                foreach ($seeder as $key => $value) 
                {
                    $fullPath = 'Thinkwinds\Framework\Database\Seeds\\'.$value.'TableSeeder';
                    $this->seed($fullPath, $value);
                }
            }
        }
    }

    /**
     * Seed the specific module.
     *
     * @param string $module
     *
     * @return array
     */
    protected function seed($fullPath, $table)
    {
         if (class_exists($fullPath)) 
         {
            if ($this->option('class')) 
            {
                $params['--class'] = $this->option('class');
            } else {
                $params['--class'] = $fullPath;
            }
            if ($option = $this->option('database')) 
            {
                $params['--database'] = $option;
            }
            if ($option = $this->option('force')) 
            {
                $params['--force'] = $option;
            }
            $this->call('db:seed', $params);
            $this->info('Seed: '. $table);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', null, InputOption::VALUE_OPTIONAL, 'The table name of the thinkwinds\'s root seeder.'],
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the thinkwinds\'s root seeder.'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run while in production.'],
        ];
    }
}
