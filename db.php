<?php
// Definindo as credenciais de conexão com o banco de dados
$servername = "localhost";  // Endereço do servidor (geralmente "localhost" para servidor local)
$username = "root";         // Nome de usuário para acessar o banco de dados
$password = "";             // Senha associada ao usuário (vazio para servidor local sem senha)
$dbname = "sistema_xpto";   // Nome do banco de dados ao qual você deseja se conectar

// Criando uma nova conexão com o banco de dados usando MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se ocorrer um erro, a execução é interrompida e a mensagem de erro é exibida
    die("Connection failed: " . $conn->connect_error);
}

// Se a conexão for bem-sucedida, o script continuará normalmente
?>
