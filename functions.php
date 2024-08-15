<?php
require 'db.php';

function registerUser($nome, $email, $senha, $cargo) {
    global $conn;
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, cargo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $hashedPassword, $cargo);
    return $stmt->execute();
}

function authenticateUser($email, $senha) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {
        return $user;
    }
    return false;
}

function getChamadosByStatus($status) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM chamados WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function updateChamadoStatus($id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE chamados SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    return $stmt->execute();
}

function registrarChamado($cliente, $produto, $descricao) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO chamados (cliente, produto, descricao, status) VALUES (?, ?, ?, 'Pendente')");
    $stmt->bind_param("sss", $cliente, $produto, $descricao);
    return $stmt->execute();
}

function solicitarMaterial($chamadoId, $materialId, $quantidade) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pedidos (peca_equipamento, quantidade, data) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $materialId, $quantidade);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE chamados SET status = 'Em Andamento' WHERE id = ?");
    $stmt->bind_param("i", $chamadoId);
    return $stmt->execute();
}

function listarMateriais() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM pecas_equipamentos");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function registrarUsoMaterial($chamadoId, $materiaisQuantidades) {
    global $conn;

    $stmt = $conn->prepare("UPDATE chamados SET status = 'Em andamento' WHERE id = ?");
    $stmt->bind_param("i", $chamadoId);
    $stmt->execute();

    foreach ($materiaisQuantidades as $materialId => $quantidade) {
        if ($quantidade > 0) {
            $stmt = $conn->prepare("INSERT INTO materiais_usados (chamado_id, peca_equipamento, quantidade) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $chamadoId, $materialId, $quantidade);
            $stmt->execute();

            $stmt = $conn->prepare("UPDATE pecas_equipamentos SET quantidade = quantidade - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantidade, $materialId);
            $stmt->execute();
        }
    }
}

function solicitarMaterialAlmoxarifado($nomeMaterial, $quantidade, $tecnicoId) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO materiais_solicitados (nome_material, quantidade, solicitado_por) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $nomeMaterial, $quantidade, $tecnicoId);
    $stmt->execute();
}

function listarPedidos() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM pedidos WHERE status = 'Pendente'");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function listarMateriaisSolicitados() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM materiais_solicitados WHERE status = 'Pendente'");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function atualizarStatusPedido($id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

function atualizarEstoque($materialId, $quantidade) {
    global $conn;
    $stmt = $conn->prepare("UPDATE pecas_equipamentos SET quantidade = quantidade + ? WHERE id = ?");
    $stmt->bind_param("ii", $quantidade, $materialId);
    $stmt->execute();
}

function atualizarStatusChamado($chamadoId, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE chamados SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $chamadoId);
    $stmt->execute();
}

function adicionarMaterialEstoque($nomeMaterial, $quantidade) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO pecas_equipamentos (nome, quantidade) VALUES (?, ?)");
    $stmt->bind_param("si", $nomeMaterial, $quantidade);
    $stmt->execute();
}

function getChamadoById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM chamados WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getMateriaisUsadosByChamado($chamadoId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM materiais_usados WHERE chamado_id = ?");
    $stmt->bind_param("i", $chamadoId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
