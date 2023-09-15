<?php
include_once('connection.php');
include_once(BUSINESS_PATH . 'Usuario.php');

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
                    $user['contrasena'],
                    $user['telefono'],
                    new DateTime($user['fechaNac']),
                    $user['nombre_Rol']
                );
            } else {
                return null; // La autenticación falló
            }
        }
    }

    public function registerUser(Usuario $user, $passwordConfirm)
    {
        if ($user->getContrasena() === $passwordConfirm) {

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
                if($stmt->execute()){
                    return true;
                }
            }
        }
        return false;
    }

    public function modifyUser(Usuario $user)
    {
        $stmt = $this->conn->prepare(
            "UPDATE usuario SET
            nombre = ?,
            apellido = ?,
            correo = ?,
            telefono = ?,
            fechaNac = ?
            WHERE id = ?"
        );
        $stmt->bind_param(
            "sssssi",
            $user->getNombre(),
            $user->getApellido(),
            $user->getCorreo(),
            $user->getTelefono(),
            $user->getFechaNac()->format('Y-m-d'),
            $user->getId()
        );
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }


    public function changeUserPassword($userId, $oldPassword, $newPassword, $confirmPassword)
    {
        if ($newPassword === $confirmPassword) {
            $stmt = $this->conn->prepare(
                "SELECT contrasena FROM usuario 
                WHERE id = ?"
            );
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $hashedPassword = $user['contrasena'];
                if (password_verify($oldPassword, $hashedPassword)) {
                    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $stmt = $this->conn->prepare(
                        "UPDATE usuario SET
                        contrasena = ?
                        WHERE id = ?"
                    );
                    $stmt->bind_param("si", $newHashedPassword, $userId);
                    if ($stmt->execute()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}