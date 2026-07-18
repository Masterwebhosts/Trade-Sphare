<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;

class DetectBrokenQueries extends Command
{
    protected $signature = 'app:detect:queries';
    protected $description = 'Detect mismatched Laravel queries vs database schema';

    public function handle()
    {
        $this->info('🔍 Scanning models vs database schema...');

        $modelsPath = app_path('Models');
        $files = glob($modelsPath . '/*.php');

        $issues = [];

        foreach ($files as $file) {

            $class = 'App\\Models\\' . basename($file, '.php');

            if (!class_exists($class)) continue;

            try {
                $model = new $class;
                $table = $model->getTable();

                if (!Schema::hasTable($table)) {
                    $issues[] = "❌ Model $class references missing table $table";
                    continue;
                }

                $columns = Schema::getColumnListing($table);

                $reflection = new ReflectionClass($class);

                foreach ($reflection->getMethods() as $method) {

                    $code = file_get_contents($file);

                    // detect common bad patterns
                    if (str_contains($code, 'advertiser_id') && !in_array('advertiser_id', $columns)) {
                        $issues[] = "⚠️ $class uses advertiser_id but column missing in $table";
                    }

                    if (str_contains($code, 'user_id') && !in_array('user_id', $columns)) {
                        $issues[] = "⚠️ $class uses user_id but column missing in $table";
                    }
                }

            } catch (\Throwable $e) {
                $issues[] = "❌ Error analyzing $class: " . $e->getMessage();
            }
        }

        if (empty($issues)) {
            $this->info('✅ No query/schema mismatches detected.');
            return 0;
        }

        $this->warn("\n🚨 Real Issues Found:\n");

        foreach ($issues as $issue) {
            $this->line($issue);
        }

        return 1;
    }
}