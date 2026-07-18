<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncStatusToState extends Command
{
    protected $signature = 'sync:state-cleanup';
    protected $description = 'Normalize ads & campaigns to state-only system';

    public function handle()
    {
        $this->info('Starting state normalization...');

        /*
        |--------------------------------------
        | ADS NORMALIZATION
        |--------------------------------------
        */
        DB::table('ads')->orderBy('id')->chunkById(500, function ($rows) {

            foreach ($rows as $row) {

                $state = $this->resolveAdState($row);

                DB::table('ads')
                    ->where('id', $row->id)
                    ->update([
                        'state' => $state,
                    ]);
            }
        });

        /*
        |--------------------------------------
        | CAMPAIGNS NORMALIZATION
        |--------------------------------------
        */
        DB::table('campaigns')->orderBy('id')->chunkById(500, function ($rows) {

            foreach ($rows as $row) {

                $state = $this->resolveCampaignState($row);

                DB::table('campaigns')
                    ->where('id', $row->id)
                    ->update([
                        'state' => $state,
                    ]);
            }
        });

        $this->info('DONE: system normalized to STATE-only architecture.');
    }

    /*
    |--------------------------------------
    | AD STATE RULES
    |--------------------------------------
    */
    private function resolveAdState($row): string
    {
        if (!empty($row->deleted_at)) {
            return 'deleted';
        }

        if (!empty($row->rejected_at)) {
            return 'rejected';
        }

        if (!empty($row->paused_at)) {
            return 'paused';
        }

        if (!empty($row->approved_at)) {
            return 'active';
        }

        return $row->state ?? 'pending_review';
    }

    /*
    |--------------------------------------
    | CAMPAIGN STATE RULES
    |--------------------------------------
    */
    private function resolveCampaignState($row): string
    {
        return $row->state ?? 'draft';
    }
}
