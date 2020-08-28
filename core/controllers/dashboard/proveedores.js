
// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_PROVEEDORES = '../../core/api/dashboard/proveedores.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_PROVEEDORES, $('#categoriesSpinner')[0]);
});

// Función para llenar la tabla con los datos enviados por readRows().
function fillTable( dataset )
{
    var table = $('#tabla');
    if($.fn.dataTable.isDataTable(table)){
        table = $('#tabla').DataTable();
        table.clear();
        //Se llena la tabla según los datos obtenidos
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
            //Se indica el lenguaje de la tabla en general
            language: {
                url: '../../resources/es_ES.json'
            },
            columns: [
                //Se mandan a llamar los campos con el nombre que poseen en la base
                { data: 'nombre_empresa' },
                { data: 'nombre_prov' },
                { data: 'celular' },
                { data: 'dui' },
                { data: 'numero_empresa' },
                { data: 'rubro' },
                { data: null,
                orderable: false,
                render:function(data, type, row)
                {
                  return `
                        <td>
                            <a href="#" onclick="openUpdateModal(${data.id_proveedor})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                            <a href="#" onclick="openDeleteDialog(${data.id_proveedor})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
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
    searchRows( API_PROVEEDORES, this );
});

// Función que prepara formulario para insertar un registro.
function openCreateModal()
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Crear proveedor' );
    // Se habilitan los campos de DUI, número de empresa y rubro.
    $( '#dui' ).prop( 'disabled', false );
    $( '#numero_empresa' ).prop( 'disabled', false );
    $( '#rubro' ).prop( 'disabled', false );
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar proveedor' );
    // Se deshabilitan los campos de DUI, número de empresa y rubro.
    $( '#dui' ).prop( 'disabled', true );
    $( '#numero_empresa' ).prop( 'disabled', true );
    $( '#rubro' ).prop( 'disabled', true );

    $.ajax({
        dataType: 'json',
        url: API_PROVEEDORES + 'readOne',
        data: { id_proveedor: id },
        type: 'post'
    })
    .done(function( response ){
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            console.log(response.dataset);
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_proveedor' ).val( response.dataset.id_proveedor );
            $( '#nombre_empresa' ).val( response.dataset.nombre_empresa );
            $( '#nombre_prov' ).val( response.dataset.nombre_prov );
            $( '#celular' ).val( response.dataset.celular );
            $( '#dui' ).val( response.dataset.dui );
            $( '#numero_empresa' ).val( response.dataset.numero_empresa );
            $( '#rubro' ).val( response.dataset.rubro );
            // Se actualizan los campos para que las etiquetas (labels) no queden sobre los datos.
            M.updateTextFields(); 
        } else {
            sweetAlert( 2, result.exception, null );
        }
    })
    .fail(function( jqXHR ){
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
    if ( $( '#id_proveedor' ).val() ) {
        saveRow( API_PROVEEDORES, 'update', this, 'save-modal' );
    } else {
        saveRow( API_PROVEEDORES, 'create', this, 'save-modal' );
    }
});

// Función para establecer el registro a eliminar y abrir una caja de dialogo para confirmar.
function openDeleteDialog( id )
{
    // Se declara e inicializa un objeto con el id del registro que será borrado.
    let identifier = { id_proveedor: id };
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete( API_PROVEEDORES, identifier );
}