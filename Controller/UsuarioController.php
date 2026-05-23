<?php
if (!isset($_SESSION)) {
    session_start();
}

class UsuarioController
{
    public function gerarLista()
    {
        require_once '../models/usuario.php';
        $u = new Usuario();
        return $results = $u->listaCadastrados();
    }
}
?>
