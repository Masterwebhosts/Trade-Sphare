(function () {

    const script = document.currentScript;
    const zoneId = script.dataset.zone;

    if (!zoneId) return;

    const baseUrl = script.dataset.base || window.location.origin;

    fetch(`${baseUrl}/api/zones/${zoneId}/serve?ts=${Date.now()}`)
        .then(res => res.json())
        .then(res => {

            if (!res || !res.success || !res.data) {
                console.log('❌ NO AD RETURNED FOR ZONE:', zoneId, res);
                return;
            }

            console.log('✅ AD RESPONSE:', res);

            const ad = res.data;

            // منع التكرار
            if (document.querySelector(`[data-zone-id="${zoneId}"]`)) {
                return;
            }

            const container = document.createElement('div');
            container.setAttribute('data-zone-id', zoneId);

            container.style.cssText = `
                border:1px solid #ddd;
                padding:10px;
                border-radius:6px;
                text-align:center;
                max-width:300px;
                font-family:Arial,sans-serif;
            `;

            // TITLE
            if (ad.title) {
                const title = document.createElement('strong');
                title.textContent = ad.title;
                container.appendChild(title);
            }

            // IMAGE
            if (ad.image) {
                const img = document.createElement('img');
                img.src = ad.image;
                img.style.maxWidth = '100%';
                img.style.marginTop = '8px';
                container.appendChild(img);
            }

            // TEXT
            if (ad.content) {
                const text = document.createElement('p');
                text.textContent = ad.content;
                text.style.marginTop = '8px';
                container.appendChild(text);
            }

            // BUTTON
            if (ad.redirect_url) {

                const a = document.createElement('a');
                a.href = ad.redirect_url;
                a.target = '_blank';
                a.textContent = 'Visit';

                a.style.cssText = `
                    display:inline-block;
                    margin-top:10px;
                    padding:8px 12px;
                    background:#111827;
                    color:#fff;
                    border-radius:6px;
                    text-decoration:none;
                `;

                a.addEventListener('click', function () {

                    fetch(`${baseUrl}/api/zones/${zoneId}/click`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ad_id: ad.ad_id
                        })
                    }).catch(() => { });

                });

                container.appendChild(a);
            }

            script.insertAdjacentElement('afterend', container);

            // IMPRESSION
            fetch(`${baseUrl}/api/zones/${zoneId}/impression`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    ad_id: ad.ad_id
                })
            }).catch(() => { });

        })
        .catch(err => {
            console.error('AD SERVE ERROR:', err);
        });

})();