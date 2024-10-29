<?php

require_once ("./persistencia/Conexion.php");
require_once ("./logica/Boleta.php");


class BoletaDAO {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function insertarBoleta($boleta) {
        $this->conexion->abrirConexion();
        $sql = "INSERT INTO boletas (nombre_usuario, id_cliente, id_evento)
                VALUES ('" . $boleta->getNombreUsuario() . "', " . $boleta->getIdCliente() . ", " . $boleta->getIdEvento() . ")";
        $this->conexion->ejecutarConsulta($sql);
        $id = $this->conexion->obtenerLlaveAutonumerica();
        $this->conexion->cerrarConexion();
        return $id;
    }
    
    public function obtenerBoletaPorId($idBoleta) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM boletas WHERE id_boleta = $idBoleta";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        if ($fila = $resultado->fetch_assoc()) {
            $boleta = new Boleta($fila['id_boleta'], $fila['nombre_usuario'], $fila['id_cliente'], $fila['id_evento']);
        } else {
            $boleta = null;
        }
        
        $this->conexion->cerrarConexion();
        return $boleta;
    }
    
    public function actualizarBoleta($boleta) {
        $this->conexion->abrirConexion();
        $sql = "UPDATE boletas SET
                    nombre_usuario = '" . $boleta->getNombreUsuario() . "',
                    id_cliente = " . $boleta->getIdCliente() . ",
                    id_evento = " . $boleta->getIdEvento() . "
                WHERE id_boleta = " . $boleta->getIdBoleta();
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function eliminarBoleta($idBoleta) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM boletas WHERE id_boleta = $idBoleta";
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function obtenerTodasLasBoletas() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM boletas";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        $boletas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $boletas[] = new Boleta($fila['id_boleta'], $fila['nombre_usuario'], $fila['id_cliente'], $fila['id_evento']);
        }
        
        $this->conexion->cerrarConexion();
        return $boletas;
    }
}

?>

