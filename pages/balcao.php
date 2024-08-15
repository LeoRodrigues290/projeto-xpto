<?php
require '../functions.php';

$chamadosPendentes = getChamadosByStatus('Pendente');
$chamadosConcluidos = getChamadosByStatus('Concluído');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrar_chamado'])) {
        registrarChamado($_POST['cliente'], $_POST['produto'], $_POST['descricao']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Balcão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistema de Gestão</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="balcao.php">Balcão</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnico-externo.php">Tecnico Externo</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnicos.php">Técnico Manutenção</a></li>

            <li class="nav-item"><a class="nav-link" href="almoxarifado.php">Almoxarifado</a></li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h1>Balcão</h1>

    <h2 class="mt-5">Registrar Novo Chamado</h2>
    <form method="post">
        <div class="form-group">
            <label for="cliente">Cliente:</label>
            <input type="text" name="cliente" id="cliente" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="produto">Produto:</label>
            <input type="text" name="produto" id="produto" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control" required></textarea>
        </div>
        <button type="submit" name="registrar_chamado" class="btn btn-primary">Registrar Chamado</button>
    </form>

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
        <?php foreach ($chamadosPendentes as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td>
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td>
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

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
        <?php foreach ($chamadosConcluidos as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td>
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td>
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td>
                <td><?php echo htmlspecialchars($chamado['status']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
