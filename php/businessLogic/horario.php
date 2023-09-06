<?php

class Salida {
    private $horaSalida;

    public function __construct($horaSalida) {
        $this->horaSalida = $horaSalida;
    }

    public function getHoraSalida() {
        return $this->horaSalida;
    }

    public function setHoraSalida($horaSalida) {
        $this->horaSalida = $horaSalida;
    }
}

class Llegada {
    private $horaLlegada;

    public function __construct($horaLlegada) {
        $this->horaLlegada = $horaLlegada;
    }

    public function getHoraLlegada() {
        return $this->horaLlegada;
    }

    public function setHoraLlegada($horaLlegada) {
        $this->horaLlegada = $horaLlegada;
    }
}

?>
