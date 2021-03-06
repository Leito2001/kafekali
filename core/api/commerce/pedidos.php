<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pedidos.php');
require_once('../../models/productos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedidos;
    $producto = new Productos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
        switch ($_GET['action']) {

            case 'createDetail':
                if ($pedido->setCliente($_SESSION['id_cliente'])) {
                    if ($pedido->readOrder()) {
                        $_POST = $pedido->validateForm($_POST);
                        if ($pedido->setProducto($_POST['id_producto'])) {
                            //Comparamos la cantidad de productos que hay en el stock y la cantidad de productos
                            //que el cliente desea comprar, para verificar si la cantidad a comprar está disponible en stock
                            $cantidadStock = $producto->getProductQuantity($_POST['id_producto'])['stock'];
                            if($cantidadStock >= $_POST['cantidad_producto']) {
                                // Si no existe un detalle pedido con ese producto en esta orden, vamos a crearlo, sino, vamos a actualizar
                                // la cantidad de dicho detalle pedido.
                                if (!boolval($dorden = $pedido->getIdDetalleOrden())) { //Si NO retorna nada, se agregará el producto al carrito.
                                    if ($pedido->setCantidad($_POST['cantidad_producto'])) {
                                        if ($pedido->setPrecio($_POST['precio_producto'])) {
                                            if ($pedido->createDetail()) {
                                                $result['status'] = 1;
                                                $result['message'] = 'Producto agregado correctamente';
                                            } else {
                                                $result['exception'] = 'Ocurrió un problema al agregar el producto';
                                            }
                                        } else {
                                            $result['exception'] = 'Precio incorrecto';
                                        }
                                    } else {
                                        $result['exception'] = 'Cantidad incorrecta';
                                    }
                                } else {
                                    //Si existe el detalle pedido, traemos su id, y la cantidad
                                    //Procedemos a asignar los valores en el modelo
                                    $pedido->setIdDetalle($dorden['0']['id_detalle_pedido']);
                                    //Y a sumar la cantidad almacenada y la nueva cantidad.
                                    $pedido->setCantidad($_POST['cantidad_producto'] + $dorden['0']['cantidad_producto']);
                                    //Luego, simplemente se actualiza la cantidad.
                                    if ($pedido->updateDetail()) {
                                        $result['status'] = 1;
                                        $result['message'] = 'Cantidad modificada correctamente';
                                    } else {
                                        $result['exception'] = 'Ocurrió un problema al modificar la cantidad';
                                    }
                                }
                            } else {
                                $result['status'] = 2;
                                $result['exception'] = 'No hay suficientes productos en stock.';
                            }
                        } else {
                            $result['exception'] = 'Producto incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Ocurrió un problema al obtener el pedido';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;

            case 'readCart':
                if ($pedido->setCliente($_SESSION['id_cliente'])) {
                    if ($pedido->readOrder()) {
                        if ($result['dataset'] = $pedido->readCart()) {
                            $result['status'] = 1;
                            $_SESSION['id_pedido'] = $pedido->getIdPedido();
                        } else {
                            $result['exception'] = 'No tiene productos en su pedido';
                        }
                    } else {
                        $result['exception'] = 'Debe agregar un producto al pedido';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;


            //Case para leer los pedidos anteriores del cliente que tiene iniciada la sesión
            case 'pastOrders':
                if ($pedido->setCliente($_SESSION['id_cliente'])) {
                    if ($result['dataset'] = $pedido->pastOrders()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay pedidos registrados';
                    }
                } else {
                    $result['exception'] = 'Cliente incorrecto';
                }
                break;

            case 'updateDetail':
                if ($pedido->setIdPedido($_SESSION['id_pedido'])) {
                    $_POST = $pedido->validateForm($_POST);
                    if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                        if ($pedido->setCantidad($_POST['cantidad_producto'])) {
                            if ($pedido->updateDetail()) {
                                $result['status'] = 1;
                                $result['message'] = 'Cantidad modificada correctamente';
                            } else {
                                $result['exception'] = 'Ocurrió un problema al modificar la cantidad';
                            }
                        } else {
                            $result['exception'] = 'Cantidad incorrecta';
                        }
                    } else {
                        $result['exception'] = 'Detalle incorrecto';
                    }
                } else {
                    $result['exception'] = 'Pedido incorrecto';
                }
                break;

            case 'createReview':
                $_POST = $pedido->validateForm($_POST);
                if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                    if ($pedido->setComentario($_POST['comentario'])) {
                        if ($pedido->setCalificacion($_POST['calificacion'])){
                            if ($pedido->createReview()) {
                                $result['status'] = 1;
                                $result['message'] = 'Reseña agregada correctamente';
                            } else {
                                $result['exception'] = 'Ocurrió un problema al agregar la reseña';
                            }
                        } else {
                            $result['exception'] = 'Calificación inválida, solamente números enteros del 1 al 10, por favor.';
                        }
                    } else {
                        $result['exception'] = 'Verifique su comentario';
                    }
                } else {
                    $result['exception'] = 'Detalle incorrecto';
                }
                break;

            case 'deleteDetail':
                if ($pedido->setIdPedido($_SESSION['id_pedido'])) {
                    if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                        if ($pedido->deleteDetail()) {
                            $result['status'] = 1;
                            $result['message'] = 'Producto removido correctamente';
                        } else {
                            $result['exception'] = 'Ocurrió un problema al remover el producto';
                        }
                    } else {
                        $result['exception'] = 'Detalle incorrecto';
                    }
                } else {
                    $result['exception'] = 'Pedido incorrecto';
                }
                break;

            case 'finishOrder':
                if ($pedido->setIdPedido($_SESSION['id_pedido'])) {
                    if ($pedido->setEstado(2)) {
                        if ($pedido->updateOrderStatus()) {
                            $result['status'] = 1;
                            $result['message'] = 'Pedido finalizado correctamente';
                        } else {
                            $result['exception'] = 'Ocurrió un problema al finalizar el pedido';
                        }
                    } else {
                        $result['exception'] = 'Estado incorrecto';
                    }
                } else {
                    $result['exception'] = 'Pedido incorrecto';
                }
                break;
            default:
                exit('Acción no disponible dentro de la sesión');
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'Debe iniciar sesión para agregar el producto al carrito';
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
