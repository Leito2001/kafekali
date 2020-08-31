<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Pedidos pasados');
?>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align">Pedidos pasados</h4>
    <!-- Tabla para mostrar pedidos pasados hechos por el cliente -->
    <table class="striped">
        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
        <thead>
            <tr>
                <th>Nº</th>
                <th>IMAGEN</th>
                <th>PRODUCTO</th>
                <th>PRECIO (US$)</th>
                <th>CANTIDAD</th>
                <th>FECHA</th>
                <th>ESTADO DEL PEDIDO</th>
                <th>SUBTOTAL (US$)</th>
                <th>OPCIONES</th>
            </tr>
        </thead>
        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
        <tbody id="tbody-rows">
        </tbody>
    </table>

    <!-- Fila para mostrar el monto total pagado -->
    <div class="row right-align">
        <p>TOTAL PAGADO (US$) <b id="pago"></b></p>
    </div>
</div>

<!-- Componente Modal para mostrar una caja de dialogo -->
<div id="item-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <h4 class="center-align">Agregar una reseña</h4>
        <!-- Formulario para crear o actualizar un registro -->
        <form method="post" id="item-form">
            <!-- Campo oculto para asignar el id del producto al momento de modificar -->
            <input class="hide" type="number" id="id_detalle_pedido" name="id_detalle_pedido"/>
            
            <div class="row">
                
                <!-- Input con validación: solo números -->
                <div class="input-field col s12 m6">
                  	<i class="material-icons prefix">star</i>
                  	<input id="calificacion" type="number" name="calificacion" class="validate" max="10" min="1" step="1" title="Solo números enteros, por favor." required/>
                  	<label for="calificacion">Calificación</label>
                </div>

                <!-- Input con validación: una cadena de texto de 120 carácteres máximo con letras, números y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">chat_bubble</i>
                    <input id="comentario" type="text" name="comentario" maxlength="500" class="validate" required/>
                    <label for="comentario">Comentario</label>
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
Commerce::footerTemplate('past_orders.js');
?>