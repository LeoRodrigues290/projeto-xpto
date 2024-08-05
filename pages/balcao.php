<?php

require '../functions.php';
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
            <!-- NF-e -->
            <button type="submit" class="btn btn-primary">Adicionar Produto</button>
        </form>

        <!-- Abrir Chamado -->
         <form action="">
            <!-- Titulo do Chamado -->
            <!-- Seletor de Profissional Externo ou Manutencao -->
         </form>


         <div class="orcamento-content">
             <!-- Orçamento Gerado pelos Técnicos -->
             <!-- Valor, Prazo, Botao para Aceitar ou Recusar Orçamento -->
         </div>
    </div>
</body>
</html>
