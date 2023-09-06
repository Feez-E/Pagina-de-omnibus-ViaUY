<?php
include_once('../businessLogic/tramo.php'); // Include the Tramo class file

class TramoLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTramoByIdInicialAndIdFinal($idInicial, $idFinal)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Tramo WHERE idInicial = ? AND idFinal = ?;"
        );
        $stmt->bind_param("ii", $idInicial, $idFinal);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Tramo(
                $row['idInicial'],
                $row['idFinal'],
                new DateTime($row['tiempo']),
                $row['distancia'],
                $row['estado_Estado']
            );
        }

        return null; // Return null if no tramo is found with the given IDs
    }

    public function getAllTramos()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Tramo;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $tramos = array();

        while ($row = $result->fetch_assoc()) {
            $tramos[] = new Tramo(
                $row['idInicial'],
                $row['idFinal'],
                new DateTime($row['tiempo']),
                $row['distancia'],
                $row['estado_estado']
            );
        }

        return $tramos;
    }
}

?>