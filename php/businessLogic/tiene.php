<?php
    class Tiene{
        private String $nombre_Rol;
        private String $nombre_Permiso;
    


    //Getter para $nombre_Rol
	public function getNombre_Rol(): string {
		return $this->nombre_Rol;
	}
	
    //Setter para $nombre_Rol
	public function setNombre_Rol(string $nombre_Rol): void {
		$this->nombre_Rol = $nombre_Rol;
	}

    //Getter para $nombre_Permiso
	public function getNombre_Permiso(): string {
		return $this->nombre_Permiso;
	}
	
    //Setter para $nombre_Permiso
	public function setNombre_Permiso(string $nombre_Permiso): void {
		$this->nombre_Permiso = $nombre_Permiso;
	}
}
?>