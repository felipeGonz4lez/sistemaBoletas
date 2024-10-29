<?php

class Proveedor {
    private $idProveedor;
    private $nombre;
    private $email;
    private $telefono;
    
    public function __construct($idProveedor, $nombre, $email, $telefono) {
        $this->idProveedor = $idProveedor;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
    }
    
    // Getters
    public function getIdProveedor() {
        return $this->idProveedor;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }
    
    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
}

?>
