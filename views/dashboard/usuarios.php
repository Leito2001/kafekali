<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar usuarios');
?>

<div class="row">
    <div class="col s12 m4">
        <!-- Enlace para abrir caja de dialogo (modal) al momento de crear un nuevo registro -->
        <a href="#" onclick="openCreateModal()" class="btn waves-effect teal tooltipped" data-tooltip="Agregar nuevo usuario"><i class="material-icons">add_circle</i></a>
    </div>       
</div>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th>CORREO</th>
            <th>CELULAR</th>
            <th>NACIMIENTO</th>
            <th>DUI</th>
            <th>USUARIO</th>
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
            <input class="hide" type="number" id="id_usuario" name="id_usuario"/>
            <div class="row">

                <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="nombres" type="text" name="nombres" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
                    <label for="nombres">Nombres</label>
                </div>

                <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="apellidos" type="text" name="apellidos" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
                    <label for="apellidos">Apellidos</label>
                </div>
                
                <!-- Input con validación: una cadena de texto de 9 carácteres cumpliendo el requisito 0000-0000 -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">phone</i>
                    <input id="celular" type="text" name="celular" placeholder="0000-0000" pattern="[2,6,7]{1}[0-9]{3}[-][0-9]{4}" minlength="9" maxlength="9" class="validate" required/>
                    <label for="celular">Celular</label>
                </div>

                <!-- Input con validación: una cadena de texto con formato de email (@ y .com) de 60 carácteres máximo -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">email</i>
                    <input id="correo" type="text" name="correo" maxlength="60" class="validate" required/>
                    <label for="correo">Correo</label>
                </div>

                <!-- Input con validación: una cadena de texto de 10 carácteres cumpliendo el requisito 00000000-0 -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">credit_card</i>
                    <input id="dui" type="text" name="dui" placeholder="00000000-0" pattern="[0-9]{8}[-][0-9]{1}" minlength="10" maxlength="10" class="validate" required/>
                    <label for="dui">DUI</label>
                </div>

                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">insert_invitation</i>
                    <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="validate" required/>
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                </div>

                <!-- Input con validación: una cadena de texto de 20 carácteres máximo entre letras, carácteres especiales (_ y .) y números sin espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person_pin</i>
                    <input id="usuario_u" type="text" name="usuario_u" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ_.]{1,20}" maxlength="20" title="No use espacios, por favor." class="validate" required/>
                    <label for="usuario_u">Nombre de usuario</label>
                </div>

                <!-- Input con validación: mínimo 6 carácteres -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">security</i>
                    <input id="clave_usuario" type="password" name="clave_usuario" minlength="6" class="validate" required/>
                    <label for="clave_usuario">Clave</label>
                </div>

                <!-- Input con validación: mínimo 6 carácteres -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">security</i>
                    <input id="confirmar_clave" type="password" name="confirmar_clave" minlength="6" class="validate" required/>
                    <label for="confirmar_clave">Confirmar clave</label>
                </div>

            </div>

            <!-- Botón para agregar usuario o cancelar operación -->
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" onclick="console.log($('#fecha_nacimiento').val())" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('usuarios.js');
?>
