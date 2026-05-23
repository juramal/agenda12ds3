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

// Botão Atualizar - Atualiza dados pessoais do usuário
if (isset($_POST["btnAtualizar"])) {
    include_once '../models/usuario.php';
    
    // Recuperar usuário da sessão
    $usuario = unserialize($_SESSION['Usuario']);
    
    // Atualizar com dados do formulário
    $usuario->setID($_POST['txtID']);
    $usuario->setNome($_POST['txtNome']);
    $usuario->setCPF($_POST['txtCPF']);
    $usuario->setDataNascimento($_POST['txtData']);
    $usuario->setEmail($_POST['txtEmail']);
    
    // Salvar no banco de dados
    if ($usuario->atualizarBD()) {
        // Atualizar sessão
        $_SESSION['Usuario'] = serialize($usuario);
        echo '<script>alert("Dados atualizados com sucesso!"); window.location.href="../principal.php";</script>';
    } else {
        echo '<script>alert("Erro ao atualizar dados!"); window.location.href="../principal.php";</script>';
    }
    exit();
}

// Botão Adicionar Formação Acadêmica
if (isset($_POST["btnAddFormacao"])) {
    include_once '../models/FormacaoAcad.php';
    include_once '../models/usuario.php';
    
    $usuario = unserialize($_SESSION['Usuario']);
    
    $formacao = new FormacaoAcad();
    $formacao->setIdUsuario($usuario->getID());
    $formacao->setInicio($_POST['txtInicioFA']);
    $formacao->setFim($_POST['txtFimFA']);
    $formacao->setDescricao($_POST['txtDescFA']);
    
    if ($formacao->inserirBD()) {
        echo '<script>alert("Formação adicionada com sucesso!"); window.location.href="../principal.php#formacao";</script>';
    } else {
        echo '<script>alert("Erro ao adicionar formação!"); window.location.href="../principal.php#formacao";</script>';
    }
    exit();
}

// Botão Excluir Formação Acadêmica
if (isset($_POST["btnExcluirFormacao"])) {
    include_once '../models/FormacaoAcad.php';
    
    $formacao = new FormacaoAcad();
    
    if ($formacao->excluirBD($_POST['idFormacao'])) {
        echo '<script>alert("Formação excluída com sucesso!"); window.location.href="../principal.php#formacao";</script>';
    } else {
        echo '<script>alert("Erro ao excluir formação!"); window.location.href="../principal.php#formacao";</script>';
    }
    exit();
}

// Botão Adicionar Experiência Profissional
if (isset($_POST["btnAddEP"])) {
    include_once '../models/ExperienciaProfissional.php';
    include_once '../models/usuario.php';
    
    $usuario = unserialize($_SESSION['Usuario']);
    
    $experiencia = new ExperienciaProfissional();
    $experiencia->setIdUsuario($usuario->getID());
    $experiencia->setInicio($_POST['txtInicioEP']);
    $experiencia->setFim($_POST['txtFimEP']);
    $experiencia->setEmpresa($_POST['txtEmpEP']);
    $experiencia->setDescricao($_POST['txtDescEP']);
    
    if ($experiencia->inserirBD()) {
        echo '<script>alert("Experiência adicionada com sucesso!"); window.location.href="../principal.php#eProfissional";</script>';
    } else {
        echo '<script>alert("Erro ao adicionar experiência!"); window.location.href="../principal.php#eProfissional";</script>';
    }
    exit();
}

// Botão Excluir Experiência Profissional
if (isset($_POST["btnExcluirEP"])) {
    include_once '../models/ExperienciaProfissional.php';
    
    $experiencia = new ExperienciaProfissional();
    
    if ($experiencia->excluirBD($_POST['idExperiencia'])) {
        echo '<script>alert("Experiência excluída com sucesso!"); window.location.href="../principal.php#eProfissional";</script>';
    } else {
        echo '<script>alert("Erro ao excluir experiência!"); window.location.href="../principal.php#eProfissional";</script>';
    }
    exit();
}

// Botão Adicionar Outras Formações
if (isset($_POST["btnAddOF"])) {
    include_once '../models/OutrasFormacoes.php';
    include_once '../models/usuario.php';
    
    $usuario = unserialize($_SESSION['Usuario']);
    
    $outraFormacao = new OutrasFormacoes();
    $outraFormacao->setIdUsuario($usuario->getID());
    $outraFormacao->setInicio($_POST['txtInicioOF']);
    $outraFormacao->setFim($_POST['txtFimOF']);
    $outraFormacao->setDescricao($_POST['txtDescOF']);
    
    if ($outraFormacao->inserirBD()) {
        echo '<script>alert("Formação adicionada com sucesso!"); window.location.href="../principal.php#outrasFormacoes";</script>';
    } else {
        echo '<script>alert("Erro ao adicionar formação!"); window.location.href="../principal.php#outrasFormacoes";</script>';
    }
    exit();
}

// Botão Excluir Outras Formações
if (isset($_POST["btnExcluirOF"])) {
    include_once '../models/OutrasFormacoes.php';
    
    $outraFormacao = new OutrasFormacoes();
    
    if ($outraFormacao->excluirBD($_POST['idOutraFormacao'])) {
        echo '<script>alert("Formação excluída com sucesso!"); window.location.href="../principal.php#outrasFormacoes";</script>';
    } else {
        echo '<script>alert("Erro ao excluir formação!"); window.location.href="../principal.php#outrasFormacoes";</script>';
    }
    exit();
}
?>
