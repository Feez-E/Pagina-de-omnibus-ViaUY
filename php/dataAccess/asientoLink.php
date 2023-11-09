<?php
include_once(BUSINESS_PATH . 'asiento.php');

class AsientoLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAsientoByNumero($numero)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Asiento WHERE numero = ?"
        );
        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $asientoData = $result->fetch_assoc();
            return new Asiento(
                $asientoData['numero'],
                $asientoData['idInicial_T_R_Transita'],
                $asientoData['idFinal_T_R_Transita'],
                $asientoData['codigo_L_R_Transita'],
                $asientoData['orden_R_Transita'],
                $asientoData['numero_U_Transita'],
                new DateTime($asientoData['horaSalida_S_Transita']),
                new DateTime($asientoData['horaLlegada_L_Transita'])
            );
        }

        return null;
    }

    public function insertAsiento(Asiento $asiento)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO Asiento (
                numero,
                idInicial_T_R_Transita, 
                idFinal_T_R_Transita, 
                codigo_L_R_Transita, 
                orden_R_Transita, 
                numero_U_Transita,
                horaSalida_S_Transita, 
                horaLlegada_L_Transita) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $numero = $asiento->getNumero();
        $idInicial = $asiento->getIdInicial_T_R_Transita();
        $idFinal = $asiento->getIdFinal_T_R_Transita();
        $codigo = $asiento->getCodigo_L_R_Transita();
        $orden = $asiento->getOrden_R_Transita();
        $numeroU = $asiento->getNumero_U_Transita();
        $horaSalida = $asiento->getHoraSalida_S_Transita()->format('H:i:s');
        $horaLlegada = $asiento->getHoraLlegada_L_Transita()->format('H:i:s');

        $stmt->bind_param("iiiiiiss", $numero, $idInicial, $idFinal, $codigo, $orden, $numeroU, $horaSalida, $horaLlegada);


        try {
            if ($stmt->execute()) {
                return true;
            } else {
                if ($stmt->errno == 1062) {
                    // Tratar error 1062
                    return true;
                } else {
                    echo $horaLlegada;
                    throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
                }
            }
        } catch (Exception $e) {
            echo "Excepción capturada: " . $e->getMessage();
            return false;
        }
    }
}
?>