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
        if ($categoria->validateSessionTime()) {
            $result['session'] = 1;
            // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
            switch ($_GET['action']) {

                case 'readAll':
                    if ($result['dataset'] = $categoria->readAllCategorias()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay categorías registradas';
                    }
                    break;

                case 'create':
                    $_POST = $categoria->validateForm($_POST);
                    if ($categoria->setCategoria($_POST['tipo_producto'])) {
                        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                            if ($categoria->setImagen($_FILES['imagen'])) {
                                if ($categoria->createCategoria()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Categoría creada correctamente';
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
                        $result['exception'] = 'Nombre incorrecto';
                    }
                    break;

                case 'readOne':
                    if ($categoria->setId($_POST['id_tipo_producto'])) {
                        if ($result['dataset'] = $categoria->readOneCategoria()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Categoría inexistente';
                        }
                    } else {
                        $result['exception'] = 'Categoría incorrecta';
                    }
                    break;

                case 'update':
                    $_POST = $categoria->validateForm($_POST);
                    if ($categoria->setId($_POST['id_tipo_producto'])) {
                        if ($data = $categoria->readOneCategoria()) {
                            if ($categoria->setCategoria($_POST['tipo_producto'])) {
                                if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                                    if ($categoria->setImagen($_FILES['imagen'])) {
                                        if ($categoria->updateCategoria()) {
                                            $result['status'] = 1;
                                            //if para guardar en el caso se haya modificado la imagen
                                            if ($categoria->deleteFile($categoria->getRuta(), $data['imagen'])) {
                                                $result['message'] = 'Categoría modificada correctamente';
                                            } else {
                                                $result['message'] = 'Categoría modificada pero no se borro la imagen anterior';
                                            }
                                        } else {
                                            $result['exception'] = Database::getException();
                                        }
                                    } else {
                                        $result['exception'] = $categoria->getImageError();
                                    }
                                    //updateCategoria en en el caso no se haya modificado la imagen
                                } else {
                                    if ($categoria->updateCategoria()) {
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
                            $result['exception'] = 'Categoría inexistente';
                        }
                    } else {
                        $result['exception'] = 'Categoría incorrecta';
                    }
                    break;

                case 'delete':
                    if ($categoria->setId($_POST['id_tipo_producto'])) {
                        if ($data = $categoria->readOneCategoria()) {
                            if ($categoria->deleteCategoria()) {
                                $result['status'] = 1;
                                //if para verificar si se eliminó o no la imagen de la categoría
                                if ($categoria->deleteFile($categoria->getRuta(), $data['imagen'])) {
                                    $result['message'] = 'Categoría eliminada correctamente';
                                } else {
                                    $result['message'] = 'Categoría eliminada pero no se borro la imagen';
                                }
                            } else {
                                $result['exception'] = Database::getException();
                            }
                        } else {
                            $result['exception'] = 'Categoría inexistente';
                        }
                    } else {
                        $result['exception'] = 'Categoría incorrecta';
                    }
                    break;
                default:
                    exit('Acción no disponible dentro de la sesión');
            }
        } else {
            $result['exception'] = 'Su sesión ha caducado';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
        //Devuelve un error si no hay un case al cual llamar
    } else {
        exit('Acceso no disponible');
    }
    //Devuelve un error si no hay un usuario con la sesión iniciada
} else {
    exit('Recurso denegado');
}
?>
