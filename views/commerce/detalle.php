<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Detalles del producto');
?>

<!-- Contenedor para mostrar el detalle del producto seleccionado previamente -->
<div class="container">
    <!-- Título para la página web -->
    <h4 class="center brown-text" id="title">Detalles del producto</h4>
    <div class="row" id="detalle">
        <!-- Componente Horizontal Card -->
        <div class="card horizontal">
            <div class="card-image">
                <img id="imagen" src="../../resources/img/unknown.png">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <h3 id="nombre" class="header"></h3>
                    <p id="descripcion"></p>
                    <p>Precio (US$) <b id="precio"></b></p>
                </div>
                <div class="card-action">
                    <!-- Formulario de cantidad para agregar el producto al carrito de compras -->
                    <form method="post" id="shopping-form">
                        <!-- Campos ocultos para asignar los datos del producto -->
                        <input type="number" id="id_producto" name="id_producto" class="hide"/>
                        <input type="number" id="precio_producto" name="precio_producto" step="0.01" class="hide"/>
                        <div class="row center">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">list</i>
                                <input type="number" id="cantidad_producto" name="cantidad_producto" min="1" class="validate" required/>
                                <label for="cantidad_producto">Cantidad</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <button type="submit" class="btn waves-effect waves-light blue tooltipped" data-tooltip="Agregar al carrito"><i class="material-icons">add_shopping_cart</i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Commerce::footerTemplate('detalle.js');
?>