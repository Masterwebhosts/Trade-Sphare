(function () {

    const script = document.currentScript;

    if (!script) {
        console.error('AD SCRIPT ERROR: currentScript not found');
        return;
    }

    const zoneId = script.dataset.zone;

    if (!zoneId) {
        console.error('AD SCRIPT ERROR: zone id missing');
        return;
    }

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

            container.setAttribute(
                'data-zone-id',
                zoneId
            );


            container.style.cssText = `
                border:1px solid #ddd;
                padding:10px;
                border-radius:6px;
                text-align:center;
                max-width:300px;
                font-family:Arial,sans-serif;
                background:#fff;
            `;



            // TITLE
            if (ad.title) {

                const title = document.createElement('strong');

                title.textContent = ad.title;

                title.style.display = 'block';

                container.appendChild(title);

            }



            // IMAGE
            if (ad.media_url) {

                const img = document.createElement('img');

                img.src = ad.media_url;

                img.alt = ad.title || 'Advertisement';

                img.style.maxWidth = '100%';

                img.style.marginTop = '8px';

                img.style.borderRadius = '4px';

                container.appendChild(img);

            }



            // DESCRIPTION
            if (ad.description) {

                const text = document.createElement('p');

                text.textContent = ad.description;

                text.style.marginTop = '8px';

                container.appendChild(text);

            }



            // BUTTON
            if (ad.target_url) {

                const a = document.createElement('a');

                a.href = ad.target_url;

                a.target = '_blank';

                a.rel = 'noopener noreferrer';

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

                    fetch(`${baseUrl}/api/track/click`, {

                        method: 'POST',

                        headers: {

                            'Content-Type': 'application/json',

                            'Accept': 'application/json'

                        },

                        body: JSON.stringify({
                            ad_id: ad.id,
                            zone_token: zoneId
                        })

                    }).catch(() => { });


                });


                container.appendChild(a);

            }



            // إضافة الإعلان بعد السكربت
            script.insertAdjacentElement(
                'afterend',
                container
            );



            // IMPRESSION
            fetch(`${baseUrl}/api/track/impression`, {

                method: 'POST',

                headers: {

                    'Content-Type': 'application/json',

                    'Accept': 'application/json'

                },
                body: JSON.stringify({
                    ad_id: ad.id,
                    zone_token: zoneId
                })

            }).catch(() => { });



        })


        .catch(err => {

            console.error(
                'AD SERVE ERROR:',
                err
            );

        });


})();