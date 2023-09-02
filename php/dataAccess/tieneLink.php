<?php
include('connection.php');
include_once('./php/businessLogic/Usuario.php');

class TieneLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRolByUsernameRol($rol)
    {
        $stmt = $this->conn->prepare("SELECT nombre_permiso FROM Tiene WHERE nombre_Rol = ?");
        $stmt->bind_param("s", $rol);
        $stmt->execute();
        $result = $stmt->get_result();

        
        return $result;
    }
    
}
?>