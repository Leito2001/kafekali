<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Detalles del producto');
?>

<!-- Contenedor para mostrar el detalle del producto seleccionado previamente -->
<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align" id="title"> </h4>
    <div class="row" id="detalle">
    <h5 class="center white-text">Información del producto</h5>
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
                    <p>Cantidad en stock: <b id="stock"></b></p>
                </div>

                <div class="card-action">
                    <!-- Formulario de cantidad para agregar el producto al carrito de compras -->
                    <form method="post" id="shopping-form">
                        <!-- Campos ocultos para asignar el id y el precio del producto -->
                        <input type="number" id="id_producto" name="id_producto" class="hide"/>
                        <input type="number" id="precio_producto" name="precio_producto" step="0.01" class="hide"/>

                        <!-- Se llena según la función para leer el stock -->
                        <div class="row center" id="comprar">

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <h5 class="center white-text">Reseñas del producto</h5>

        <ul class="collection" id="comments">   
        </ul>
         
    </div>
</div>

<?php
Commerce::footerTemplate('detalle.js');
?>