
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistema de Gestão</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="pages/balcao.php">Balcão</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/tecnicos.php">Técnicos</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/analista.php">Analista</a></li>
                <li class="nav-item"><a class="nav-link" href="pages/almoxarifado.php">Almoxarifado</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>