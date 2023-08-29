<?php
    class Rol{
        private String $nombre;
        private String $descripcion;

        // Constructor
        public function __construct($nombre,
            $descripcion
        ){
            $this->$nombre = $nombre;
            $this->$descripcion = $descripcion;
        }

        // Getter para $nombre
	    public function getNombre(): string {
		    return $this->nombre;
	    }
	
	
	    public function setNombre(string $nombre): void {
		    $this->nombre = $nombre;
	    }

	    // Getter para $nombre
	    public function getDescripcion(): string {
	    	return $this->descripcion;
	    }
	
	
	    public function setDescripcion(string $descripcion): void {
		    $this->descripcion = $descripcion;
	    }
}
