// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PEDIDOS = '../../core/api/commerce/pedidos.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los productos del carrito de compras para llenar la tabla en la vista.
    pastOrders();
});

// Función para obtener el detalle del pedido (carrito de compras).
function pastOrders()
{
    $.ajax({
        dataType: 'json',
        url: API_PEDIDOS + 'pastOrders'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje y se direcciona a la página principal.
        if ( response.status ) {
            // Se declara e inicializa una variable para concatenar las filas de la tabla en la vista.
            let content = '';
            // Se declara e inicializa una variable para calcular el importe por cada producto.
            let subtotal = 0;
            // Se declara e inicializa una variable para ir sumando cada subtotal y obtener el monto final a pagar.
            let total = 0;
            // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                subtotal = row.precio * row.cantidad_producto;
                total += subtotal;
                // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                content += `
                    <tr>
                        <td>${row.id_pedido}</td>
                        <!-- Se concatena la imagen del producto -->
                        <td><img src="../../resources/img/productos/${row.imagen_producto}" class="materialboxed" height="60"></td>
                        <td>${row.nombre_producto}</td>
                        <td>${row.precio}</td>
                        <td>${row.cantidad_producto}</td>
                        <td>${row.fecha}</td>
                        <td>${row.estado_pedido}</td>
                        <!-- Se concatena el resultado de la funcion subtotal -->
                        <td>${subtotal.toFixed(2)}</td>
                        <td>
                            <a href="#" onclick="openReviewModal(${row.id_detalle_pedido})" class="${row.estado_pedido != 'Enviado' ? 'disabled' : ''} btn waves-effect amber darken-2 tooltipped" data-tooltip="Hacer una reseña"><i class="material-icons">star</i></a>
                        </td>
                    </tr>
                `;
            });
            // Se agregan las filas al cuerpo de la tabla mediante su id para mostrar los registros.
            $( '#tbody-rows' ).html( content );
            // Se muestra el total a pagar con dos decimales.
            $( '#pago' ).text( total.toFixed(2) );
            // Se inicializa el componente Tooltip asignado a los enlaces para que funcionen las sugerencias textuales.
            $( '.tooltipped' ).tooltip();
        } else {
            sweetAlert( 4, response.exception, 'index.php' );
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

// Función que abre una caja de dialogo (modal) con formulario para modificar la cantidad de producto.
function openReviewModal( id )
{
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#item-modal' ).modal( 'open' );
    // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
    $( '#id_detalle_pedido' ).val( id );
    // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
    M.updateTextFields();
}

// Evento para cambiar la cantidad de producto.
$( '#item-form' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    $.ajax({
        type: 'post',
        url: API_PEDIDOS + 'createReview',
        data: $( '#item-form' ).serialize(),
        dataType: 'json'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            // Se cierra la caja de dialogo (modal).
            $( '#item-modal' ).modal( 'close' );
            sweetAlert( 1, response.message, null );
        } else {
            sweetAlert( 2, response.exception, null );
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

// Evento para crear o modificar un registro.
$( '#save-form' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario se crea un registro.
    if ( $( '#id_detalle_pedido' ).val() ) {
        saveRow( API_PEDIDOS, 'update', this, 'save-modal' );
    } else {
        saveRow( API_PEDIDOS, 'createReview', this, 'save-modal' );
    }
});