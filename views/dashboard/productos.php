<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar productos');
?>

<div class="row">
    <div class="col s12 m4">
        <!-- Enlace para abrir caja de dialogo (modal) al momento de crear un nuevo registro -->
        <a href="#" onclick="openCreateModal()" class="btn waves-effect teal tooltipped" data-tooltip="Agregar nuevo producto"><i class="material-icons">add_circle</i></a>
        <!-- Enlace para generar reporte de productos por categoría -->
        <a href="../../core/reports/dashboard/productos.php" target="_blank" class="btn waves-effect amber darken-2 tooltipped" data-tooltip="Reporte de productos por categoría"><i class="material-icons">assignment</i></a>
    </div>       
</div>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>IMAGEN</th>
            <th>NOMBRE</th>
            <th>DESCRIPCIÓN</th>
            <th>PRECIO $</th>
            <th>CATEGORÍA</th>
            <th>PROVEEDOR</th>
            <th>ESTADO</th>
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
        <!-- Formulario para crear o actualizar un producto -->
        <form method="post" id="save-form" enctype="multipart/form-data">
            <!-- Campo oculto para asignar el id del producto al momento de modificar -->
            <input class="hide" type="number" id="id_producto" name="id_producto"/>
            
            <div class="row">

                <!-- Input con validación: una cadena de texto de 60 carácteres máximo con letras, números y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="nombre_producto" type="text" name="nombre_producto" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s]{1,60}" maxlength="60" class="validate" required/>
                    <label for="nombre_producto">Nombre del producto</label>
                </div>

                <!-- Input con validación: una cadena de texto de 120 carácteres máximo con letras, números y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="descripcion" type="text" name="descripcion" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\,\.]{1,400}" maxlength="400" class="validate" required/>
                    <label for="descripcion">Descripción del producto</label>
                </div>

                <!-- Input con validación: solo números -->
                <div class="input-field col s12 m6">
                  	<i class="material-icons prefix">attach_money</i>
                  	<input id="precio" type="number" name="precio" class="validate" max="999.99" min="0.01" step="any" required/>
                  	<label for="precio">Precio (US$)</label>
                </div>

                <!-- Combobox para categoría -->
                <div class="input-field col s12 m6">
                <i class="material-icons prefix">category</i>
                    <select id="tipo_producto" name="tipo_producto" required>
                    </select>
                    <label for="tipo_producto">Categoría del producto</label>
                </div>

                <!-- Combobox para proveedor -->
                <div class="input-field col s12 m6">
                <i class="material-icons prefix">swap_horizontal_circle</i>
                    <select id="nombre_prov" name="nombre_prov" required>
                    </select>
                    <label for="nombre_prov">Proveedor del producto</label>
                </div>

                <!-- Adjuntar imagen de 500x500 px -->
                <div class="file-field input-field col s12 m6">
                    <div class="btn waves-effect tooltipped" data-tooltip="Seleccione una imagen de 500x500">
                        <span><i class="material-icons">image</i></span>
                        <input id="imagen_producto" type="file" name="imagen_producto" accept=".gif, .jpg, .png"/>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Formatos aceptados: gif, jpg y png"/>
                    </div>
                </div>

                <!-- Switch estado -->
                <div class="col s12 m12">
                    <p>
                        <div class="switch center">
                            <span>Estado:‎‎  ‏‏</span>
                            <label>
                                <i class="material-icons">visibility_off</i>
                                <input id="estado_producto" type="checkbox" name="estado_producto" checked/>
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
                            </label>
                        </div>
                    </p>
                </div>

            </div>

            <!-- Opciones para guardar y cancelar -->
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('productos.js');
?>
