<?php
require 'asiento.php';

class Reserva implements JsonSerializable
{
    private Asiento $asiento;
    private int $id_Usuario;
    private DateTime $fechaLimite;
    private string $metodo_MetodoPago;
    private string $estado;
    private DateTime $fecha;
    private DateTime $hora;
    private string $codigo_Tiquet;

    public function __construct(
        Asiento $asiento,
        ?int $id_Usuario,
        DateTime $fechaLimite,
        ?string $metodo_MetodoPago,
        string $estado,
        DateTime $fecha,
        DateTime $hora,
        ?string $codigo_Tiquet
    ) {
        $this->asiento = $asiento;
        $this->id_Usuario = $id_Usuario ?? 0;
        $this->fechaLimite = $fechaLimite;
        $this->metodo_MetodoPago = $metodo_MetodoPago ?? 0;
        $this->estado = $estado;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->codigo_Tiquet = $codigo_Tiquet ?? 0;
    }

    // Getter y Setter para el objeto Asiento
    public function getAsiento(): Asiento
    {
        return $this->asiento;
    }

    public function setAsiento(Asiento $asiento): void
    {
        $this->asiento = $asiento;
    }

    // Getters y Setters para otros atributos
    public function getId_Usuario(): int
    {
        return $this->id_Usuario;
    }

    public function setId_Usuario(int $id_Usuario): self
    {
        $this->id_Usuario = $id_Usuario;
        return $this;
    }

    public function getFechaLimite(): DateTime
    {
        return $this->fechaLimite;
    }

    public function setFechaLimite(DateTime $fechaLimite): self
    {
        $this->fechaLimite = $fechaLimite;
        return $this;
    }

    public function getMetodo_MetodoPago(): string
    {
        return $this->metodo_MetodoPago;
    }

    public function setMetodo_MetodoPago(string $metodo_MetodoPago): self
    {
        $this->metodo_MetodoPago = $metodo_MetodoPago;
        return $this;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;
        return $this;
    }

    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getHora(): DateTime
    {
        return $this->hora;
    }

    public function setHora(DateTime $hora): self
    {
        $this->hora = $hora;
        return $this;
    }

    public function getCodigo_Tiquet(): string
    {
        return $this->codigo_Tiquet;
    }

    public function setCodigo_Tiquet(string $codigo_Tiquet): self
    {
        $this->codigo_Tiquet = $codigo_Tiquet;
        return $this;
    }


    public function jsonSerialize()
    {
        return [
            "asiento" => $this->asiento,
            "id_Usuario" => $this->id_Usuario,
            "fechaLimite" => $this->fechaLimite->format('Y-m-d'),
            "metodo_MetodoPago" => $this->metodo_MetodoPago,
            "estado" => $this->estado,
            "fecha" => $this->fecha->format('Y-m-d'),
            "hora" => $this->hora->format('H:i:s'),
            "codigo_Tiquet" => $this->codigo_Tiquet,
        ];
    }

}
