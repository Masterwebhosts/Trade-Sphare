<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LedgerScan extends Command
{
    protected $signature = 'ledger:scan';
    protected $description = 'Scan project for ledger violations and forbidden wallet mutations';

    public function handle(): int
    {
        $paths = [
            app_path(),
            base_path('routes'),
            base_path('database'),
            base_path('tests'),
            app_path('Console'),
        ];

        $found = false;

        foreach ($paths as $path) {

            if (!File::exists($path)) {
                continue;
            }

            foreach (File::allFiles($path) as $file) {

                $pathName = $file->getPathname();

                if (
                    str_contains($pathName, 'vendor') ||
                    str_contains($pathName, 'storage') ||
                    str_contains($pathName, 'bootstrap/cache') ||
                    str_contains($pathName, '.blade.php.cache')
                ) {
                    continue;
                }

                $content = file_get_contents($pathName);

                /*
                |-----------------------------
                | STRIP COMMENTS ONLY
                |-----------------------------
                */

                $cleanContent = preg_replace('!/\*.*?\*/!s', '', $content);
                $cleanContent = preg_replace('/\/\/.*$/m', '', $cleanContent);

                /*
                |-----------------------------
                | RULES
                |-----------------------------
                */

                $rules = [

                    'critical' => [
                        '/WalletTransaction::create\s*\(/',
                        '/WalletTransaction::query\(\)\s*->\s*create\s*\(/',
                        '/DB::table\([\'"]wallet_transactions[\'"]\)\s*->\s*insert/',
                        '/app\s*\(\s*WalletTransaction::class\s*\)\s*->\s*create/',

                        // balance mutations (FULL COVERAGE)
                        '/\$wallet->balance(\s*[\+\-\*\/]?=|\+\+|--)/',
                        '/setAttribute\s*\(\s*[\'"]balance[\'"]/',
                        '/\$wallet\[[\'"]balance[\'"]\]\s*=/',
                        '/data_set\s*\(\s*\$wallet\s*,\s*[\'"]balance[\'"]/',
                        '/forceFill\s*\(\s*\([^)]*[\'"]balance[\'"]\s*=>/',

                        // dynamic bypass protection
                        '/call_user_func\s*\(\s*\[\s*WalletTransaction::class\s*,\s*[\'"]create[\'"]\s*\]/',
                    ],
                ];

                foreach ($rules as $severity => $patterns) {

                    foreach ($patterns as $pattern) {

                        if (preg_match($pattern, $cleanContent)) {

                            $this->error("CRITICAL LEDGER VIOLATION: {$pathName}");
                            $found = true;
                        }
                    }
                }
            }
        }

        if (!$found) {
            $this->info('OK: Ledger clean. No critical violations found.');
        }

        return $found ? 1 : 0;
    }
}