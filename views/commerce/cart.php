<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Carrito de compras');
?>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align indigo-text">Carrito de compras</h4>
    <!-- Tabla para mostrar el detalle de los productos agregados al carrito de compras -->
    <table class="striped">
        <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
        <thead>
            <tr>
                <th>IMAGEN</th>
                <th>PRODUCTO</th>
                <th>PRECIO (US$)</th>
                <th>CANTIDAD</th>
                <th>SUBTOTAL (US$)</th>
                <th class="actions-column">ACCIÓN</th>
            </tr>
        </thead>
        <!-- Cuerpo de la tabla para mostrar un registro por fila -->
        <tbody id="tbody-rows">
        </tbody>
    </table>
    <!-- Fila para mostrar el monto total a pagar -->
    <div class="row right-align">
        <p>TOTAL A PAGAR (US$) <b id="pago"></b></p>
    </div>
    <!-- Enlace para generar reporte de productos por categoría -->
    <div class="row center-align">
        <a href="../../core/reports/dashboard/productos.php" target="_blank" class="btn waves-effect amber darken-2"><i class="material-icons left">assignment</i>Generar factura</a>
        <a href="index.php" class="waves-effect waves-light btn"><i class="material-icons left">store</i>Seguir comprando</a>
        <button type="button" onclick="finishOrder()" class="btn waves-effect green"><i class="material-icons left">check_circle</i>Finalizar pedido</button>
    </div>
    <!-- Fila para mostrar un enlace que dirección a la página principal para seguir comprando -->
    <div class="row right-align">
        
    </div>
</div>

<!-- Componente Modal para mostrar una caja de dialogo -->
<div id="item-modal" class="modal">
    <div class="modal-content">
        <!-- Título para la caja de dialogo -->
        <h4 class="center-align">Cambiar cantidad</h4>
        <!-- Formulario para crear o actualizar un registro -->
        <form method="post" id="item-form">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input type="number" id="id_detalle_pedido" name="id_detalle_pedido" class="hide"/>
            <div class="row">
                <div class="input-field col s12 m4 offset-m4">
                    <i class="material-icons prefix">list</i>
                    <input type="number" id="cantidad_producto" name="cantidad_producto" min="1" class="validate" required/>
                    <label for="cantidad_producto">Cantidad</label>
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
Commerce::footerTemplate('cart.js');
?>