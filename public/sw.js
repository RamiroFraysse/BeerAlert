// imports
//Cuando el sw se instale, y se vaya a ejecutar va a leer esa instancia del pouchdb
//como es un recurso inmutable lo guardamos en el app shell inmutable.
// importScripts('https://cdn.jsdelivr.net/npm/pouchdb@7.0.0/dist/pouchdb.min.js');

// importScripts('js/sw-db.js');
importScripts('/BeerAlert/resources/assets/js/sw-utils.js');



const STATIC_CACHE    = 'static-v1';
const DYNAMIC_CACHE   = 'dynamic-v1';
const INMUTABLE_CACHE = 'inmutable-v1';


/**
 * El appshell contiene todo lo necesario para que mi aplicacion cargue de forma
 * instantánea o lo más rápido posible
 */
const APP_SHELL = [
    '/BeerAlert/public/',
    '/BeerAlert/public/home',
    '/BeerAlert/resources/views/layouts/app.blade.php',
    '/BeerAlert/resources/views/temp_dia.php',
    '/BeerAlert/resources/assets/js/sw-utils.js',
    '/BeerAlert/resources/assets/img/beer.png',
    '/BeerAlert/resources/assets/img/beer3.png',   
    '/BeerAlert/public/manifest.json',
    '/BeerAlert/public/js/appsw.js',
    '/BeerAlert/public/js/apphome.js',
    '/BeerAlert/public/css/app.css',
    '/BeerAlert/public/css/app2.css',
    '/BeerAlert/public/favicon.ico',
    '/BeerAlert/resources/assets/img/icons/favicon-152x152.png',
    '/BeerAlert/resources/assets/img/icons/favicon-128x128.png',
    '/BeerAlert/public/beer-ico-72x72.png',
];

/**
 * Todo lo que no vamos a poder cambiar lo agregamos en el inmutable 
 * Son librerias de terceros
 * */
const APP_SHELL_INMUTABLE = [
    'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
    'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
    'https://code.highcharts.com/highcharts.js',
    'https://code.highcharts.com/modules/series-label.js',
    'https://code.highcharts.com/modules/exporting.js',
    'https://code.highcharts.com/modules/export-data.js',
    'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',
];

/**
 * Almacenamos en el cache, el appshell y el inmutable
 */
self.addEventListener('install', e => {

    const cacheStatic = caches.open( STATIC_CACHE ).then(cache => 
        cache.addAll( APP_SHELL ));

    const cacheInmutable = caches.open( INMUTABLE_CACHE ).then(cache => 
        cache.addAll( APP_SHELL_INMUTABLE ));

    e.waitUntil( Promise.all([ cacheStatic, cacheInmutable ])  );
    console.log('instalado sw');

});

/*
 * Cada vez que cambie el sw, borre los caches anteriores que no me van a servir 
*/
self.addEventListener('activate', e => {

    const respuesta = caches.keys().then( keys => {
        keys.forEach( key => {
            //Borro versiones viejas del cache estático
            if (  key !== STATIC_CACHE && key.includes('static') ) {
                return caches.delete(key);
            }
            //Borro versiones viejas del cache dinámico
            if (  key !== DYNAMIC_CACHE && key.includes('dynamic') ) {
                return caches.delete(key);
            }
        });
    });
    e.waitUntil( respuesta );
    console.log('activado sw');

});




self.addEventListener( 'fetch', e => {
    
    let respuesta;
            // if(e.request.url.includes('/api')){
            //     //llamo a una funcion encargada de manejar las cosas relacionadas a la api.
            //     console.log('include api');
            //     respuesta =  manejoApiMensajes(DYNAMIC_CACHE,e.request);
            
            //CACHE WITH NEWTORK FALLBACK
            //1ro tengo que verificar en el cache si existe la request
            respuesta = caches.match( e.request ).then( res => {
                if ( res ) {
                    //existe en cache, regresa la respuesta del cache, y actualiza el cache para mantener la version mas reciente de la web.
                    actualizaCacheStatico( STATIC_CACHE, e.request, APP_SHELL_INMUTABLE );
                    return res;
                } else {
                    //no existe la en cache, voy a la web
                    console.log('se hizo un fetch con el request ',e.request.url,' y no estaba en el cache estático ni inmutable');
                    console.log(e.request);
                    if(e.request.method!='POST'){
                        return fetch( e.request ).then( newRes => {
                            return actualizaCacheDinamico( DYNAMIC_CACHE, e.request, newRes );
            
                        });
                    }else
                        return fetch(e.request);
                } 
            });
        // }
    e.respondWith( respuesta );

});

//Escuchar push para que se muestren
self.addEventListener('push', function (e) {
    console.log('push event');
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log(msg);
        //espera a que termine el envio de la notificacion push, luego accede al registro 
        //del service worker
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            badge: msg.icon,
            actions: msg.actions,
            vibrate: [100,30,100,30,100,200,200,30,200,30,200,200,100,30,100,30,100],
            data: {
                url: 'http://localhost:8080/BeerAlert/public/home'
            }
            
        }));
    }
});

self.addEventListener('notificationclick',e => {
    const notificacion = e.notification; //referencia a la notificacion completa
    const accion = e.action;
    const respuesta = 
    clients.matchAll() //agarra todos los tabs abierto del mismo sitio
    .then(clientes => {
        //si esta abierto quiero que mueva el tab que se encuentra visible
        let cliente = clientes.find( c => {
            return c.visibilityState ==='visible';
        });
        if(cliente !== undefined){
            cliente.navigate(notificacion.data.url);
            cliente.focus();//para que ese tab sea el que este activo en el navegador del cliente
        }else{
        //no tengo nada abierto
            clients.openWindow(notificacion.data.url);
        }
        return notificacion.close();//en el momento que se llame se cierra

    });
    e.waitUntil(respuesta);
});