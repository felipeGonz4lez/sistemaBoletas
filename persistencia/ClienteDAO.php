<?php

require_once ("./persistencia/Conexion.php");
require_once ("./logica/Cliente.php");


class ClienteDAO {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }
    
    public function insertarCliente($cliente) {
        $this->conexion->abrirConexion();
        $sql = "INSERT INTO clientes (nombre, email, telefono)
                VALUES ('" . $cliente->getNombre() . "', '" . $cliente->getEmail() . "', '" . $cliente->getTelefono() . "')";
        $this->conexion->ejecutarConsulta($sql);
        $id = $this->conexion->obtenerLlaveAutonumerica();
        $this->conexion->cerrarConexion();
        return $id;
    }
    
    public function obtenerClientePorId($idCliente) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM clientes WHERE id_cliente = $idCliente";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        if ($fila = $resultado->fetch_assoc()) {
            $cliente = new Cliente($fila['id_cliente'], $fila['nombre'], $fila['email'], $fila['telefono']);
        } else {
            $cliente = null;
        }
        
        $this->conexion->cerrarConexion();
        return $cliente;
    }
    
    public function actualizarCliente($cliente) {
        $this->conexion->abrirConexion();
        $sql = "UPDATE clientes SET
                    nombre = '" . $cliente->getNombre() . "',
                    email = '" . $cliente->getEmail() . "',
                    telefono = '" . $cliente->getTelefono() . "'
                WHERE id_cliente = " . $cliente->getIdCliente();
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function eliminarCliente($idCliente) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM clientes WHERE id_cliente = $idCliente";
        $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    }
    
    public function obtenerTodosLosClientes() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM clientes";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        
        $clientes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $clientes[] = new Cliente($fila['id_cliente'], $fila['nombre'], $fila['email'], $fila['telefono']);
        }
        
        $this->conexion->cerrarConexion();
        return $clientes;
    }
}

?>
