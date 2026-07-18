@extends('layouts.app')

@section('content')

<h1>Analytics Dashboard</h1>

@php
    // KPI DATA (safe defaults)
    $clicks = $clicks ?? 0;
    $impressions = $impressions ?? 0;
    $revenue = $revenue ?? 0;

    $ctr = $impressions > 0 ? ($clicks / $impressions) * 100 : 0;

    // حماية من null collections
    $clicksByDay = $clicksByDay ?? collect([]);
    $impressionsByDay = $impressionsByDay ?? collect([]);

    $datesClicks = $clicksByDay->pluck('date')->values();
    $valuesClicks = $clicksByDay->pluck('total')->values();

    $datesImpr = $impressionsByDay->pluck('date')->values();
    $valuesImpr = $impressionsByDay->pluck('total')->values();
@endphp

<!-- KPIs -->
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:15px; margin-bottom:30px;">

    <div style="background:white; padding:15px;">
        <h3>Clicks</h3>
        <h2>{{ $clicks }}</h2>
    </div>

    <div style="background:white; padding:15px;">
        <h3>Impressions</h3>
        <h2>{{ $impressions }}</h2>
    </div>

    <div style="background:white; padding:15px;">
        <h3>CTR</h3>
        <h2>{{ number_format($ctr, 2) }}%</h2>
    </div>

    <div style="background:white; padding:15px;">
        <h3>Revenue</h3>
        <h2>${{ number_format($revenue, 2) }}</h2>
    </div>

</div>

<!-- CHARTS -->
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    <div style="background:white; padding:20px;">
        <h3>Clicks Trend</h3>
        <canvas id="clicksChart"></canvas>
    </div>

    <div style="background:white; padding:20px;">
        <h3>Impressions Trend</h3>
        <canvas id="impressionsChart"></canvas>
    </div>

</div>

<script>
const clicksLabels = @json($datesClicks);
const clicksData = @json($valuesClicks);

const impressionsLabels = @json($datesImpr);
const impressionsData = @json($valuesImpr);

new Chart(document.getElementById('clicksChart'), {
    type: 'line',
    data: {
        labels: clicksLabels,
        datasets: [{
            label: 'Clicks',
            data: clicksData,
            borderColor: 'blue',
            fill: false
        }]
    }
});

new Chart(document.getElementById('impressionsChart'), {
    type: 'line',
    data: {
        labels: impressionsLabels,
        datasets: [{
            label: 'Impressions',
            data: impressionsData,
            borderColor: 'green',
            fill: false
        }]
    }
});
</script>

@endsection
