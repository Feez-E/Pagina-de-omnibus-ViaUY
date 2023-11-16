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
            "SELECT T.* 
            FROM Transita T 
            INNER JOIN Linea L ON L.codigo = T.codigo_L_Recorre 
            WHERE T.vigencia = true AND L.vigencia = true
            ORDER BY T.codigo_L_Recorre, T.horaSalida_Salida ASC, T.orden_Recorre ASC;"
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
                $row['horaLlegada_Llegada'],
                $row['vigencia']
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
                Transita.horaLlegada_Llegada,
                Transita.vigencia
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
                $row['horaLlegada_Llegada'],
                $row['vigencia']
            );

        }
        return $transitas;

    }

    public function validationToggleTransita(int $linea, int $unidad, string $hora)
    {
        // Obtener el valor actual de "vigencia"
        $stmt = $this->conn->prepare("SELECT distinct(vigencia) FROM Transita
            WHERE codigo_L_Recorre = ? AND  numero_Unidad = ? AND horaSalida_Salida = ?;");
        $stmt->bind_param("iis", $linea, $unidad, $hora);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $vigenciaActual = $row['vigencia'];

            // Invertir el valor de "vigencia"
            $nuevaVigencia = !$vigenciaActual;

            // Actualizar "vigencia" en la base de datos
            $stmt = $this->conn->prepare("UPDATE Transita SET vigencia=? 
                WHERE codigo_L_Recorre = ? AND  numero_Unidad = ? AND horaSalida_Salida = ?;");
            $stmt->bind_param("iiis", $nuevaVigencia, $linea, $unidad, $hora);

            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }

    public function insertTransita($codigo, $idInical, $idFinal, $orden, $numeroUnidad, $horaSalida, $horaLLegada)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO 
            Transita(codigo_L_Recorre, idInicial_T_Recorre, idFinal_T_Recorre, 
            orden_Recorre, numero_Unidad, horaSalida_Salida, horaLlegada_Llegada) 
            VALUES (?, ?, ?, ?,?, ?, ?);"
        );

        $stmt->bind_param(
            "iiiiiss",
            $codigo,
            $idInical,
            $idFinal,
            $orden,
            $numeroUnidad,
            $horaSalida,
            $horaLLegada
        );

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}

?>