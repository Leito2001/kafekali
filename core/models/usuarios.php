<?php
/*
*	Clase para manejar la tabla usuario de la base de datos. Es clase hija de Validator.
*/
class Usuarios extends Validator
{
    // Declaración de atributos (propiedades).
    private $id = null;
    private $nombres = null;
    private $apellidos = null;
    private $celular = null;
    private $correo = null;
    private $dui = null;
    private $nacimiento = null;
    private $usuario_u = null;
    private $password_u = null;

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

    public function setNombres($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->nombres = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if ($this->validateAlphabetic($value, 1, 50)) {
            $this->apellidos = $value;
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

    public function setDui($value)
    {
        if ($this->validateDUI($value)) {
            $this->dui = $value;
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

    public function setUsuario($value)
    {
        if ($this->validateAlphabetic($value, 1, 25)) {
            $this->usuario_u = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPassword($value)
    {
        if ($this->validatePassword($value)) {
            $this->password_u = $value;
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

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    public function getUsuario()
    {
        return $this->usuario_u;
    }

    public function getPassword()
    {
        return $this->password_u;
    }

    /*
    *   Métodos para gestionar la cuenta del usuario.
    */

    // Revisa que el usuario existe en la base de datos.
    public function checkUser($usuario_u)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE usuario_u = ?';
        $params = array($usuario_u);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->usuario_u = $usuario_u;
            return true;
        } else {
            return false;
        }
    }

    public function checkCorreo()
    {
        $sql = 'SELECT nombres, apellidos, id_usuario FROM usuario WHERE correo = ?';
        $params = array($this->correo);
        if ( $data = Database::getRow($sql, $params)) {
            $this->nombres = $data['nombres'];
            $this->apellidos = $data['apellidos'];
            $this->id = $data['id_usuario'];
            return true;
        } else {
            return false;
        }
    }

    //Compara la contraseña ingresada con la encriptada en la base de datos
    public function checkPassword($password)
    {
        $sql = 'SELECT password_u FROM usuario WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['password_u'])) {
            return true;
        } else {
            return false;
        }
    }

    //Método para cambiar la contraseña
    public function changePassword()
    {
        $hash = password_hash($this->password_u, PASSWORD_DEFAULT);
        $sql = 'UPDATE usuario SET password_u = ? WHERE id_usuario = ?';
        $params = array($hash, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Método para editar el perfil del usuario de la sesión actual
    public function editProfile()
    {
        $sql = 'UPDATE usuario
                SET nombres = ?, apellidos = ?, usuario_u = ?, celular = ?, correo = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->usuario_u, $this->celular, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones CRUD (create, read, update, delete).
    */

    //Crear
    public function createUsuario()
    {
        // Se encripta la clave por medio del algoritmo bcrypt.
        $hash = password_hash($this->password_u, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO usuario (nombres, apellidos, celular, correo, dui, fecha_nacimiento, usuario_u, password_u)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->celular, $this->correo, $this->dui, $this->nacimiento, $this->usuario_u, $hash);
        return Database::executeRow($sql, $params);
    }

    //Leer todos los usuarios
    public function readAllUsuarios()
    {
        $sql = 'SELECT usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.celular, usuario.correo, usuario.dui, usuario.fecha_nacimiento, 
                usuario.usuario_u 
                FROM usuario
                ORDER BY nombres';
        $params = null;
        return Database::getRows($sql, $params);
    }

    //leer un solo usuario
    public function readOneUsuario()
    {
        $sql = 'SELECT usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.celular, usuario.correo, usuario.dui, usuario.fecha_nacimiento, 
                usuario.usuario_u
                FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Actualizar
    public function updateUsuario()
    {
        $sql = 'UPDATE usuario
                SET nombres = ?, apellidos = ?, celular = ?, correo = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->celular, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Eliminar
    public function deleteUsuario()
    {
        $sql = 'DELETE FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>