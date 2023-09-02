<?php
include_once('connection.php');
include_once('../businessLogic/Usuario.php');

class UserLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserByUsernameAndPassword($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE apodo = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['contrasena'];

            if (password_verify($password, $hashedPassword)) {
                return new Usuario(
                    $user['id'],
                    $user['apodo'],
                    $user['nombre'],
                    $user['apellido'],
                    $user['correo'],
                    $user['contrasena'], // No necesitas cambiar esto
                    $user['telefono'],
                    new DateTime($user['fechaNac']),
                    $user['nombre_Rol']
                );
            } else {
                return null; // La autenticación falló
            }
        }
    }

    public function registerUser(Usuario $user)
    {
        $apodo = $user->getApodo();
        $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE apodo = ?");
        $stmt->bind_param("s", $apodo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $nombre = $user->getNombre();
            $apellido = $user->getApellido();
            $correo = $user->getCorreo();
            $contrasena = password_hash($user->getContrasena(), PASSWORD_DEFAULT);
            $telefono = $user->getTelefono();
            $fechaNac = $user->getFechaNac()->format('Y-m-d H:i:s');
            $nombre_Rol = $user->getNombreRol();

            $stmt = $this->conn->prepare(
                "INSERT INTO Usuario (apodo, nombre, apellido, correo, contrasena, telefono, fechaNac, nombre_Rol) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param("ssssssss", $apodo, $nombre, $apellido, $correo, $contrasena, $telefono, $fechaNac, $nombre_Rol);
            $stmt->execute();
        }



    }
}
?>