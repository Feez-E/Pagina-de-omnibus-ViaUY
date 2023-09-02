<?php
include('connection.php');
include('../bussinessLogic/Usuario.php');

class UserLink {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserByUsernameAndPassword($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE apodo = ? AND contrasena = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
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

    // Puedes agregar otros métodos para operaciones de base de datos adicionales relacionadas con usuarios si es necesario
}
?>