<?php
    class Permiso{
        private String $nombre;
        private String $descripcion;
        private String $url;

        // Constructor
        public function __construct(string $nombre,
            string $descripcion,
            string $url,
        ) {
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->url = $url;
        }
    
	// Getter para $nombre
	public function getNombre(): string {
		return $this->nombre;
	}

    // Setter para $nombre
	public function setNombre(string $nombre): void {
		$this->nombre = $nombre;
	}

    // Getter para $descripcion
	public function getDescripcion(): string {
		return $this->descripcion;
	}
	
	// Setter para $descripcion
	public function setDescripcion(string $descripcion):  void {
		$this->descripcion = $descripcion;
	}

	// Getter para $url
	public function getUrl(): string {
		return $this->url;
	}

	// Setter para $url
	public function setUrl(string $url): void {
		$this->url = $url;
	}
}
