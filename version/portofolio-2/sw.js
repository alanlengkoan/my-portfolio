var CACHE_NAME = 'cache-saya-1';
var FILES_TO_CACHE = [
  '/',
  'index.html',
  'assets/css/style.css',
  'assets/img/gambar.png',
  'assets/img/profil.jpg',
  'assets/img/launcher-icon-1x.png',
  'assets/img/launcher-icon-2x.png',
  'assets/img/launcher-icon-4x.png',
  'assets/img/launcher-icon-5x.png',
  'assets/img/projects/project1.webp',
  'assets/img/projects/project2.webp',
  'assets/img/projects/project3.webp',
  'assets/img/projects/project4.webp',
  'assets/img/projects/project5.webp',
  'assets/img/projects/project6.webp',
  'assets/img/projects/project-detail1.webp',
  'assets/img/projects/project-detail2.webp',
  'assets/img/projects/project-detail3.webp',
  'assets/img/projects/project-detail4.webp',
  'assets/img/projects/project-detail5.webp',
  'assets/img/projects/project-detail6.webp',
  'assets/font-awesome/css/font-awesome.min.css',
  'assets/font-awesome/fonts/fontawesome-webfont.woff?v=4.6.3',
  'assets/font-awesome/fonts/fontawesome-webfont.woff2?v=4.6.3',
  'assets/font-awesome/fonts/fontawesome-webfont.ttf?v=4.6.3',
  'assets/bootstrap-4.5.0/css/bootstrap.min.css',
  'assets/bootstrap-4.5.0/js/bootstrap.min.js',
  'assets/js/jquery.min.js',
  'assets/js/jquery.easing.min.js',
  'assets/js/jquery.easypiechart.min.js',
  'assets/js/typed.min.js',
  'assets/js/dinamis.js',
  'assets/js/app.js',
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