<?php
/*
*   Clase para definir las plantillas de las páginas web del sitio público.
*/
class Commerce
{
    /*
    *   Método para imprimir la plantilla del encabezado.
    *
    *   Parámetros: $title (título de la página web).
    *
    *   Retorno: ninguno.
    */
    public static function headerTemplate($title)
    {
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en las páginas web.
        session_start();
        // Se imprime el código HTML para el encabezado del documento.
        print('
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="utf-8">
                    <title>'.$title.'</title>
                    <link type="image/png" rel="icon" href="../../resources/img/logo.png"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/materialize.min.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/material-icons.css"/>
                    <link type="text/css" rel="stylesheet" href="../../resources/css/commerce.css"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                </head>
                <body>
        ');
        // Se obtiene el nombre del archivo de la página web actual.
        $filename = basename($_SERVER['PHP_SELF']);
        // Se comprueba si existe una sesión de cliente para mostrar el menú de opciones, de lo contrario se muestra otro menú.
        if (isset($_SESSION['id_cliente'])) {
            // Se verifica si la página web actual es diferente a login.php y register.php, de lo contrario se direcciona a index.php
            if ($filename != 'login.php' && $filename != 'signin.php') {
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="orange darken-4">
                                <div class="nav-wrapper">
                                    <a href="index.php" class="brand-logo"><img src="../../resources/img/logo_texto_blanco.png" height="60"></a>
                                    <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                                        <li><a href="cart.php"><i class="material-icons left">shopping_cart</i>Carrito</a></li>
                                        <li><a href="#" onclick="logOut()"><i class="material-icons left">close</i>Cerrar sesión</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <ul class="sidenav" id="mobile">
                            <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                            <li><a href="cart.php"><i class="material-icons left">shopping_cart</i>Carrito</a></li>
                            <li><a href="#" onclick="logOut()"><i class="material-icons left">close</i>Cerrar sesión</a></li>
                        </ul>
                    </header>
                    <main>
                ');
            } else {
                header('location: index.php');
            }
        } else {
            // Se verifica si la página web actual es diferente a index.php (Iniciar sesión) y a register.php (Crear primer usuario) para direccionar a index.php, de lo contrario se muestra un menú vacío.
            if ($filename != 'cart.php') {
                print('
                    <header>
                        <div class="navbar-fixed">
                            <nav class="orange darken-4">
                                <div class="nav-wrapper">
                                    <a href="index.php" class="brand-logo"><img src="../../resources/img/logo_texto_blanco.png" height="60"></a>
                                    <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                                    <ul class="right hide-on-med-and-down">
                                        <li><a href="#title"><i class="material-icons left">view_module</i>Catálogo</a></li>
                                        <li><a href="signin.php"><i class="material-icons left">person</i>Crear cuenta</a></li>
                                        <li><a href="login.php"><i class="material-icons left">login</i>Iniciar sesión</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <ul class="sidenav" id="mobile">
                            <li><a href="index.php"><i class="material-icons left">view_module</i>Catálogo</a></li>
                            <li><a href="signin.php"><i class="material-icons left">person</i>Crear cuenta</a></li>
                            <li><a href="login.php"><i class="material-icons left">login</i>Iniciar sesión</a></li>
                        </ul>
                    </header>
                    <main>
                ');
            } else {
                header('location: login.php');
            }
        }
        // Se llama al método que contiene el código de las cajas de dialogo (modals).
        self::modals();
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
                    <!-- Contenedor para mostrar efecto parallax con una altura de 300px e imagen aleatoria -->
                    <div class="parallax-container">
                        <div class="parallax">
                            <img id="parallax">
                        </div>
                    </div>
                </main>
                <!--Pie de página-->
                <footer class="page-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col m4 s12">
                                <h5 class="white-text" id="kfot">Kafekali</h5>
                                <p class="grey-text text-lighten-4">Un proyecto impulsado por</p>
                                <img src="../../resources/img/conamype_blanco.png" alt="logo" width="270">
                            </div>
                            <div class="col m4 s12">
                                <h5 class="white-text" id="kfot">¿Necesitas ayuda?</h5>
                                <ul>
                                    <li><a class="grey-text text-lighten-3" href="#!">Preguntas frecuentes</a></li>
                                    <br>
                                    <li><a href="#terminos" class="modal-trigger white-text"><b>Términos y condiciones</b></a></li>
                                    <br>
                                    <li><a class="grey-text text-lighten-3" href="#!">+503 78613311</a></li>
                                </ul>
                            </div>
                            <div class="col m4 s12">
                                <h5 class="white-text" id="kfot">Conócenos</h5>
                                <ul>
                                    <li><a class="grey-text text-lighten-3" href="index.php">Sobre nosotros</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer-copyright">
                        <div class="container">
                            © 2020 Kafekali
                        </div>
                    </div>
                </footer>
                <script type="text/javascript" src="../../resources/js/jquery-3.4.1.min.js"></script>
                <script type="text/javascript" src="../../resources/js/materialize.min.js"></script>
                <script type="text/javascript" src="../../resources/js/sweetalert.min.js"></script>
                <script type="text/javascript" src="../../core/helpers/components.js"></script>
                <script type="text/javascript" src="../../core/controllers/commerce/initialization.js"></script>
                <script type="text/javascript" src="../../core/controllers/commerce/account.js"></script>
                <script type="text/javascript" src="../../core/controllers/commerce/'.$controller.'"></script>
            </body>
            </html>
        ');
    }

    /*
    *   Método para imprimir las cajas de dialogo (modals).
    */
    private static function modals()
    {
        // Se imprime el código HTML de las cajas de dialogo (modals).
        print('
            <!-- Componente Modal para mostrar los Términos y condiciones -->
            <div id="terminos" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">TÉRMINOS Y CONDICIONES</h4>
                    <p class="center"> <b>¡Bienvenido a Kafekali!</b> <br><br>
                    Es muy importante que lea los siguientes términos y condiciones antes de hacer alguna compra en nuestra tienda. <br>
                    Usando el sitio wwww.kafekali.com el cliente conviene y acepta estos términos de uso. <br>
                    El uso del sitio www.kafekali.com, el cual otorga acceso a productos de belleza, está sujetos a los términos y condiciones de este acuerdo. 
                    www.kafekali.com se reserva el derecho de cambiar, modificar, agregar o de quitar porciones de estos términos y condiciones de uso en cualquier momento. <br>
                    Es responsabilidad del usuario revisar si hay cambios. Los cambios son efectivos inmediatamente después que hayan sido puestos en el sitio. <br>
                    <b>General:</b> Kafekali no será responsable por cualquier daño resultante del uso de este sitio, incluyendo, de forma no limitativa: daños directos, indirectos, 
                    incidentales, comerciales, punitivos y daños consecuentes de cualquier clase. <br>
                    Kafekali se reserva el derecho a cancelar la cuenta y el servicio a clientes que hagan mal uso o intenten efectuar un acto ilícito.</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar la Misión -->
            <div id="mision" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">MISIÓN</h4>
                    <p>Ofrecer los mejores productos a nivel nacional para satisfacer a nuestros clientes y...</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar la Visión -->
            <div id="vision" class="modal">
                <div class="modal-content">
                    <h4 class="center-align">VISIÓN</h4>
                    <p>Ser la empresa lider en la región ofreciendo productos de calidad a precios accesibles y...</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>

            <!-- Componente Modal para mostrar los Valores -->
            <div id="valores" class="modal">
                <div class="modal-content center-align">
                    <h4>VALORES</h4>
                    <p>Responsabilidad</p>
                    <p>Honestidad</p>
                    <p>Seguridad</p>
                    <p>Calidad</p>
                </div>
                <div class="divider"></div>
                <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close btn waves-effect"><i class="material-icons">done</i></a>
                </div>
            </div>
        ');
    }
}
?>