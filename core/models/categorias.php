<?php
/*
 *    Clase para manejar la tabla tipo_producto de la base de datos. Es clase hija de Validator.
 */
class Categorias extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $categoria = null;
    private $imagen = null;
    private $archivo = null;
    private $ruta = '../../../resources/img/categorias/';

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

    public function setCategoria($value)
    {
        if ($this->validateAlphanumeric($value, 1, 35)) {
            $this->categoria = $value;
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

    /*
     *   Métodos para obtener valores de los atributos.
     */

    public function getId()
    {
        return $this->id;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    /*
     *   Métodos para realizar las operaciones CRUD (create, read, update, delete).
     */

    // Crear
    public function createCategoria()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'INSERT INTO tipo_producto (tipo_producto, imagen)
                    VALUES (?, ?)';
            $params = array($this->categoria, $this->imagen);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }

    // Leer todas las categorías
    public function readAllCategorias()
    {
        $sql = 'SELECT id_tipo_producto, tipo_producto, imagen
                FROM tipo_producto
                ORDER BY tipo_producto';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //Leer una sola categoría
    public function readOneCategoria()
    {
        $sql = 'SELECT id_tipo_producto, tipo_producto, imagen
                FROM tipo_producto
                WHERE id_tipo_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Actualizar categoría
    public function updateCategoria()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'UPDATE tipo_producto
                    SET tipo_producto = ?, imagen = ?
                    WHERE id_tipo_producto = ?';
            $params = array($this->categoria, $this->imagen, $this->id);
        } else {
            $sql = 'UPDATE tipo_producto
                    SET tipo_producto = ?
                    WHERE id_tipo_producto = ?';
            $params = array($this->categoria, $this->id);
        }
        return Database::executeRow($sql, $params);
    }

    //Eliminar categoría
    public function deleteCategoria()
    {
        $sql = 'DELETE FROM tipo_producto
                WHERE id_tipo_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

}
?>
