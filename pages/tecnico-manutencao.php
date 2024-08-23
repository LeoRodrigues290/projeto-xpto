<?php
require '../functions.php'; // Inclui o arquivo de funções que contém as funções para manipulação do banco de dados

// Obtém todos os chamados com status 'Em Andamento'
$chamados = getChamadosByStatus('Em Andamento');

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o formulário de conclusão de chamado foi enviado
    if (isset($_POST['concluir_chamado'])) {
        // Atualiza o status do chamado para 'Concluído' usando a função updateChamadoStatus
        updateChamadoStatus($_POST['chamado_id'], 'Concluído');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Técnico Manutenção</title>
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
    <h1>Técnico Manutenção</h1>

    <h2 class="mt-5">Chamados em Andamento</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Descrição</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <!-- Itera sobre os chamados e exibe cada um deles em uma linha da tabela -->
        <?php foreach ($chamados as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td> <!-- Exibe o nome do cliente -->
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td> <!-- Exibe o nome do produto -->
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td> <!-- Exibe a descrição do chamado -->
                <td>
                    <!-- Formulário para concluir o chamado -->
                    <form method="post">
                        <input type="hidden" name="chamado_id" value="<?php echo $chamado['id']; ?>"> <!-- ID do chamado -->
                        <button type="submit" name="concluir_chamado" class="btn btn-success">Concluir Chamado</button> <!-- Botão para concluir -->
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
