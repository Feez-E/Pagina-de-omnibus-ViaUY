<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
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

    public function deleteParada(int $id)
    {

        $stmt = $this->conn->prepare(
            "DELETE FROM Parada WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function validationToggleParada(int $id)
    {
        // Obtener el valor actual de "vigencia"
        $stmt = $this->conn->prepare("SELECT vigencia FROM parada WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $vigenciaActual = $row['vigencia'];

            // Invertir el valor de "vigencia"
            $nuevaVigencia = !$vigenciaActual;

            // Actualizar "vigencia" en la base de datos
            $stmt = $this->conn->prepare("UPDATE parada SET vigencia=? WHERE id=?");
            $stmt->bind_param("ii", $nuevaVigencia, $id);

            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }
    public function getParadaIdByLatest()
    {
        $stmt = $this->conn->prepare("SELECT MAX(id) AS max_id FROM parada");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $maxId = $row['max_id'];
            return $maxId;
        }
        return null;
    }
}

?>