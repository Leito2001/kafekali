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

            <!-- Input con validación: una cadena de texto de 20 carácteres máximo entre letras, carácteres especiales (_ y .) y números sin espacios -->
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">person</i>
                <input type="text" id="usuario_c" name="usuario_c" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ_.]{1,20}" maxlength="20" title="No use espacios, por favor." class="validate" required/>
                <label for="usuario_c">Nombre de usuario</label>
            </div>

            <!-- Input con validación: solo números, capacidad mínima 6 -->
            <div class="input-field col s12 m4 offset-m4">
                <i class="material-icons prefix">lock</i>
                <input type="password" id="clave_cliente" name="clave_cliente" minlength="6" class="validate" required/>
                <label for="clave_cliente">Clave</label>
            </div>

        </div>

        <!-- Botón para ingresar -->
        <div class="row center-align">
            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Ingresar"><i class="material-icons">send</i></button>
        </div>

    </form>

    <!-- Botón para registrar un nuevo cliente -->
    <div class="row center-align">
        <a href="signin.php" type="submit" class="btn waves-effect indigo tooltipped" data-tooltip="Registrarse"><i class="material-icons">person</i></a>
    </div>
</div>

<?php
Commerce::footerTemplate('login.js');
?>