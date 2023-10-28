<?php
class MetodoPago implements JsonSerializable
{
    private string $metodo;

    public function __construct(string $metodo)
    {
        $this->metodo = $metodo;
    }

    public function getMetodo(): string
    {
        return $this->metodo;
    }

    public function setMetodo(string $metodo): void
    {
        $this->metodo = $metodo;
    }

    public function jsonSerialize()
    {
        return [
            "metodo" => $this->metodo,
        ];
    }
}