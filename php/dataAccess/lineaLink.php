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
        include_once('../businessLogic/linea.php');

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
    
}
?>