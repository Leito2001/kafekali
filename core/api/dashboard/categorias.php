<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/categorias.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $categoria = new Categorias;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $categoria->readAllTProducto()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay categorias registradas';
                }
                break;

            case 'create':
                $_POST = $categoria->validateForm($_POST);
                if ($categoria->setTipoProducto($_POST['tipo_producto'])) {
                        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                            if ($categoria->setImagen($_FILES['imagen'])) {
                                if ($categoria->createTProducto()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Categoria creado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = $categoria->getImageError();
                            }
                        } else {
                            $result['exception'] = 'Seleccione una imagen';
                        }
                   
                } else {
                    $result['exception'] = 'categoria incorrecta';
                }
                break;
            case 'readOne':
                if ($categoria->setId($_POST['id_tipo_producto'])) {
                    if ($result['dataset'] = $categoria->readOneTProducto()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'categoria inexistente';
                    }
                } else {
                    $result['exception'] = 'categoria incorrecta';
                }
                break;

            
                case 'update':
                    $_POST = $categoria->validateForm($_POST);
                    if ($categoria->setId($_POST['id_tipo_producto'])) {
                        if ($data = $categoria->readOneTProducto()) {
                            if ($categoria->setTipoProducto($_POST['tipo_producto'])) {
                                    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                                        if ($categoria->setImagen($_FILES['imagen'])) {
                                            if ($categoria->updateTProducto()) {
                                                $result['status'] = 1;
                                                if ($categoria->deleteFile($categoria->getRuta(), $data['imagen'])) {
                                                    $result['message'] = 'Categoría modificada correctamente';
                                                } else {
                                                    $result['message'] = 'Categoría modificada, pero no se borró la imagen anterior';
                                                }
                                            } else {
                                                $result['exception'] = Database::getException();
                                            } 
                                        } else {
                                            $result['exception'] = $categoria->getImageError();
                                        }
                                    } else {
                                        if ($categoria->updateTProducto()) {
                                            $result['status'] = 1;
                                            $result['message'] = 'Categoría modificada correctamente';
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
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
                    if ($categoria->setId($_POST['id_tipo_producto'])) {
                        if ($data = $categoria->readOneTProducto()) {
                            if ($categoria->deleteTProducto()) {
                                $result['status'] = 1;
                                if ($categoria->deleteFile($categoria->getRuta(), $data['imagen'])) {
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