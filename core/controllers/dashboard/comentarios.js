// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_COMENTARIOS = '../../core/api/dashboard/comentarios.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_COMENTARIOS );
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
                //Se mandan a llamar los campos con el nombre que poseen en la base
                { data: 'nombre_producto' },
                { data: 'comentario' },
                { data: 'calificacion' },
                { data: 'usuario_c' },
                { data: 'fecha_review' },
                { data: null,
                ordereable: false,
                render: function (data, type, meta) 
                    {
                        if (data.estado_comentario){
                            return `<i class="material-icons">visibility</i>`;
                        } else {
                            return `<i class="material-icons">visibility_off</i>`;
                        }
                    },
                targets: -1
                },
                { data: null,
                orderable: false,
                render:function(data, type, row)
                {
                  return `
                        <td>
                            <a href="#" onclick="openUpdateModal(${data.id_comentario}, ${data.id_detalle_pedido})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar estado"><i class="material-icons">mode_edit</i></a>
                        </td>`;
                },
                targets: -1
                },
            ]
        } );
    }
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( comentario, detalle )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar estado de la reseña' );
    $( '#usuario_c' ).prop( 'disabled', true );
    $( '#nombre_producto' ).prop( 'disabled', true );
    $( '#calificacion' ).prop( 'disabled', true );
    $( '#fecha_review' ).prop( 'disabled', true );
    $( '#comentario' ).prop( 'disabled', true );

    $.ajax({
        dataType: 'json',
        url: API_COMENTARIOS + 'readOne',
        data: { id_comentario: comentario, id_detalle_pedido: detalle },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            jsonResponse = response.dataset[0];
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_detalle_pedido' ).val( jsonResponse.id_detalle_pedido );
            $( '#id_comentario' ).val( jsonResponse.id_comentario );
            $( '#usuario_c' ).val( jsonResponse.usuario_c );
            $( '#nombre_producto' ).val( jsonResponse.nombre_producto );
            $( '#calificacion' ).val( jsonResponse.calificacion );
            $( '#fecha_review' ).val( jsonResponse.fecha_review );
            $( '#comentario' ).val( jsonResponse.comentario );
            //Se configura el switch del estado según lo ingresado en la base, true o false.
            (jsonResponse.estado_comentario ) ? $( '#estado_comentario' ).prop( 'checked', true ) : $( '#estado_comentario' ).prop( 'checked', false );
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
    saveRow( API_COMENTARIOS, 'updateEstado', this, 'save-modal' );
    $( '#save-form' )[0].reset();
});
