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
        $stmt = $this->conn->prepare(
            "SELECT ROUND(
                (SELECT distancia FROM Tramo WHERE idInicial = ? AND idFinal = ?) *
                (SELECT multiplicador FROM Tramo INNER JOIN Estado ON Tramo.estado_Estado = Estado.estado WHERE idInicial = ? AND idFinal = ?) *
                (SELECT valorDouble FROM ParametroDouble WHERE nombre_Parametro = 'precioKm') *
                (SELECT ROUND(SUM(multiplicador) - (COUNT(*) - 1), 2) FROM Caracteristica WHERE numero_Unidad = ?), 2
            ) AS precio;"
        );

        $stmt->bind_param("iiiii", $idInicial, $idFinal, $idInicial, $idFinal, $numeroUnidad);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['precio'];
        }

        return null; // Return null if no result is found
    }


    public function getIfTramoExistsByCoords($coordInicial, $coordFinal)
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM Tramo AS T
        INNER JOIN Parada AS P1 ON T.idInicial = P1.id
        INNER JOIN Parada AS P2 ON T.idFinal = P2.id
        WHERE P1.coordenadas = ? AND P2.coordenadas = ?;"
        );

        $stmt->bind_param("ss", $coordInicial, $coordFinal);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->fetch_assoc()['COUNT(*)'] > 0) {
            return true;
        }

        return false;
    }

    public function insertTramo($idInicial, $idFinal, $distancia, $tiempo)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO Tramo (idInicial, idFinal, tiempo, distancia, estado_Estado) VALUES 
            (?, ?, ?, ?, 'N');"
        );

        $stmt->bind_param("iisd", $idInicial, $idFinal, $tiempo, $distancia);

        if ($stmt->execute() || $stmt->errno == 1062) {
            return true;
        }

        throw new Exception("Error executing the query: " . $stmt->error);
    }


    public function getTiempoTotalByIds($tramos)
    {
        // Construir la parte de la consulta WHERE dinámicamente
        $conditions = [];
        $params = [];

        if (is_array($tramos)) {
            foreach ($tramos as $tramo) {
                if (isset($tramo['idInicial'], $tramo['idFinal'])) {
                    $conditions[] = "(idInicial = ? AND idFinal = ?)";
                    $params[] = intval($tramo['idInicial']);
                    $params[] = intval($tramo['idFinal']);
                }
            }
        }
        // Unir las condiciones con OR
        $whereClause = implode(' OR ', $conditions);

        // Construir la consulta completa
        $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))) AS tiempo_total FROM Tramo WHERE $whereClause";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $types = str_repeat('ii', (count($tramos) - 1));
        $stmt->bind_param($types, ...$params);

        // Ejecutar la consulta
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['tiempo_total'];
        }

        return null; // Devolver null si no se encuentra ningún resultado
    }
}

?>