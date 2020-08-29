<?php
/*
*	Clase para manejar las tablas pedido y detalle_pedido de la base de datos. Es clase hija de Validator.
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
    private $semana = null;
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

    public function setSemana($value)
    {
        if($this->validateNaturalNumber($value)) {
            $this->semana = $value;
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

    public function getSemana()
    {
        return $this->semana;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    /*
    *   Métodos para realizar las operaciones CRUD (create, read, update, delete).
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
        $sql = 'INSERT INTO detalle_pedido (cantidad_producto, id_pedido, id_producto, precio, fecha, semana)
                VALUES (?, ?, ?, ?, getdate(), getweek())';
        $params = array($this->cantidad, $this->id_pedido, $this->producto, $this->precio);
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

    // Método para obtener el id del detalle
    public function getIdDetalleOrden(){
        $sql = 'SELECT id_detalle_pedido, cantidad_producto FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?';
        $params = array($this->id_pedido, $this->producto);
        return Database::getRows($sql, $params);
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

    // Método para obtener los pedidos pasados del cliente
    public function pastOrders()
    {
        $sql = 'SELECT pedido.id_pedido, productos.imagen_producto, detalle_pedido.id_detalle_pedido, productos.nombre_producto, detalle_pedido.precio, 
                detalle_pedido.cantidad_producto, detalle_pedido.fecha, estado_pedido.estado_pedido
                FROM pedido 
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                WHERE id_estado_pedido != 1 AND id_cliente = ?
                GROUP BY id_pedido, imagen_producto, id_detalle_pedido, nombre_producto, estado_pedido
                ORDER BY fecha';
        $params = array($this->cliente);
        return Database::getRows($sql, $params); 
    }

    // Método utilizado en dashboard para leer todos los pedidos
    public function readAllPedidos()
    {
        $sql = 'SELECT pedido.id_pedido, detalle_pedido.id_detalle_pedido, productos.imagen_producto, cliente.usuario_c, productos.nombre_producto, 
                detalle_pedido.precio, detalle_pedido.cantidad_producto, detalle_pedido.fecha, estado_pedido.estado_pedido, detalle_pedido.semana,
                detalle_pedido.cantidad_producto * detalle_pedido.precio AS total
                FROM pedido 
                INNER JOIN cliente USING (id_cliente)
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                ORDER BY fecha, semana';
        $params = null;
        return Database::getRows($sql, $params);
    }

    // Método utilizado en dashboard para leer un solo pedido
    public function readOnePedido()
    {
        $sql = 'SELECT pedido.id_pedido, detalle_pedido.id_detalle_pedido, cliente.usuario_c, productos.nombre_producto, 
                detalle_pedido.precio, detalle_pedido.cantidad_producto, detalle_pedido.fecha, estado_pedido.id_estado_pedido
                FROM pedido 
                INNER JOIN cliente USING (id_cliente) 
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                WHERE id_detalle_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

    //Método utilizado en el dashboard para leer los posibles estados del pedido en un combobox
    public function getEstadosCb()
    {
        $sql  = 'SELECT id_estado_pedido, estado_pedido FROM estado_pedido WHERE id_estado_pedido != 1';
        $params = null;
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

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedido
                WHERE id_pedido = ? AND id_detalle_pedido = ?';
        $params = array($this->id_pedido, $this->id_detalle);
        return Database::executeRow($sql, $params);
    }

    /*
    *      Métodos para generar gráficas
    */

    // 5 clientes con más pedidos
    public function fiveClients()
    {
        $sql = 'SELECT COUNT (id_cliente) AS pedidoscliente, usuario_c 
                FROM pedido 
                INNER JOIN cliente USING (id_cliente) 
                GROUP BY usuario_c 
                ORDER BY pedidoscliente DESC
                LIMIT 5';
        $params = null;
        return Database::getRows($sql, $params);
    }

    // Ventas 7 días posteriores al actual con pedidos finalizados o entregados
    public function ventas7Dias()
    {
        $sql = 'SELECT COUNT (id_pedido) AS pedidos, detalle_pedido.fecha
                FROM detalle_pedido 
                INNER JOIN pedido USING (id_pedido)
                INNER JOIN estado_pedido USING (id_estado_pedido)
                WHERE id_estado_pedido != 1 AND id_estado_pedido != 3
                AND fecha 
                /* Datos entre la fecha actual menos 7 días */
                BETWEEN (SELECT CAST (CURRENT_DATE AS DATE) - CAST(\'6 DAYS\' AS INTERVAL) AS rango) AND CURRENT_DATE
                GROUP BY fecha ORDER BY fecha ASC';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /*
    *     Métodos para generar reportes
    */

    //Consulta para reporte: ventas por semana con total de ingresos por día por pedidos finalizados o enviados
    public function ventasSemana()
    {
        $sql = 'SELECT COUNT (id_pedido) AS pedidos, detalle_pedido.fecha, extract(week from detalle_pedido.fecha::date) AS semana, 
                SUM (detalle_pedido.precio) as ventatotaldia
                FROM detalle_pedido 
                INNER JOIN pedido USING (id_pedido)
                INNER JOIN estado_pedido USING (id_estado_pedido)
                WHERE id_estado_pedido != 1 AND id_estado_pedido != 3
                GROUP BY detalle_pedido.semana, detalle_pedido.fecha
                ORDER BY semana';
        $params = null;
        return Database::getRows($sql, $params);
    }

    // Consulta para reporte: pedidos agrupados por estado
    public function pedidosEstado()
    {
        $sql = 'SELECT cliente.usuario_c, productos.nombre_producto, 
                detalle_pedido.precio, detalle_pedido.cantidad_producto, detalle_pedido.fecha, estado_pedido.estado_pedido,
                detalle_pedido.cantidad_producto * detalle_pedido.precio AS total
                FROM pedido 
                INNER JOIN cliente USING (id_cliente)
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                WHERE id_estado_pedido != 1 AND id_estado_pedido = ?
                GROUP BY estado_pedido, usuario_c, nombre_producto, detalle_pedido.precio, cantidad_producto, fecha';
                $params = array($this->estado);
        return Database::getRows($sql, $params);
    }

    //Consulta para generar factura

    public function createFactura()
    {
        $sql = 'SELECT productos.nombre_producto, 
                detalle_pedido.precio, detalle_pedido.cantidad_producto,
                detalle_pedido.precio * detalle_pedido.cantidad_producto AS subtotal,
                (SELECT SUM (detalle_pedido.precio * detalle_pedido.cantidad_producto) AS totalpagar FROM detalle_pedido WHERE id_pedido = ?)
                FROM pedido 
                INNER JOIN cliente USING (id_cliente) 
                INNER JOIN detalle_pedido USING(id_pedido) 
                INNER JOIN productos USING(id_producto)
                INNER JOIN estado_pedido USING(id_estado_pedido)
                WHERE id_pedido = ?
                GROUP BY id_pedido, id_detalle_pedido, usuario_c, nombre_producto';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }
    
}
?>