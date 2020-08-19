<?php
/*
*	Clase para manejar la tabla categorias de la base de datos. Es clase hija de Validator.
*/
class Pventa extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $puntoVenta = null;
    private $direccion = null;
    private $imagen = null;
    private $archivo = null;
    private $ruta = '../../../resources/img/pventa/';

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

    public function setPuntoVenta($value)
    {
        if($this->validateAlphanumeric($value, 1, 120)) {
            $this->puntoVenta = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if($this->validateString($value, 1, 400)) {
            $this->direccion = $value;
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

    public function getPuntoVenta()
    {
        return $this->puntoVenta;
    }

    public function getDireccion()
    {
        return $this->direccion;
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
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    public function createPVenta()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'INSERT INTO punto_de_venta (punto_venta, direccion, imagen) 
                    VALUES (?, ?, ?)';
            $params = array($this->puntoVenta, $this->direccion, $this->imagen);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }

    public function readAllPVenta()
    {
        $sql = 'SELECT id_punto_venta, punto_venta, direccion, imagen 
                FROM punto_de_venta
                ORDER BY punto_venta';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOnePVenta()
    {
        $sql = 'SELECT id_punto_venta, punto_venta, direccion, imagen 
                FROM punto_de_venta
                WHERE id_punto_venta = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updatePVenta()
    {
        if ($this->saveFile($this->archivo, $this->ruta, $this->imagen)) {
            $sql = 'UPDATE punto_de_venta 
                    SET punto_venta = ?, direccion = ?, imagen = ?
                    WHERE id_punto_venta = ?';
            $params = array($this->puntoVenta, $this->direccion, $this->imagen, $this->id);
        } else {
            $sql = 'UPDATE punto_de_venta 
                    SET punto_venta = ?, direccion = ?
                    WHERE id_punto_venta = ?';
            $params = array($this->puntoVenta, $this->direccion, $this->id);
        }
        return Database::executeRow($sql, $params);
    }

    public function deletePVenta()
    {
        $sql = 'DELETE FROM punto_de_venta 
                WHERE id_punto_venta = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>