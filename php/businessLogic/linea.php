<?php
class Linea implements JsonSerializable
{
	private int $codigo;
	private string $nombre;
	private string $origen;
	private string $destino;
	private bool $vigencia;

	public function __construct(
		int $codigo,
		string $nombre,
		string $origen,
		string $destino,
		bool $vigencia
	) {
		$this->codigo = $codigo;
		$this->nombre = $nombre;
		$this->origen = $origen;
		$this->destino = $destino;
		$this->vigencia = $vigencia;
	}



	// Getter para $codigo
	public function getCodigo(): int
	{
		return $this->codigo;
	}

	// Getter para $nombre
	public function getNombre(): string
	{
		return $this->nombre;
	}

	// Setter para $nombre
	public function setNombre(string $nombre): void
	{
		$this->nombre = $nombre;
	}

	// Getter para $origen
	public function getOrigen(): string
	{
		return $this->origen;
	}

	// Setter para %origen
	public function setOrigen(string $origen): void
	{
		$this->origen = $origen;
	}

	// Getter para $destino
	public function getDestino(): string
	{
		return $this->destino;
	}

	// Setter para $destino
	public function setDestino(string $destino): void
	{
		$this->destino = $destino;
	}

	// Getter para $vigencia
	public function getVigencia(): bool
	{
		return $this->vigencia;
	}

	// Setter para $vigencia
	public function setVigencia(bool $vigencia): void
	{
		$this->vigencia = $vigencia;
	}

	public function jsonSerialize()
    {
        return [
			"codigo" => $this->codigo,
			"nombre" => $this->nombre,
			"origen" => $this->origen,
			"destino" => $this->destino,
			"vigencia" => $this->vigencia
        ];
    }
}
