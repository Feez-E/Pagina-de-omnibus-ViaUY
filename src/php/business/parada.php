<?php
    class Parada{
        private int $id;
        private string $direccion;
        private string $coordenadas;
        private bool $vigencia;

         // Constructor
        public function __construct(int $id,
            string $direccion,
            string $coordenadas,
            bool $vigencia
        ) {
            $this->id = $id;
            $this->direccion = $direccion;
            $this->coordenadas = $coordenadas;
            $this->vigencia = $vigencia;
        }

        // Getter para $id
        public function getId(): int {
            return $this->id;
        }

        // Setter para $id
        public function setId(int $id): void {
            $this->id = $id;
        }

        // Getter para $direccion
        public function getDireccion(): string {
            return $this->direccion;
        }

        // Setter para $direccion
        public function setDireccion(string $direccion): void {
            $this->direccion = $direccion;
        }

        // Getter para $coordenadas
        public function getCoordenadas(): string {
            return $this->coordenadas;
        }

        // Setter para $coordenadas
        public function setCoordenadas(string $coordenadas): void {
            $this->coordenadas = $coordenadas;
        }

        // Getter para $vigencia
        public function isVigencia(): bool {
            return $this->vigencia;
        }

        // Setter para $vigencia
        public function setVigencia(bool $vigencia): void {
            $this->vigencia = $vigencia;
        }
    }
?>