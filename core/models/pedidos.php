<?php
/*
*	Clase para manejar las tablas pedidos y detalle_pedido de la base de datos. Es clase hija de Validator.
*/
class Pedidos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id_pedido = null;
    private $id_detalle = null;
    private $cliente = null;
    private $producto = null;
    private $cantidad = null;
    private $precio = null;
    private $estado = null; // Valor por defecto en la base de datos: 1
    /*
    *   POSIBLES ESTADOS PARA UN PEDIDO
    *   1: Pendiente. Es cuando el pedido esta en proceso por parte del cliente y se puede modificar el detalle.
    *   2: Finalizado. Es cuando el cliente finaliza el pedido y ya no es posible modificar el detalle.
    *   3: Cancelado. Es cuando el cliente se arrepiente de haber realizado el pedido.
    *   4: Enviado. Es cuando la tienda ha entregado el pedido al cliente.
    */

    /*
    *   Métodos para asignar valores a los atributos.
    */
    public function setIdPedido($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id_detalle = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaPedido($value)
    {
        if ($this->validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if($this->validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if ($this->validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPventa($value)
    {
        if($this->validateNaturalNumber($value)) {
            $this->pventa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    // Método para verificar si existe un pedido pendiente del cliente para seguir comprando, de lo contrario crea uno.
    public function readOrder()
    {
        $sql = 'SELECT id_pedido
                FROM pedido
                WHERE id_estado_pedido = 1 AND id_cliente = ?';
        $params = array($this->cliente);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedido (id_cliente, id_estado_pedido)
                    VALUES(?, 1)';
            $params = array($this->cliente);
            if (Database::executeRow($sql, $params)) {
                // Se obtiene el último valor insertado en la llave primaria de la tabla pedidos.
                $this->id_pedido = Database::getLastRowId();
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        $sql = 'INSERT INTO detalle_pedido (cantidad_producto, id_pedido, id_producto, precio, fecha)
                VALUES (?, ?, ?, ?, getdate())';
        $params = array($this->cantidad, $this->id_pedido, $this->producto, $this->precio);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readCart()
    {
        $sql = 'SELECT productos.imagen_producto, detalle_pedido.id_detalle_pedido, productos.nombre_producto, detalle_pedido.precio, 
                detalle_pedido.cantidad_producto, detalle_pedido.fecha, estado_pedido.estado_pedido
                FROM pedido 
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    // Método para cambiar el estado de un pedido.
    public function updateOrderStatus()
    {
        $sql = 'UPDATE pedido
                SET id_estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalle_pedido
                SET cantidad_producto = ?
                WHERE id_pedido = ? AND id_detalle_pedido = ?';
        $params = array($this->cantidad, $this->id_pedido, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedido
                WHERE id_pedido = ? AND id_detalle_pedido = ?';
        $params = array($this->id_pedido, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

}
?>