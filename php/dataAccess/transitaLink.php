<?php
include_once(BUSINESS_PATH . 'transita.php');

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
            "SELECT * FROM Transita
            ORDER BY  codigo_L_Recorre, horaSalida_Salida ASC, orden_Recorre ASC;"
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

    public function getTransitasAndRecorre()
    {

        $stmt = $this->conn->prepare(
            "SELECT
                Recorre.idInicial_Tramo AS idInicial_T_Recorre,
                Recorre.idFinal_Tramo AS idFinal_T_Recorre,
                Recorre.codigo_Linea AS codigo_L_Recorre,
                Recorre.orden AS orden_Recorre,
                Transita.numero_Unidad,
                Transita.horaSalida_Salida,
                Transita.horaLlegada_Llegada
            FROM Recorre
            LEFT JOIN Transita ON Recorre.idInicial_Tramo = Transita.idInicial_T_Recorre
                           AND Recorre.idFinal_Tramo = Transita.idFinal_T_Recorre
                           AND Recorre.codigo_Linea = Transita.codigo_L_Recorre
                           AND Recorre.orden = Transita.orden_Recorre
            ORDER BY Recorre.codigo_Linea, Transita.numero_Unidad, Transita.horaSalida_Salida, Recorre.orden;"
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