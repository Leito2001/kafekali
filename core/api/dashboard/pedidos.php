<?php
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pedidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedido = new Pedidos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
	if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
           
            case 'readAll':
                    if ($result['dataset'] = $pedido->readAllPedidos()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No tiene productos en su pedido carepija';
                    }
                break;

            case 'getEstados':
                if ($result['dataset'] = $pedido->getEstadosCb()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay datos disponibles';
                }
            break;  

            case 'readOne':
                if ($pedido->setIdPedido($_POST['id_detalle_pedido'])) {
                    if ($result['dataset'] = $pedido->readOnePedido()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'Pedido inexistente';
                    }
                } else {
                    $result['exception'] = 'Pedido incorrecto';
                }
                break;

                case 'updateEstado':
                    if ($pedido->setIdPedido($_POST['id_detalle_pedido'])) {
                        $_POST = $pedido->validateForm($_POST);
                        if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                            if ($pedido->setEstado($_POST['estado_pedido']) === 1  ) {
                                if ($pedido->updateOrderStatus()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Estado modificado correctamente';
                                } else {
                                    $result['exception'] = 'Ocurrió un problema al modificar el estado';
                                }
                            } else {
                                $result['exception'] = 'Estado pendiente es inválido, no se puede modificar';
                            }
                        } else {
                            $result['exception'] = 'Detalle incorrecto';
                        }
                    } else {
                        $result['exception'] = 'Pedido incorrecto';
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