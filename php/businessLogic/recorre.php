<?php
class Recorre implements JsonSerializable
{
    private int $idInicialTramo;
    private int $idFinalTramo;
    private int $codigoLinea;
    private int $orden;

    public function __construct(
        int $idInicialTramo,
        int $idFinalTramo,
        int $codigoLinea,
        int $orden
    ) {
        $this->idInicialTramo = $idInicialTramo;
        $this->idFinalTramo = $idFinalTramo;
        $this->codigoLinea = $codigoLinea;
        $this->orden = $orden;
    }

    // Getter para $idInicialTramo
    public function getIdInicialTramo(): int
    {
        return $this->idInicialTramo;
    }

    // Getter para $idFinalTramo
    public function getIdFinalTramo(): int
    {
        return $this->idFinalTramo;
    }

    // Getter para $codigoLinea
    public function getCodigoLinea(): int
    {
        return $this->codigoLinea;
    }

    // Setter para $codigoLinea
    public function setCodigoLinea(int $codigoLinea): void
    {
        $this->codigoLinea = $codigoLinea;
    }

    // Getter para $orden
    public function getOrden(): int
    {
        return $this->orden;
    }

    // Setter para $orden
    public function setOrden(int $orden): void
    {
        $this->orden = $orden;
    }

    public function jsonSerialize()
    {
        return [
            "idInicialTramo" => $this->idInicialTramo,
            "idFinalTramo" => $this->idFinalTramo,
            "codigoLinea" => $this->codigoLinea,
            "orden" => $this->orden
        ];
    }
}
?>