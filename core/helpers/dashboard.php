<?php
/*
*	Clase para definir las plantillas de las páginas web del sitio privado.
*/
class Dashboard
{
    /*
    *   Método para imprimir la plantilla del encabezado.
    *
    *   Parámetros: $title (título de la página web y del contenido principal).
    *
    *   Retorno: ninguno.
    */
    public static function headerTemplate($title)
    {
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en las páginas web.
        session_start();
        // Se imprime el código HTML de la cabecera del documento.
        print('
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <title>'.$title.'</title>
                    <link type="image/png" rel="icon" href="../../resources/img/logo.png"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/materialize.min.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/datatables.min.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/material-icons.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/dashboard.css"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body>
        ');
        // Se obtiene el nombre del archivo de la página web actual.
        $filename = basename($_SERVER['PHP_SELF']);
        // Se comprueba si existe una sesión de administrador para mostrar el menú de opciones, de lo contrario se muestra un menú vacío.
        if (isset($_SESSION['id_usuario'])) {
            // Se verifica si la página web actual es diferente a index.php (Iniciar sesión) y a register.php (Crear primer usuario) para no iniciar sesión otra vez, de lo contrario se direcciona a main.php
            if ($filename != 'index.php' && $filename != 'register.php') {
                // Se llama al método que contiene el código de las cajas de dialogo (modals).
                self::modals();
                // Se imprime el código HTML para el encabezado del documento con el menú de opciones.
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="deep-orange darken-3">
                                <div class="nav-wrapper">
                                    <a href="main.php" class="brand-logo"><img src="../../resources/img/logo_texto_blanco.png" height="60"></a>
                                    <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="usuarios.php"><i class="material-icons left">group</i>Usuarios</a></li>
                                        <li><a href="pedidos.php"><i class="material-icons left">view_module</i>Pedidos</a></li>
                                        <li><a href="proveedores.php"><i class="material-icons left">swap_horizontal_circle</i>Proveedores</a></li>
                                        <li><a href="tipo_producto.php"><i class="material-icons left">dashboard</i>Categorías</a></li>
                                        <li><a href="productos.php"><i class="material-icons left">category</i>Productos</a></li>                                     
                                        <li><a href="#" class="dropdown-trigger" data-target="dropdown"><i class="material-icons left">account_circle</i>Cuenta: <b>'.$_SESSION['usuario_u'].'</b></a></li>
                                    </ul>
                                    <ul id="dropdown" class="dropdown-content">
                                        <li><a href="#" onclick="openModalProfile()"><i class="material-icons">face</i>Editar perfil</a></li>
                                        <li><a href="#password-modal" class="modal-trigger"><i class="material-icons">lock</i>Cambiar clave</a></li>
                                        <li><a href="#" onclick="signOff()"><i class="material-icons">clear</i>Salir</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <ul class="sidenav" id="mobile">
                            <li><a href="usuarios.php"><i class="material-icons left">group</i>Usuarios</a></li>
                            <li><a href="pedidos.php"><i class="material-icons left">view_module</i>Pedidos</a></li>
                            <li><a href="proveedores.php"><i class="material-icons left">swap_horizontal_circle</i>Proveedores</a></li>
                            <li><a href="tipo_producto.php"><i class="material-icons left">category</i>Categorías</a></li>
                            <li><a href="productos.php"><i class="material-icons left">dashboard</i>Productos</a></li>
                            <li><a class="dropdown-trigger" href="#" data-target="dropdown-mobile"><i class="material-icons">account_circle</i>Cuenta: <b>'.$_SESSION['usuario_u'].'</b></a></li>
                        </ul>
                        <ul id="dropdown-mobile" class="dropdown-content">
                            <li><a href="#" onclick="openModalProfile()">Editar perfil</a></li>
                            <li><a href="#password-modal" class="modal-trigger">Cambiar clave</a></li>
                            <li><a href="#" onclick="signOff()">Salir</a></li>
                        </ul>
                    </header>
                    <main class="container">
                    <h3 class="center-align">'.$title.'</h3>
                ');
            } else {
                header('location: main.php');
            }
        } else {
            // Se verifica si la página web actual es diferente a index.php (Iniciar sesión) y a register.php (Crear primer usuario) para direccionar a index.php, de lo contrario se muestra un menú vacío.
            if ($filename != 'index.php' && $filename != 'register.php') {
                header('location: index.php');
            } else {
                // Se imprime el código HTML para el encabezado del documento con un menú vacío cuando sea iniciar sesión o registrar el primer usuario.
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="deep-orange darken-3">
                                <div class="nav-wrapper">
                                    <a href="index.php" class="brand-logo"><i class="material-icons">dashboard</i></a>
                                </div>
                            </nav>
                        </div>
                    </header>
                    <main class="container">
                    <h3 class="center-align">'.$title.'</h3>
                ');
            }
        }
    }

    /*
    *   Método para imprimir la plantilla del pie.
    *
    *   Parámetros: $controller (nombre del archivo que sirve como controlador de la página web).
    *
    *   Retorno: ninguno.
    */
    public static function footerTemplate($controller)
    {
        // Se imprime el código HTML para el pie del documento.
        print('
                    </main>
                    <footer class="page-footer deep-orange darken-3">
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <h5 class="white-text">Kafekali</h5>
                                    <p class="white-text">Un proyecto impulsado por:</p>
                                    <img src="../../resources/img/conamype_blanco.png" alt="logo" width="270">
                                </div>
                                <div class="col s12 m6 l6">
                                    <h5 class="white-text">Soporte</h5>
                                    <a class="white-text" href="mailto:cmrale4@gmail.com"><i class="material-icons left">email</i>E-mail</a>
                                </div>
                                <div class="col s12 m6 l6">
                                    <a href="#terminos-modal" class="modal-trigger white-text"><i class="material-icons left">help</i>Términos y condiciones</a>
                                </div>
                            </div>
                        </div>
                        <div class="footer-copyright">
                            <div class="container">
                                <span>© Kafekali, todos los derechos reservados.</span>
                            </div>
                        </div>
                    </footer>
                    <script type="text/javascript" src="../../resources/js/jquery-3.4.1.min.js"></script>
                    <script type="text/javascript" src="../../resources/js/datatables.min.js"></script>
                    <script type="text/javascript" src="../../resources/js/materialize.min.js"></script>
                    <script type="text/javascript" src="../../resources/js/sweetalert.min.js"></script>
                    '.(isset($_SESSION['usuario_u']) ? '<script> let USER_NAME = "'.$_SESSION['usuario_u'].'" </script>' : '').'
                    <script type="text/javascript" src="../../core/helpers/components.js"></script>
                    <script type="text/javascript" src="../../core/controllers/dashboard/initialization.js"></script>
                    <script type="text/javascript" src="../../core/controllers/dashboard/account.js"></script>
                    <script type="text/javascript" src="../../core/controllers/dashboard/'.$controller.'"></script>
                </body>
            </html>
        ');
    }

    /*
    *   Método para imprimir las cajas de dialogo (modals) de editar pefil y cambiar contraseña.
    */
    private function modals()
    {
        // Se imprime el código HTML de las cajas de dialogo (modals).
        print('
            <!-- Componente Modal para mostrar el formulario de editar perfil -->
            <div id="profile-modal" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">Editar perfil</h4>
                    <form method="post" id="profile-form">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input id="nombres_perfil" type="text" name="nombres_perfil" class="validate" required/>
                                <label for="nombres_perfil">Nombres</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input id="apellidos_perfil" type="text" name="apellidos_perfil" class="validate" required/>
                                <label for="apellidos_perfil">Apellidos</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_pin</i>
                                <input id="alias_perfil" type="text" name="alias_perfil" class="validate" required/>
                                <label for="alias_perfil">Nombre de usuario</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">phone</i>
                                <input id="celular_perfil" type="text" name="celular_perfil" class="validate" required/>
                                <label for="celular_perfil">Celular</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <i class="material-icons prefix">email</i>
                                <input id="correo_perfil" type="email" name="correo_perfil" class="validate" required/>
                                <label for="correo_perfil">Correo</label>
                            </div>
                        </div>
                        <div class="row center-align">
                            <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Componente Modal para mostrar el formulario de cambiar contraseña -->
            <div id="password-modal" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">Cambiar contraseña</h4>
                    <form method="post" id="password-form">
                        <div class="row center-align">
                            <label>CLAVE ACTUAL</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_actual_1" type="password" name="clave_actual_1" class="validate" required/>
                                <label for="clave_actual_1">Clave</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_actual_2" type="password" name="clave_actual_2" class="validate" required/>
                                <label for="clave_actual_2">Confirmar clave</label>
                            </div>
                        </div>
                        <div class="row center-align">
                            <label>CLAVE NUEVA</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_nueva_1" type="password" name="clave_nueva_1" class="validate" required/>
                                <label for="clave_nueva_1">Clave</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">security</i>
                                <input id="clave_nueva_2" type="password" name="clave_nueva_2" class="validate" required/>
                                <label for="clave_nueva_2">Confirmar clave</label>
                            </div>
                        </div>
                        <div class="row center-align">
                            <a href="#" class="btn waves-effect grey tooltipped modal-close" data-tooltip="Cancelar"><i class="material-icons">cancel</i></a>
                            <button type="submit" class="btn waves-effect blue tooltipped" data-tooltip="Guardar"><i class="material-icons">save</i></button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Componente Modal para mostrar términos y condiciones -->
            <div id="terminos-modal" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">Términos y condiciones</h4>
                    <form method="post" id="terminos-form">
                        <div class="row center-align">
                            <p>
                                <b>¡Bienvenido al sistema de Kafekali!</b><br><br>
                                Es muy importante que lea los siguientes términos y condiciones antes de realizar alguna acción en el sistema.<br>
                                En todo momento, el usuario es el responsable único y final de mantener en secreto sus claves de acceso con la cual ingrese a 
                                ciertos servicios y contenidos de www.kafekali.com; así como a las páginas de terceros. <br><br>
                                Si desea que otra persona use su dispositivo, es importante que siempre cierre sesión para que ninguna otra persona tenga acceso
                                 a su cuenta. Acepta notificar de inmediato a la compañía sobre cualquier uso no autorizado de su nombre de usuario y contraseña. <br><br> 
                                 Está estrictamente prohibido transmitir sus credenciales de inicio de sesión de www.kafekali.com a cualquier otro, son de uso personal.
                                Tampoco está permitido compartir sus credenciales de inicio de sesión con familiares o amigos cercanos. <br><br>
                                Si el sistema detectara actividad sospechosa de dirección IP o cualquier otro tipo de actividad en su cuenta, tenemos el derecho de suspenderlo
                                y revocar cualquier acceso futuro a www.kafekali.com.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        ');
    }
}
?>