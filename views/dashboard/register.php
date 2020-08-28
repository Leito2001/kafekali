<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Registrar primer usuario');
?>

<!-- Formulario para registrar al primer usuario del dashboard -->
<form method="post" id="register-form">
    
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
            <input id="usuario_u" type="text" name="usuario_u" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ_.]{1,20}" maxlength="20" title="No use espacios, por favor" class="validate" required/>
            <label for="usuario_u">Nombre de usuario</label>
        </div>

        <!-- Input con validación: mínimo 6 carácteres -->
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">security</i>
            <input id="clave1" type="password" name="clave1" minlength="6" class="validate" required/>
            <label for="clave1">Clave</label>
        </div>

        <!-- Input con validación: mínimo 6 carácteres -->
        <div class="input-field col s12 m6">
            <i class="material-icons prefix">security</i>
            <input id="clave2" type="password" name="clave2" minlength="6" class="validate" required/>
            <label for="clave2">Confirmar clave</label>
        </div>

    </div>

    <!-- Botón para agregar usuario -->
    <div class="row center-align">
 	    <button type="submit" onclick="console.log($('#fecha_nacimiento').val())" class="btn waves-effect blue tooltipped" data-tooltip="Crear usuario"><i class="material-icons">save</i></button>
    </div>

</form>

<?php
Dashboard::footerTemplate('register.js');
?>
