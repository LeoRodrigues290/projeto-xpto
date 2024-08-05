<?php

require '../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add_produto':
            $cliente = $_POST['cliente'];
            $produto = $_POST['produto'];
            $numero_de_serie = $_POST['numero_de_serie'];
            $descricao_problema = $_POST['descricao_problema'];
            $garantia = isset($_POST['garantia']) ? 1 : 0;
            $orcamento = $_POST['orcamento'];
            addProduto($cliente, $produto, $numero_de_serie, $descricao_problema, $garantia, $orcamento);
            break;
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
    <div class="container mt-5">
        <h1>Balcão</h1>
        <form method="post">
            <input type="hidden" name="action" value="add_produto">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <input type="text" class="form-control" id="cliente" name="cliente" required>
            </div>
            <div class="form-group">
                <label for="produto">Produto</label>
                <input type="text" class="form-control" id="produto" name="produto" required>
            </div>
            <div class="form-group">
                <label for="numero_de_serie">Número de Série</label>
                <input type="text" class="form-control" id="numero_de_serie" name="numero_de_serie" required>
            </div>
            <div class="form-group">
                <label for="descricao_problema">Descrição do Problema</label>
                <textarea class="form-control" id="descricao_problema" name="descricao_problema" rows="3" required></textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="garantia" name="garantia">
                <label class="form-check-label" for="garantia">Garantia</label>
            </div>
            <div class="form-group">
                <label for="orcamento">Orçamento</label>
                <input type="number" step="0.01" class="form-control" id="orcamento" name="orcamento" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Produto</button>
        </form>

        <h2 class="mt-5">Lista de Produtos</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Número de Série</th>
                    <th>Descrição do Problema</th>
                    <th>Garantia</th>
                    <th>Orçamento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($produto['cliente']); ?></td>
                        <td><?php echo htmlspecialchars($produto['produto']); ?></td>
                        <td><?php echo htmlspecialchars($produto['numero_de_serie']); ?></td>
                        <td><?php echo htmlspecialchars($produto['descricao_problema']); ?></td>
                        <td><?php echo $produto['garantia'] ? 'Sim' : 'Não'; ?></td>
                        <td><?php echo htmlspecialchars($produto['orcamento']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
