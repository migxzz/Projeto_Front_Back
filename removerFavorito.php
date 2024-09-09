<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}

// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Obter o ID da vaga e do usuário de forma segura
$vaga_id = filter_input(INPUT_POST, 'vaga_id', FILTER_VALIDATE_INT);
$usuario_id = $_SESSION['usuario_id'];

if ($vaga_id === false) {
    // Se o ID da vaga não for válido, redireciona o usuário
    header('Location: perfil.php');
    exit();
}

// Remover a vaga dos favoritos
$query = "DELETE FROM aplicacoes_favoritas WHERE usuario_id = :usuario_id AND vaga_id = :vaga_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->bindParam(':vaga_id', $vaga_id, PDO::PARAM_INT);
$stmt->execute();

// Redirecionar para o perfil do usuário
header('Location: perfil.php');
exit();
?>
