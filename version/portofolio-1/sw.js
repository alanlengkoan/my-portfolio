var CACHE_NAME = 'cache-saya-1';
var FILES_TO_CACHE = [
  '/',
  'index.html',
  'gambar/gambar.png',
  'gambar/gambar.jpg',
  'gambar/bg.webp',
  'gambar/launcher-icon-4x.png',
  'gambar/projects/project1.webp',
  'gambar/projects/project2.webp',
  'gambar/projects/project3.webp',
  'gambar/projects/project4.webp',
  'gambar/projects/project5.webp',
  'gambar/projects/project6.webp',
  'gambar/projects/project-detail1.webp',
  'gambar/projects/project-detail2.webp',
  'gambar/projects/project-detail3.webp',
  'gambar/projects/project-detail4.webp',
  'gambar/projects/project-detail5.webp',
  'gambar/projects/project-detail6.webp',
  'vendor/bootstrap/css/bootstrap.min.css',
  'vendor/font-awesome/css/font-awesome.min.css',
  'vendor/font-awesome/fonts/fontawesome-webfont.woff?v=4.6.3',
  'vendor/font-awesome/fonts/fontawesome-webfont.woff2?v=4.6.3',
  'vendor/font-awesome/fonts/fontawesome-webfont.ttf?v=4.6.3',
  'css/style.css',
  'vendor/jquery/jquery.min.js',
  'vendor/bootstrap/js/bootstrap.min.js',
  'vendor/jquery-easing/jquery.easing.min.js',
  'vendor/js/dinamis.js',
  'vendor/js/scrollreveal.js',
  'vendor/js/app.js',
  'manifest.json'
];

// install services worker
self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
    .then(function (cache) {
      console.log('Menyimpan file cache untuk offline');
      return cache.addAll(FILES_TO_CACHE);
    })
  );
});

// untuk memanggil services worker
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request).then(function (response) {
      // Cache hit - return response
      if (response) {
        return response;
      }
      return fetch(event.request);
    })
  );
});

self.addEventListener('activate', function (event) {
  // untuk menghapus cache lama
  event.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(keyList.map((key) => {
        if (key !== CACHE_NAME) {
          console.log('menghapus cache lama', key);
          return caches.delete(key);
        }
      }));
    })
  );

  event.waitUntil(self.clients.claim());

  console.log('Service Worker activating.');
});