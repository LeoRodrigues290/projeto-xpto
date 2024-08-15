<?php
// Inicia a sessão para acessar ou criar variáveis de sessão
session_start();

// Verifica se o usuário já está autenticado
if (isset($_SESSION['user_id'])) {
    // Se o usuário estiver autenticado, redireciona para o dashboard
    header('Location: dashboard.php');
} else {
    // Se o usuário não estiver autenticado, redireciona para a página de login
    header('Location: login.php');
}

// Encerra o script após o redirecionamento para evitar execução de código adicional
exit;
?>
