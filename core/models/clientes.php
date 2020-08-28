<?php
/*
*	Clase para manejar la tabla cliente de la base de datos. Es clase hija de Validator.
*/
class Clientes extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombre = null;
    private $apellido = null;
    private $celular = null;  
    private $correo = null;
    private $nacimiento = null;
    private $dui = null;
    private $password_c = null;
    private $usuario_c = null;
    private $direccion = null;
    private $estado = null; // Valor por defecto al insertar: true

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

    public function setNombre($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellido($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellido = $value;
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

    public function setCorreo($value)
    {
        if ($this->validateEmail($value)) {
            $this->correo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNacimiento($value)
    {
        if ($this->validateDate($value)) {
            $this->nacimiento = $value;
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

    public function setPasswordC($value)
    {
        if ($this->validatePassword($value)) {
            $this->password_c = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuarioC($value)
    {
        if ($this->validateAlphanumeric($value, 1, 20)) {
            $this->usuario_c = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if ($this->validateString($value, 1, 200)) {
            $this->direccion = $value;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getPasswordC()
    {
        return $this->password_c;
    }

    public function getUsuarioC()
    {
        return $this->usuario_c;
    }

        public function getDireccion()
    {
        return $this->direccion;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    /*
    *   Métodos para gestionar la cuenta del cliente.
    */

    //Verifica el estado del cliente para saber si está de alta/baja
    public function checkCliente($usuario_c)
    {
        $sql = 'SELECT id_cliente, estado_usuario FROM cliente WHERE usuario_c = ?';
        $params = array($usuario_c);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->estado = $data['estado_usuario'];
            $this->usuario_c = $usuario_c;
            return true;
        } else {
            return false;
        }
    }

    //Verifica que la contraseña ingresada
    public function checkPassword($password)
    {
        $sql = 'SELECT password_c FROM cliente WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        //Aquí es el nombre del campo en la base
        if (password_verify($password, $data['password_c'])) {
            return true;
        } else {
            return false;
        }
    }

    //Método para cambiar contraseña
    public function changePassword()
    {
        $hash = password_hash($this->clave, PASSWORD_DEFAULT);
        $sql = 'UPDATE cliente SET password_c = ? WHERE id_cliente = ?';
        $params = array($hash, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Permite editar los datos del cliente
    public function editProfile()
    {
        $sql = 'UPDATE cliente 
                SET nombre = ?, apellido = ?, celular = ?, correo = ?, fecha_nacimiento = ?, dui = ?, usuario_c = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->apellido, $this->celular, $this->correo, $this->nacimiento, $this->dui, $this->usuario_c, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones CRUD (create, read, update, delete).
    */

    // Crear
    public function createCliente()
    {
        // Se encripta la clave por medio del algoritmo bcrypt que genera un string de 60 caracteres.
        $hash = password_hash($this->password_c, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO cliente (nombre, apellido, celular, correo, fecha_nacimiento, dui, password_c, usuario_c, estado_usuario, direccion, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, true, ?, getdate())';
        $params = array($this->nombre, $this->apellido, $this->celular, $this->correo, $this->nacimiento, $this->dui, $hash, $this->usuario_c, $this->direccion);
        return Database::executeRow($sql, $params);
    }

    // Lear todos los clientes
    public function readAllClientes()
    {
        $sql = 'SELECT id_cliente, nombre, apellido, celular, correo, fecha_nacimiento, dui, usuario_c, estado_usuario, direccion
                FROM cliente
                ORDER BY apellido';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //Leer un solo cliente
    public function readOneCliente()
    {
        $sql = 'SELECT id_cliente, nombre, apellido, celular, correo, fecha_nacimiento, dui, usuario_c, estado_usuario, direccion
                FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Cambiar el estado del cliente
    public function updateStatus()
    {
        $sql = 'UPDATE cliente
                SET estado_usuario = ?
                WHERE id_cliente = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }


    //Eliminar
    public function deleteCliente()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    
    /*
     *     Métodos para generar gráficas 
     */

    // Cantidad de clientes registrados en los últimos 7 días
    public function clientes7Dias()
    {
        $sql = 'SELECT COUNT (id_cliente) AS clientes, fecha_registro
                FROM cliente 
                WHERE fecha_registro 
                BETWEEN (SELECT CAST (CURRENT_DATE AS DATE) - CAST(\'6 DAYS\' AS INTERVAL) AS rango) AND CURRENT_DATE
                GROUP BY fecha_registro ORDER BY fecha_registro ASC';
        $params = null;
        return Database::getRows($sql, $params);
    }

}
?>