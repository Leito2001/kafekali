<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pventa.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pventa = new Pventa;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $pventa->readAllPVenta()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay puntos de venta registrados';
                }
                break;

            case 'create':
                $_POST = $pventa->validateForm($_POST);
                if ($pventa->setPuntoVenta($_POST['punto_venta'])) {
                    if ($pventa->setDireccion($_POST['direccion'])) {
                        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                            if ($pventa->setImagen($_FILES['imagen'])) {
                                if ($pventa->createPVenta()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Punto de venta creado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = $pventa->getImageError();
                            }
                        } else {
                            $result['exception'] = 'Seleccione una imagen';
                        }
                    } else {
                        $result['exception'] = 'Dirección incorrecta';
                    }
                } else {
                    $result['exception'] = 'Nombre incorrecto';
                }
                break;
            case 'readOne':
                if ($pventa->setId($_POST['id_punto_venta'])) {
                    if ($result['dataset'] = $pventa->readOnePVenta()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Punto inexistente';
                    }
                } else {
                    $result['exception'] = 'Punto incorrecta';
                }
                break;

            case 'update':
                $_POST = $pventa->validateForm($_POST);
                if ($pventa->setId($_POST['id_punto_venta'])) {
                    if ($data = $pventa->readOnePVenta()) {
                        if ($pventa->setPuntoVenta($_POST['punto_venta'])) {
                            if ($pventa->setDireccion($_POST['direccion'])) {
                                if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                                    if ($pventa->setImagen($_FILES['imagen'])) {
                                        if ($pventa->updatePVenta()) {
                                            $result['status'] = 1;
                                            if ($pventa->deleteFile($pventa->getRuta(), $data['imagen'])) {
                                                $result['message'] = 'Punto de venta modificado correctamente';
                                            } else {
                                                $result['message'] = 'Punto de venta modificado, pero no se borró la imagen anterior';
                                            }
                                        } else {
                                            $result['exception'] = Database::getException();
                                        } 
                                    } else {
                                        $result['exception'] = $pventa->getImageError();
                                    }
                                } else {
                                    if ($pventa->updatePVenta()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Punto de venta modificado correctamente';
                                    } else {
                                        $result['exception'] = Database::getException();
                                    }
                                }
                            } else {
                                $result['exception'] = 'Dirección incorrecta';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Punto inexistente';
                    }
                } else {
                    $result['exception'] = 'Punto incorrecto';
                }
                break;

            case 'delete':
                if ($pventa->setId($_POST['id_punto_venta'])) {
                    if ($data = $pventa->readOnePVenta()) {
                        if ($pventa->deletePVenta()) {
                            $result['status'] = 1;
                            if ($pventa->deleteFile($pventa->getRuta(), $data['imagen'])) {
                                $result['message'] = 'Punto de venta eliminado correctamente';
                            } else {
                                $result['message'] = 'Punto de venta eliminado, pero no se borró la imagen';
                            }
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Punto inexistente';
                    }
                } else {
                    $result['exception'] = 'Punto incorrecto';
                }
                break;
            default:
                exit('Acción no disponible dentro de la sesión');
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