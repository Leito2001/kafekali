<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Tu tienda de café');
?>

<!-- Slider con indicadores, altura de 400px y una duración entre transiciones de 6 segundos -->
<div class="slider" id="slider">
    <ul class="slides">
        <li>
            <img src="../../resources/img/slider/img01.jpg" alt="Primera foto">
            <div class="caption center-align">
                <h2>¿Sabías que...?</h2>
                <h4>El café reduce el riesgo de padecer Alzheimer.</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/img02.jpg" alt="Segunda foto">
            <div class="caption left-align">
                <h2>¿Preocupado por tu peso?</h2>
                <h4>El café contribuye a reducir esos kilos de más.</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/img03.jpg" alt="Tercera foto">
            <div class="caption right-align">
                <h2>¿Sabías que...?</h2>
                <h4>El café reduce el riesgo de cáncer.</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/img04.jpg" alt="Cuarta foto">
            <div class="caption center-align">
                <h2>¿Quieres lucir radiante?</h2>
                <h4>El café ayuda a tener una piel más perfecta.</h4>
            </div>
        </li>
    </ul>
</div>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center indigo-text" id="title">Nuestro catálogo</h4>
    <!-- Fila para mostrar las categorías disponibles -->
    <div class="row" id="categorias"></div>
</div>

<?php
Commerce::footerTemplate('index.js');
?>