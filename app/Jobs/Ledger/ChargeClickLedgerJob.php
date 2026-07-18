<?php

namespace App\Jobs\Ledger;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Ledger\LedgerService;

class ChargeClickLedgerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $campaignId;
    public int $publisherId;
    public float $amount;
    public int $clickId;

    public function __construct(
        int $campaignId,
        int $publisherId,
        float $amount,
        int $clickId
    ) {
        $this->campaignId  = $campaignId;
        $this->publisherId = $publisherId;
        $this->amount      = $amount;
        $this->clickId     = $clickId;
    }

    public function handle(LedgerService $ledger): void
    {
        $ledger->chargeClickWithSplit(
            campaignId: $this->campaignId,
            publisherId: $this->publisherId,
            amount: $this->amount,
            clickId: $this->clickId
        );
    }
}