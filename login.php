<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $user = authenticateUser($email, $senha);

    if ($user) {
        $_SESSION['user_id'] = $user ['id'];
        header('Location: dashboard.php');
        exit;
    } else {
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                    <h2 class="card-title text-center">Login</h2>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>   

                    <form action="login.php" method="post">
                       <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                       </div>
                       <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                       </div> 
                       <button type="submit" class="btn btn-primary btn-block">Entrar</button> 
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