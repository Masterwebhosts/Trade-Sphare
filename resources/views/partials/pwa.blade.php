<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

<meta name="theme-color" content="#2563eb">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

<style>
    #trade-sphare-install-prompt {
        position: fixed;
        right: 16px;
        left: 16px;
        bottom: 16px;
        z-index: 99999;
        display: none;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        direction: rtl;
        font-family: inherit;
    }

    #trade-sphare-install-prompt .pwa-install-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border-radius: 12px;
        object-fit: cover;
    }

    #trade-sphare-install-prompt .pwa-install-content {
        flex: 1;
        min-width: 0;
    }

    #trade-sphare-install-prompt .pwa-install-title {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    #trade-sphare-install-prompt .pwa-install-text {
        margin: 0;
        font-size: 13px;
        line-height: 1.5;
        color: #6b7280;
    }

    #trade-sphare-install-prompt .pwa-install-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    #trade-sphare-install-prompt button {
        border: 0;
        cursor: pointer;
        font: inherit;
    }

    #trade-sphare-install-prompt .pwa-install-button {
        padding: 9px 14px;
        border-radius: 10px;
        background: #2563eb;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
    }

    #trade-sphare-install-prompt .pwa-install-dismiss {
        padding: 8px;
        background: transparent;
        color: #6b7280;
        font-size: 13px;
    }

    @media (max-width: 640px) {
        #trade-sphare-install-prompt {
            align-items: flex-start;
            bottom: 12px;
            right: 12px;
            left: 12px;
            padding: 12px;
        }

        #trade-sphare-install-prompt .pwa-install-actions {
            flex-direction: column;
        }

        #trade-sphare-install-prompt .pwa-install-button {
            white-space: nowrap;
        }
    }
</style>

<div id="trade-sphare-install-prompt" role="dialog" aria-label="تثبيت تطبيق Trade Sphare">
    <img
        class="pwa-install-icon"
        src="{{ asset('icons/icon-192.png') }}"
        alt="Trade Sphare"
    >

    <div class="pwa-install-content">
        <p class="pwa-install-title">ثبت Trade Sphare</p>
        <p class="pwa-install-text">ثبت التطبيق للوصول إليه بسرعة من جهازك.</p>
    </div>

    <div class="pwa-install-actions">
        <button type="button" class="pwa-install-button" id="trade-sphare-install-button">
            تثبيت
        </button>

        <button type="button" class="pwa-install-dismiss" id="trade-sphare-install-dismiss">
            لاحقا
        </button>
    </div>
</div>

<script>
    (function () {
        let deferredPrompt = null;

        const prompt = document.getElementById('trade-sphare-install-prompt');
        const installButton = document.getElementById('trade-sphare-install-button');
        const dismissButton = document.getElementById('trade-sphare-install-dismiss');

        if (!prompt || !installButton || !dismissButton) {
            return;
        }

        const showPrompt = function () {
            prompt.style.display = 'flex';
        };

        const hidePrompt = function () {
            prompt.style.display = 'none';
        };

        const isStandalone = function () {
            return window.matchMedia('(display-mode: standalone)').matches
                || window.navigator.standalone === true;
        };

        window.addEventListener('beforeinstallprompt', function (event) {
            event.preventDefault();
            deferredPrompt = event;

            if (!isStandalone()) {
                showPrompt();
            }
        });

        window.addEventListener('appinstalled', function () {
            deferredPrompt = null;
            hidePrompt();
        });

        dismissButton.addEventListener('click', function () {
            hidePrompt();
        });

        installButton.addEventListener('click', async function () {
            if (!deferredPrompt) {
                return;
            }

            deferredPrompt.prompt();

            const choice = await deferredPrompt.userChoice;

            deferredPrompt = null;

            if (choice.outcome === 'accepted') {
                hidePrompt();
            }
        });

        /*
         * إذا لم يرسل المتصفح beforeinstallprompt
         * نظهر نفس الـPopup بدون أي تعليمات إضافية.
         */
        setTimeout(function () {
            if (!isStandalone() && !deferredPrompt) {
                showPrompt();
            }
        }, 2500);
    })();

    /*
     * تسجيل Service Worker.
     */
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('{{ asset('service-worker.js') }}', {
                scope: '/'
            }).catch(function (error) {
                console.error('Trade Sphare service worker registration failed:', error);
            });
        });
    }
</script>
