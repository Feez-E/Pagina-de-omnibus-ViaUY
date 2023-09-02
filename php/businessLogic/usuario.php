<?php
    class Usuario{
        private int $id;
        private string $apodo;
        private string $nombre;
        private string $apellido;
        private string $correo;
        private string $contrasena;
        private int $telefono;
        private DateTime $fechaNac;
        private string $nombre_Rol;

        // Constructor
    public function __construct(
        int $id,
        string $apodo,
        string $nombre,
        string $apellido,
        string $correo,
        string $contrasena,
        int $telefono,
        DateTime $fechaNac,
        string $nombre_Rol
    ) {
        $this->id = $id;
        $this->apodo = $apodo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->contrasena = $contrasena;
        $this->telefono = $telefono;
        $this->fechaNac = $fechaNac;
        $this->nombre_Rol = $nombre_Rol;
    }
        // Getter para $id
        public function getId(): int {
            return $this->id;
        }

        // Getter para $apodo
        public function getApodo(): string {
            return $this->apodo;
        }

        // Setter para $apodo
        public function setApodo(string $apodo): void {
          $this->apodo = $apodo;
        }

        // Getter para $nombre
        public function getNombre(): string {
            return $this->nombre;
        }

        // Setter para $nombre
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }

        // Getter para $apellido
        public function getApellido(): string {
            return $this->apellido;
        }

        // Setter para $apellido
        public function setApellido(string $apellido): void {
            $this->apellido = $apellido;
        }

        // Getter para $correo
        public function getCorreo(): string {
            return $this->correo;
        }

        // Setter para $correo
        public function setCorreo(string $correo): void {
            $this->correo = $correo;
        }

        // Getter para $contraseña
        public function getContrasena(): string {
            return $this->contrasena;
        }

        // Setter para $contraseña
        public function setContrasena(string $contrasena): void {
            $this->contrasena = $contrasena;
        }

        // Getter para $telefono
        public function getTelefono(): int {
            return $this->telefono;
        }

        // Setter para $telefono
        public function setTelefono(int $telefono): void {
            $this->telefono = $telefono;
        }

         //Getter para $fechaNac
	    public function getFechaNac(): DateTime {
		    return $this->fechaNac;
	    }
        
         //Setter para $fechaNac
	    public function setFechaNac(DateTime $fechaNac): void {
		    $this->fechaNac = $fechaNac;
	    }

        // Getter para $nombre_Rol
        public function getNombreRol(): string {
            return $this->nombre_Rol;
        }

        // Setter para $nombre_Rol
        public function setNombreRol(string $nombre_Rol): void {
            $this->nombre_Rol = $nombre_Rol;
        }
	
}


class AuthenticationService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM Usuario WHERE apodo = ? AND contrasena = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            return new Usuario(
                $user['id'],
                $user['apodo'],
                $user['nombre'],
                $user['apellido'],
                $user['correo'],
                $user['contrasena'],
                $user['telefono'],
                new DateTime($user['fechaNac']),
                $user['nombre_Rol']
            );
        } else {
            return null; // La autenticación falló
        }
    }
}
?>