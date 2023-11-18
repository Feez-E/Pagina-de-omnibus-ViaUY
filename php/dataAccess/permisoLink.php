<?php
class PermisoLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRolByUsernameRol($rol)
    {
        $stmt = $this->conn->prepare(
            "SELECT p.nombre, p.numero, p.url, t.nombre_rol
            FROM Permiso p
            JOIN Tiene t ON p.nombre = t.nombre_permiso WHERE nombre_rol = ? ;"
        );
        $stmt->bind_param("s", $rol);
        $stmt->execute();
        $result = $stmt->get_result();
        $permisos = array();

        while ($row = $result->fetch_assoc()) {
            $nombre = $row['nombre'];
            $url = $row['url'];
            $numero = $row['numero'];
            $permisos[$nombre] = array(
                "url" => $url,
                "numero" => $numero
            );
        }

        return $permisos;
    }

}
?>