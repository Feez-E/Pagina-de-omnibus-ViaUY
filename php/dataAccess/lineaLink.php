<?php
include_once(BUSINESS_PATH . 'linea.php');

class LineaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getLineas()
    {

        $stmt = $this->conn->prepare(
            "SELECT * FROM Linea;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $lineas = array();

        while ($row = $result->fetch_assoc()) {

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

    public function getCodigoLineaByNombre($nombre)
    {

        $stmt = $this->conn->prepare(
            "SELECT codigo FROM Linea WHERE nombre = ?;"
        );
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $codigo = $result->fetch_assoc();
            return $codigo['codigo'];
        }
        return null;
    }

    public function validationToggleLinea(string $nombre)
    {
        // Obtener el valor actual de "vigencia"
        $stmt = $this->conn->prepare("SELECT vigencia FROM Linea WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $vigenciaActual = $row['vigencia'];

            // Invertir el valor de "vigencia"
            $nuevaVigencia = !$vigenciaActual;

            // Actualizar "vigencia" en la base de datos
            $stmt = $this->conn->prepare("UPDATE Linea SET vigencia=? WHERE nombre=?");
            $stmt->bind_param("is", $nuevaVigencia, $nombre);

            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }

    public function insertLinea($nombre, $origen, $destino)
    {

        $stmt = $this->conn->prepare(
            "INSERT INTO Linea (nombre, origen, destino, vigencia) VALUES 
            (?, ?, ?, false)"
        );

        $stmt->bind_param("sss", $nombre, $origen, $destino);
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }
}
?>