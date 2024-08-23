<?php
require '../functions.php'; // Inclui o arquivo de funções para manipulação do banco de dados

// Obtém todos os chamados com status 'Pendente' e 'Concluído'
$chamadosPendentes = getChamadosByStatus('Pendente');
$chamadosConcluidos = getChamadosByStatus('Concluído');

$mensagem = null;

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o formulário de registro de chamado foi enviado
    if (isset($_POST['registrar_chamado'])) {
        // Verifica se todos os dados necessários estão presentes
        if (!empty($_POST['cliente']) && !empty($_POST['produto']) && !empty($_POST['descricao'])) {
            // Registra um novo chamado com as informações fornecidas
            $resultado = registrarChamado($_POST['cliente'], $_POST['produto'], $_POST['descricao']);
            if ($resultado) {
                $mensagem = array('success' => 'Chamado registrado com sucesso.');
            } else {
                $mensagem = array('error' => 'Ocorreu um erro ao registrar o chamado.');
            }
        } else {
            $mensagem = array('error' => 'Preencha todos os campos para registrar o chamado.');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Balcão</title>
    <!-- Inclui o CSS do Bootstrap para estilização -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Navbar com links para outras seções do sistema -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistema de Gestão</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="balcao.php">Balcão</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnico-externo.php">Técnico Externo</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnico-manutencao.php">Técnico Manutenção</a></li>
            <li class="nav-item"><a class="nav-link" href="almoxarifado.php">Almoxarifado</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1>Balcão</h1>

    <?php if (isset($mensagem['success'])): ?>
        <div class="alert alert-success"><?php echo $mensagem['success']; ?></div>
    <?php endif; ?>

    <!-- Exibe mensagem de erro, se definida -->
    <?php if (isset($mensagem['error'])): ?>
        <div class="alert alert-danger"><?php echo $mensagem['error']; ?></div>
    <?php endif; ?>

    <!-- Formulário para registrar um novo chamado -->
    <h2 class="mt-5">Registrar Novo Chamado</h2>
    <form method="post">
        <div class="form-group">
            <label for="cliente">Cliente:</label>
            <input type="text" name="cliente" id="cliente" class="form-control" required> <!-- Campo para o nome do cliente -->
        </div>
        <div class="form-group">
            <label for="produto">Produto:</label>
            <input type="text" name="produto" id="produto" class="form-control" required> <!-- Campo para o nome do produto -->
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control" required></textarea> <!-- Campo para a descrição do chamado -->
        </div>
        <button type="submit" name="registrar_chamado" class="btn btn-primary">Registrar Chamado</button> <!-- Botão para enviar o formulário -->
    </form>

    <!-- Exibe a lista de chamados pendentes -->
    <h2 class="mt-5">Chamados Pendentes</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Descrição</th>
        </tr>
        </thead>
        <tbody>
        <!-- Itera sobre os chamados pendentes e exibe cada um em uma linha da tabela -->
        <?php foreach ($chamadosPendentes as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td> <!-- Exibe o nome do cliente -->
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td> <!-- Exibe o nome do produto -->
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td> <!-- Exibe a descrição do chamado -->
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Exibe a lista de chamados concluídos -->
    <h2 class="mt-5">Chamados Concluídos</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Descrição</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <!-- Itera sobre os chamados concluídos e exibe cada um em uma linha da tabela -->
        <?php foreach ($chamadosConcluidos as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td> <!-- Exibe o nome do cliente -->
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td> <!-- Exibe o nome do produto -->
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td> <!-- Exibe a descrição do chamado -->
                <td><?php echo htmlspecialchars($chamado['status']); ?></td> <!-- Exibe o status do chamado -->
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
