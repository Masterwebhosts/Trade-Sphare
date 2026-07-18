<?php

namespace App\Listeners;

use App\Events\ClickCreated;
use App\Services\AdTech\AntiFraudService;
use App\Services\Ledger\LedgerService;

class ProcessClick
{
    public function __construct(
        private AntiFraudService $fraud,
        private LedgerService $ledger
    ) {}

    public function handle(ClickCreated $event): void
    {
        try {

            $click = $event->click;

            logger()->info('CLICK START', ['id' => $click->id]);

            // 1. FRAUD CHECK
            if (! $this->fraud->evaluateClick($click)) {

                $click->update([
                    'is_suspicious' => true,
                    'fraud_score'   => 100,
                ]);

                return;
            }

            logger()->info('FRAUD OK');

            // 2. CAMPAIGN LOAD
            $campaign = $click->campaign;

            if (! $campaign) {
                logger()->error('NO CAMPAIGN');
                return;
            }

            logger()->info('CAMPAIGN OK');

            // 3. RESOLVE ADVERTISER SAFELY (IMPORTANT FIX)
            $advertiserId = $campaign->advertiser_id ?? $campaign->user_id;

            if (!$advertiserId) {
                logger()->error('NO ADVERTISER FOUND');
                return;
            }

            // 4. LEDGER
            try {
                $this->ledger->chargeClickWithSplit(
                    campaignId: $campaign->id,
                    advertiserId: $advertiserId,
                    publisherId: $click->publisher_id,
                    amount: 0.10,
                    clickId: $click->id
                );
            } catch (\Throwable $e) {
                logger()->error('LEDGER FAILED', [
                    'msg' => $e->getMessage()
                ]);
            }

            logger()->info('CLICK DONE');

        } catch (\Throwable $e) {

            logger()->error('CLICK FATAL', [
                'msg' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}