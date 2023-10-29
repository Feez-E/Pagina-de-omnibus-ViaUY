<?php
include_once(BUSINESS_PATH . 'tramo.php'); // Include the Tramo class file

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

    public function calcularPrecioTramo($idInicial, $idFinal, $numeroUnidad)
    {
        $stmt = $this->conn->prepare("
            SELECT ROUND(
                (SELECT distancia FROM Tramo WHERE idInicial = ? AND idFinal = ?) *
                (SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = ? AND idFinal = ?) *
                (SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = 'precioKm') *
                (SELECT ROUND(SUM(multiplicador) - (COUNT(*) - 1), 2) FROM Caracteristica WHERE numero_Unidad = ?), 2
            ) AS precio;
        ");

        $stmt->bind_param("iiiii", $idInicial, $idFinal, $idInicial, $idFinal, $numeroUnidad);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['precio'];
        }

        return null; // Return null if no result is found
    }
}

?>