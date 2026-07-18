<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Services\Billing\BudgetEngineService;

class BudgetSyncCommand extends Command
{
    protected $signature = 'budget:sync';

    public function handle(BudgetEngineService $engine)
    {
        Campaign::chunk(100, function ($campaigns) use ($engine) {

            foreach ($campaigns as $campaign) {
                $engine->enforce($campaign);
            }

        });

        $this->info('Budget sync completed');
    }
}