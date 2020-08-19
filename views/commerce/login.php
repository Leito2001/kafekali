<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Iniciar sesión');
?>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align indigo-text">Iniciar sesión</h4>
    <!-- Formulario para iniciar sesión -->
    <form method="post" id="session-form">
        <div class="row">
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">email</i>
                <input type="email" id="usuario" name="usuario" class="validate" required/>
                <label for="usuario">Correo electrónico</label>
            </div>
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">security</i>
                <input type="password" id="clave" name="clave" class="validate" required/>
                <label for="clave">Clave</label>
            </div>
        </div>
        <div class="row center-align">
            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
        </div>
    </form>
    <div class="row center-align">
        <a href="signin.php" type="submit" class="btn waves-effect indigo tooltipped" data-tooltip="Registrarse"><i class="material-icons">person</i></a>
    </div>
</div>

<?php
Commerce::footerTemplate('login.js');
?>