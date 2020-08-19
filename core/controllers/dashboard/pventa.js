// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PVENTA = '../../core/api/dashboard/pventa.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_PVENTA );
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
                    return `<img src="../../resources/img/pventa/${data.imagen}" class="materialboxed" height="100">`;
                },
                targets: -1
                },
                { data: 'punto_venta' },
                { data: 'direccion' },
                { data: null,
                orderable: false,
                    
                render:function(data, type, row)
                {
                  return `
                        <td>
                            <a href="#" onclick="openUpdateModal(${data.id_punto_venta})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                            <a href="#" onclick="openDeleteDialog(${data.id_punto_venta})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                        </td>`;
                },
                targets: -1
                },
            ]
        } );
    }
}

// Evento para mostrar los resultados de una búsqueda.
$( '#search-form' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se llama a la función que realiza la búsqueda. Se encuentra en el archivo components.js
    searchRows( API_PVENTA, this );
});

// Función que prepara formulario para insertar un registro.
function openCreateModal()
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Crear punto de venta' );
    // Se establece el campo de tipo archivo como obligatorio.
    $( '#imagen' ).prop( 'required', true );
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar punto de venta' );
    // Se establece el campo de tipo archivo como opcional.
    $( '#imagen' ).prop( 'required', false );

    $.ajax({
        dataType: 'json',
        url: API_PVENTA + 'readOne',
        data: { id_punto_venta: id },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_punto_venta' ).val( response.dataset.id_punto_venta );
            $( '#punto_venta' ).val( response.dataset.punto_venta );
            $( '#direccion' ).val( response.dataset.direccion );
            // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
            M.updateTextFields();
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
}

// Evento para crear o modificar un registro.
$( '#save-form' ).submit(function( event ) {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se comprueba si el campo oculto del formulario esta seteado para actualizar, de lo contrario se crea un registro.
    if ( $( '#id_punto_venta' ).val() ) {
        saveRow( API_PVENTA, 'update', this, 'save-modal' );
    } else {
        saveRow( API_PVENTA, 'create', this, 'save-modal' );
    }
});

// Función para establecer el registro a eliminar y abrir una caja de dialogo para confirmar.
function openDeleteDialog( id )
{
    // Se declara e inicializa un objeto con el id del registro que será borrado.
    let identifier = { id_punto_venta: id };
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete( API_PVENTA, identifier );
}