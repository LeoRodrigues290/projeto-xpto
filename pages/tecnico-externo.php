<?php
require '../functions.php'; // Inclui o arquivo de funções que contém as funções para manipulação do banco de dados

// Obtém todos os chamados com status 'Pendente'
$chamados = getChamadosByStatus('Pendente');

// Lista todos os materiais disponíveis
$materiais = listarMateriais();

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o formulário de registro de uso de material foi enviado
    if (isset($_POST['registrar_uso_material'])) {
        // Registra o uso dos materiais selecionados para o chamado específico
        registrarUsoMaterial($_POST['chamado_id'], $_POST['materiais'], $_POST['quantidade']);
    }
    // Verifica se o formulário de solicitação de material ao almoxarifado foi enviado
    elseif (isset($_POST['solicitar_material'])) {
        // Solicita um novo material ao almoxarifado
        solicitarMaterialAlmoxarifado($_POST['nome_material'], $_POST['quantidade'], $_POST['tecnico_id']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Técnico Externo</title>
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
        <!-- Itera sobre os chamados pendentes e exibe cada um deles em uma linha da tabela -->
        <?php foreach ($chamados as $chamado): ?>
            <tr>
                <td><?php echo htmlspecialchars($chamado['cliente']); ?></td> <!-- Exibe o nome do cliente -->
                <td><?php echo htmlspecialchars($chamado['produto']); ?></td> <!-- Exibe o nome do produto -->
                <td><?php echo htmlspecialchars($chamado['descricao']); ?></td> <!-- Exibe a descrição do chamado -->
                <td>
                    <!-- Formulário para registrar o uso de materiais no chamado -->
                    <form method="post">
                        <input type="hidden" name="chamado_id" value="<?php echo $chamado['id']; ?>"> <!-- ID do chamado -->

                        <h3>Materiais a serem usados:</h3>
                        <!-- Itera sobre os materiais disponíveis e cria um campo para registrar a quantidade usada -->
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
    <!-- Formulário para solicitar um novo material ao almoxarifado -->
    <form method="post">
        <div class="form-group">
            <label for="nome_material">Nome do Material:</label>
            <input type="text" name="nome_material" id="nome_material" class="form-control" required> <!-- Campo para o nome do material -->
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" required> <!-- Campo para a quantidade solicitada -->
        </div>
        <input type="hidden" name="tecnico_id" value="<?php echo $_SESSION['usuario_id']; ?>"> <!-- ID do técnico logado -->
        <button type="submit" name="solicitar_material" class="btn btn-secondary">Solicitar Material</button> <!-- Botão para enviar a solicitação -->
    </form>
</div>
</body>
</html>
