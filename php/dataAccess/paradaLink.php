<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'parada.php');
class ParadaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getParadaById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Parada WHERE id = ?;"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Parada(
                $row['id'],
                $row['direccion'],
                $row['coordenadas'],
                $row['vigencia']
            );
        }

        return null; // Devolver null si no se encuentra ninguna parada con ese ID
    }


    public function getAllParadas()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Parada;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $paradas = array();

        while ($row = $result->fetch_assoc()) {
            $paradas[] = new Parada(
                $row['id'],
                $row['direccion'],
                $row['coordenadas'],
                $row['vigencia']
            );
        }

        return $paradas;
    }

    public function insertParada($direccion, $coordenadas)
    {
        $vigencia = 1;

        $stmt = $this->conn->prepare(
            "INSERT INTO Parada (direccion, coordenadas, vigencia) 
                VALUES ( ?, ?, ?)"
        );

        $stmt->bind_param("ssi", $direccion, $coordenadas, $vigencia);
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }
}

?>