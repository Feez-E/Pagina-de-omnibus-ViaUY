<?php

class Tiquet implements JsonSerializable
{
    private int $codigo;
    private int $precio;
    public function __construct(

        int $codigo,
        int $precio

    ) {
        $this->codigo = $codigo;
        $this->precio = $precio;
    }

    // Getter y Setter para Codigo
    public function getCodigo(): int
    {
        return $this->codigo;
    }

    public function setCodigo(int $codigo): void
    {
        $this->codigo = $codigo;
    }

    // Getter y Setter para Precio

    public function getPrecio(): int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): void
    {
        $this->precio = $precio;
    }



    public function jsonSerialize()
    {
        return [
            "codigo" => $this->codigo,
            "precio" => $this->precio,
        ];
    }
}
