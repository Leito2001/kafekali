// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_CATALOGO = '../../core/api/commerce/catalogo.php?action=';
const API_PEDIDOS = '../../core/api/commerce/pedidos.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se busca en la URL las variables (parámetros) disponibles.
    let params = new URLSearchParams( location.search );
    // Se obtienen los datos localizados por medio de las variables.
    const ID = params.get( 'id' );
    // Se llama a la función que muestra el detalle del producto seleccionado previamente.
    readOneProducto( ID );
});

// Función para obtener y mostrar los datos del producto seleccionado.
function readOneProducto( id )
{
    $.ajax({
        dataType: 'json',
        url: API_CATALOGO + 'readOne',
        data: { id_producto: id },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se muestra un mensaje de error en pantalla.
        if ( response.status ) {
            // Se colocan los datos en la tarjeta de acuerdo al producto seleccionado previamente.
            $( '#imagen' ).prop( 'src', '../../resources/img/productos/' + response.dataset.imagen_producto );
            $( '#nombre' ).text( response.dataset.nombre_producto );
            $( '#descripcion' ).text( response.dataset.descripcion );
            $( '#precio' ).text( response.dataset.precio );
            // Se asignan los valores a los campos ocultos del formulario.
            $( '#id_producto' ).val( response.dataset.id_producto );
            $( '#precio' ).val( response.dataset.precio );
        } else {
            // Se presenta un mensaje de error cuando no existen datos para mostrar.
            $( '#title' ).html( `<i class="material-icons small">cloud_off</i><span class="red-text">${response.exception}</span>` );
            // Se limpia el contenido del div sino existen datos para mostrar.
            $( '#detalle' ).html( '' );
        }
    })
    .fail(function( jqXHR ) {
        // Se verifica si la API ha respondido para mostrar la respuesta, de lo contrario se presenta el estado de la petición.
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
}

// Evento para agregar un producto al carrito de compras.
$( '#shopping-form' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_PEDIDOS + 'createDetail',
        data: $( '#shopping-form' ).serialize(),
        dataType: 'json'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje.
        if ( response.status ) {
            sweetAlert( 1, response.message, 'cart.php' );
        } else {
            // Se verifica si el usuario ha iniciado sesión para mostrar algún error ocurrido, de lo contrario se direcciona para que se autentique. 
            if ( response.session ) {
                sweetAlert( 2, response.exception, null );
            } else {
                sweetAlert( 3, response.exception, 'login.php' );
            }
        }
    })
    .fail(function( jqXHR ) {
        // Se verifica si la API ha respondido para mostrar la respuesta, de lo contrario se presenta el estado de la petición.
        if ( jqXHR.status == 200 ) {
            console.log( jqXHR.responseText );
        } else {
            console.log( jqXHR.status + ' ' + jqXHR.statusText );
        }
    });
});