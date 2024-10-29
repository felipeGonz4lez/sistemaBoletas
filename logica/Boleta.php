<?php

class Boleta {
    private $idBoleta;
    private $nombreUsuario;
    private $idCliente;
    private $idEvento;
    
    public function __construct($idBoleta, $nombreUsuario, $idCliente, $idEvento) {
        $this->idBoleta = $idBoleta;
        $this->nombreUsuario = $nombreUsuario;
        $this->idCliente = $idCliente;
        $this->idEvento = $idEvento;
    }
    
    // Getters
    public function getIdBoleta() {
        return $this->idBoleta;
    }
    
    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }
    
    public function getIdCliente() {
        return $this->idCliente;
    }
    
    public function getIdEvento() {
        return $this->idEvento;
    }
    
    // Setters
    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }
    
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }
    
    public function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }
}

?>
