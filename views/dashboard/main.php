<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Bienvenido');
?>

<!-- Se muestra un saludo de acuerdo con la hora del cliente -->
<div class="row">
    <h4 class="center-align" id="greeting"></h4>
</div>

<!-- Se muestra una gráfica de acuerdo con los datos existentes -->
<div class="row">
    <div class="col s12 m12">

        <div class="row">
            <div class="col s6 m6">
                <canvas class="center-align" id="chart" width="100" height="60"></canvas>
            </div>
            <div class="col s6 m6">
                <canvas class="center-align" id="chart4" width="100" height="60"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col s6 m6">
                <canvas class="center-align" id="chart2" width="100" height="60"></canvas>
            </div>
            <div class="col s6 m6">
                <canvas class="center-align" id="chart3" width="100" height="60"></canvas>
            </div>
        </div>
        
    </div>
</div>

<!-- Importación del archivo para generar gráficas en tiempo real. Para más información https://www.chartjs.org/ -->
<script type="text/javascript" src="../../resources/js/chart.js"></script>

<?php
Dashboard::footerTemplate('main.js');
?>
