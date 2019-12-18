<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Console\Commands;

use Illuminate\Console\Command;
use Thinkwinds\Framework\Thinkwinds;

class ThinkwindsInfoCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'thinkwinds:info {--t=null}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thinkwinds Info';

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
        $t = $this->option('t');
        switch ($t) {
            case 'version':
                $this->info($this->thinkwinds->version());
                break;
            default:
                $this->info('Welcome to use Thinkwinds');
                $this->info('https://www.thinkwinds.com');
                break;
        }
    }
}
