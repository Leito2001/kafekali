<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Registrarse');
?>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align indigo-text">Regístrate como cliente</h4>
    <!-- Formulario para crear cuenta -->
    <form method="post" id="register-form">
        <!-- Campo oculto para asignar el token del reCAPTCHA -->
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"/>
        
        <div class="row">

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="nombre" name="nombre" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" class="validate" required/>
                <label for="nombre">Nombres</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="apellido" name="apellido" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" class="validate" required/>
                <label for="apellido">Apellidos</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">phone</i>
                <input type="text" id="celular" name="celular" placeholder="0000-0000" pattern="[2,6,7]{1}[0-9]{3}[-][0-9]{4}" class="validate" required/>
                <label for="celular">Celular</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">email</i>
                <input type="email" id="correo" name="correo" maxlength="60" class="validate" required/>
                <label for="correo">Correo electrónico</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">cake</i>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="validate" required/>
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">how_to_reg</i>
                <input type="text" id="dui" name="dui" placeholder="00000000-0" pattern="[0-9]{8}[-][0-9]{1}" class="validate" required/>
                <label for="dui">DUI</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">cake</i>
                <input type="text" id="usuario_c" name="usuario_c" class="validate" required/>
                <label for="usuario_c">Nombre de usuario</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">security</i>
                <input type="password" id="clave_cliente" name="clave_cliente" class="validate" required/>
                <label for="clave_cliente">Clave</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">security</i>
                <input type="password" id="confirmar_clave" name="confirmar_clave" class="validate" required/>
                <label for="confirmar_clave">Confirmar clave</label>
            </div>

            <label class="center-align col s12">
                <input type="checkbox" id="condicion" name="condicion" required/>
                <span>Acepto <a href="#terminos" class="modal-trigger">términos y condiciones</a></span>
            </label>
        </div>
        <div class="row center-align">
            <div class="col s12">
                <button type="submit" onclick="console.log($('#fecha_nacimiento').val())" class="btn waves-effect blue tooltipped" data-tooltip="Registrar"><i class="material-icons">send</i></button>
            </div>
        </div>
    </form>
</div>

<!-- Importación del archivo para que funcione el reCAPTCHA. Para más información https://developers.google.com/recaptcha/docs/v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT"></script>

<?php
Commerce::footerTemplate('signin.js');
?>