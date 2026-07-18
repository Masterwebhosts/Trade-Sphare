(function () {

    const script = document.currentScript;
    if (!script) return;

    const zoneId = script.dataset.zone;
    if (!zoneId) return;

    const baseUrl = window.location.origin;

    fetch(`${baseUrl}/api/zones/${zoneId}/serve`, {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(r => r.ok ? r.json() : null)
        .then(res => {

            if (!res || !res.success || !res.data) return;

            const ad = res.data;

            const container = document.createElement('div');
            container.style.textAlign = 'center';
            container.style.margin = '10px 0';

            const link = document.createElement('a');
            link.href = ad.redirect_url || '#';
            link.target = '_blank';
            link.rel = 'noopener noreferrer';

            // IMAGE
            if (ad.image && typeof ad.image === 'string') {
                const img = document.createElement('img');
                img.src = ad.image;
                img.style.maxWidth = '100%';
                img.style.height = 'auto';

                img.onerror = function () {
                    this.remove();
                };

                container.appendChild(img);
            }

            // TITLE
            if (ad.title) {
                const title = document.createElement('div');
                title.textContent = ad.title;
                title.style.marginTop = '5px';
                title.style.fontSize = '14px';
                container.appendChild(title);
            }

            link.appendChild(container);
            script.parentNode.insertBefore(link, script);

            // IMPRESSION
            fetch(`${baseUrl}/api/zones/${zoneId}/impression`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ad_id: ad.ad_id,
                    zone_id: zoneId
                })
            }).catch(() => { });

        })
        .catch(() => { });

})();