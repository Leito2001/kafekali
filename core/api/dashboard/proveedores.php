<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/proveedores.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $proveedores = new Proveedores;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
	if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $proveedores->readAllProveedores()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay proveedores registrados';
                }
            break;                

            case 'create':
            $_POST = $proveedores->validateForm($_POST);

                if ($proveedores->setNombreEmpresa($_POST['nombre_empresa'])) {

                    if ($proveedores->setNombreProveedor($_POST['nombre_prov'])) {

                        if ($proveedores->setCelular($_POST['celular'])){

                            if ($proveedores->setDui($_POST['dui'])){
                                
                                if ($proveedores->setNumeroEmpresa($_POST['numero_empresa'])){

                                    if ($proveedores->setRubro($_POST['rubro'])){

                                        if ($proveedores->createProveedor()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Proveedor creado correctamente';
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }

                                    } else {
                                        $result['exception'] = 'Por favor, verifique el rubro';
                                    }

                                } else {
                                    $result['exception'] = 'Por favor, verifique el número de la empresa';
                                }

                            } else {
                                $result['exception'] = 'Por favor, verifique el formato de DUI';
                            }

                        } else {
                            $result['exception'] = 'Por favor, verifique el formato de celular';
                        }
                        
                    } else {
                        $result['exception'] = 'Por favor, verifique el nombre del proveedor';
                    }
                } else {
                    $result['exception'] = 'Por favor, verifique el nombre de la empresa';
                }
            break;


            case 'readOne':
                if ($proveedores->setId($_POST['id_proveedor'])) {
                    if ($result['dataset'] = $proveedores->readOneProveedor()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Proveedor inexistente';
                    }
                } else {
                    $result['exception'] = 'Proveedor incorrecto';
                }
            break;

                case 'update':
                    $_POST = $proveedores->validateForm($_POST);
                    if ($proveedores->setId($_POST['id_proveedor'])) {
                        if ($proveedores->readOneProveedor()) {
                            if ($proveedores->setNombreEmpresa($_POST['nombre_empresa'])) {
                                if ($proveedores->setNombreProveedor($_POST['nombre_prov'])) {
                                    if ($proveedores->setCelular($_POST['celular'])) {
                                        if ($proveedores->updateProveedor()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Proveedor modificado correctamente';
                                        } else {
                                            $result['exception'] = Database::getException();
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
                if ($proveedores->setId($_POST['id_proveedor'])) {
                    if ($proveedores->deleteProveedor()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Proveedor incorrecto';
                    }
                break;
            
            default:
            exit('Acción no disponible');
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        exit('Acceso no disponible');
    }
} else {
	exit('Recurso denegado');
}
?>