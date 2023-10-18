<?php

class LineaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getLineas()
    {
        include_once(BUSINESS_PATH.'linea.php');

        $stmt = $this->conn->prepare(
            "SELECT * FROM Linea;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $lineas = array();

        while ($row = $result-> fetch_assoc()){

            $lineas[] = new Linea(
                $row['codigo'],
                $row['nombre'],
                $row['origen'],
                $row['destino'],
                $row['vigencia']
            );
            
        }

        return $lineas;
    }
    
    public function getNombreLineaByCodigo($codigo)
    {
        include_once(BUSINESS_PATH.'linea.php');

        $stmt = $this->conn->prepare(
            "SELECT nombre FROM Linea WHERE codigo = ?;"
        );
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $codigo = $result->fetch_assoc();
            return $codigo['nombre'];
        }
        return null;
    }
    
}
?>