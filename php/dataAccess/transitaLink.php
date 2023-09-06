<?php
include_once('../businessLogic/transita.php');

class TransitaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTransitas()
    {

        $stmt = $this->conn->prepare(
            "SELECT * FROM Transita ORDER BY codigo_L_Recorre, orden_Recorre ASC;"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $transitas = array();

        while ($row = $result->fetch_assoc()) {

            $transitas[] = new Transita(
                $row['idInicial_T_Recorre'],
                $row['idFinal_T_Recorre'],
                $row['codigo_L_Recorre'],
                $row['orden_Recorre'],
                $row['numero_Unidad'],
                $row['horaSalida_Salida'],
                $row['horaLlegada_Llegada']
            );

        }

        return $transitas;
    }
}

?>