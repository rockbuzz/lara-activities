<?php

namespace Rockbuzz\LaraActivities\Console;

use Illuminate\Console\Command;
use Rockbuzz\LaraActivities\Models\Activity;

class PruneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activities:prune {--hours=24 : The number of hours to retain Activities data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune stale entries from the Activities database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Activity $activity)
    {
        $this->info($activity->prune(now()->subHours($this->option('hours'))).' entries pruned.');
    }
}
