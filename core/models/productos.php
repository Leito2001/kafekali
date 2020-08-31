<?php
/*
*	Clase para manejar la tabla productos de la base de datos. Es clase hija de Validator.
*/
class Productos extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $producto = null;
    private $descripcion = null;
    private $precio = null;
    private $categoria = null;
    private $proveedor = null;
    private $imagen = null;
    private $estado = null;
    private $archivo = null;
    private $ruta = '../../../resources/img/productos/';

    /*
    *   Métodos para asignar valores a los atributos.
    */

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if ($this->validateAlphanumeric($value, 1, 60)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if ($this->validateString($value, 1, 400)) {
            $this->descripcion = $value;
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

    public function setCategoria($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->categoria = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProveedor($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->proveedor = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setImagen($file)
    {
        if ($this->validateImageFile($file, 500, 500)) {
            $this->imagen = $this->getImageName();
            $this->archivo = $file;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if ($this->validateBoolean($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */

    public function getId()
    {
        return $this->id;
    }

    public function getProducto()
    {
        return $this->producto;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getProveedor()
    {
        return $this->proveedor;
    }


    public function getEstado()
    {
        return $this->estado;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    /*
    *   Métodos para realizar las operaciones CRUD (create, read, update, delete).
    */

    // Crear
    public function createProducto()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'INSERT INTO productos (nombre_producto, descripcion, precio, id_tipo_producto, id_proveedor, imagen_producto, estado_producto)
                    VALUES (?, ?, ?, ?, ?, ?, ?)';
            $params = array($this->producto, $this->descripcion, $this->precio, $this->categoria, $this->proveedor, $this->imagen, $this->estado);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }

    //Leer todos los productos
    public function readAllProductos()
    {
        $sql = 'SELECT productos.id_producto, productos.nombre_producto, productos.descripcion, productos.precio, 
        tipo_producto.tipo_producto, proveedor.nombre_prov, productos.imagen_producto, productos.estado_producto, productos.stock
                FROM productos INNER JOIN tipo_producto ON productos.id_tipo_producto = tipo_producto.id_tipo_producto
                INNER JOIN proveedor ON productos.id_proveedor = proveedor.id_proveedor
                ORDER BY nombre_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //Leer un solo producto
    public function readOneProducto()
    {
        $sql = 'SELECT productos.id_producto, productos.nombre_producto, productos.descripcion, productos.precio, 
                tipo_producto.id_tipo_producto, proveedor.id_proveedor, productos.imagen_producto, productos.estado_producto, productos.stock
                FROM productos 
                INNER JOIN tipo_producto USING (id_tipo_producto)
                INNER JOIN proveedor USING (id_proveedor)
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Actualizar
    public function updateProducto()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'UPDATE productos 
                    SET nombre_producto = ?, descripcion = ?, precio = ?, id_tipo_producto = ?, id_proveedor = ?, imagen_producto = ?, estado_producto = ?
                    WHERE id_producto = ?';
            $params = array($this->producto, $this->descripcion, $this->precio, $this->categoria, $this->proveedor, $this->imagen, $this->estado, $this->id);
        } else {
            $sql = 'UPDATE productos 
                    SET nombre_producto = ?, descripcion = ?, precio = ?, id_tipo_producto = ?, id_proveedor = ?, estado_producto = ?
                    WHERE id_producto = ?';
            $params = array($this->producto, $this->descripcion, $this->precio, $this->categoria, $this->proveedor, $this->estado, $this->id);
        }
        return Database::executeRow($sql, $params);
    }

    //Eliminar
    public function deleteProducto()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Funciones para rellenar combobox
    */ 

    public function getCategoriasCb()
    {
        $sql  = 'SELECT id_tipo_producto, tipo_producto FROM tipo_producto ORDER BY tipo_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function getProveedorCb()
    {
        $sql  = 'SELECT  id_proveedor, nombre_prov FROM proveedor ORDER BY nombre_prov';
        $params = null;
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar reportes.
    */

    //Reporte de productos por categoría
    public function readProductosCategoria()
    {
        $sql = 'SELECT tipo_producto.tipo_producto, productos.id_producto, productos.imagen_producto, productos.nombre_producto, 
                productos.descripcion, productos.precio
                FROM productos INNER JOIN tipo_producto USING(id_tipo_producto)
                WHERE id_tipo_producto = ? AND estado_producto = true
                ORDER BY tipo_producto';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar gráficas.
    */

    //Cantidad de productos por categoría
    public function cantidadProductosCategoria()
    {
        $sql = 'SELECT tipo_producto, COUNT(id_producto) cantidad
                FROM productos INNER JOIN tipo_producto USING(id_tipo_producto)
                GROUP BY id_tipo_producto, tipo_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    // 5 productos más vendidos
    public function fiveBestSellers()
    {
        $sql = 'SELECT pr.nombre_producto, COUNT(dp.id_producto) AS pedidos
                FROM productos pr 
                INNER JOIN detalle_pedido dp USING (id_producto) 
                INNER JOIN pedido pe USING (id_pedido)
                INNER JOIN estado_pedido ep USING (id_estado_pedido)
                WHERE id_estado_pedido != 1
                GROUP BY id_producto, nombre_producto
                LIMIT 5';
        $params = null;
        return Database::getRows($sql, $params);
    }
}
?>