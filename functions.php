<?php
// Inclui a conexão com o banco de dados
require 'db.php';

// Função para registrar um novo usuário no sistema
function registerUser($nome, $email, $senha, $cargo) {
    global $conn;
    // Criptografa a senha usando bcrypt
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
    // Prepara a query SQL para inserção dos dados do usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, cargo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $hashedPassword, $cargo);
    // Executa a query e retorna true se o registro foi bem-sucedido
    return $stmt->execute();
}

// Função para autenticar um usuário no sistema
function authenticateUser($email, $senha) {
    global $conn;
    // Prepara a query SQL para buscar o usuário pelo email
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifica se a senha fornecida corresponde à senha criptografada no banco de dados
    if ($user && password_verify($senha, $user['senha'])) {
        return $user; // Retorna os dados do usuário se a autenticação for bem-sucedida
    }
    return false; // Retorna false se a autenticação falhar
}

// Função para obter chamados com um status específico
function getChamadosByStatus($status) {
    global $conn;
    // Prepara a query SQL para buscar chamados pelo status
    $stmt = $conn->prepare("SELECT * FROM chamados WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    // Retorna todos os chamados com o status fornecido
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Função para atualizar o status de um chamado específico
function updateChamadoStatus($id, $status) {
    global $conn;
    // Prepara a query SQL para atualizar o status do chamado
    $stmt = $conn->prepare("UPDATE chamados SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    // Executa a query e retorna true se a atualização foi bem-sucedida
    return $stmt->execute();
}

// Função para registrar um novo chamado
function registrarChamado($cliente, $produto, $descricao) {
    global $conn;
    // Prepara a query SQL para inserir um novo chamado com status 'Pendente'
    $stmt = $conn->prepare("INSERT INTO chamados (cliente, produto, descricao, status) VALUES (?, ?, ?, 'Pendente')");
    $stmt->bind_param("sss", $cliente, $produto, $descricao);
    // Executa a query e retorna true se o registro foi bem-sucedido
    return $stmt->execute();
}

// Função para solicitar material para um chamado
function solicitarMaterial($chamadoId, $materialId, $quantidade) {
    global $conn;
    // Prepara a query SQL para inserir um pedido de material
    $stmt = $conn->prepare("INSERT INTO pedidos (peca_equipamento, quantidade, data) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $materialId, $quantidade);
    $stmt->execute();

    // Atualiza o status do chamado para 'Em Andamento'
    $stmt = $conn->prepare("UPDATE chamados SET status = 'Em Andamento' WHERE id = ?");
    $stmt->bind_param("i", $chamadoId);
    // Executa a query e retorna true se a atualização foi bem-sucedida
    return $stmt->execute();
}

// Função para listar todos os materiais disponíveis
function listarMateriais() {
    global $conn;
    // Executa a query SQL para buscar todos os materiais na tabela pecas_equipamentos
    $stmt = $conn->query("SELECT * FROM pecas_equipamentos");
    // Retorna todos os materiais como um array associativo
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

// Função para registrar o uso de materiais em um chamado
function registrarUsoMaterial($chamadoId, $materiaisQuantidades) {
    global $conn;

    // Atualiza o status do chamado para 'Em andamento'
    $stmt = $conn->prepare("UPDATE chamados SET status = 'Em andamento' WHERE id = ?");
    $stmt->bind_param("i", $chamadoId);
    $stmt->execute();

    // Loop através de cada material e sua quantidade
    foreach ($materiaisQuantidades as $materialId => $quantidade) {
        if ($quantidade > 0) {
            // Insere o material usado no chamado
            $stmt = $conn->prepare("INSERT INTO materiais_usados (chamado_id, peca_equipamento, quantidade) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $chamadoId, $materialId, $quantidade);
            $stmt->execute();

            // Atualiza o estoque, subtraindo a quantidade usada
            $stmt = $conn->prepare("UPDATE pecas_equipamentos SET quantidade = quantidade - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $materialId);
            $stmt->execute();
        }
    }
}

// Função para solicitar material ao almoxarifado
function solicitarMaterialAlmoxarifado($nomeMaterial, $quantidade, $tecnicoId) {
    global $conn;
    // Prepara a query SQL para inserir um pedido de material no almoxarifado
    $stmt = $conn->prepare("INSERT INTO materiais_solicitados (nome_material, quantidade, solicitado_por) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nomeMaterial, $quantidade, $tecnicoId);
    $stmt->execute();
}

// Função para listar pedidos pendentes
function listarPedidos() {
    global $conn;
    // Executa a query SQL para buscar todos os pedidos pendentes
    $stmt = $conn->query("SELECT * FROM pedidos WHERE status = 'Pendente'");
    // Retorna todos os pedidos como um array associativo
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

// Função para listar materiais solicitados pendentes
function listarMateriaisSolicitados() {
    global $conn;
    // Executa a query SQL para buscar todos os materiais solicitados pendentes
    $stmt = $conn->query("SELECT * FROM materiais_solicitados WHERE status = 'Pendente'");
    // Retorna todos os materiais solicitados como um array associativo
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

// Função para atualizar o status de um pedido
function atualizarStatusPedido($id, $status) {
    global $conn;
    // Prepara a query SQL para atualizar o status de um pedido
    $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// Função para atualizar o estoque de materiais
function atualizarEstoque($materialId, $quantidade) {
    global $conn;
    // Prepara a query SQL para aumentar a quantidade de um material no estoque
    $stmt = $conn->prepare("UPDATE pecas_equipamentos SET quantidade = quantidade + ? WHERE id = ?");
    $stmt->bind_param("ii", $quantidade, $materialId);
    $stmt->execute();
}

// Função para atualizar o status de um chamado específico
function atualizarStatusChamado($chamadoId, $status) {
    global $conn;
    // Prepara a query SQL para atualizar o status do chamado
    $stmt = $conn->prepare("UPDATE chamados SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $chamadoId);
    $stmt->execute();
}

// Função para adicionar um novo material ao estoque
function adicionarMaterialEstoque($nomeMaterial, $quantidade) {
    global $conn;
    // Prepara a query SQL para inserir um novo material no estoque
    $stmt = $conn->prepare("INSERT INTO pecas_equipamentos (nome, quantidade) VALUES (?, ?)");
    $stmt->bind_param("si", $nomeMaterial, $quantidade);
    $stmt->execute();
}

// Função para obter os detalhes de um chamado específico pelo ID
function getChamadoById($id) {
    global $conn;
    // Prepara a query SQL para buscar um chamado pelo ID
    $stmt = $conn->prepare("SELECT * FROM chamados WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // Retorna os detalhes do chamado como um array associativo
    return $stmt->get_result()->fetch_assoc();
}

// Função para obter os materiais usados em um chamado específico
function getMateriaisUsadosByChamado($chamadoId) {
    global $conn;
    // Prepara a query SQL para buscar os materiais usados em um chamado específico
    $stmt = $conn->prepare("SELECT * FROM materiais_usados WHERE chamado_id = ?");
    $stmt->bind_param("i", $chamadoId);
    $stmt->execute();
    // Retorna todos os materiais usados como um array associativo
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Função para listar todos os chamados
function listarChamados() {
    global $conn;
    // Executa a query SQL para buscar todos os chamados
    $stmt = $conn->query("SELECT * FROM chamados");
    // Retorna todos os chamados como um array associativo
    return $stmt->fetch_all(MYSQLI_ASSOC);
}
?>
