<?php
// Inicia a sessão para rastrear o estado do usuário
session_start();

// Inclui o arquivo de funções que contém a lógica de autenticação
require 'functions.php';

// Verifica se o método de requisição é POST, indicando o envio do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta o email e a senha enviados pelo formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Autentica o usuário usando a função authenticateUser definida em functions.php
    $user = authenticateUser($email, $senha);

    // Verifica se a autenticação foi bem-sucedida
    if ($user) {
        // Armazena o ID do usuário na sessão e redireciona para o dashboard
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        // Se a autenticação falhar, define uma mensagem de erro
        $error = "Email ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Inclui o CSS do Bootstrap para estilização -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center">Login</h2>

                    <!-- Exibe uma mensagem de erro se houver -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Formulário de login -->
                    <form action="login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <!-- Campo para entrada do email -->
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <!-- Campo para entrada da senha -->
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <!-- Botão para enviar o formulário -->
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        <!-- Links para recuperação de senha e cadastro -->
                        <a href="#" class="btn btn-link btn-block">Esqueci minha senha</a>
                        <a href="cadastro.php" class="btn btn-link btn-block">Cadastrar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
