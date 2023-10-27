<?php
include_once(BUSINESS_PATH . 'caracteristica.php');

class CaracteristicaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getCaracteristicas()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Caracteristicas"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $caracteristicas = array();

        while ($row = $result->fetch_assoc()) {
            $caracteristica = new Caracteristica(
                $row['numeroUnidad'],
                $row['propiedad'],
                $row['multiplicador']
            );
            $caracteristicas[] = $caracteristica;
        }

        return $caracteristicas;
    }
    
    public function getCaracteristicasByNumeroUnidad($numeroUnidad)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Caracteristica WHERE numero_Unidad = ?"
        );
        $stmt->bind_param("i", $numeroUnidad);
        $stmt->execute();
        $result = $stmt->get_result();
        $caracteristicas = array();
    
        while ($row = $result->fetch_assoc()) {
            $caracteristica = new Caracteristica(
                $row['numero_Unidad'],
                $row['propiedad'],
                $row['multiplicador']
            );
            $caracteristicas[] = $caracteristica;
        }
    
        return $caracteristicas;
    }
}
?>