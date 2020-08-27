<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar proveedores');
?>

<div class="row">
    <div class="col s12 m4">
        <!-- Enlace para abrir caja de dialogo (modal) al momento de crear un nuevo registro -->
        <a href="#" onclick="openCreateModal()" class="btn waves-effect teal tooltipped" data-tooltip="Agregar nuevo proveedor"><i class="material-icons">add_circle</i></a>
        <!--Enlace para abrir reporte de productos por proveedor-->
        <a href="../../core/reports/dashboard/proveedores.php" target="_blank" class="btn waves-effect amber darken-2 tooltipped" data-tooltip="Reporte de productos por proveedor"><i class="material-icons">assignment</i></a>
    </div>       
</div>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>EMPRESA</th>
            <th>PROVEEDOR</th>
            <th>CELULAR</th>
            <th>DUI</th>
            <th>Nº EMPRESA</th>
            <th>RUBRO</th>
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
        <form method="post" id="save-form">
            <!-- Campo oculto para asignar el id del registro al momento de modificar -->
            <input class="hide" type="number" id="id_proveedor" name="id_proveedor"/>
            <div class="row">

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">work</i>
                    <input id="nombre_empresa" type="text" name="nombre_empresa" class="validate" required/>
                    <label for="nombre_empresa">Nombre de la empresa</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="nombre_prov" type="text" name="nombre_prov" class="validate" required/>
                    <label for="nombre_prov">Nombre del proveedor</label>
                </div>
                
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">phone</i>
                    <input id="celular" type="text" name="celular" class="validate" required/>
                    <label for="celular">Teléfono o celular del proveedor/empresa</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">credit_card</i>
                    <input id="dui" type="text" name="dui" class="validate" required/>
                    <label for="dui">DUI del proveedor</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">format_list_numbered</i>
                    <input id="numero_empresa" type="number" name="numero_empresa" class="validate" required/>
                    <label for="numero_empresa">Número de empresa</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">swap_horizontal_circle</i>
                    <input id="rubro" type="text" name="rubro" class="validate" required/>
                    <label for="rubro">Rubro de la empresa</label>
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
Dashboard::footerTemplate('proveedores.js');
?>
