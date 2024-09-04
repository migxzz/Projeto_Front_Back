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

// Obter o ID da vaga e do usuário
$vaga_id = $_POST['vaga_id'];
$usuario_id = $_SESSION['usuario_id'];

// Verificar se a vaga já foi favoritada
$query = "SELECT * FROM aplicacoes_favoritas WHERE usuario_id = :usuario_id AND vaga_id = :vaga_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->bindParam(':vaga_id', $vaga_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    // Inserir a vaga como favorita
    $query = "INSERT INTO aplicacoes_favoritas (usuario_id, vaga_id, data_favorito) VALUES (:usuario_id, :vaga_id, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':vaga_id', $vaga_id, PDO::PARAM_INT);
    $stmt->execute();
}

header('Location: perfil.php');
exit();
?>
