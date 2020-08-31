<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Catálogo de productos');
?>
    <!--Contenido-->
    <div class="container">
        <div class="row" id="info">
            <!-- Catálogo de productos-->
            <h4 class="center-align">Catálogo de productos</h4>
            <!-- Fila para mostrar las categorías disponibles -->
            <div class="row" id="categorias"></div>
        </div>
    </div>

<?php
Commerce::footerTemplate('index.js');
?>