<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Iniciar sesión');
?>

<div class="container">
    <div class="row">
        <!-- Formulario para iniciar sesión -->
        <form method="post" id="session-form"> 

            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">person_pin</i>
                <input id="usuario_u" type="text" name="usuario_u" class="validate" required/>
                <label for="usuario_u">Nombre de usuario</label>
            </div>

            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">security</i>
                <input id="clave" type="password" name="clave" class="validate" required/>
                <label for="clave">Clave</label>
            </div>

            <div class="col s12 center-align">
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
            </div>
            
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('index.js');
?>
