<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/clientes.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new Clientes;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {

            case 'logout':
                unset($_SESSION['id_cliente']);
                $result['status'] = 1;
                $result['message'] = 'sesion eliminada correctamente';
            break;
            default:
                exit('Acción no disponible dentro de la sesión');
        }
    } else {
        // Se compara la acción a realizar cuando el cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'register':
                $_POST = $cliente->validateForm($_POST);
                // Se sanea el valor del token para evitar datos maliciosos.
                $token = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);
                if ($token) {
                    $secretKey = '6LdBzLQUAAAAAL6oP4xpgMao-SmEkmRCpoLBLri-';
                    $ip = $_SERVER['REMOTE_ADDR'];

                    $data = array(
                        'secret' => $secretKey,
                        'response' => $token,
                        'remoteip' => $ip
                    );

                    $options = array(
                        'http' => array(
                            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data)
                        ),
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        )
                    );

                    $url = 'https://www.google.com/recaptcha/api/siteverify';
                    $context  = stream_context_create($options);
                    $response = file_get_contents($url, false, $context);
                    $captcha = json_decode($response, true);

                    if ($captcha['success']) {

                        if ($cliente->setNombre($_POST['nombre'])) {

                            if ($cliente->setApellido($_POST['apellido'])) {

                                if ($cliente->setCelular($_POST['celular'])) {

                                    if ($cliente->setCorreo($_POST['correo'])) {

                                        if ($cliente->setNacimiento($_POST['fecha_nacimiento'])) {

                                            if ($cliente->setDui($_POST['dui'])) {

                                                if ($cliente->setUsuarioC($_POST['usuario_c'])) {
                                                    //Compara los datos en ambos textbox, si coinciden, se inserta la contraseña
                                                    if ($_POST['clave_cliente'] == $_POST['confirmar_clave']) {

                                                        if ($cliente->setPasswordC($_POST['clave_cliente'])) {

                                                            if ($cliente->setDireccion($_POST['direccion'])) {

                                                                if ($cliente->createCliente()) {
                                                                    $result['status'] = 1;
                                                                    $result['message'] = 'Cliente registrado correctamente';
                                                                } else {
                                                                    $result['exception'] = 'Ocurrió un problema al registrar el cliente';
                                                                }
                                                            } else {
                                                                $result['exception'] = 'Verifique la dirección';
                                                            }
                                                        } else {
                                                            $result['exception'] = 'Clave menor a 6 caracteres';
                                                        }
                                                    } else {
                                                        $result['exception'] = 'Claves diferentes';
                                                    }
                                                } else {
                                                    $result['exception'] = 'Verifique el nombre de usuario';
                                                }
                                            } else {
                                                $result['exception'] = 'Verifique el formato de DUI';
                                            }
                                        } else {
                                            $result['exception'] = 'Verifique la fecha de nacimiento';
                                        }
                                    } else {
                                        $result['exception'] = 'Verifique el formato del correo';
                                    }
                                } else {
                                    $result['exception'] = 'Verifique el formato del celular';
                                }
                            } else {
                                $result['exception'] = 'Apellidos incorrectos';
                            }
                        } else {
                            $result['exception'] = 'Nombres incorrectos';
                        }
                    } else {
                        $result['exception'] = 'No eres un humano';
                    }
                } else {
                    $result['exception'] = 'Ocurrió un problema al cargar el reCAPTCHA';
                }

                break;

            case 'login':
                $_POST = $cliente->validateForm($_POST);
                //Verifica si existe el cliente
                if ($cliente->checkCliente($_POST['usuario_c'])) {
                    //Verifica el estado del cliente para saber si tiene acceso o no a la tienda
                    if ($cliente->getEstado()) {
                        if ($cliente->checkPassword($_POST['clave_cliente'])) {
                            $_SESSION['id_cliente'] = $cliente->getId();
                            $_SESSION['usuario_c'] = $cliente->getUsuarioC();
                            $result['status'] = 1;
                            $result['message'] = 'Bienvenido';
                        } else {
                            $result['exception'] = 'Clave incorrecta';
                        }
                    } else {
                        $result['exception'] = 'Su cuenta ha sido desactivada';
                    }
                } else {
                    $result['exception'] = 'Nombre de usuario incorrecto';
                }
                break;

                case 'recuperar':
                    if ($cliente->setCorreo($_POST['correo_usuario'])) {
                        //Verifica que la contraseña coincida con la que está en la base
                        if ($cliente->checkCorreo()) {
                            $password = uniqid();
                            require '../../../libraries/phpmailer52/class.phpmailer.php';
                            require '../../../libraries/phpmailer52/class.smtp.php';
    
                            //Create a new PHPMailer instance
                            $mail = new PHPMailer;

                            //Uso de UTF-8
                            $mail->CharSet='UTF-8';
                            //Tell PHPMailer to use SMTP
                            $mail->isSMTP();
    
                            //Enable SMTP debugging
                            // SMTP::DEBUG_OFF = off (for production use)
                            // SMTP::DEBUG_CLIENT = client messages
                            // SMTP::DEBUG_SERVER = client and server messages
                            //$mail->SMTPDebug = 2;
    
    
                            //Set the hostname of the mail server
                            $mail->Host = 'smtp.gmail.com';
                            // use
                            // $mail->Host = gethostbyname('smtp.gmail.com');
                            // if your network does not support SMTP over IPv6
    
                            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                            $mail->Port = 465;
    
                            $mail->SMTPSecure = 'ssl';
    
                            //Whether to use SMTP authentication
                            $mail->SMTPAuth = true;
    
                            //Username to use for SMTP authentication - use full email address for gmail
                            $mail->Username = 'leomoi30553@gmail.com';
    
                            //Password to use for SMTP authentication
                            $mail->Password = 'leito1724spidermaneslaley';
    
                            //Set who the message is to be sent from
                            $mail->setFrom('leomoi30553@gmail.com', 'Kafekali');
    
                            //Set an alternative reply-to address
                            //$mail->addReplyTo('replyto@example.com', 'First Last');
                            
                            //Set who the message is to be sent to
                            $mail->addAddress($_POST['correo_usuario'], $cliente->getNombre().' '.$cliente->getApellido());
    
                            //Set the subject line
                            $mail->Subject = 'Restauración de contraseña';
    
                            //Read an HTML message body from an external file, convert referenced images to embedded,
                            //convert HTML into a basic plain-text alternative body
                            //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
    
                            //Replace the plain text body with one created manually
                            $mail->Body = 'Su nueva contraseña es: '.$password;
    
                            //Attach an image file
                            //$mail->addAttachment('images/phpmailer_mini.png');
    
                            //send the message, check for errors
                            if ($mail->send()) {
                                if($cliente->setPasswordC($password)){
                                    if($cliente->changePassword()){
                                        $result['status'] = 1;
                                        $result['message'] = 'Su contraseña ha sido restablecida correctamente, revise su correo.';
                                    }else{
                                        $result['exception'] = 'Ocurrió un problema al cambiar la contraseña';
                                    }
                                }else{
                                    $result['exception'] = 'Contraseña incorrecta';
                                }
                            } else {
                                $result['exception'] = $mail->ErrorInfo;
                            }
                        } else {
                            $result['exception'] = 'Correo inexistente';
                        }
                    } else {
                        $result['exception'] = 'Correo incorrecto';
                    }
                break;

            default:
                exit('Acción no disponible fuera de la sesión');
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
    //Devuelve un error si no hay un cliente con la sesión iniciada
} else {
    exit('Recurso denegado');
}
?>
