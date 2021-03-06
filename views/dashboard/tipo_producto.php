<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar categorías');
?>

<div class="row">
    <div class="col s12 m4">
        <!-- Enlace para abrir caja de dialogo (modal) al momento de crear un nuevo registro -->
        <a href="#" onclick="openCreateModal()" class="btn waves-effect teal tooltipped" data-tooltip="Agregar nueva categoría"><i class="material-icons">add_circle</i></a>
    </div>       
</div>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>IMAGEN</th>
            <th>CATEGORÍA</th>
            <th class="actions-column">ACCIÓN</th>
        </tr>
    </thead>
    <!-- Cuerpo de la tabla para mostrar un registro por fila -->
    <tbody>
    </tbody>
</table>

<!-- Componente Modal para mostrar una caja de dialogo -->
<div id="save-modal" class="modal">
    <div class="modal-content">
        <h4 id="modal-title" class="center-align"></h4>
        <!-- Formulario para crear o actualizar un registro -->
        <form method="post" id="save-form" enctype="multipart/form-data" autocomplete="off">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input class="hide" type="number" id="id_tipo_producto" name="id_tipo_producto"/>
            <div class="row">

                <!-- Input con validación: una cadena de texto de 35 carácteres máximo solo con letras y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="tipo_producto" type="text" name="tipo_producto" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,35}" maxlength="35" class="validate" required/>
                    <label for="tipo_producto">Nombre de la categoría</label>
                </div>

                <!-- Espacio para agregar imagen de 500x500 px -->
                <div class="file-field input-field col s12 m6">
                    <div class="btn waves-effect tooltipped" data-tooltip="Seleccione una imagen de 500x500">
                        <span><i class="material-icons">image</i></span>
                        <input id="imagen" type="file" name="imagen" accept=".gif, .jpg, .png"/>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Formatos aceptados: gif, jpg y png"/>
                    </div>
                </div>

            </div>

            <!-- Botones para guardar o agregar -->
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('categorias.js');
?>
