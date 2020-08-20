<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
	if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
           
            case 'readAll':
                if ($result['dataset'] = $producto->readAllProductos()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay productos registrados';
                }
            break;

            case 'getCategorias':
                if ($result['dataset'] = $producto->getCategoriasCb()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            break;  

            case 'getProveedor':
                if ($result['dataset'] = $producto->getProveedorCb()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            break;  

                case 'create':
                    $_POST = $producto->validateForm($_POST);
                    if ($producto->setProducto($_POST['nombre_producto'])) {

                        if ($producto->setDescripcion($_POST['descripcion'])) {

                            if ($producto->setPrecio($_POST['precio'])){

                                if (isset($_POST['tipo_producto'])) {

                                    if ($producto->setCategoria($_POST['tipo_producto'])){

                                        if (isset($_POST['nombre_prov'])){

                                            if ($producto->setProveedor($_POST['nombre_prov'])){

                                                if (is_uploaded_file($_FILES['imagen_producto']['tmp_name'])){

                                                    if ($producto->setImagen($_FILES['imagen_producto'])) {

                                                        if ($producto->setEstado(isset($_POST['estado_producto']) ? 1 : 0)) {

                                                            if ($producto->createProducto()) {
                                                                $result['status'] = 1;
                                                                $result['message'] = 'Producto creado correctamente';
                                                            } else {
                                                                $result['exception'] = Database::getException();;
                                                            }

                                                        } else {
                                                            $result['exception'] = 'Estado incorrecto';
                                                        }

                                                    } else {
                                                        $result['exception'] = $producto->getImageError();
                                                    }                                                

                                                } else {
                                                    $result ['exception'] = 'Por favor, seleccione una imagen';
                                                }

                                            } else {
                                                $result ['exception'] = 'Por favor, verifique el proveedor';
                                            }

                                        } else {
                                            $result['exception'] = 'Por favor, seleccione un proveedor';
                                        }

                                    } else {
                                        $result['exception'] = 'Por favor, verifique la categoría del producto';
                                    }

                                } else {
                                    $result['exception'] = 'Por favor, seleccione una categoría';
                                }

                            } else {
                                $result['exception'] = 'Por favor, verifique el precio del producto';
                            }

                        } else {
                            $result['exception'] = 'Por favor, verifique el nombre del producto'; 
                        }

                    } else {
                        $result['exception'] = 'Por favor, verifique el nombre del producto'; 
                    }

                break;

            case 'readOne':
                if ($producto->setId($_POST['id_producto'])) {
                    if ($result['dataset'] = $producto->readOneProducto()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Producto inexistente';
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;

            case 'update2':
                $_POST = $producto->validateForm($_POST);
                if ($producto->setId($_POST['id_producto'])) {
                    if ($data = $producto->readOneProducto()) {
                        if ($producto->setNombre($_POST['nombre_producto'])) {
                            if ($producto->setDescripcion($_POST['descripcion_producto'])) {
                                if ($producto->setPrecio($_POST['precio_producto'])) {
                                    if ($producto->setCategoria($_POST['categoria_producto'])) {
                                        if ($producto->setEstado(isset($_POST['estado_producto']) ? 1 : 0)) {
                                            if (is_uploaded_file($_FILES['archivo_producto']['tmp_name'])) {
                                                if ($producto->setImagen($_FILES['archivo_producto'])) {
                                                    if ($producto->updateProducto()) {
                                                        $result['status'] = 1;
                                                        if ($producto->deleteFile($producto->getRuta(), $data['imagen_producto'])) {
                                                            $result['message'] = 'Producto modificado correctamente';
                                                        } else {
                                                            $result['message'] = 'Producto modificada pero no se borro la imagen anterior';
                                                        }
                                                    } else {
                                                        $result['exception'] = Database::getException();
                                                    }
                                                } else {
                                                    $result['exception'] = $producto->getImageError();
                                                }
                                            } else {
                                                if ($producto->updateProducto()) {
                                                    $result['status'] = 1;
                                                    $result['message'] = 'Producto modificado correctamente';
                                                } else {
                                                    $result['exception'] = Database::getException();
                                                } 
                                            }
                                        } else {
                                            $result['exception'] = 'Estado incorrecto';
                                        }
                                    } else {
                                        $result['exception'] = 'Seleccione una categoría';
                                    }
                                } else {
                                    $result['exception'] = 'Precio incorrecto';
                                }
                            } else {
                                $result['exception'] = 'Descripción incorrecta';
                            }
                        } else {
                            $result['exception'] = 'Nombre incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Producto inexistente';
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
            break;

            case 'update':
                $_POST = $producto->validateForm($_POST);
                    if ($producto->setId($_POST['id_producto'])) {

                        if ($data = $producto->readOneProducto()) {

                            if ($producto->setProducto($_POST['nombre_producto'])) {

                                if ($producto->setDescripcion($_POST['descripcion'])) {

                                    if ($producto->setPrecio($_POST['precio'])) {

                                        if($producto->setCategoria($_POST['tipo_producto'])){

                                            if($producto->setProveedor($_POST['nombre_prov'])){

                                                if ($producto->setEstado(isset($_POST['estado_producto']) ? 1 : 0)) {

                                                    if (is_uploaded_file($_FILES['imagen_producto']['tmp_name'])) {
                                                        if ($producto->setImagen($_FILES['imagen_producto'])) {
                                                            if ($producto->updateProducto()) {
                                                                $result['status'] = 1;
                                                                if ($producto->deleteFile($producto->getRuta(), $data['imagen_producto'])) {
                                                                    $result['message'] = 'Producto modificado correctamente';
                                                                } else {
                                                                    $result['message'] = 'Producto modificada pero no se borro la imagen anterior';
                                                                }
                                                            } else {
                                                                $result['exception'] = Database::getException();
                                                            }
                                                        } else {
                                                            $result['exception'] = $producto->getImageError();
                                                        }
                                                    } else {
                                                        if ($producto->updateProducto()) {
                                                            $result['status'] = 1;
                                                            $result['message'] = 'Producto modificado correctamente';
                                                        } else {
                                                            $result['exception'] = Database::getException();
                                                        } 
                                                    }

                                                } else {
                                                    $result['exception'] = 'Estado invalido';
                                                }

                                            } else {
                                                $result['exception'] = 'Proveedor invalido';
                                            }

                                        } else {
                                            $result['exception'] = 'Categoria invalida';
                                        }

                                    } else {
                                        $result['exception'] = 'Precio incorrecto';
                                    }

                                } else {
                                    $result['exception'] = 'Descripción incorrecta';
                                }

                            } else {
                                $result['exception'] = 'Nombre incorrecto';
                            }
                            
                        } else {
                            $result['exception'] = 'Producto inexistente';
                        }

                    } else {
                        $result['exception'] = 'Producto incorrecto';
                    }
                    break;

            case 'delete':
                if ($producto->setId($_POST['id_producto'])) {
                    if ($data = $producto->readOneProducto()) {
                        if ($producto->deleteProducto()) {
                            $result['status'] = 1;
                            if ($producto->deleteFile($producto->getRuta(), $data['imagen_producto'])) {
                                $result['message'] = 'Producto eliminado correctamente';
                            } else {
                                $result['message'] = 'Producto eliminado pero no se borro la imagen';
                            }
                        } else {
                            $result['exception'] = Database::getException();
                        }
                    } else {
                        $result['exception'] = 'Producto inexistente';
                    }
                } else {
                    $result['exception'] = 'Producto incorrecto';
                }
                break;

            case 'cantidadProductosCategoria':
                if ($result['dataset'] = $producto->cantidadProductosCategoria()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
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