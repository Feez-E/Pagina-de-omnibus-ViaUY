<?php
class Estado
{
    private string $estado;
    private float $multiplicador;

    public function __construct(
        string $estado,
        float $multiplicador
    ) {
        $this->estado = $estado;
        $this->multiplicador = $multiplicador;
    }

    

	// Getter para $estado
	public function getEstado(): string {
		return $this->estado;
	}

    

	// Getter para $multiplicador
	public function getMultiplicador(): float {
		return $this->multiplicador;
	}
	
	// Setter para $multiplicador
	public function setMultiplicador(float $multiplicador): void {
		$this->multiplicador = $multiplicador;
	}
}