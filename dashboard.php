<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

// Verifica se o usuário está logado, ou seja, se a variável de sessão 'user_id' está definida
if (!isset($_SESSION['user_id'])) {
    // Se o usuário não estiver logado, redireciona para a página de login
    header('Location: login.php');
    // Interrompe a execução do script após o redirecionamento
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o conjunto de caracteres como UTF-8 para suporte a caracteres especiais -->
    <meta charset="UTF-8">
    <!-- Define o título da página -->
    <title>Dashboard</title>
    <!-- Inclui a folha de estilos do Bootstrap para estilização responsiva -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Cria uma barra de navegação usando componentes do Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Título do sistema na barra de navegação -->
    <a class="navbar-brand" href="#">Sistema de Gestão</a>
    <!-- Configuração do menu de navegação -->
    <div class="collapse navbar-collapse">
        <!-- Lista de itens do menu de navegação -->
        <ul class="navbar-nav ml-auto">
            <!-- Link para a página 'Balcão' -->
            <li class="nav-item"><a class="nav-link" href="pages/balcao.php">Balcão</a></li>
            <!-- Link para a página 'Técnico Externo' -->
            <li class="nav-item"><a class="nav-link" href="pages/tecnico-externo.php">Tecnico Externo</a></li>
            <!-- Link para a página 'Técnico Manutenção' -->
            <li class="nav-item"><a class="nav-link" href="pages/tecnico-manutencao.php">Técnico Manutenção</a></li>
            <!-- Link para a página 'Almoxarifado' -->
            <li class="nav-item"><a class="nav-link" href="pages/almoxarifado.php">Almoxarifado</a></li>
        </ul>
    </div>
</nav>

<!-- Container principal para o conteúdo da página -->
<div class="container mt-5">
    <!-- Cabeçalho centralizado com a mensagem de boas-vindas -->
    <h1 class="text-center">Bem-vindo ao Dashboard</h1>
</div>
</body>
</html>
