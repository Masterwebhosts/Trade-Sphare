const CACHE_VERSION = 'trade-sphare-v2';

const STATIC_CACHE = `${CACHE_VERSION}-static`;

const OFFLINE_URL = '/offline.html';

const STATIC_ASSETS = [
    OFFLINE_URL,
    '/manifest.webmanifest',

    '/icons/icon-192x192.png',
    '/icons/icon-192x192-maskable.png',
    '/icons/icon-512x512-maskable.png',

    '/icons/favicon-96x96.png',
    '/icons/favicon.svg',
    '/icons/favicon.ico',
    '/icons/apple-touch-icon.png'
];

const EXCLUDED_PREFIXES = [
    '/api/',
    '/admin/',
    '/advertiser/',
    '/publisher/',
    '/console/',
    '/tracking/',
    '/login',
    '/register',
    '/logout',
    '/forgot-password',
    '/reset-password',
    '/password/',
    '/email/',
    '/verify-email',
    '/confirm-password',
    '/profile',
    '/dashboard',
    '/management/',
    '/wallet/',
    '/withdrawals',
    '/subscriptions/',
    '/products/',
    '/ad/',
    '/ads-by-governorate',
    '/zones/',
    '/embed/'
];

function isExcludedPath(pathname) {
    return EXCLUDED_PREFIXES.some((prefix) => {
        return pathname === prefix || pathname.startsWith(prefix);
    });
}

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((cacheName) => cacheName !== STATIC_CACHE)
                        .map((cacheName) => caches.delete(cacheName))
                );
            })
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    if (url.origin !== self.location.origin) {
        return;
    }

    if (isExcludedPath(url.pathname)) {
        return;
    }

    /*
     * صفحات Laravel:
     * لا نخزنها حاليًا لأن Trade-Sphare يحتوي
     * على صفحات وبيانات مرتبطة بالمستخدم.
     */
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => {
                return caches.match(OFFLINE_URL);
            })
        );

        return;
    }

    /*
     * الملفات الثابتة:
     * Cache First
     */
    const staticDestination = [
        'style',
        'script',
        'image',
        'font'
    ];

    if (staticDestination.includes(request.destination)) {
        event.respondWith(
            caches.match(request).then((cachedResponse) => {

                if (cachedResponse) {
                    return cachedResponse;
                }

                return fetch(request).then((response) => {

                    if (response.ok) {
                        const responseClone = response.clone();

                        caches.open(STATIC_CACHE)
                            .then((cache) => {
                                cache.put(request, responseClone);
                            });
                    }

                    return response;
                });

            })
        );
    }
});