<?php

class Evento {
    private $idEvento;
    private $nombre;
    private $fecha;
    private $aforo;
    private $idProveedor;
    private $precio;
    
    public function __construct($idEvento, $nombre, $fecha, $aforo, $idProveedor, $precio) {
        $this->idEvento = $idEvento;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->aforo = $aforo;
        $this->idProveedor = $idProveedor;
        $this->precio = $precio;
    }
    
    // Getters
    public function getIdEvento() {
        return $this->idEvento;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function getAforo() {
        return $this->aforo;
    }
    
    public function getIdProveedor() {
        return $this->idProveedor;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    public function setAforo($aforo) {
        $this->aforo = $aforo;
    }
    
    public function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
}

?>
