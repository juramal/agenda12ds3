<?php
if (!isset($_SESSION)) {
    session_start();
}

// Botão Login - Autenticação de usuário comum
if (isset($_POST["btnLogin"])) {
    include_once '../models/usuario.php';
    $cpf = $_POST['txtLogin'];
    $senha = $_POST['txtSenha'];
    
    $usuario = new Usuario();
    
    if ($usuario->carregarUsuario($cpf) && $usuario->getSenha() == $senha) {
        $_SESSION['Usuario'] = serialize($usuario);
        header('Location: ../principal.php');
        exit();
    } else {
        echo '<script>alert("CPF ou senha incorretos!"); window.location.href="../login.php";</script>';
        exit();
    }
}

// Botão Primeiro Acesso - Cadastro de novo usuário
if (isset($_POST["btnPrimeiroAcesso"])) {
    header('Location: ../primeiroacesso.php');
    exit();
}

// Botão ADM - Acesso ao painel de administração
if (isset($_POST["btnADM"])) {
    include '../View/ADMLogin.php';
    exit();
}

// Botão Login ADM - Autenticação do administrador
if (isset($_POST["btnLoginADM"])) {
    include_once '../Controller/AdministradorController.php';
    $cpf = $_POST['txtLoginADM'];
    $senha = $_POST['txtSenhaADM'];
    
    $administradorController = new AdministradorController();
    
    if ($administradorController->login($cpf, $senha)) {
        include '../View/ADMPrincipal.php';
    } else {
        echo '<script>alert("Login ou senha incorretos!");</script>';
        include '../View/ADMLogin.php';
    }
    exit();
}

// Botão Listar Cadastrados - Lista todos os usuários
if (isset($_POST["btnListarCadastrados"])) {
    include '../View/ADMListarCadastrados.php';
    exit();
}

// Botão Listar Administradores - Lista todos os administradores
if (isset($_POST["btnListarAdministradores"])) {
    include '../View/ADMListarAdminsitradores.php';
    exit();
}

// Botão Voltar - Retorna ao painel principal
if (isset($_POST["btnVoltar"])) {
    include '../View/ADMPrincipal.php';
    exit();
}

// Botão Visualizar - Visualiza dados completos do usuário
if (isset($_POST["btnVisualizar"])) {
    $_SESSION['idUsuarioVisualizar'] = $_POST['idUsuarioVisualizar'];
    include '../View/ADMVisualizarCadastro.php';
    exit();
}

// Botão Voltar Lista Cadastrados - Retorna à lista de usuários
if (isset($_POST["btnVoltarListaCadastrados"])) {
    include '../View/ADMListarCadastrados.php';
    exit();
}
?>
