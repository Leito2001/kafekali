
// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_USUARIOS = '../../core/api/dashboard/usuarios.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_USUARIOS, $('#categoriesSpinner')[0]);
    // Se declara e inicializa un objeto para obtener la fecha y hora actual.
    let today = new Date();
    // Se declara e inicializa una variable para guardar el día en formato de 2 dígitos.
    let day = ( '0' + today.getDate() ).slice( -2 );
    // Se declara e inicializa una variable para guardar el mes en formato de 2 dígitos.
    var month = ( '0' + ( today.getMonth() + 1 ) ).slice( -2 );
    // Se declara e inicializa una variable para guardar el año con la mayoría de edad.
    let year = today.getFullYear() - 18;
    // Se declara e inicializa una variable para establecer el formato de la fecha.
    let date = (`${year}-${month}-${day}`);
    // Se asigna la fecha como valor máximo en el campo del formulario.
    $( '#fecha_nacimiento' ).prop( 'max', date );
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
                { data: 'apellidos' },
                { data: 'nombres' },
                { data: 'correo' },
                { data: 'celular' },
                { data: 'fecha_nacimiento' },
                { data: 'dui' },
                { data: 'usuario_u' },
                { data: null,
                orderable: false,
                render:function(data, type, row)
                {
                  return `
                        <td>
                            <a href="#" onclick="openUpdateModal(${data.id_usuario})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                            <a href="#" onclick="openDeleteDialog(${data.id_usuario})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
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
    searchRows( API_USUARIOS, this );
});

// Función que prepara formulario para insertar un registro.
function openCreateModal()
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Crear usuario' );
    // Se habilitan los campos de clave, confirmar clave, nombre de usuario, fecha de nacimiento y DUI.
    $( '#clave_usuario' ).prop( 'disabled', false );
    $( '#confirmar_clave' ).prop( 'disabled', false );
    $( '#usuario_u' ).prop( 'disabled', false );
    $( '#fecha_nacimiento' ).prop( 'disabled', false );
    $( '#dui' ).prop( 'disabled', false );
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar usuario' );
    // Se deshabilitan los campos de clave, confirmar clave, nombre de usuario, fecha de nacimiento y DUI.
    $( '#clave_usuario' ).prop( 'disabled', true );
    $( '#dui' ).prop( 'disabled', true );
    $( '#fecha_nacimiento' ).prop( 'disabled', true );
    $( '#confirmar_clave' ).prop( 'disabled', true );
    $( '#usuario_u' ).prop( 'disabled', true );

    $.ajax({
        dataType: 'json',
        url: API_USUARIOS + 'readOne',
        data: { id_usuario: id },
        type: 'post'
    })
    .done(function( response ){
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            console.log(response.dataset);
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            $( '#id_usuario' ).val( response.dataset.id_usuario );
            $( '#nombres' ).val( response.dataset.nombres );
            $( '#apellidos' ).val( response.dataset.apellidos );
            $( '#celular' ).val( response.dataset.celular );
            $( '#correo' ).val( response.dataset.correo );
            $( '#dui' ).val( response.dataset.dui );
            $( '#fecha_nacimiento' ).val( response.dataset.fecha_nacimiento );
            $( '#usuario_u' ).val( response.dataset.usuario_u );
            $( '#clave_usuario' ).val( response.dataset.password_u );
            $( '#clave_usuario' ).prop( 'disabled', true );
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
    if ( $( '#id_usuario' ).val() ) {
        saveRow( API_USUARIOS, 'update', this, 'save-modal' );
    } else {
        saveRow( API_USUARIOS, 'create', this, 'save-modal' );
    }
});

// Función para establecer el registro a eliminar y abrir una caja de dialogo para confirmar.
function openDeleteDialog( id )
{
    // Se declara e inicializa un objeto con el id del registro que será borrado.
    let identifier = { id_usuario: id };
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete( API_USUARIOS, identifier );
}