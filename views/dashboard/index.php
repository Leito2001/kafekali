<?php
require_once('../../core/helpers/dashboard.php');
Dashboard::headerTemplate('Iniciar sesión');
?>

<div class="container">
    <div class="row">
        <!-- Formulario para iniciar sesión -->
        <form method="post" id="session-form"> 

        

            <!-- Input con validación: una cadena de texto de 20 carácteres máximo entre letras, carácteres especiales (_ y .) y números sin espacios -->
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">person</i>
                <input id="usuario_u" type="text" name="usuario_u" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ_.]{1,20}" maxlength="20" title="No use espacios, por favor." class="validate" required/>
                <label for="usuario_u">Nombre de usuario</label>
            </div>

            <!-- Input tipo password. 6 carácteres mínimo -->
            <div class="input-field col s12 m6 offset-m3">
                <i class="material-icons prefix">lock</i>
                <input id="clave" type="password" name="clave" minlength="6" class="validate" required/>
                <label for="clave">Clave</label>
            </div>

            <!-- Botón para ingresar -->
            <div class="col s12 center-align">
                <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
            </div>
            
        </form>
    </div>
</div>

<?php
Dashboard::footerTemplate('index.js');
?>
