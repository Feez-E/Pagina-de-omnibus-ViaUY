<?php
class Linea_diaHabil implements JsonSerializable
{
    private int $codigo_Linea;
    private string $dia;

    public function __construct(
        int $codigo_Linea,
        string $dia
    ) {
        $this->codigo_Linea = $codigo_Linea;
        $this->dia = $dia;
    }




    // Getter para $codigo_Linea
    public function getCodigo_Linea(): int
    {
        return $this->codigo_Linea;
    }

    // Getter para $dia
    public function getDia(): string
    {
        return $this->dia;
    }

    public function jsonSerialize()
    {
        return [
            "codigo_Linea" => $this->codigo_Linea,
            "dia" => $this->dia
        ];
    }
}

?>