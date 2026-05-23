<?php

class ConexaoBD {
    private $serverName = "localhost";
    private $userName = "root";
    private $password = ""; // XAMPP padrão vem sem senha
    private $dbName = "projeto_final";

    public function conectar() {
        $conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
        
        if ($conn->connect_error) {
            die("Erro ao conectar: " . $conn->connect_error);
        }
        
        return $conn;
    }
}

?>