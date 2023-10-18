<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/dirs.php');
include_once(BUSINESS_PATH . 'recorre.php');
class RecorreLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRecorreById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Recorre WHERE id = ?;"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Recorre(
                $row['idInicialTramo'],
                $row['idFinalTramo'],
                $row['codigoLinea'],
                $row['orden']
            );
        }

        return null; // Devolver null si no se encuentra ningún Recorre con ese ID
    }

    public function getAllRecorridos()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Recorre ORDER BY codigo_linea, orden;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $recorridos = array();

        while ($row = $result->fetch_assoc()) {
            $recorridos[] = new Recorre(
                $row['idInicial_Tramo'],
                $row['idFinal_Tramo'],
                $row['codigo_Linea'],
                $row['orden']
            );
        }

        return $recorridos;
    }
}