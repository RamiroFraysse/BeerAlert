var swReg;
var swLocation;
// var key;
//referencias a los botones
var btnActivadas = $('.btn-noti-activadas');
var btnDesactivadas = $('.btn-noti-desactivadas');


//Hacemos el registro cuando nuestra página web ya esta cargada 
if ( navigator.serviceWorker ) {
    swLocation = 'sw.js';
    window.addEventListener('load',function(){
        navigator.serviceWorker.register(swLocation).then(function(reg){
            //El navegador web esta cargado por completo
            swReg = reg;
            //confirmar si ya esta subscripto
            swReg.pushManager.getSubscription()
            //.then(initPush)
            .then(verificaSuscripcion)
            .catch(error => console.log);
        });
    });
}

//convierte la clave a un formato apropiado
function urlBase64ToUint8Array(base64String) {
    
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    console.log(outputArray);
    return outputArray;
}

function verificaSuscripcion(activadas){
    //Por el momento 
    if(activadas){
        console.log('activadas');
        btnActivadas.removeClass('oculto');
        btnDesactivadas.addClass('oculto');
    }else{
        console.log('desactivadas');
        btnActivadas.addClass('oculto');
        btnDesactivadas.removeClass('oculto');
    }
}

function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    fetch('/BeerAlert/public/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    })
    .then(verificaSuscripcion)
    .catch((err) => {
        cancelarSubscripcion();
        console.log(err)
    });        
}

function getPublicKey(){
    //obtengo la llave
    return fetch('/BeerAlert/public/key')
    .then(response => response.json())
    .then(data => {        
        key = data.publicKey;
        return key;
    });
}

function cancelarSubscripcion(){
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    //Obtenemos la subscipcion actual
    swReg.pushManager.getSubscription().then(subs => {
        subs.unsubscribe().then(()=> verificaSuscripcion(false));
        fetch('/BeerAlert/public/deleteSubscribe',{
            method: 'POST',
            body: JSON.stringify(subs),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
         }
        }).then(res => console.log(res));
    });
}

btnDesactivadas.on('click',function(){
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    if(!swReg)
        return console.log('No hay registro del sw');
    
    getPublicKey().then(key => {
        swReg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(key)
        }).then(res => res.toJSON())
        .then( suscripcion => {
        //posteo de la suscripcion
            storePushSubscription(suscripcion);
        })
    .catch(console.log);
    })
})

btnActivadas.on( 'click',function(){
    cancelarSubscripcion();  
})
