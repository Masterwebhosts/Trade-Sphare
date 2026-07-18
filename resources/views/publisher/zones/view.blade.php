<div id="ad-zone-3"></div>

<script>
(async function () {
    try {
        const res = await fetch('/api/zones/3/serve', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!data.success || !data.data) {
            return;
        }

        const ad = data.data;

        const container = document.getElementById('ad-zone-3');

        container.innerHTML = `
            <a href="${ad.redirect_url}" target="_blank" rel="noopener noreferrer">
                <img src="${ad.image}" style="max-width:100%;display:block;border-radius:6px;">
            </a>
        `;
    } catch (e) {
        console.error('Ad loading error:', e);
    }
})();
</script>
