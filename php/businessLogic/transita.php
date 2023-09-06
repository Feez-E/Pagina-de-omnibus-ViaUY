<?php

class Transita {
    private $idInicial_T_Recorre;
    private $idFinal_T_Recorre;
    private $codigo_L_Recorre;
    private $orden_Recorre;
    private $numero_Unidad;
    private $horaSalida_Salida;
    private $horaLlegada_Llegada;

    public function __construct(
        $idInicial_T_Recorre, 
        $idFinal_T_Recorre, 
        $codigo_L_Recorre, 
        $orden_Recorre, 
        $numero_Unidad, 
        $horaSalida_Salida, 
        $horaLlegada_Llegada
    ) {
        $this->idInicial_T_Recorre = $idInicial_T_Recorre;
        $this->idFinal_T_Recorre = $idFinal_T_Recorre;
        $this->codigo_L_Recorre = $codigo_L_Recorre;
        $this->orden_Recorre = $orden_Recorre;
        $this->numero_Unidad = $numero_Unidad;
        $this->horaSalida_Salida = $horaSalida_Salida;
        $this->horaLlegada_Llegada = $horaLlegada_Llegada;
    }

    public function getIdInicial_T_Recorre() {
        return $this->idInicial_T_Recorre;
    }


    public function getIdFinal_T_Recorre() {
        return $this->idFinal_T_Recorre;
    }

    public function getCodigo_L_Recorre() {
        return $this->codigo_L_Recorre;
    }

    public function getOrden_Recorre() {
        return $this->orden_Recorre;
    }


    public function getNumero_Unidad() {
        return $this->numero_Unidad;
    }

    public function getHoraSalida_Salida() {
        return $this->horaSalida_Salida;
    }

    public function setHoraSalida_Salida($horaSalida_Salida) {
        $this->horaSalida_Salida = $horaSalida_Salida;
    }

    public function getHoraLlegada_Llegada() {
        return $this->horaLlegada_Llegada;
    }

    public function setHoraLlegada_Llegada($horaLlegada_Llegada) {
        $this->horaLlegada_Llegada = $horaLlegada_Llegada;
    }
}

?>
