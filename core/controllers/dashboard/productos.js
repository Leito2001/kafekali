// Constantes para establecer las rutas y parámetros de comunicación con la API.
const API_PRODUCTOS = '../../core/api/dashboard/productos.php?action=';

// Método que se ejecuta cuando el documento está listo.
$( document ).ready(function() {
    // Se llama a la función que obtiene los registros para llenar la tabla. Se encuentra en el archivo components.js
    readRows( API_PRODUCTOS );
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
                { data: 'descripcion' },
                { data: 'precio' },
                { data: 'stock' },
                { data: 'nombre_prov' },
                { data: null,
                ordereable: false,
                render: function (data, type, meta) 
                    {
                        if (data.estado_producto){
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
                            <a href="#" onclick="openUpdateModal(${data.id_producto})" class="btn waves-effect teal tooltipped" data-tooltip="Actualizar"><i class="material-icons">mode_edit</i></a>
                            <a href="#" onclick="openDeleteDialog(${data.id_producto})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar"><i class="material-icons">delete</i></a>
                        </td>`;
                },
                targets: -1
                },
            ]
        } );
    }
}

//Funcion para traer a las categorías, selectedId tiene el valor de 0 para evitar errores de null
function getCategorias(selectedId = 0){
    $.ajax({
        url: API_PRODUCTOS + 'getCategorias',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            let jsonResponse = response.dataset;
            //Si no se le ha ingresado un valor a selectedId, se ingresa la opcion deshabilitada para seleccionar la categoría;
            //si no, se deja vacío (para el Create)
            let dropDown = selectedId == 0 ? `<option value="" disabled selected>Selecciona la categoría</option>` : '';

            jsonResponse.forEach(tyype => {
                //verificamos si el id que esta pasando ahorita es el mismo que el recibido, para aplicarle la categoría seleccionado
                let estado = ((tyype.id_tipo_producto == selectedId) ? ' selected' : '');
                dropDown += `
                    <option value="${tyype.id_tipo_producto}"${estado}>${tyype.tipo_producto}</option>
                `;
            });
            //ingresamos las opciones al select
            $('#tipo_producto').html(dropDown);
            //inicializamos el select con materializecss
            $('#tipo_producto').formSelect();
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

//Funcion para traer a los proveedores, selectedId tiene el valor de 0 para evitar errores de null
function getProveedor(selectedId = 0){
    $.ajax({
        url: API_PRODUCTOS + 'getProveedor',
        type: 'post',
        dataType: 'json',
        success: function (response) {
            let jsonResponse = response.dataset;
            //Si no se le ha ingresado un valor a selectedId, se ingresa la opcion deshabilitada para seleccionar al proveedor;
            //si no, se deja vacío (para el Create)
            let dropDown = selectedId == 0 ? `<option value="" disabled selected>Selecciona el proveedor</option>` : '';
            jsonResponse.forEach(proovider => {
                //verificamos si el id que esta pasando ahorita es el mismo que el recibido, para aplicarle el proveedor seleccionado
                let estado = ((proovider.id_proveedor == selectedId) ? ' selected' : '');
                dropDown += `
                    <option value="${proovider.id_proveedor}"${estado}>${proovider.nombre_prov}</option>
                `;
            });
            //ingresamos las opciones al select
            $('#nombre_prov').html(dropDown);
            //inicializamos el select con materializecss
            $('#nombre_prov').formSelect();
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

// Función que prepara formulario para insertar un registro.
function openCreateModal()
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Crear producto' );
    // Se establece el campo de tipo archivo como obligatorio.
    $( '#imagen_producto' ).prop( 'required', true );
    //Se inicializan los combobox
    getCategorias();
    getProveedor();
}

// Función que prepara formulario para modificar un registro.
function openUpdateModal( id )
{
    // Se limpian los campos del formulario.
    $( '#save-form' )[0].reset();
    // Se abre la caja de dialogo (modal) que contiene el formulario.
    $( '#save-modal' ).modal( 'open' );
    // Se asigna el título para la caja de dialogo (modal).
    $( '#modal-title' ).text( 'Modificar producto' );
    // Se establece el campo de tipo archivo como opcional.
    $( '#imagen_producto' ).prop( 'required', false );

    $.ajax({
        dataType: 'json',
        url: API_PRODUCTOS + 'readOne',
        data: { id_producto: id },
        type: 'post'
    })
    .done(function( response ) {
        // Se comprueba si la API ha retornado una respuesta satisfactoria, de lo contrario se muestra un mensaje de error.
        if ( response.status ) {
            jsonResponse = response.dataset;
            // Se inicializan los campos del formulario con los datos del registro seleccionado previamente.
            getProveedor(jsonResponse.id_proveedor);
            getCategorias(jsonResponse.id_tipo_producto);
            $( '#id_producto' ).val( jsonResponse.id_producto );
            $( '#nombre_producto' ).val( jsonResponse.nombre_producto );
            $( '#descripcion' ).val( jsonResponse.descripcion );
            $( '#precio' ).val( jsonResponse.precio );
            $( '#stock' ).val( jsonResponse.stock );
            //Se configura el switch del estado según lo ingresado en la base, true o false.
            (jsonResponse.estado_producto ) ? $( '#estado_producto' ).prop( 'checked', true ) : $( '#estado_producto' ).prop( 'checked', false );
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
    if ( $( '#id_producto' ).val() ) {
        saveRow( API_PRODUCTOS, 'update', this, 'save-modal' );
    } else {
        saveRow( API_PRODUCTOS, 'create', this, 'save-modal' );
    }
    $( '#save-form' )[0].reset();
});


// Función para establecer el registro a eliminar y abrir una caja de dialogo para confirmar.
function openDeleteDialog( id )
{
    // Se declara e inicializa un objeto con el id del registro que será borrado.
    let identifier = { id_producto: id };
    // Se llama a la función que elimina un registro. Se encuentra en el archivo components.js
    confirmDelete( API_PRODUCTOS, identifier );
}