<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}

// Verificar se o ID da empresa foi passado via POST
if (!isset($_POST['empresa_id'])) {
    echo 'ID da empresa não fornecido.';
    exit();
}

$empresa_id = $_POST['empresa_id'];

// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Deletar a empresa do banco de dados
$query = "DELETE FROM empresas WHERE id = :empresa_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
$stmt->execute();

// Redirecionar para a página de perfil ou onde desejar
header('Location: perfil.php');
exit();
?>
