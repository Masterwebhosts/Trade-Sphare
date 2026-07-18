(function () {

    'use strict';

    const script = document.currentScript;
    if (!script) return;

    const zoneId = script.dataset.zone;
    if (!zoneId) return;

    const baseUrl = script.dataset.base || window.location.origin;

    let impressionSent = false;

    function sendImpression(adId) {
        if (impressionSent) return;
        impressionSent = true;

        fetch(`${baseUrl}/api/zones/${zoneId}/impression`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            keepalive: true,
            body: JSON.stringify({
                ad_id: adId,
                zone_id: zoneId
            })
        }).catch(() => { });
    }

    function sendClick(adId) {
        fetch(`${baseUrl}/api/zones/${zoneId}/click`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            keepalive: true,
            body: JSON.stringify({
                ad_id: adId,
                zone_id: zoneId
            })
        }).catch(() => { });
    }

    function observeViewability(el, callback) {
        if (!('IntersectionObserver' in window)) {
            callback();
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                    callback();
                    observer.disconnect();
                }
            });
        }, { threshold: [0.5] });

        observer.observe(el);
    }

    fetch(`${baseUrl}/api/zones/${zoneId}/serve`, {
        headers: { 'Accept': 'application/json' }
    })
        .then(async res => {
            const text = await res.text();

            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Invalid JSON response:', text);
                return null;
            }
        })
        .then(res => {

            if (!res || !res.success || !res.data) return;

            const ad = res.data;

            const container = document.createElement('div');
            container.className = 'ad-container';
            container.style.cssText = `
            margin: 10px 0;
            text-align: center;
        `;

            const link = document.createElement('a');
            link.href = ad.redirect_url || '#';
            link.target = '_blank';
            link.rel = 'noopener noreferrer';

            link.addEventListener('click', () => {
                sendClick(ad.ad_id);
            });

            // IMAGE
            if (ad.image && typeof ad.image === 'string') {
                const img = document.createElement('img');

                img.src = ad.image;
                img.loading = 'lazy';

                img.style.cssText = `
                max-width: 100%;
                height: auto;
                display: block;
                margin: 0 auto;
            `;

                img.onerror = function () {
                    this.remove();
                };

                link.appendChild(img);
            }

            // TITLE
            if (ad.title) {
                const title = document.createElement('div');
                title.textContent = ad.title;
                title.style.cssText = `
                font-size: 14px;
                margin-top: 5px;
                color: #333;
            `;
                link.appendChild(title);
            }

            container.appendChild(link);
            script.insertAdjacentElement('afterend', container);

            observeViewability(container, () => {
                sendImpression(ad.ad_id);
            });

        })
        .catch(err => {
            console.error('Ad fetch failed:', err);
        });

})();