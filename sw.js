self.addEventListener('install', (e) => {
  console.log('[Service Worker] Install');
});

self.addEventListener('fetch', (e) => {
  // Just fetch the request from the network (Basic PWA)
  e.respondWith(fetch(e.request));
});