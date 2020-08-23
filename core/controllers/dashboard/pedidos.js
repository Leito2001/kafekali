// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_PEDIDOS = '../../core/api/dashboard/pedidos.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_PEDIDOS );
});

// Función para llenar la tabla con los datos de los registros.
function fillTable( dataset )
{
    var table = $('#tabla');
    if($.fn.dataTable.isDataTable(table)){
        table = $('#tabla').DataTable();
        table.clear();
        table.rows.add(dataset);
        table.draw();
    }
    else{
        table.DataTable( {
            responsive: true,
            bLengthChange: false,
            dom:
            "<'row'<'col-sm-12 col-md-12'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            data: dataset,
            language: {
                url: '../../resources/es_ES.json'
            },
            columns: [
                { data: null,
                    ordereable: false,
                    render: function(data, type, meta) 
                    {
                        return `<img src="../../resources/img/productos/${data.imagen_producto}" class="materialboxed" height="100">`;
                    },
                    targets: -1
                    },
                { data: 'usuario_c' },
                { data: 'nombre_producto' },
                { data: 'precio' },
                { data: 'cantidad_producto' },
                { data: 'total' },
                { data: 'fecha' },
                { data: 'estado_pedido' },
                { data: null,
                orderable: false,
                    
                render:function(data, type, row)
                {
                  return `
                        <td>
                            <a href="#" onclick="openUpdateModal(${data.id_detalle_pedido})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                        </td>`;
                },
                targets: -1
                },
            ]
        } );
    }
}

//Función para llenar el combobox de estado_pedido
function getEstados(selectedId = 0){
    $.ajax({
        url: API_PEDIDOS + 'getEstados',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            let jsonResponse = response.dataset;
            let dropDown = selectedId == 0 ? `<option value="" disabled selected>Seleccione el estado</option>` : '';

            jsonResponse.forEach(sstatus => {
                //verificamos si el id que esta pasando ahorita es el mismo que el recibido, para aplicarle el estado de seleccionado
                let estado = ((sstatus.id_estado_pedido == selectedId) ? ' selected' : '');
                dropDown += `
                    <option value="${sstatus.id_estado_pedido}"${estado}>${sstatus.estado_pedido}</option>
                `;
            });

            $('#estado_pedido').html(dropDown);
            $('#estado_pedido').formSelect();
        },
        error: function (jqXHR) {
            // Se verifica si la API ha respondido para mostrar la respuesta, de lo contrario se presenta el estado de la petición.
            if (jqXHR.status == 200) {
                console.log(jqXHR.responseText);
            } else {
                console.log(jqXHR.status + ' ' + jqXHR.statusText);
            }
        }
    });
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar pedido' );
    // Se deshabilitan los campos
    $( '#usuario_c' ).prop( 'disabled', true );
    $( '#nombre_producto' ).prop( 'disabled', true );
    $( '#cantidad_producto' ).prop( 'disabled', true );
    $( '#fecha' ).prop( 'disabled', true );

    $.ajax({
        dataType: 'json',
        url: API_PEDIDOS + 'readOne',
        data: { id_detalle_pedido: id },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            jsonResponse = response.dataset['0'];
            console.log(response);
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_pedido' ).val( jsonResponse.id_pedido );
            $( '#id_detalle_pedido' ).val( jsonResponse.id_detalle_pedido );
            $( '#usuario_c' ).val( jsonResponse.usuario_c );
            $( '#nombre_producto' ).val( jsonResponse.nombre_producto );
            $( '#cantidad_producto' ).val( jsonResponse.cantidad_producto );
            $( '#fecha' ).val( jsonResponse.fecha );
            getEstados(jsonResponse.id_estado_pedido);
            // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
            M.updateTextFields();
        } else {
            sweetAlert( 2, result.exception, null );
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

// Evento para crear o modificar un registro.
$( '#save-form' ).submit(function( event ) {
    event.preventDefault();
    // Se llama a la función que crea o actualiza un registro. Se encuentra en el archivo components.js
    // Se comprueba si el id del registro esta asignado en el formulario para actualizar, de lo contrario se crea un registro.
    if ( $( '#id_detalle_pedido' ).val() ) {
        saveRow( API_PEDIDOS, 'updateEstado', this, 'save-modal' ); 
    } else {
        saveRow( API_PEDIDOS, 'create', this, 'save-modal' );
    }
    $( '#save-form' )[0].reset();
});
