<?php
class Tramo
{
    private int $idInicial;
    private int $idFinal;
    private DateTime $tiempo;
    private float $distancia;
    private string $estado_estado;


    public function __construct(
        int $idInicial,
        int $idFinal,
        DateTime $tiempo,
        float $distancia,
        string $estado_estado
    ) {
        $this->idInicial = $idInicial;
        $this->idFinal = $idFinal;
        $this->tiempo = $tiempo;
        $this->distancia = $distancia;
        $this->estado_estado = $estado_estado;
    }

    

	// Getter para $idInicial
	public function getIdInicial(): int {
		return $this->idInicial;
	}

	// Getter para $idFinal
	public function getIdFinal(): int {
		return $this->idFinal;
	}

	// Getter para $tiempo
	public function getTiempo(): DateTime {
		return $this->tiempo;
	}
	
	// Setter para $tiempo
	public function setTiempo(DateTime $tiempo): void {
		$this->tiempo = $tiempo;
	}

	// Getter para $distancia
	public function getDistancia(): float {
		return $this->distancia;
	}
	
	// Setter para $distancia
	public function setDistancia(float $distancia): void {
		$this->distancia = $distancia;
	}

    // Getter para $estado
	public function getEstado_estado(): String {
		return $this->estado_estado;
	}
	
	// Setter para $estado
	public function setEstado_estado(String $estado): void {
		$this->estado_estado = $estado;
	}
}
