<?php

class Factura {
    private $idFactura;
    private $fecha;
    private $total;
    private $idCliente;
    
    public function __construct($idFactura, $fecha, $total, $idCliente) {
        $this->idFactura = $idFactura;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->idCliente = $idCliente;
    }
    
    // Getters
    public function getIdFactura() {
        return $this->idFactura;
    }
    
    public function getFecha() {
        return $this->fecha;
    }
    
    public function getTotal() {
        return $this->total;
    }
    
    public function getIdCliente() {
        return $this->idCliente;
    }
    
    // Setters
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    
    public function setTotal($total) {
        $this->total = $total;
    }
    
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }
}

?>
