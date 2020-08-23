<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar pedidos');
?>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>IMAGEN</th>
            <th>CLIENTE</th>
            <th>PRODUCTO</th>
            <th>PRECIO C/U (USD$)</th>
            <th>CANTIDAD</th>
            <th>TOTAL (USD$)</th>
            <th>FECHA</th>
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
        <!-- Formulario para crear o actualizar un registro -->
        <form method="post" id="save-form" enctype="multipart/form-data">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input class="hide" type="number" id="id_detalle_pedido" name="id_detalle_pedido"/>
            <input class="hide" type="number" id="id_pedido" name="id_pedido"/>
            <div class="row">

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="usuario_c" type="text" name="usuario_c" class="validate" required/>
                    <label for="usuario_c">Cliente</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="nombre_producto" type="text" name="nombre_producto" class="validate" required/>
                    <label for="nombre_producto">Nombre del producto</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="cantidad_producto" type="number" name="cantidad_producto" class="validate" required/>
                    <label for="cantidad_producto">Cantidad de producto</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">note_add</i>
                    <input id="fecha" type="date" name="fecha" class="validate" required/>
                    <label for="fecha">Fecha del pedido</label>
                </div>

                <div class="input-field col s12 m6">
                <i class="material-icons prefix">category</i>
                    <select id="estado_pedido" name="estado_pedido" required>
                    </select>
                    <label for="estado_pedido">Estado del pedido</label>
                </div>

            </div>
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('pedidos.js');
?>
