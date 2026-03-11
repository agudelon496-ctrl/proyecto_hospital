<?php

/**
 * Clase de conexión a la base de datos usando PDO.
 * Configura el host, nombre de BD y credenciales,
 * y proporciona el método getConnection().
 */
class Conexion {

    private $host = "localhost";
    private $db_name = "hospital_pro";
    private $username = "root";
    private $password = "";
    private $conn;

    // Devuelve un objeto PDO conectado a la BD.
    // Si ocurre un error se captura y se imprime.
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $exception){
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>