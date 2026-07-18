<?php

namespace App\Services\AdTech;

use App\Models\Click;

class AntiFraudService
{
    /**
     * DEPRECATED - replaced by FraudDetectionService
     */

    public function evaluateClick(Click $click): bool
    {
        return true;
    }

    private function isDuplicateClick(Click $click): bool
    {
        return false;
    }

    private function isHighVelocityIp(?string $ip): bool
    {
        return false;
    }

    public function calculateFraudScore(Click $click): int
    {
        return 0;
    }
}