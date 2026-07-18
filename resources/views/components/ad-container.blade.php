<div style="border:1px solid #ddd; padding:12px; max-width:320px; font-family: Arial, sans-serif; border-radius:8px;">

    @if($ad)

        <h4 style="margin:0 0 10px 0;">
            {{ $ad->title }}
        </h4>

        @if($ad->image_url)
            <img src="{{ $ad->image_url }}"
                 style="width:100%; height:auto; display:block; border-radius:6px;"
                 loading="lazy">
        @endif

        <div style="margin-top:12px;">
            <a href="{{ $ad->target_url }}"
               target="_blank"
               rel="noopener noreferrer"
               onclick="trackClick({{ $ad->id }}, {{ $zone->id }})">
                أنقر هنا لمشاهدة التفاصيل
            </a>
        </div>

    @else
        @include('ads.empty')
    @endif

</div>

<script>
function trackClick(adId, zoneId) {
    if (!adId || !zoneId) return;

    fetch(`/api/zones/${zoneId}/click`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ad_id: adId
        })
    }).catch(() => {});
}
</script>
