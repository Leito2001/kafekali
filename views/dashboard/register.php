<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Registrar primer usuario');
?>

<!-- Formulario para registrar al primer usuario del dashboard -->
<form method="post" id="register-form">
    
    <div class="row">

        <div class="input-field col s12 m6">
          	<i class="material-icons prefix">person</i>
          	<input id="nombres" type="text" name="nombres" class="validate" required/>
          	<label for="nombres">Nombres</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">person</i>
            <input id="apellidos" type="text" name="apellidos" class="validate" required/>
            <label for="apellidos">Apellidos</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">phone</i>
            <input id="celular" type="text" name="celular" class="validate" required/>
            <label for="celular">Celular</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">email</i>
            <input id="correo" type="text" name="correo" class="validate" required/>
            <label for="correo">Correo</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">credit_card</i>
            <input id="dui" type="text" name="dui" class="validate" required/>
            <label for="dui">DUI</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">insert_invitation</i>
            <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="validate" required/>
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">person_pin</i>
            <input id="usuario_u" type="text" name="usuario_u" class="validate" required/>
            <label for="usuario_u">Nombre de usuario</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">security</i>
            <input id="clave1" type="password" name="clave1" class="validate" required/>
            <label for="clave1">Clave</label>
        </div>

        <div class="input-field col s12 m6">
            <i class="material-icons prefix">security</i>
            <input id="clave2" type="password" name="clave2" class="validate" required/>
            <label for="clave2">Confirmar clave</label>
        </div>

    </div>

    <div class="row center-align">
 	    <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Crear usuario"><i class="material-icons">save</i></button>
    </div>

</form>

<?php
Dashboard::footerTemplate('register.js');
?>
