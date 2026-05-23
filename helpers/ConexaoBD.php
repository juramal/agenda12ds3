<?php

class ConexaoBD {
    private $serverName =
    "localhost"; private
    $userName = "root"; private
    $password = "password"; private
    $dbName = "projeto_final";

    public function conectar() {
        try{
            $conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

        }
        catch (Exception $e) {
            die("Erro ao conectar: " . $e->getMessage());
        }
        return $conn;
    }

}


?>