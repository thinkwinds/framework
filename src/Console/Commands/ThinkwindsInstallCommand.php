<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Thinkwinds;

class ThinkwindsInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'thinkwinds:install {--data=true}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thinkwinds Install';

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
        $boolData = $this->option('data');
        $this->call('migrate', [
            '--force' => true
        ]);
        $this->call('db:seed');
        // $seedListsClass = [
        //     'ManageUser', 'Config', 'Role', 'ManageMenu', 'RoleUri'
        // ];
        // if($seedListsClass)
        // {
        //     foreach ($seedListsClass as $class) 
        //     {
        //         $this->call('db:seed', [
        //             '--class' => $class . 'TableSeeder'
        //         ]);
        //     }
        // }
        $this->call('thinkwinds:seed', [
            '--force' => true
        ]);
        //Set up test data in the database
        if (!empty($boolData))
        {
            $seedListClass = [
                //'Article'
            ];
            if($seedListClass) 
            {
                foreach ($seedListClass as $class) 
                {
                    $this->call('db:seed', [
                        '--class' => $class . 'TableSeeder'
                    ]);
                }
            }
        }
    }
}