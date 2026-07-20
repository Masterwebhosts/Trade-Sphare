const CACHE_NAME = "a3lani-v4";


const STATIC_FILES = [

    "/",
    "/manifest.json",
    "/offline.html",

    "/icons/icon-192.png",
    "/icons/icon-512.png"

];


// =========================
// Install
// =========================

self.addEventListener("install", event => {


    self.skipWaiting();


    event.waitUntil(

        caches.open(CACHE_NAME)

            .then(cache => {


                return cache.addAll(STATIC_FILES);


            })

            .catch(error => {

                console.log(
                    "Cache install error:",
                    error
                );

            })

    );


});





// =========================
// Activate
// =========================

self.addEventListener("activate", event => {


    event.waitUntil(


        caches.keys()

            .then(cacheNames => {


                return Promise.all(

                    cacheNames.map(cache => {


                        if (cache !== CACHE_NAME) {


                            return caches.delete(cache);


                        }


                    })

                );


            })

            .then(() => self.clients.claim())


    );


});






// =========================
// Fetch
// =========================


self.addEventListener("fetch", event => {



    const request = event.request;



    // صفحات Laravel

    if (request.mode === "navigate") {


        event.respondWith(


            fetch(request)

                .then(response => {


                    return response;


                })

                .catch(() => {


                    return caches.match(
                        "/offline.html"
                    );


                })


        );


        return;


    }





    // الملفات الثابتة


    event.respondWith(


        caches.match(request)

            .then(cached => {


                if (cached) {

                    return cached;

                }



                return fetch(request)

                    .then(response => {


                        return caches.open(CACHE_NAME)

                            .then(cache => {


                                cache.put(
                                    request,
                                    response.clone()
                                );


                                return response;


                            });


                    });


            })


    );



});