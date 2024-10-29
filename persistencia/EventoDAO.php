<?php

require_once ("./persistencia/Conexion.php");
require_once ("./logica/Evento.php");


class EventoDAO {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function insertarEvento($evento) {
        $this->conexion->abrirConexion();
        $sql = "INSERT INTO eventos (nombre_evento, fecha, aforo, id_proveedor, precio)
                VALUES ('" . $evento->getNombre() . "', '" . $evento->getFecha() . "', " . $evento->getAforo() . ", " . $evento->getIdProveedor() . ", " . $evento->getPrecio() . ")";
        $this->conexion->ejecutarConsulta($sql);
        $id = $this->conexion->obtenerLlaveAutonumerica();
        $this->conexion->cerrarConexion();
        return $id;
    }
    
    public function obtenerEventoPorId($idEvento) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM eventos WHERE id_evento = $idEvento";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        if ($fila = $resultado->fetch_assoc()) {
            $evento = new Evento($fila['id_evento'], $fila['nombre_evento'], $fila['fecha'], $fila['aforo'], $fila['id_proveedor'], $fila['precio']);
        } else {
            $evento = null;
        }
        
        $this->conexion->cerrarConexion();
        return $evento;
    }
    
    public function actualizarEvento($evento) {
        $this->conexion->abrirConexion();
        $sql = "UPDATE eventos SET
                    nombre_evento = '" . $evento->getNombre() . "',
                    fecha = '" . $evento->getFecha() . "',
                    aforo = " . $evento->getAforo() . ",
                    id_proveedor = " . $evento->getIdProveedor() . ",
                    precio = " . $evento->getPrecio() . "
                WHERE id_evento = " . $evento->getIdEvento();
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function eliminarEvento($idEvento) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM eventos WHERE id_evento = $idEvento";
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function obtenerTodosLosEventos() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM eventos";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        $eventos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $eventos[] = new Evento($fila['id_evento'], $fila['nombre_evento'], $fila['fecha'], $fila['aforo'], $fila['id_proveedor'], $fila['precio']);
        }
        
        $this->conexion->cerrarConexion();
        return $eventos;
    }
}

?>
