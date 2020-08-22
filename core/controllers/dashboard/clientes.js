// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_CLIENTES = '../../core/api/dashboard/clientes.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_CLIENTES );
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
                //Se mandan a llamar los campos con el nombre que poseen en la base
                { data: 'apellido' },
                { data: 'nombre' },
                { data: 'correo' },
                { data: 'celular' },
                { data: 'direccion' },
                { data: 'dui' },
                { data: 'usuario_c' },
                { data: null,
                    ordereable: false,
                    render: function (data, type, meta) 
                        {
                            if (data.estado_usuario){
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
                            <a href="#" onclick="openUpdateModal(${data.id_cliente})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                        </td>`;
                },
                targets: -1
                },
            ]
        } );
    }
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar estado del cliente' );
    // Se deshabilitan los campos de usuario, fecha de nacimiento, DUI y contraseña.
    $( '#nombre' ).prop( 'disabled', true );
    $( '#apellido' ).prop( 'disabled', true );
    $( '#celular' ).prop( 'disabled', true );
    $( '#correo' ).prop( 'disabled', true );
    $( '#direccion' ).prop( 'disabled', true );
    $( '#dui' ).prop( 'disabled', true );
    $( '#fecha_nacimiento' ).prop( 'disabled', true );
    $( '#usuario_c' ).prop( 'disabled', true );

    $.ajax({
        dataType: 'json',
        url: API_CLIENTES + 'readOne',
        data: { id_cliente: id },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            jsonResponse = response.dataset;
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_cliente' ).val( jsonResponse.id_cliente );
            $( '#nombre' ).val( jsonResponse.nombre );
            $( '#apellido' ).val( jsonResponse.apellido );
            $( '#celular' ).val( jsonResponse.celular );
            $( '#correo' ).val( jsonResponse.correo );
            $( '#direccion' ).val( jsonResponse.direccion );
            $( '#dui' ).val( jsonResponse.dui );
            $( '#fecha_nacimiento' ).val( jsonResponse.fecha_nacimiento );
            $( '#usuario_c' ).val( jsonResponse.usuario_c );
            (jsonResponse.estado_usuario ) ? $( '#estado_usuario' ).prop( 'checked', true ) : $( '#estado_usuario' ).prop( 'checked', false );
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
    if ( $( '#id_cliente' ).val() ) {
        saveRow( API_CLIENTES, 'update', this, 'save-modal' );
    } else {
        saveRow( API_CLIENTES, 'create', this, 'save-modal' );
    }
    $( '#save-form' )[0].reset();
});
