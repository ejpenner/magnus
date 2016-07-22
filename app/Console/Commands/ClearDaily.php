<?php
namespace Magnus\Console\Commands;

use Magnus\Opus;
use Illuminate\Console\Command;

class ClearDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:daily-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the daily pageviews';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $this->info('Resetting daily Opus views...');
        $opera = Opus::all();
        $progressBar = $this->output->createProgressBar(count($opera));
        foreach ($opera as $opus) {
            $opus->save(['daily_views' => 0]);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->info("\n");
    }
}
