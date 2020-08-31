<?php
//Se llaman todos los modelos para obtener los datos necesarios
require_once('../../helpers/database.php');
require_once('../../helpers/validator.php');
require_once('../../models/pedidos.php');
require_once('../../models/clientes.php');
require_once('../../models/productos.php');

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
                if ($result['dataset'] = $pedido->readAllReviews()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = 'No hay reseñas registradas';
                }
                break;

            case 'readOne':
                if ($pedido->setIdComentario($_POST['id_comentario'])) {
                    $_POST = $pedido->validateForm($_POST);
                    if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                        if ($result['dataset'] = $pedido->readProductoReviews()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Reseña inexistente';
                        }
                    } else {
                        $result['exception'] = 'Detalle incorrecto';
                    }
                } else {
                    $result['exception'] = 'Comentario incorrecto';
                }
                break;

            case 'updateEstado':
                if ($pedido->setIdComentario($_POST['id_comentario'])) {
                    $_POST = $pedido->validateForm($_POST);
                    if ($pedido->setIdDetalle($_POST['id_detalle_pedido'])) {
                        if ($pedido->setEstadoComentario(isset($_POST['estado_comentario']) ? 1 : 0)) {
                            if ($pedido->updateReview()) {
                                $result['status'] = 1;
                                $result['message'] = 'Estado modificado correctamente';
                            } else {
                                $result['exception'] = 'Ocurrió un problema al modificar el estado';
                            }
                        } else {
                            $result['exception'] = 'Estado inválido';
                        }
                    } else {
                        $result['exception'] = 'Detalle incorrecto';
                    }
                } else {
                    $result['exception'] = 'Comentario incorrecto';
                }
                break;

            default:
                exit('Acción no disponible dentro de la sesión');
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
