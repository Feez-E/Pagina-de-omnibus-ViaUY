<?php
include_once(BUSINESS_PATH . 'unidad.php');

class UnidadLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUnidades()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Unidad"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $unidades = array();

        while ($row = $result->fetch_assoc()) {
            $unidad = new Unidad(
                $row['numero'],
                $row['matricula'],
                $row['numeroChasis'],
                $row['capacidadPrimerPiso'],
                $row['capacidadSegundoPiso'],
                $row['vigencia']
            );
            $unidades[] = $unidad;
        }

        return $unidades;
    }

    public function getUnidadesVigentes()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Unidad WHERE vigencia = true"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $unidades = array();

        while ($row = $result->fetch_assoc()) {
            $unidad = new Unidad(
                $row['numero'],
                $row['matricula'],
                $row['numeroChasis'],
                $row['capacidadPrimerPiso'],
                $row['capacidadSegundoPiso'],
                $row['vigencia']
            );
            $unidades[] = $unidad;
        }

        return $unidades;
    }


    public function getUnidadesByLineaYHora($nombreLinea, $horaSalida)
    {
        $stmt = $this->conn->prepare(
            "SELECT DISTINCT U.*
             FROM Unidad U
             INNER JOIN Transita T ON U.numero = T.numero_Unidad
             INNER JOIN Linea L ON T.codigo_L_Recorre = L.codigo
             WHERE L.nombre = ? AND T.horaSalida_Salida = ?"
        );

        $stmt->bind_param("ss", $nombreLinea, $horaSalida);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $unidad = $result->fetch_assoc();
            return new Unidad(
                $unidad['numero'],
                $unidad['matricula'],
                $unidad['numeroChasis'],
                $unidad['capacidadPrimerPiso'],
                $unidad['capacidadSegundoPiso'],
                $unidad['vigencia']
            );
        }

        return null;

    }

    public function validationToggleUnidad(int $numero)
    {
        // Obtener el valor actual de "vigencia"
        $stmt = $this->conn->prepare("SELECT vigencia FROM Unidad WHERE numero = ?");
        $stmt->bind_param("i", $numero);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $vigenciaActual = $row['vigencia'];

            // Invertir el valor de "vigencia"
            $nuevaVigencia = !$vigenciaActual;

            // Actualizar "vigencia" en la base de datos
            $stmt = $this->conn->prepare("UPDATE Unidad SET vigencia=? WHERE numero=?");
            $stmt->bind_param("ii", $nuevaVigencia, $numero);

            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }
}
?>