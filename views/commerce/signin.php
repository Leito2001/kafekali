<?php
require_once('../../core/helpers/commerce.php');
Commerce::headerTemplate('Registrarse');
?>

<div class="container">
    <!-- Título para la página web -->
    <h4 class="center-align">Regístrate como cliente</h4>
    <!-- Formulario para crear cuenta -->
    <form method="post" id="register-form">
        <!-- Campo oculto para asignar el token del reCAPTCHA -->
        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response"/>
        
        <div class="row">

            <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="nombre" name="nombre" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
                <label for="nombre">Nombres</label>
            </div>

            <!-- Input con validación: una cadena de texto de 50 carácteres máximo solo con letras y espacios -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_box</i>
                <input type="text" id="apellido" name="apellido" pattern="[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]{1,50}" maxlength="50" class="validate" required/>
                <label for="apellido">Apellidos</label>
            </div>

            <!-- Input con validación: una cadena de texto de 9 carácteres cumpliendo el requisito 0000-0000 -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">phone</i>
                <input type="text" id="celular" name="celular" placeholder="0000-0000" pattern="[2,6,7]{1}[0-9]{3}[-][0-9]{4}" minlength="9" maxlength="9" class="validate" required/>
                <label for="celular">Celular</label>
            </div>

            <!-- Input con validación: una cadena de texto con formato de email (@ y .com) de 60 carácteres máximo -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">email</i>
                <input type="email" id="correo" name="correo" maxlength="60" class="validate" required/>
                <label for="correo">Correo electrónico</label>
            </div>
            
            <!-- Input con validación: una cadena de texto sin restricciones de escritura con 200 carácteres máximo -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">place</i>
                <input type="text" id="direccion" name="direccion" pattern="[a-zA-Z0-9#ñÑáÁéÉíÍóÓúÚ\s\,\:\;\.\-\+]" class="validate" maxlength="200" class="validate" required/>
                <label for="direccion">Direccion del cliente</label>
            </div>

            <div class="input-field col s12 m6">
                <i class="material-icons prefix">today</i>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="validate" required/>
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
            </div>

            <!-- Input con validación: una cadena de texto de 10 carácteres cumpliendo el requisito 00000000-0 -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">how_to_reg</i>
                <input type="text" id="dui" name="dui" placeholder="00000000-0" pattern="[0-9]{8}[-][0-9]{1}" minlength="10" maxlength="10" class="validate" required/>
                <label for="dui">DUI</label>
            </div>

            <!-- Input con validación: una cadena de texto de 20 carácteres máximo entre letras, carácteres especiales (_ y .) y números sin espacios -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">account_circle</i>
                <input type="text" id="usuario_c" name="usuario_c" pattern="[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ_.]{1,20}" maxlength="20" title="No use espacios, por favor." class="validate" required/>
                <label for="usuario_c">Nombre de usuario</label>
            </div>

            <!-- Input con validación: mínimo 6 carácteres -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">lock</i>
                <input type="password" id="clave_cliente" name="clave_cliente" minlength="6" class="validate" required/>
                <label for="clave_cliente">Clave</label>
            </div>

            <!-- Input con validación: mínimo 6 carácteres -->
            <div class="input-field col s12 m6">
                <i class="material-icons prefix">lock</i>
                <input type="password" id="confirmar_clave" name="confirmar_clave" minlength="6" class="validate" required/>
                <label for="confirmar_clave">Confirmar clave</label>
            </div>

            <!-- Chebox para aceptar información del modal con términos y condiciones -->
            <label class="center-align col s12">
                <input type="checkbox" id="condicion" name="condicion" required/>
                <span>Acepto <a href="#terminos" class="modal-trigger">términos y condiciones</a></span>
            </label>
        </div>

        <!-- Botón para registrarse -->
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