<?php
require '../functions.php'; // Inclui o arquivo de funções para manipulação do banco de dados

// Obtém todos os pedidos e materiais solicitados com status 'Pendente'
$pedidos = $conn->query("SELECT * FROM pedidos WHERE status = 'Pendente'");
$materiais_solicitados = $conn->query("SELECT * FROM materiais_solicitados WHERE status = 'Pendente'");

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o formulário de atualização de estoque foi enviado
    if (isset($_POST['atualizar_estoque'])) {
        $nome_material = $_POST['nome_material'];
        $quantidade = $_POST['quantidade'];

        // Prepara e executa a consulta para verificar se o material já existe no estoque
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

// Função para listar materiais do estoque
function listarMateriais() {
    global $conn;
    return $conn->query("SELECT * FROM pecas_equipamentos");
}

$materiais = listarMateriais(); // Obtém a lista de materiais do estoque
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Almoxarifado</title>
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
    <h1>Almoxarifado</h1>

    <!-- Exibe a lista de pedidos de materiais -->
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
        <!-- Itera sobre os pedidos e exibe cada um em uma linha da tabela -->
        <?php while ($pedido = $pedidos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['peca_equipamento']); ?></td> <!-- Exibe o nome da peça -->
                <td><?php echo htmlspecialchars($pedido['quantidade']); ?></td> <!-- Exibe a quantidade solicitada -->
                <td><?php echo htmlspecialchars($pedido['data']); ?></td> <!-- Exibe a data do pedido -->
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Exibe a lista de materiais solicitados por técnicos -->
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
        <!-- Itera sobre as solicitações de materiais e exibe cada uma em uma linha da tabela -->
        <?php while ($solicitacao = $materiais_solicitados->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($solicitacao['nome_material']); ?></td> <!-- Exibe o nome do material -->
                <td><?php echo htmlspecialchars($solicitacao['quantidade']); ?></td> <!-- Exibe a quantidade solicitada -->
                <td><?php echo htmlspecialchars($solicitacao['data_solicitacao']); ?></td> <!-- Exibe a data da solicitação -->
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulário para atualizar o estoque -->
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
