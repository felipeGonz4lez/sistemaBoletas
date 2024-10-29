<?php

require_once ("./persistencia/Conexion.php");
require_once ("./logica/Factura.php");


class FacturaDAO {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function insertarFactura($factura) {
        $this->conexion->abrirConexion();
        $sql = "INSERT INTO facturas (fecha, total, id_cliente)
                VALUES ('" . $factura->getFecha() . "', " . $factura->getTotal() . ", " . $factura->getIdCliente() . ")";
        $this->conexion->ejecutarConsulta($sql);
        $id = $this->conexion->obtenerLlaveAutonumerica();
        $this->conexion->cerrarConexion();
        return $id;
    }
    
    public function obtenerFacturaPorId($idFactura) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM facturas WHERE id_factura = $idFactura";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        if ($fila = $resultado->fetch_assoc()) {
            $factura = new Factura($fila['id_factura'], $fila['fecha'], $fila['total'], $fila['id_cliente']);
        } else {
            $factura = null;
        }
        
        $this->conexion->cerrarConexion();
        return $factura;
    }
    
    public function actualizarFactura($factura) {
        $this->conexion->abrirConexion();
        $sql = "UPDATE facturas SET
                    fecha = '" . $factura->getFecha() . "',
                    total = " . $factura->getTotal() . ",
                    id_cliente = " . $factura->getIdCliente() . "
                WHERE id_factura = " . $factura->getIdFactura();
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function eliminarFactura($idFactura) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM facturas WHERE id_factura = $idFactura";
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function obtenerTodasLasFacturas() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM facturas";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        $facturas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $facturas[] = new Factura($fila['id_factura'], $fila['fecha'], $fila['total'], $fila['id_cliente']);
        }
        
        $this->conexion->cerrarConexion();
        return $facturas;
    }
}

?>
