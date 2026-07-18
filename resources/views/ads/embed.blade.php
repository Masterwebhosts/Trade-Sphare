<div style="
    border:1px solid #ddd;
    padding:12px;
    max-width:320px;
    font-family:Arial,sans-serif;
    border-radius:8px;
    background:#fff;
">

@if($ad)

    <h4 style="margin:0 0 10px;">
        {{ $ad->title }}
    </h4>
     
    <div style="margin-bottom:8px; display:flex; justify-content:flex-end;">
    <span onclick="window.location.href='/'"
          style="
            font-size:11px;
            background:#f3f4f6;
            color:#6b7280;
            padding:3px 8px;
            border-radius:999px;
            cursor:pointer;
            border:1px solid #e5e7eb;
            user-select:none;
          ">
        إعلان ممول
    </span>
</div>

    @if($ad->media_url)
    <img src="{{ $ad->media_url }}" style="width:100%;border-radius:6px;">
@endif

    @if($ad->description)
    <p style="margin-top:10px;color:#555;">
        {{ $ad->description }}
    </p>
@endif
    <div style="margin-top:15px">

    <a href="{{ $ad->target_url }}"
       target="_blank"
       rel="noopener noreferrer"
       onclick="trackClick(event, {{ $ad->id }}, '{{ $zone->token }}', '{{ $ad->target_url }}')"
       style="
            display:inline-block;
            padding:10px 15px;
            background:#111827;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
       ">
        زيارة الإعلان
    </a>

</div>
@else

    <div style="padding:20px;text-align:center;color:#999">
        لا يوجد إعلان متاح حالياً
    </div>

@endif

</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function trackClick(event, adId, zoneToken, url) {

    event.preventDefault();

    const win = window.open();

    fetch('/api/track/click', {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'X-CSRF-TOKEN':
                document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')

        },

        body: JSON.stringify({

            ad_id: adId,

            zone_token: zoneToken

        }),

        keepalive: true

    })
    .finally(() => {

        win.location = url;

    });
}
</script>