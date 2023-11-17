<?php
include_once(BUSINESS_PATH . 'tiquet.php');

class TiquetLink
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTiquetByCodigo($codigo)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Tiquet WHERE codigo = ?"
        );
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $tiquetData = $result->fetch_assoc();
            return new Tiquet(
                $tiquetData['codigo'],
                $tiquetData['precio']
            );
        }

        return null;
    }

    public function getPrecioByCodigo($codigo)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM Tiquet WHERE codigo = ?"
        );
        $stmt->bind_param("i", $codigo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $tiquetData = $result->fetch_assoc();
            return $tiquetData['precio'];
        }

        return null;
    }

    public function insertTiquet(Tiquet $tiquet)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO Tiquet (codigo, precio) VALUES (?, ?)"
        );

        $codigo = $tiquet->getCodigo();
        $precio = $tiquet->getPrecio();

        $stmt->bind_param("ii", $codigo, $precio);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function selectTiquetsFromDate(int $date)
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*)
            FROM Tiquet
            WHERE CAST(codigo AS CHAR) LIKE ?;"
        );

        $dateParam = $date . '%';
        $stmt->bind_param("s", $dateParam);
        if ($stmt->execute()) {
            $count = $stmt->get_result()->fetch_row()[0];
            return $count;
        } else {
            return false;
        }


    }
    public function deleteTiquetByCodigo($codigo)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM Tiquet WHERE codigo = ?"
        );

        $stmt->bind_param("i", $codigo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}