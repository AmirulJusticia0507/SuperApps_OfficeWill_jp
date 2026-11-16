const CACHE_NAME = 'dep-service-static-v1';
const STATIC_ASSETS = [
    '/favicon.ico',
    '/img/officewill.png',
    '/img/pwa-icon-192.png',
    '/img/pwa-icon-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS)));
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => Promise.all(
            keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)),
        )),
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    if (request.method !== 'GET' || url.origin !== self.location.origin) return;

    // Only serve explicitly listed static assets from cache. Never cache pages,
    // form submissions, authenticated responses, or API data.
    if (STATIC_ASSETS.includes(url.pathname)) {
        event.respondWith(
            caches.match(request).then((cached) => cached || fetch(request)),
        );
    }
});
