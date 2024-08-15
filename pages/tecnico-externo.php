<?php
require '../functions.php';

$chamados = getChamadosByStatus('Pendente');
$materiais = listarMateriais();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registrar_uso_material'])) {
        registrarUsoMaterial($_POST['chamado_id'], $_POST['materiais'], $_POST['quantidade']);
    } elseif (isset($_POST['solicitar_material'])) {
        solicitarMaterialAlmoxarifado($_POST['nome_material'], $_POST['quantidade'], $_POST['tecnico_id']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Técnico Externo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Sistema de Gestão</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="balcao.php">Balcão</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnico-externo.php">Tecnico Externo</a></li>
            <li class="nav-item"><a class="nav-link" href="tecnico-manutencao.php">Técnico Manutenção</a></li>

            <li class="nav-item"><a class="nav-link" href="almoxarifado.php">Almoxarifado</a></li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h1>Técnico Externo</h1>

    <h2 class="mt-5">Chamados Pendentes</h2>
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
        <?php foreach ($chamados as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td>
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td>
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="chamado_id" value="<?php echo $chamado['id']; ?>">

                        <h3>Materiais a serem usados:</h3>
                        <?php foreach ($materiais as $material): ?>
                            <div class="form-group">
                                <label><?php echo htmlspecialchars($material['nome']); ?></label>
                                <input type="number" name="quantidade[<?php echo $material['id']; ?>]" class="form-control" min="0">
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" name="registrar_uso_material" class="btn btn-primary">Registrar Uso de Materiais</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Solicitar Novo Material ao Almoxarifado</h2>
    <form method="post">
        <div class="form-group">
            <label for="nome_material">Nome do Material:</label>
            <input type="text" name="nome_material" id="nome_material" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required>
        </div>
        <input type="hidden" name="tecnico_id" value="<?php echo $_SESSION['usuario_id']; ?>">
        <button type="submit" name="solicitar_material" class="btn btn-secondary">Solicitar Material</button>
    </form>
</div>
</body>
</html>
