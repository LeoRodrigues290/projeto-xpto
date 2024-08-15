<?php
require '../functions.php';

$pedidos = $conn->query("SELECT * FROM pedidos WHERE status = 'Pendente'");
$materiais_solicitados = $conn->query("SELECT * FROM materiais_solicitados WHERE status = 'Pendente'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizar_estoque'])) {
        $nome_material = $_POST['nome_material'];
        $quantidade = $_POST['quantidade'];

        // Verifica se o material já existe no estoque
        $stmt = $conn->prepare("SELECT id FROM pecas_equipamentos WHERE nome = ?");
        $stmt->bind_param("s", $nome_material);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Atualiza o estoque existente
            $row = $result->fetch_assoc();
            $materialId = $row['id'];
            $stmt = $conn->prepare("UPDATE pecas_equipamentos SET quantidade = quantidade + ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $materialId);
            $stmt->execute();
        } else {
            // Insere novo material no estoque
            $stmt = $conn->prepare("INSERT INTO pecas_equipamentos (nome, quantidade) VALUES (?, ?)");
            $stmt->bind_param("si", $nome_material, $quantidade);
            $stmt->execute();
        }
    }
}

$materiais = listarMateriais();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Almoxarifado</title>
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
    <h1>Almoxarifado</h1>

    <h2 class="mt-5">Pedidos de Materiais</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Material</th>
            <th>Quantidade Solicitada</th>
            <th>Data do Pedido</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($pedido = $pedidos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['peca_equipamento']); ?></td>
                <td><?php echo htmlspecialchars($pedido['quantidade']); ?></td>
                <td><?php echo htmlspecialchars($pedido['data']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Materiais Solicitados por Técnicos</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nome do Material</th>
            <th>Quantidade</th>
            <th>Data da Solicitação</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($solicitacao = $materiais_solicitados->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($solicitacao['nome_material']); ?></td>
                <td><?php echo htmlspecialchars($solicitacao['quantidade']); ?></td>
                <td><?php echo htmlspecialchars($solicitacao['data_solicitacao']); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Atualizar Estoque</h2>
    <form method="post">
        <div class="form-group">
            <label for="nome_material">Nome do Material:</label>
            <input type="text" name="nome_material" id="nome_material" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required>
        </div>
        <button type="submit" name="atualizar_estoque" class="btn btn-primary">Atualizar Estoque</button>
    </form>
</div>
</body>
</html>
