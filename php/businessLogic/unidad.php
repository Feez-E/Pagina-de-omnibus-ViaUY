<?php
class Unidad {
    private int $numero;
    private string $matricula;
    private string $numeroChasis;
    private int $capacidadPrimerPiso;
    private ?int $capacidadSegundoPiso;
    private bool $vigencia;

    public function __construct(
        int $numero,
        string $matricula, 
        string $numeroChasis, 
        int $capacidadPrimerPiso, 
        ?int $capacidadSegundoPiso, 
        bool $vigencia
    ) {
        $this->numero = $numero;
        $this->matricula = $matricula;
        $this->numeroChasis = $numeroChasis;
        $this->capacidadPrimerPiso = $capacidadPrimerPiso;
        $this->capacidadSegundoPiso = $capacidadSegundoPiso;
        $this->vigencia = $vigencia;
    }

    // Getter para $numero
    public function getNumero(): int {
        return $this->numero;
    }

    // Getter para $matricula
    public function getMatricula(): string {
        return $this->matricula;
    }

    // Setter para $matricula
    public function setMatricula(string $matricula): void {
        $this->matricula = $matricula;
    }

    // Getter para $numeroChasis
    public function getNumeroChasis(): string {
        return $this->numeroChasis;
    }

    // Setter para $numeroChasis
    public function setNumeroChasis(string $numeroChasis): void {
        $this->numeroChasis = $numeroChasis;
    }

    // Getter para $capacidadPrimerPiso
    public function getCapacidadPrimerPiso(): int {
        return $this->capacidadPrimerPiso;
    }

    // Setter para $capacidadPrimerPiso
    public function setCapacidadPrimerPiso(int $capacidadPrimerPiso): void {
        $this->capacidadPrimerPiso = $capacidadPrimerPiso;
    }

    // Getter para $capacidadSegundoPiso
    public function getCapacidadSegundoPiso(): ?int {
        return $this->capacidadSegundoPiso;
    }

    // Setter para $capacidadSegundoPiso
    public function setCapacidadSegundoPiso(?int $capacidadSegundoPiso): void {
        $this->capacidadSegundoPiso = $capacidadSegundoPiso;
    }

    // Getter para $vigencia
    public function getVigencia(): bool {
        return $this->vigencia;
    }

    // Setter para $vigencia
    public function setVigencia(bool $vigencia): void {
        $this->vigencia = $vigencia;
    }
}


?>