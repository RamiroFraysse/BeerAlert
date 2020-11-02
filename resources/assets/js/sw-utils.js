//guardar en el cache dinamico
function actualizaCacheDinamico(dynamicCache,req,res){
        if( res.ok ){
            //data a almacenar en el cache
            if(req.url.includes('/key') || req.url.includes('/edit') || req.url.includes('/login') || req.url.includes('/logout'))
                return res.clone();
            else{
                return caches.open(dynamicCache).then( cache => {
                    cache.put(req,res.clone());
                    return res.clone();
                });
            }
        }else{
            return res; //va a ser un 404, o un error de que no cons el registro por ej
        }
}

// Cache with network update
function actualizaCacheStatico( staticCache, req, APP_SHELL_INMUTABLE ) {
    if ( APP_SHELL_INMUTABLE.includes(req.url) ) {
        // No hace falta actualizar el inmutable
        // console.log('existe en inmutable', req.url );

    } else {
        // console.log('actualizando', req.url );
        return fetch( req )
                .then( res => {
                    //para reutilizar el codigo, esto es para que nuestro cache siempre lo vamos a estar utilizando
                    return actualizaCacheDinamico( staticCache, req, res );
                });
    }

}

//Network with cache fallback/update
function manejoApiMensajes(cacheName, req){
    console.log('tengo que guardarlo');
    // //clono los req porque si los consumo una vez, ya no se pueden volver a utilizar.
    // if(req.clone().method === 'POST'){
    //     if(self.registration.sync){ //el self apunta al service worker
    //         //req.clone().text extraigo la informacion que se encuentra en el req
    //         return req.clone().text().then(body => {
    //             console.log(body);
    //             //podemos leer y obtener el objeto
    //             //almacenamos en db
    //             const bodyObj = JSON.parse(body);//paso de json a objeto
    //             return guardarMensaje(bodyObj);
    
    //         });
    //     }else{
    //         //No soporta sync manager
    //         return fetch(req);   
    //     }
    // }else{
    //     console.log('ENTRA AL ELSE');
    //     return fetch(req).then(res => {
    //         if(res.ok){
    //             actualizaCacheDinamico(cacheName,req,res.clone());
    //             return res.clone();
    //         }else{
    //             //respuesta no es exitosa
    //             return caches.match(req);
    //         }
    
    //     }).catch(err => {
    //         //no tiene conexion a internet
    //         return caches.match(req); //sino logra encontrar nada retorna undifined
    //     });
    // } 
   
}