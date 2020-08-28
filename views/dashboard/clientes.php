<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Administrar clientes');
?>

<!-- Tabla para mostrar los registros existentes -->
<table class="striped" id="tabla">
    <!-- Cabeza de la tabla para mostrar los títulos de las columnas -->
    <thead>
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRES</th>
            <th>CORREO</th>
            <th>CELULAR</th>
            <th>DIRECCIÓN</th>
            <th>DUI</th>
            <th>USUARIO</th>
            <th>ESTADO</th>
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
            <input class="hide" type="number" id="id_cliente" name="id_cliente"/>

            <div class="row">

                <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="nombre" type="text" name="nombres" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
                    <label for="nombres">Nombres</label>
                </div>

                <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person</i>
                    <input id="apellido" type="text" name="apellidos" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
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
                    <input id="correo" type="email" name="correo" maxlength="60" class="validate" required/>
                    <label for="correo">Correo</label>
                </div>

                <!-- Input con validación: una cadena de texto sin restricciones de escritura con 200 carácteres máximo -->
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">place</i>
                    <input id="direccion" type="text" name="direccion" pattern="[a-zA-Z0-9#ñÑáÁéÉíÍóÓúÚ\s\,\:\;\.\-\+]" class="validate" maxlength="200" required/>
                    <label for="direccion">Dirección del cliente</label>
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
                    <input id="usuario_c" type="text" name="usuario_c" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\_\.]{1,20}" title="No use espacios, por favor." maxlength="20" class="validate" required/>
                    <label for="usuario_c">Nombre de usuario</label>
                </div>

                <!-- Switch estado -->
                <div class="col s12 m12">
                    <p>
                        <div class="switch center">
                            <span>Estado:‎‎  ‏‏</span>
                            <label>
                                <i class="material-icons">visibility_off</i>
                                <input id="estado_usuario" type="checkbox" name="estado_usuario" checked/>
                                <span class="lever"></span>
                                <i class="material-icons">visibility</i>
                            </label>
                        </div>
                    </p>
                </div>

            </div>

            <!-- Opciones de guardar y cancelar -->
            <div class="row center-align">
                <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                <button type="submit" onclick="console.log($('#fecha_nacimiento').val())" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
            </div>
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('clientes.js');
?>
