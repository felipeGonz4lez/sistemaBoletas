<?php

class Conexion {
    private $mysqlConexion;
    private $resultado;
    
    public function abrirConexion() {
        $this->mysqlConexion = new mysqli("localhost", "root", "", "sistemaboletas");
        
        if ($this->mysqlConexion->connect_error) {
            die("Error de conexión: " . $this->mysqlConexion->connect_error);
        }
    }
    
    public function ejecutarConsulta($sentenciaSQL) {
        $this->resultado = $this->mysqlConexion->query($sentenciaSQL);
        return $this->resultado;
    }
    
    public function siguienteRegistro() {
        return $this->resultado->fetch_assoc();
    }
    
    public function obtenerLlaveAutonumerica() {
        return $this->mysqlConexion->insert_id;
    }
    
    public function cerrarConexion() {
        $this->mysqlConexion->close();
    }
    
    public function numeroFilas() {
        return $this->resultado->num_rows;
    }
}

?>
