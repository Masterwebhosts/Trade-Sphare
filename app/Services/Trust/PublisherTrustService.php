<?php

namespace App\Services\Trust;

use App\Models\Wallet;

class PublisherTrustService
{
    /**
     * Get payout multiplier based on trust score.
     */
    public function getMultiplier(int $publisherId): float
    {
        $wallet = Wallet::where('publisher_id', $publisherId)->first();

        if (!$wallet) {
            return 0.50;
        }

        $score = (int) $wallet->trust_score;

        return match (true) {
            $score >= 90 => 1.20,
            $score >= 80 => 1.10,
            $score >= 60 => 1.00,
            $score >= 40 => 0.80,
            $score >= 20 => 0.50,
            default      => 0.20,
        };
    }

    /**
     * Increase publisher trust.
     */
    public function reward(int $publisherId, int $points = 1): void
    {
        $wallet = Wallet::where('publisher_id', $publisherId)->first();

        if (!$wallet) {
            return;
        }

        $wallet->trust_score = min(
            100,
            ((int) $wallet->trust_score) + $points
        );

        $wallet->save();
    }

    /**
     * Decrease publisher trust.
     */
    public function penalize(int $publisherId, int $points = 5): void
    {
        $wallet = Wallet::where('publisher_id', $publisherId)->first();

        if (!$wallet) {
            return;
        }

        $wallet->trust_score = max(
            0,
            ((int) $wallet->trust_score) - $points
        );

        $wallet->save();
    }

    /**
     * Apply event-based trust adjustment.
     */
    public function adjust(int $publisherId, string $event): void
    {
        match ($event) {
            'good_click'       => $this->reward($publisherId, 1),
            'review_click'     => $this->penalize($publisherId, 2),
            'suspicious_click' => $this->penalize($publisherId, 5),
            'fraud_block'      => $this->penalize($publisherId, 10),
            default            => null,
        };
    }

    /**
     * Get current trust score.
     */
    public function getScore(int $publisherId): int
    {
        $wallet = Wallet::where('publisher_id', $publisherId)->first();

        return $wallet
            ? (int) $wallet->trust_score
            : 0;
    }
}
