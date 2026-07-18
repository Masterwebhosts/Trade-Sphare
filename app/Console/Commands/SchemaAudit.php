<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SchemaAudit extends Command
{
    protected $signature = 'app:schema:audit';
    protected $description = 'Detect broken columns, relations, and schema inconsistencies';

    public function handle()
    {
        $this->info('🔍 Running Schema Audit...');

        $issues = [];

        $tables = DB::select('SHOW TABLES');
        $dbName = 'Tables_in_' . env('DB_DATABASE');

        foreach ($tables as $table) {

            $tableName = $table->$dbName;

            $columns = Schema::getColumnListing($tableName);

            // 1. Detect advertiser_id usage
            if (in_array('advertiser_id', $columns)) {
                $issues[] = "⚠️ [$tableName] still uses advertiser_id (should be user_id?)";
            }

            // 2. Detect missing common FK patterns
            $commonFKs = ['user_id', 'campaign_id', 'ad_id'];

            foreach ($commonFKs as $fk) {
                if (str_contains($tableName, 'campaign') && !in_array('user_id', $columns)) {
                    $issues[] = "❌ [$tableName] missing user_id (campaign ownership issue)";
                }

                if (str_contains($tableName, 'ads') && !in_array('campaign_id', $columns)) {
                    $issues[] = "❌ [$tableName] missing campaign_id";
                }
            }

            // 3. Detect orphan-like tables
            $hasId = in_array('id', $columns);
            if (!$hasId) {
                $issues[] = "❌ [$tableName] missing primary key id";
            }

            // 4. Detect suspicious schema mismatches
            if (in_array('advertiser_id', $columns) && in_array('user_id', $columns)) {
                $issues[] = "⚠️ [$tableName] has BOTH advertiser_id and user_id (duplicate ownership model)";
            }
        }

        // Report
        if (empty($issues)) {
            $this->info('✅ No schema issues detected.');
            return 0;
        }

        $this->warn("\n🚨 Schema Issues Found:\n");

        foreach ($issues as $issue) {
            $this->line($issue);
        }

        return 1;
    }
}