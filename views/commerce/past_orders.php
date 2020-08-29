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
                <th>Nº ORDEN</th>
                <th>IMAGEN</th>
                <th>PRODUCTO</th>
                <th>PRECIO (US$)</th>
                <th>CANTIDAD</th>
                <th>FECHA</th>
                <th>ESTADO DEL PEDIDO</th>
                <th>SUBTOTAL (US$)</th>
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

<?php
Commerce::footerTemplate('past_orders.js');
?>