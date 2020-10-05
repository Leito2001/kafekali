
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
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        if ($cliente->validateSessionTime()) {
            $result['session'] = 1;
            // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
            switch ($_GET['action']) {

                case 'readAll':
                    if ($result['dataset'] = $cliente->readAllClientes()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay clientes registrados';
                    }
                    break;

                case 'readOne':
                    if ($cliente->setId($_POST['id_cliente'])) {
                        if ($result['dataset'] = $cliente->readOneCliente()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'Cliente inexistente';
                        }
                    } else {
                        $result['exception'] = 'Cliente incorrecto';
                    }
                    break;

                case 'update':
                    $_POST = $cliente->validateForm($_POST);

                    if ($cliente->setId($_POST['id_cliente'])) {

                        if ($cliente->readOneCliente()) {

                            //Lee el estado del cliente según valores booleanos true or false
                            if ($cliente->setEstado(isset($_POST['estado_usuario']) ? 1 : 0)) {

                                if ($cliente->updateStatus()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'Estado modificado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                            } else {
                                $result['exception'] = 'Estado incorrecto';
                            }
                        } else {
                            $result['exception'] = 'Usuario inexistente';
                        }
                    } else {
                        $result['exception'] = 'Usuario incorrecto';
                    }
                    break;

                    //Case para leer los datos de la gráfica a generar
                case '7DiasClientes':
                    if ($result['dataset'] = $cliente->clientes7Dias()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
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

