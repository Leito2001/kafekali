<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar reseñas');
?>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>IMAGEN</th>
            <th>PRODUCTO</th>
            <th>COMENTARIO</th>
            <th>CALIFICACIÓN</th>
            <th>USUARIO</th>
            <th>FECHA</th>
            <th>ESTADO</th>
            <th class="actions-column">ACCIÓN</th>
        </tr>
    </thead>
    <!-- Cuerpo de la tabla para mostrar un registro por fila -->
    <tbody>
    </tbody>
</table>

<!-- Componente Modal para mostrar una caja de diálogo -->
<div id="save-modal" class="modal">
    <div class="modal-content">
        <h4 id="modal-title" class="center-align"></h4>
        <!-- Formulario para actualizar el estado de un pedido -->
        <form method="post" id="save-form" enctype="multipart/form-data">

            <!-- Campo oculto para asignar el id del detalle y del pedido al momento de modificar -->
            <input class="hide" type="number" id="id_detalle_pedido" name="id_detalle_pedido"/>
            <input class="hide" type="number" id="id_comentario" name="id_comentario"/>
            
            <div class="row">

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">category</i>
                    <input id="nombre_producto" type="text" name="nombre_producto" class="validate" required/>
                    <label for="nombre_producto">Nombre del producto</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">chat_bubble</i>
                    <input id="comentario" type="text" name="comentario" class="validate" required/>
                    <label for="comentario">Comentario</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">star</i>
                    <input id="calificacion" type="number" name="calificacion" class="validate" required/>
                    <label for="calificacion">Calificación</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="usuario_c" type="text" name="usuario_c" class="validate" required/>
                    <label for="usuario_c">Cliente</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">calendar_today</i>
                    <input id="fecha_review" type="date" name="fecha_review" class="validate" required/>
                    <label for="fecha_review">Fecha del pedido</label>
                </div>

                <!-- Switch estado_pedido -->
                <div class="col s12 m6">
                    <p>
                        <div class="switch center">
                            <span>Estado:‎‎  ‏‏</span>
                            <label>
                                <i class="material-icons">visibility_off</i>
                                <input id="estado_comentario" type="checkbox" name="estado_comentario" checked/>
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
                            </label>
                        </div>
                    </p>
                </div>

            </div>

            <!-- Opciones de guardar y cancelar -->
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>

        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('comentarios.js');
?>
