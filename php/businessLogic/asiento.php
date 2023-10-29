
<?php
class Asiento implements JsonSerializable
{
    private int $numero;
    private int $idInicial_T_R_Transita;
    private int $idFinal_T_R_Transita;
    private int $codigo_L_R_Transita;
    private int $orden_R_Transita;
    private int $numero_U_Transita;
    private DateTime $horaSalida_S_Transita;
    private DateTime $horaLlegada_L_Transita;
    private string $nombre_P_ParametroDouble;
    private float $precio;

    public function __construct(
        ?int $numero,
        ?int $idInicial_T_R_Transita,
        ?int $idFinal_T_R_Transita,
        ?int $codigo_L_R_Transita,
        ?int $orden_R_Transita,
        ?int $numero_U_Transita,
        ?DateTime $horaSalida_S_Transita,
        ?DateTime $horaLlegada_L_Transita,
        ?string $nombre_P_ParametroDouble,
        ?float $precio
    ) {
        $this->numero = $numero ?? 0;
        $this->idInicial_T_R_Transita = $idInicial_T_R_Transita ?? 0;
        $this->idFinal_T_R_Transita = $idFinal_T_R_Transita ?? 0;
        $this->codigo_L_R_Transita = $codigo_L_R_Transita ?? 0;
        $this->orden_R_Transita = $orden_R_Transita ?? 0;
        $this->numero_U_Transita = $numero_U_Transita ?? 0;
        $this->horaSalida_S_Transita = $horaSalida_S_Transita;
        $this->horaLlegada_L_Transita = $horaLlegada_L_Transita;
        $this->nombre_P_ParametroDouble = $nombre_P_ParametroDouble ?? 0;
        $this->precio = $precio ?? 0.0;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getIdInicial_T_R_Transita(): int
    {
        return $this->idInicial_T_R_Transita;
    }

    public function setIdInicial_T_R_Transita(int $idInicial_T_R_Transita): void
    {
        $this->idInicial_T_R_Transita = $idInicial_T_R_Transita;
    }

    public function getIdFinal_T_R_Transita(): int
    {
        return $this->idFinal_T_R_Transita;
    }

    public function setIdFinal_T_R_Transita(int $idFinal_T_R_Transita): void
    {
        $this->idFinal_T_R_Transita = $idFinal_T_R_Transita;
    }

    public function getCodigo_L_R_Transita(): int
    {
        return $this->codigo_L_R_Transita;
    }

    public function setCodigo_L_R_Transita(int $codigo_L_R_Transita): void
    {
        $this->codigo_L_R_Transita = $codigo_L_R_Transita;
    }

    public function getOrden_R_Transita(): int
    {
        return $this->orden_R_Transita;
    }

    public function setOrden_R_Transita(int $orden_R_Transita): void
    {
        $this->orden_R_Transita = $orden_R_Transita;
    }

    public function getNumero_U_Transita(): int
    {
        return $this->numero_U_Transita;
    }

    public function setNumero_U_Transita(int $numero_U_Transita): void
    {
        $this->numero_U_Transita = $numero_U_Transita;
    }

    public function getHoraSalida_S_Transita(): DateTime 
    {
        return $this->horaSalida_S_Transita;
    }

    public function setHoraSalida_S_Transita(DateTime $horaSalida_S_Transita): void
    {
        $this->horaSalida_S_Transita = $horaSalida_S_Transita;
    }

    public function getHoraLlegada_L_Transita(): DateTime 
    {
        return $this->horaLlegada_L_Transita;
    }

    public function setHoraLlegada_L_Transita(DateTime  $horaLlegada_L_Transita): void
    {
        $this->horaLlegada_L_Transita = $horaLlegada_L_Transita;
    }

    public function getNombre_P_ParametroDouble(): string
    {
        return $this->nombre_P_ParametroDouble;
    }

    public function setNombre_P_ParametroDouble(string $nombre_P_ParametroDouble): void
    {
        $this->nombre_P_ParametroDouble = $nombre_P_ParametroDouble;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function jsonSerialize()
    {
        return [
            "numero" => $this->numero,
            "idInicial_T_R_Transita" => $this->idInicial_T_R_Transita,
            "idFinal_T_R_Transita" => $this->idFinal_T_R_Transita,
            "codigo_L_R_Transita" => $this->codigo_L_R_Transita,
            "orden_R_Transita" => $this->orden_R_Transita,
            "numero_U_Transita" => $this->numero_U_Transita,
            "horaSalida_S_Transita" => $this->horaSalida_S_Transita,
            "horaLlegada_L_Transita" => $this->horaLlegada_L_Transita,
            "nombre_P_ParametroDouble" => $this->nombre_P_ParametroDouble,
            "precio" => $this->precio
        ];
    }
}