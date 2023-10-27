<?php
class Caracteristica implements JsonSerializable{
    private int $numeroUnidad;
    private string $propiedad;
    private float $multiplicador;

    public function __construct(int $numeroUnidad, string $propiedad, float $multiplicador) {
        $this->numeroUnidad = $numeroUnidad;
        $this->propiedad = $propiedad;
        $this->multiplicador = $multiplicador;
    }

    // Getter para $numeroUnidad
    public function getNumeroUnidad(): int {
        return $this->numeroUnidad;
    }

    // Getter para $propiedad
    public function getPropiedad(): string {
        return $this->propiedad;
    }

    // Setter para $propiedad
    public function setPropiedad(string $propiedad): void {
        $this->propiedad = $propiedad;
    }

    // Getter para $multiplicador
    public function getMultiplicador(): float {
        return $this->multiplicador;
    }

    // Setter para $multiplicador
    public function setMultiplicador(float $multiplicador): void {
        $this->multiplicador = $multiplicador;
    }

    public function jsonSerialize()
    {


        return [
            "numeroUnidad" => $this->numeroUnidad,
            "propiedad" => $this->propiedad,
            "multiplicador" => $this->multiplicador 
        ];

    }
}

?>