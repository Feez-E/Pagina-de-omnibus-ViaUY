<?php
include_once(BUSINESS_PATH.'linea_diaHabil.php');

class Linea_diaHabilLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getLinea_diaHabilByCodigo_Linea($codigo_Linea)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Linea_diaHabil WHERE codigo_Linea = ?;"
        );
        $stmt->bind_param("i", $codigo_Linea);
        $stmt->execute();
        $result = $stmt->get_result();
        $lineaDiaHabilArray = array();

        while ($row = $result->fetch_assoc()) {
            $lineaDiaHabilArray[] = new Linea_diaHabil(
                $row['codigo_Linea'],
                $row['dia']
            );
        }

        return $lineaDiaHabilArray;
    }

    public function getAllLineaDiaHabil()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Linea_diaHabil;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $lineaDiaHabilArray = array();

        while ($row = $result->fetch_assoc()) {
            $lineaDiaHabilArray[] = new Linea_diaHabil(
                $row['codigo_Linea'],
                $row['dia']
            );
        }

        return $lineaDiaHabilArray;
    }

    public function updateLineaDiaHabil($codigo_Linea , $dia)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Linea_diaHabil WHERE codigo_Linea = ? AND dia = ?;"
        );
        $stmt->bind_param("is", $codigo_Linea, $dia);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt = $this->conn->prepare(
                "DELETE FROM Linea_diaHabil WHERE codigo_Linea = ? AND dia = ?;"
                );
                $stmt->bind_param("is", $codigo_Linea, $dia);
                if($stmt->execute()) {
                    return "deletedLineaDiaHabil";
                } else {
                    return false;
                }
        } else {
            $stmt = $this->conn->prepare(
                "INSERT INTO Linea_diaHabil  (codigo_Linea, dia) VALUES (?, ?);"
                );
                $stmt->bind_param("is", $codigo_Linea, $dia);
                if($stmt->execute()) {
                    return "addedLineaDiaHabil";
                } else {
                    return false;
                }
        }
    }
}
?>