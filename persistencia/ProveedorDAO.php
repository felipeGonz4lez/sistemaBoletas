<?php

require_once ("./persistencia/Conexion.php");
require_once ("./logica/Proveedor.php");


class ProveedorDAO {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function insertarProveedor($proveedor) {
        $this->conexion->abrirConexion();
        $sql = "INSERT INTO proveedores (nombre, email, telefono)
                VALUES ('" . $proveedor->getNombre() . "', '" . $proveedor->getEmail() . "', '" . $proveedor->getTelefono() . "')";
        $this->conexion->ejecutarConsulta($sql);
        $id = $this->conexion->obtenerLlaveAutonumerica();
        $this->conexion->cerrarConexion();
        return $id;
    }
    
    public function obtenerProveedorPorId($idProveedor) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM proveedores WHERE id_proveedor = $idProveedor";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        if ($fila = $resultado->fetch_assoc()) {
            $proveedor = new Proveedor($fila['id_proveedor'], $fila['nombre'], $fila['email'], $fila['telefono']);
        } else {
            $proveedor = null;
        }
        
        $this->conexion->cerrarConexion();
        return $proveedor;
    }
    
    public function actualizarProveedor($proveedor) {
        $this->conexion->abrirConexion();
        $sql = "UPDATE proveedores SET
                    nombre = '" . $proveedor->getNombre() . "',
                    email = '" . $proveedor->getEmail() . "',
                    telefono = '" . $proveedor->getTelefono() . "'
                WHERE id_proveedor = " . $proveedor->getIdProveedor();
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function eliminarProveedor($idProveedor) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM proveedores WHERE id_proveedor = $idProveedor";
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function obtenerTodosLosProveedores() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM proveedores";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        $proveedores = [];
        while ($fila = $resultado->fetch_assoc()) {
            $proveedores[] = new Proveedor($fila['id_proveedor'], $fila['nombre'], $fila['email'], $fila['telefono']);
        }
        
        $this->conexion->cerrarConexion();
        return $proveedores;
    }
}

?>
