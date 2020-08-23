// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PRODUCTOS = '../../core/api/dashboard/productos.php?action=';
const API_PEDIDOS = '../../core/api/dashboard/pedidos.php?action=';
const API_CLIENTES = '../../core/api/dashboard/clientes.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se declara e inicializa un objeto con la fecha y hora actual del cliente.
    let today = new Date();
    // Se declara e inicializa una variable con el número de horas transcurridas en el día.
    let hour = today.getHours();
    // Se declara e inicializa una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if ( hour < 12 ) {
        greeting = 'Buenos días, ';
    } else if ( hour < 19 ) {
        greeting = 'Buenas tardes, ';
    } else if ( hour <= 23 ) {
        greeting = 'Buenas noches, ';
    }
    // Se muestra el saludo en la página web.
    $( '#greeting' ).text( greeting + USER_NAME);
    // Se llama a la función que muestra una gráfica en la página web.
    graficaCategorias();
    graficaFiveBestSellers();
    graficaFiveClients();
    grafica7Dias();
    grafica7DiasClientes();
});

// Función para graficar la cantidad de productos por categoría.
function graficaCategorias()
{
    $.ajax({
        dataType: 'json',
        url: API_PRODUCTOS + 'cantidadProductosCategoria',
        data: null
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se remueve la etiqueta canvas asignada para la gráfica.
        if ( response.status ) {
            // Se declaran los arreglos para guardar los datos por gráficar.
            let categorias = [];
            let cantidad = [];
            // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                // Se asignan los datos a los arreglos.
                categorias.push( row.tipo_producto );
                cantidad.push( row.cantidad );
            });
            // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
            barGraph( 'productosporcategoria', categorias, cantidad, 'Cantidad de productos', 'Cantidad de productos por categoría' );
        } else {
            $( '#productosporcategoria' ).remove();
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

// Función para graficar la cantidad pedidos 7 días anteriores al actual.
function grafica7Dias()
{
    $.ajax({
        dataType: 'json',
        url: API_PEDIDOS + '7Dias',
        data: null
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se remueve la etiqueta canvas asignada para la gráfica.
        if ( response.status ) {
            // Se declaran los arreglos para guardar los datos por gráficar.
            let fecha = [];
            let pedidos = [];
            // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                // Se asignan los datos a los arreglos.
                fecha.push( row.fecha );
                pedidos.push( row.pedidos );
            });
            // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
            barGraph( '7dias', fecha, pedidos, 'Cantidad de pedidos', 'Cantidad de pedidos de los últimos 7 días' );
        } else {
            $( '#7dias' ).remove();
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

// Función para graficar la cantidad clientes registrados 7 días anteriores al actual.
function grafica7DiasClientes()
{
    $.ajax({
        dataType: 'json',
        url: API_CLIENTES + '7DiasClientes',
        data: null
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se remueve la etiqueta canvas asignada para la gráfica.
        if ( response.status ) {
            // Se declaran los arreglos para guardar los datos por gráficar.
            let fecha = [];
            let clientes = [];
            // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                // Se asignan los datos a los arreglos.
                fecha.push( row.fecha_registro );
                clientes.push( row.clientes );
            });
            // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
            barGraph( 'clientes7dias', fecha, clientes, 'Cantidad de registros', 'Cantidad de registros de clientes de los últimos 7 días' );
        } else {
            $( '#clientes7dias' ).remove();
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

// Función para graficar 5 productos más vendidos
function graficaFiveBestSellers()
{
    $.ajax({
        dataType: 'json',
        url: API_PRODUCTOS + 'fiveBestSellers',
        data: null
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se remueve la etiqueta canvas asignada para la gráfica.
        if ( response.status ) {
            // Se declaran los arreglos para guardar los datos por gráficar.
            let producto = [];
            let pedidos = [];
            // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                // Se asignan los datos a los arreglos.
                producto.push( row.nombre_producto );
                pedidos.push( row.pedidos );
            });
            // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
            doughnutGraph( '5productos', producto, pedidos, 'Top 5 productos más vendidos' );
        } else {
            $( '#5productos' ).remove();
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

// Función para graficar 5 clientes con más pedidos
function graficaFiveClients()
{
    $.ajax({
        dataType: 'json',
        url: API_PEDIDOS + 'fiveClients',
        data: null
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado datos, de lo contrario se remueve la etiqueta canvas asignada para la gráfica.
        if ( response.status ) {
            // Se declaran los arreglos para guardar los datos por gráficar.
            let cliente = [];
            let pedidos = [];
            // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
            response.dataset.forEach(function( row ) {
                // Se asignan los datos a los arreglos.
                cliente.push( row.usuario_c );
                pedidos.push( row.pedidoscliente );
            });
            // Se llama a la función que genera y muestra una gráfica de barras. Se encuentra en el archivo components.js
            doughnutGraph( '5clientes', cliente, pedidos, 'Top 5 clientes con más pedidos' );
        } else {
            $( '#5clientes' ).remove();
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

