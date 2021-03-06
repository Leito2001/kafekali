<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/usuarios.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $usuario = new Usuarios;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'session' =>0);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        if ($usuario->validateSessionTime()) {
            $result['session'] = 1;
            // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
            switch ($_GET['action']) {

                case 'logout':
                    unset($_SESSION['id_usuario']);
                    $result['status'] = 1;
                    $result['message'] = 'Sesión cerrada correctamente';
                    break;

                case 'readProfile':
                    if ($usuario->setId($_SESSION['id_usuario'])) {
                        if ($result['dataset'] = $usuario->readOneUsuario()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                case 'editProfile':
                    if ($usuario->setId($_SESSION['id_usuario'])) {
                        if ($usuario->readOneUsuario()) {
                            $_POST = $usuario->validateForm($_POST);
                            if ($usuario->setNombres($_POST['nombres_perfil'])) {
                                if ($usuario->setApellidos($_POST['apellidos_perfil'])) {
                                    if ($usuario->setCorreo($_POST['correo_perfil'])) {
                                        if ($usuario->setCelular($_POST['celular_perfil'])) {
                                            if ($usuario->setUsuario($_POST['alias_perfil'])) {
                                                if ($usuario->editProfile()) {
                                                    $_SESSION['alias_usuario'] = $usuario->getUsuario();
                                                    $result['status'] = 1;
                                                    $result['message'] = 'Perfil modificado correctamente';
                                                } else {
                                                    $result['exception'] = Database::getException();
                                                }
                                            } else {
                                                $result['exception'] = 'Alias incorrecto';
                                            }
                                        } else {
                                            $result['exception'] = 'Verifique el celular';
                                        }
                                    } else {
                                        $result['exception'] = 'Correo incorrecto';
                                    }
                                } else {
                                    $result['exception'] = 'Apellidos incorrectos';
                                }
                            } else {
                                $result['exception'] = 'Nombres incorrectos';
                            }
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                case 'password':
                    if ($usuario->setId($_SESSION['id_usuario'])) {
                        $_POST = $usuario->validateForm($_POST);
                        if ($_POST['clave_actual_1'] == $_POST['clave_actual_2']) {
                            if ($usuario->setPassword($_POST['clave_actual_1'])) {
                                if ($usuario->checkPassword($_POST['clave_actual_1'])) {
                                    if ($_POST['clave_nueva_1'] == $_POST['clave_nueva_2']) {
                                        if ($usuario->setPassword($_POST['clave_nueva_1'])) {
                                            if ($usuario->changePassword()) {
                                                $result['status'] = 1;
                                                $result['message'] = 'Contraseña cambiada correctamente';
                                            } else {
                                                $result['exception'] = Database::getException();
                                            }
                                        } else {
                                            $result['exception'] = $usuario->getPasswordError(); //getPasswordError para validar contraseña;
                                        }
                                    } else {
                                        $result['exception'] = 'Claves nuevas diferentes';
                                    }
                                } else {
                                    $result['exception'] = 'Clave actual incorrecta';
                                }
                            } else {
                                $result['exception'] = $usuario->getPasswordError();
                            }
                        } else {
                            $result['exception'] = 'Claves actuales diferentes';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                case 'readAll':
                    if ($result['dataset'] = $usuario->readAllUsuarios()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay usuarios registrados';
                    }
                    break;

                case 'create':
                    $_POST = $usuario->validateForm($_POST);

                    if ($usuario->setNombres($_POST['nombres'])) {

                        if ($usuario->setApellidos($_POST['apellidos'])) {

                            if ($usuario->setCelular($_POST['celular'])) {

                                if ($usuario->setCorreo($_POST['correo'])) {

                                    if ($usuario->setDui($_POST['dui'])) {

                                        if ($usuario->setNacimiento($_POST['fecha_nacimiento'])) {

                                            if ($usuario->setUsuario($_POST['usuario_u'])) {

                                                //Compara los datos en ambos textbox, si coinciden, se cambia la contraseña
                                                if ($_POST['clave_usuario'] == $_POST['confirmar_clave']) {

                                                    if ($usuario->setPassword($_POST['clave_usuario'])) {

                                                        if ($usuario->createUsuario()) {
                                                            $result['status'] = 1;
                                                            $result['message'] = 'Usuario creado correctamente';
                                                        } else {
                                                            $result['exception'] = Database::getException();
                                                        }
                                                    } else {
                                                        $result['exception'] = $cliente->getPasswordError(); //getPasswordError para validar contraseña;
                                                    }
                                                } else {
                                                    $result['exception'] = 'Claves diferentes';
                                                }
                                            } else {
                                                $result['exception'] = 'Por favor, verifique el nombre de usuario';
                                            }
                                        } else {
                                            $result['exception'] = 'Por favor, verifique la fecha de nacimiento';
                                        }
                                    } else {
                                        $result['exception'] = 'Por favor, verifique el formato de DUI';
                                    }
                                } else {
                                    $result['exception'] = 'Por favor, verifique el formato de correo';
                                }
                            } else {
                                $result['exception'] = 'Por favor, verifique el formato de celular';
                            }
                        } else {
                            $result['exception'] = 'Por favor, verifique los apellidos';
                        }
                    } else {
                        $result['exception'] = 'Por favor, verifique los nombres';
                    }
                    break;

                case 'readOne':
                    if ($usuario->setId($_POST['id_usuario'])) {
                        if ($result['dataset'] = $usuario->readOneUsuario()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                case 'update':
                    $_POST = $usuario->validateForm($_POST);
                    if ($usuario->setId($_POST['id_usuario'])) {
                        if ($usuario->readOneUsuario()) {
                            if ($usuario->setNombres($_POST['nombres'])) {
                                if ($usuario->setApellidos($_POST['apellidos'])) {
                                    if ($usuario->setCorreo($_POST['correo'])) {
                                        if ($usuario->setCelular($_POST['celular'])) {
                                            if ($usuario->updateUsuario()) {
                                                $result['status'] = 1;
                                                $result['message'] = 'Usuario modificado correctamente';
                                            } else {
                                                $result['exception'] = Database::getException();
                                            }
                                        } else {
                                            $result['exception'] = 'Celular incorrecto';
                                        }
                                    } else {
                                        $result['exception'] = 'Correo incorrecto';
                                    }
                                } else {
                                    $result['exception'] = 'Apellidos incorrectos';
                                }
                            } else {
                                $result['exception'] = 'Nombres incorrectos';
                            }
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                case 'delete':
                    if ($_POST['id_usuario'] != $_SESSION['id_usuario']
                    ) {
                        if ($usuario->setId($_POST['id_usuario'])) {
                            if ($usuario->readOneUsuario()) {
                                if ($usuario->deleteUsuario()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Usuario eliminado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = 'Usuario inexistente';
                            }
                        } else {
                            $result['exception'] = 'Usuario incorrecto';
                        }
                    } else {
                        $result['exception'] = 'No se puede eliminar a sí mismo';
                    }
                    break;

                default:
                    exit('Acción no disponible log');
            }
        } else {
            $result['exception'] = 'Su sesión ha caducado';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($usuario->readAllUsuarios()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existe al menos un usuario registrado';
                } else {
                    $result['exception'] = 'No existen usuarios registrados';
                }
                break;

            case 'register':
                $_POST = $usuario->validateForm($_POST);

                if ($usuario->setNombres($_POST['nombres'])) {

                    if ($usuario->setApellidos($_POST['apellidos'])) {

                        if ($usuario->setCelular($_POST['celular'])) {

                            if ($usuario->setCorreo($_POST['correo'])) {

                                if ($usuario->setDui($_POST['dui'])) {

                                    if ($usuario->setNacimiento($_POST['fecha_nacimiento'])) {

                                        if ($usuario->setUsuario($_POST['usuario_u'])) {

                                            //Compara los datos en ambos textbox, si coinciden, se inserta la contraseña
                                            if ($_POST['clave1'] == $_POST['clave2']) {

                                                if ($usuario->setPassword($_POST['clave1'])) {

                                                    if ($usuario->createUsuario()) {
                                                        $result['status'] = 1;
                                                        $result['message'] = 'Usuario registrado correctamente';
                                                    } else {
                                                        $result['exception'] = Database::getException();
                                                    }
                                                } else {
                                                    $result['exception'] = $usuario->getPasswordError();
                                                }
                                            } else {
                                                $result['exception'] = 'Claves diferentes';
                                            }
                                        } else {
                                            $result['exception'] = 'Por favor, verifique el usuario';
                                        }
                                    } else {
                                        $result['exception'] = 'Por favor, verificar fecha de nacimiento';
                                    }
                                } else {
                                    $result['exception'] = 'Por favor, verificar DUI';
                                }
                            } else {
                                $result['exception'] = 'Correo incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Celular incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Apellidos incorrectos';
                    }
                } else {
                    $result['exception'] = 'Nombres incorrectos';
                }
                break;

            case 'login':
                $data = $usuario->validateForm($_POST);
                //Verifica si el usuario existe
                if ($usuario->checkUser($data['usuario_u'])) {
                    //Verifica que la contraseña coincida con la que está en la base
                    if ($usuario->checkPassword($data['clave'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Autenticación correcta';
                        $_SESSION['id_usuario'] = $usuario->getId();
                        $_SESSION['usuario_u'] = $usuario->getUsuario();
                        $_SESSION['tiempo'] = time();
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Clave incorrecta';
                    }
                } else {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;

            case 'recuperar':
                if ($usuario->setCorreo($_POST['correo_usuario'])) {
                    //Verifica que la contraseña coincida con la que está en la base
                    if ($usuario->checkCorreo()) {
                        $password = uniqid();
                        require '../../../libraries/phpmailer52/class.phpmailer.php';
                        require '../../../libraries/phpmailer52/class.smtp.php';

                        //Create a new PHPMailer instance
                        $mail = new PHPMailer;
                        //Uso de UTF-8
                        $mail->CharSet = 'UTF-8';

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
                        $mail->addAddress($_POST['correo_usuario'], $usuario->getNombres() . ' ' . $usuario->getApellidos());

                        //Set the subject line
                        $mail->Subject = 'Restauración de contraseña';

                        //Read an HTML message body from an external file, convert referenced images to embedded,
                        //convert HTML into a basic plain-text alternative body
                        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

                        //Replace the plain text body with one created manually
                        $mail->Body = 'Su nueva contraseña es: ' . $password;

                        //Attach an image file
                        //$mail->addAttachment('images/phpmailer_mini.png');

                        //send the message, check for errors
                        if ($mail->send()) {
                            if ($usuario->setPassword($password)) {
                                if ($usuario->changePassword()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Su contraseña ha sido restablecida correctamente, revise su correo.';
                                } else {
                                    $result['exception'] = 'Ocurrió un problema al cambiar la contraseña';
                                }
                            } else {
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
    //Devuelve un error si no hay un usuario con la sesión iniciada
} else {
    exit('Recurso denegado');
}
?>
