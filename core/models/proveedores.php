<?php
/*
*	Clase para manejar la tabla clientes de la base de datos. Es clase hija de Validator.
*/
class Proveedores extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombreEmpresa = null;
    private $nombreProveedor = null;
    private $celular = null;
    private $dui = null;
    private $numeroEmpresa = null;
    private $rubro = null;

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

    public function setNombreEmpresa($value)
    {
        if ($this->validateAlphanumeric($value, 1, 60)) {
            $this->nombreEmpresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombreProveedor($value)
    {
        if ($this->validateAlphabetic($value, 1, 60)) {
            $this->nombreProveedor = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCelular($value)
    {
        if ($this->validatePhone($value)) {
            $this->celular = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if ($this->validateDUI($value)) {
            $this->dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNumeroEmpresa($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->numeroEmpresa = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setRubro($value)
    {
        if ($this->validateAlphabetic($value, 1, 30)) {
            $this->rubro = $value;
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

    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    public function getNombreProveedor()
    {
        return $this->nombreProveedor;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getNumeroEmpresa()
    {
        return $this->numeroEmpresa;
    }

    public function getRubro()
    {
        return $this->rubro;
    }

    /*
    *   Métodos para gestionar los datos del proveedor.
    */

    public function createProveedor()
    {
        $sql = 'INSERT INTO proveedor (nombre_empresa, nombre_prov, celular, dui, numero_empresa, rubro) 
                VALUES (?, ?, ?, ?, ?, ?)';
        $params = array($this->nombreEmpresa, $this->nombreProveedor, $this->celular, $this->dui, $this->numeroEmpresa, $this->rubro);
        return Database::executeRow($sql, $params);
    }

    public function readAllProveedores()
    {
        $sql = 'SELECT id_proveedor, nombre_empresa, nombre_prov, celular, dui, numero_empresa, rubro
                FROM proveedor
                ORDER BY nombre_empresa';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function readOneProveedor()
    {
        $sql = 'SELECT id_proveedor, nombre_empresa, nombre_prov, celular, dui, numero_empresa, rubro
                FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateProveedor()
    {
        $sql = 'UPDATE proveedor 
                SET nombre_empresa = ?, nombre_prov = ?, celular = ?
                WHERE id_proveedor = ?';
        $params = array($this->nombreEmpresa, $this->nombreProveedor, $this->celular, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteProveedor()
    {
        $sql = 'DELETE FROM proveedor
                WHERE id_proveedor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>