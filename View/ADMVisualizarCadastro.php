<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="../style.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Visualizar Cadastro</title>
<style>
body, h1, h2, h3, h4, h5, h6 { 
    font-family: "Montserrat", sans-serif 
}
.info-box {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
}
</style>
</head>
<body>
<?php
include_once '../models/usuario.php';
include_once '../models/FormacaoAcad.php';
include_once '../models/ExperienciaProfissional.php';
include_once '../models/OutrasFormacoes.php';
if (!isset($_SESSION)) {
    session_start();
}

// Recuperar ID do usuário
$idusuario = $_SESSION['idUsuarioVisualizar'];

// Carregar dados do usuário
$usuario = new Usuario();
$usuario->setID($idusuario);
// Buscar dados completos do usuário
require_once '../helpers/ConexaoBD.php';
$con = new ConexaoBD();
$conn = $con->conectar();
$sql = "SELECT * FROM usuario WHERE idusuario = " . $idusuario;
$result = $conn->query($sql);
$dadosUsuario = $result->fetch_object();
$conn->close();

// Buscar formações
$formacaoAcad = new FormacaoAcad();
$listaFormacoes = $formacaoAcad->listaFormacoes($idusuario);

// Buscar experiências
$experiencia = new ExperienciaProfissional();
$listaExperiencias = $experiencia->listaExperiencias($idusuario);

// Buscar outras formações
$outrasFormacoes = new OutrasFormacoes();
$listaOutrasFormacoes = $outrasFormacoes->listaOutrasFormacoes($idusuario);
?>

<header class="w3-container w3-padding-32 w3-center">
    <h1 class="w3-text-white w3-panel w3-cyan w3-round-large"><?php echo $dadosUsuario->nome; ?> Currículo</h1>
</header>

<div class="w3-content" style="max-width:1200px">
    
    <!-- Dados Pessoais -->
    <div class="w3-container w3-padding-32">
        <h3 class="w3-border-bottom w3-border-cyan w3-padding-16"><i class="fa fa-user w3-margin-right"></i>Dados Pessoais</h3>
        
        <div class="info-box">
            <strong>NOME:</strong> <?php echo $dadosUsuario->nome; ?>
        </div>
        
        <div class="info-box">
            <strong>CPF:</strong> <?php echo $dadosUsuario->cpf; ?>
        </div>
        
        <div class="info-box">
            <strong>EMAIL:</strong> <?php echo $dadosUsuario->email; ?>
        </div>
        
        <div class="info-box">
            <strong>DATA DE NASCIMENTO:</strong> <?php echo date('d/m/Y', strtotime($dadosUsuario->dataNascimento)); ?>
        </div>
    </div>

    <!-- Formação Acadêmica -->
    <div class="w3-container w3-padding-32">
        <h3 class="w3-border-bottom w3-border-cyan w3-padding-16"><i class="fa fa-mortar-board w3-margin-right"></i>Formação Acadêmica</h3>
        
        <?php if ($listaFormacoes && $listaFormacoes->num_rows > 0): ?>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-cyan">
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($formacao = $listaFormacoes->fetch_object()): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($formacao->inicio)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($formacao->fim)); ?></td>
                    <td><?php echo $formacao->descricao; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="w3-text-grey"><i>Nenhuma formação acadêmica cadastrada.</i></p>
        <?php endif; ?>
    </div>

    <!-- Experiência Profissional -->
    <div class="w3-container w3-padding-32">
        <h3 class="w3-border-bottom w3-border-cyan w3-padding-16"><i class="fa fa-briefcase w3-margin-right"></i>Experiência Profissional</h3>
        
        <?php if ($listaExperiencias && $listaExperiencias->num_rows > 0): ?>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-cyan">
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Empresa</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($exp = $listaExperiencias->fetch_object()): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($exp->inicio)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($exp->fim)); ?></td>
                    <td><?php echo $exp->empresa; ?></td>
                    <td><?php echo $exp->descricao; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="w3-text-grey"><i>Nenhuma experiência profissional cadastrada.</i></p>
        <?php endif; ?>
    </div>

    <!-- Outras Formações -->
    <div class="w3-container w3-padding-32">
        <h3 class="w3-border-bottom w3-border-cyan w3-padding-16"><i class="fa fa-certificate w3-margin-right"></i>Outras Formações</h3>
        
        <?php if ($listaOutrasFormacoes && $listaOutrasFormacoes->num_rows > 0): ?>
        <table class="w3-table-all w3-hoverable">
            <thead>
                <tr class="w3-cyan">
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($outraForm = $listaOutrasFormacoes->fetch_object()): ?>
                <tr>
                    <td><?php echo date('d/m/Y', strtotime($outraForm->inicio)); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($outraForm->fim)); ?></td>
                    <td><?php echo $outraForm->descricao; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="w3-text-grey"><i>Nenhuma outra formação cadastrada.</i></p>
        <?php endif; ?>
    </div>

    <!-- Botão Voltar -->
    <div class="w3-container w3-padding-32 w3-center">
        <form action="../Controller/navegacao.php" method="post">
            <button name="btnVoltarListaCadastrados" class="w3-button w3-blue w3-round-large w3-padding-large" style="width: 300px;">
                <i class="fa fa-arrow-left"></i> Voltar
            </button>
        </form>
    </div>

</div>

<footer class="w3-container w3-padding-32 w3-center w3-opacity w3-light-grey w3-xlarge">
    <p class="w3-medium">Sistema de Currículos - Enlatados Juarez</p>
</footer>

</body>
</html>
