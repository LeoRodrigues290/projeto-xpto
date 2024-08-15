<?php
session_start(); // Inicia a sessão para gerenciar variáveis de sessão

require 'functions.php'; // Inclui o arquivo com as funções de manipulação do banco de dados

// Verifica se o método de requisição é POST, indicando o envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome']; // Captura o nome enviado pelo formulário
    $email = $_POST['email']; // Captura o email enviado pelo formulário
    $senha = $_POST['senha']; // Captura a senha enviada pelo formulário
    $cargo = $_POST['cargo']; // Captura o cargo selecionado no formulário

    // Chama a função para registrar o usuário e verifica se a operação foi bem-sucedida
    if(registerUser($nome, $email, $senha, $cargo)){
        $success = "Usuário cadastrado com sucesso!"; // Define mensagem de sucesso
    } else {
        $error = "Falha ao cadastrar o usuário!"; // Define mensagem de erro
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>

    <!-- Link para o CSS do Bootstrap para estilização -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center">Cadastro de Usuário</h2>

                    <!-- Exibe mensagem de sucesso, se definida -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <!-- Exibe mensagem de erro, se definida -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Formulário de cadastro de usuário -->
                    <form action="cadastro.php" method="post">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <select class="form-control" name="cargo" id="cargo" required>
                                <option value="Balcão">Balcão</option>
                                <option value="Técnicos Externo">Técnicos</option>
                                <option value="Analista Contábil">Analista</option>
                                <option value="Almoxarifado">Almoxarifado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                        <a class="btn btn-link btn-block" href="login.php">Voltar ao Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
