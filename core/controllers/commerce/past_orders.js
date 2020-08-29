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