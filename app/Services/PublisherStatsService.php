<?php

namespace App\Services;

use App\Models\Click;
use Illuminate\Support\Facades\DB;

class PublisherStatsService
{
    public function getDashboardStats(int $publisherId): array
    {
        return [
            'today' => [
                'clicks'   => $this->clicksToday($publisherId),
                'earnings' => $this->earningsToday($publisherId),
            ],
            'yesterday' => [
                'clicks'   => $this->clicksYesterday($publisherId),
                'earnings' => $this->earningsYesterday($publisherId),
            ],
            'total' => [
                'clicks'   => $this->clicksTotal($publisherId),
                'earnings' => $this->earningsTotal($publisherId),
            ],
            'epc'       => $this->epc($publisherId),
            'top_zones' => $this->topZones($publisherId),
            'top_ads'   => $this->topAds($publisherId),
        ];
    }

    /* ---------------- BASE QUERY ---------------- */

    private function baseQuery(int $id)
    {
        return Click::where('publisher_id', $id);
    }

    /* ---------------- CLICKS ---------------- */

    private function clicksToday(int $id): int
    {
        return (clone $this->baseQuery($id))
            ->whereDate('created_at', today())
            ->count();
    }

    private function clicksYesterday(int $id): int
    {
        return (clone $this->baseQuery($id))
            ->whereDate('created_at', today()->subDay())
            ->count();
    }

    private function clicksTotal(int $id): int
    {
        return (clone $this->baseQuery($id))->count();
    }

    /* ---------------- EARNINGS ---------------- */

    private function earningsToday(int $id): float
    {
        return (float) (clone $this->baseQuery($id))
            ->whereDate('created_at', today())
            ->sum('publisher_revenue');
    }

    private function earningsYesterday(int $id): float
    {
        return (float) (clone $this->baseQuery($id))
            ->whereDate('created_at', today()->subDay())
            ->sum('publisher_revenue');
    }

    private function earningsTotal(int $id): float
    {
        return (float) (clone $this->baseQuery($id))
            ->sum('publisher_revenue');
    }

    /* ---------------- EPC ---------------- */

    private function epc(int $id): float
    {
        $clicks = $this->clicksTotal($id);

        if ($clicks === 0) {
            return 0;
        }

        return round(
            $this->earningsTotal($id) / $clicks,
            4
        );
    }

    /* ---------------- TOP ZONES ---------------- */

    private function topZones(int $id): array
    {
        return $this->baseQuery($id)
            ->select(
                'ad_zone_id',
                DB::raw('COUNT(*) as clicks'),
                DB::raw('SUM(publisher_revenue) as earnings')
            )
            ->whereNotNull('ad_zone_id')
            ->groupBy('ad_zone_id')
            ->orderByDesc('earnings')
            ->get()
            ->map(fn ($row) => [
                'ad_zone_id' => $row->ad_zone_id,
                'name'       => 'Zone #' . $row->ad_zone_id,
                'clicks'     => (int) $row->clicks,
                'earnings'   => (float) $row->earnings,
            ])
            ->toArray();
    }

    /* ---------------- TOP ADS ---------------- */

    private function topAds(int $id): array
    {
        return $this->baseQuery($id)
            ->select(
                'ad_id',
                DB::raw('COUNT(*) as clicks'),
                DB::raw('SUM(publisher_revenue) as earnings')
            )
            ->groupBy('ad_id')
            ->orderByDesc('earnings')
            ->get()
            ->map(fn ($row) => [
                'ad_id'    => $row->ad_id,
                'title'    => 'Ad #' . $row->ad_id,
                'clicks'   => (int) $row->clicks,
                'earnings' => (float) $row->earnings,
            ])
            ->toArray();
    }

    /* ---------------- CHART (FIXED) ---------------- */

    public function getLast7DaysChart(int $publisherId): array
    {
        $days = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $clicks = Click::where('publisher_id', $publisherId)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as clicks')
            ->groupBy('date')
            ->pluck('clicks', 'date');

        $earnings = Click::where('publisher_id', $publisherId)
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(publisher_revenue) as earnings')
            ->groupBy('date')
            ->pluck('earnings', 'date');

        return [
            'labels' => $days,
            'clicks' => $days->map(fn ($d) => $clicks[$d] ?? 0)->values(),
            'earnings' => $days->map(fn ($d) => (float) ($earnings[$d] ?? 0))->values(),
        ];
    }
}