<?php
include_once(BUSINESS_PATH . 'reserva.php');

class ReservaLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getReservas()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Reserva ORDER BY codigo_Tiquet DESC, numero_Asiento, orden_R_T_Asiento"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $reservas = array();

        while ($row = $result->fetch_assoc()) {
            $asiento = new Asiento(
                $row['numero_Asiento'],
                $row['idInicial_T_R_T_Asiento'],
                $row['idFinal_T_R_T_Asiento'],
                $row['codigo_L_R_T_Asiento'],
                $row['orden_R_T_Asiento'],
                $row['numero_U_T_Asiento'],
                new DateTime($row['horaSalida_S_T_Asiento']),
                new DateTime($row['horaLlegada_L_T_Asiento'])
            );

            $reserva = new Reserva(
                $asiento,
                $row['id_Usuario'],
                new DateTime($row['fechaLimite']),
                $row['metodo_MetodoPago'],
                $row['estado'],
                new DateTime($row['fecha']),
                new DateTime($row['hora']),
                $row['codigo_Tiquet']
            );

            $reservas[] = $reserva;
        }

        return $reservas;
    }

    public function getReservasByUserId($id_Usuario)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Reserva WHERE id_Usuario = ? ORDER BY codigo_Tiquet DESC, numero_Asiento, orden_R_T_Asiento"
        );
        $stmt->bind_param("i", $id_Usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservas = array();

        while ($row = $result->fetch_assoc()) {
            $asiento = new Asiento(
                $row['numero_Asiento'],
                $row['idInicial_T_R_T_Asiento'],
                $row['idFinal_T_R_T_Asiento'],
                $row['codigo_L_R_T_Asiento'],
                $row['orden_R_T_Asiento'],
                $row['numero_U_T_Asiento'],
                new DateTime($row['horaSalida_S_T_Asiento']),
                new DateTime($row['horaLlegada_L_T_Asiento'])
            );

            $reserva = new Reserva(
                $asiento,
                $row['id_Usuario'],
                new DateTime($row['fechaLimite']),
                $row['metodo_MetodoPago'],
                $row['estado'],
                new DateTime($row['fecha']),
                new DateTime($row['hora']),
                $row['codigo_Tiquet']
            );

            $reservas[] = $reserva;
        }

        return $reservas;
    }

    public function getReservasFromTravel($linea, $unidad, $idInicial, $idFinal, $fecha, $horaSalida, $horaLlegada)
    {
        $stmt = $this->conn->prepare(
            "SELECT numero_Asiento, 
            idInicial_T_R_T_Asiento,
            idFinal_T_R_T_Asiento, 
            estado,
            fecha,
            hora
            FROM Reserva 
            WHERE codigo_L_R_T_Asiento = ? 
            AND numero_U_T_Asiento = ? 
            AND horaSalida_S_T_Asiento = ? 
            AND horaLlegada_L_T_Asiento = ? 
            AND fecha = ?;"
        );
        $stmt->bind_param("iisss", $linea, $unidad, $horaSalida, $horaLlegada, $fecha);
        $stmt->execute();
        $result = $stmt->get_result();
        $asientos = array();


        while ($row = $result->fetch_assoc()) {


            $asiento = [
                "numeroAsiento" => $row['numero_Asiento'],
                "idInicial" => $row['idInicial_T_R_T_Asiento'],
                "idFinal" => $row['idFinal_T_R_T_Asiento'],
                "estado" => $row['estado'],

            ];

            $asientos[] = $asiento;
        }

        return $asientos;

    }

    public function changeStatusReservaByTiquet($estado, $tiquetReserva)
    {
        $stmt = $this->conn->prepare("UPDATE Reserva SET estado=? WHERE codigo_Tiquet=?");

        $stmt->bind_param("ss", $estado, $tiquetReserva);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertReserva(
        $numero_Asiento,
        $idInicial_T_R_T_Asiento,
        $idFinal_T_R_T_Asiento,
        $codigo_L_R_T_Asiento,
        $orden_R_T_Asiento,
        $numero_U_T_Asiento,
        $horaSalida_S_T_Asiento,
        $horaLlegada_L_T_Asiento,
        $id_Usuario,
        $fechaLimite,
        $metodo_MetodoPago,
        $estado,
        $fecha,
        $hora,
        $codigo_Tiquet
    ) {
        $stmt = $this->conn->prepare(
            "INSERT INTO Reserva (numero_Asiento, idInicial_T_R_T_Asiento, idFinal_T_R_T_Asiento, codigo_L_R_T_Asiento, orden_R_T_Asiento, numero_U_T_Asiento, horaSalida_S_T_Asiento, horaLlegada_L_T_Asiento, id_Usuario, fechaLimite, metodo_MetodoPago, estado, fecha, hora, codigo_Tiquet) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "iiiiisssissssss",
            $numero_Asiento,
            $idInicial_T_R_T_Asiento,
            $idFinal_T_R_T_Asiento,
            $codigo_L_R_T_Asiento,
            $orden_R_T_Asiento,
            $numero_U_T_Asiento,
            $horaSalida_S_T_Asiento,
            $horaLlegada_L_T_Asiento,
            $id_Usuario,
            $fechaLimite,
            $metodo_MetodoPago,
            $estado,
            $fecha,
            $hora,
            $codigo_Tiquet
        );

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return $stmt->errno;
            }
        } catch (Exception $e) {
            return $stmt->errno;
        }

    }

    public function deleteReservaByCodigoTiquet($codigo)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM Reserva WHERE codigo_Tiquet = ?"
        );

        $stmt->bind_param("i", $codigo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
?>