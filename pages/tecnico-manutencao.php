<?php
require '../functions.php';

$chamados = getChamadosByStatus('Em Andamento');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['concluir_chamado'])) {
        updateChamadoStatus($_POST['chamado_id'], 'Concluído');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Técnico Manutenção</title>
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
    <h1>Técnico Manutenção</h1>

    <h2 class="mt-5">Chamados em Andamento</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Descrição</th>
            <th>Materiais Usados</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($chamados as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td>
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td>
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td>
                <td>
                    <ul>
                        <?php
                        $materiaisUsados = getMateriaisUsadosByChamado($chamado['id']);
                        foreach ($materiaisUsados as $material): ?>
                            <li><?php echo htmlspecialchars($material['peca_equipamento']) . ' - ' . htmlspecialchars($material['quantidade']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="chamado_id" value="<?php echo $chamado['id']; ?>">
                        <button type="submit" name="concluir_chamado" class="btn btn-success">Concluir Chamado</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
