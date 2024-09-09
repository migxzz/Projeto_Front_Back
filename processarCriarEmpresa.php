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

// Obter os dados do formulário e sanitizar
$nome_empresa = filter_var($_POST['nome_empresa'], FILTER_SANITIZE_STRING);
$email_empresa = filter_var($_POST['email_empresa'], FILTER_SANITIZE_EMAIL);
$telefone_empresa = filter_var($_POST['telefone_empresa'], FILTER_SANITIZE_STRING);
$endereco_empresa = filter_var($_POST['endereco_empresa'], FILTER_SANITIZE_STRING);
$usuario_id = $_SESSION['usuario_id'];

try {
    // Inserir a empresa no banco de dados
    $query = "INSERT INTO empresas (nome, email, telefone, endereco, usuario_id) 
              VALUES (:nome_empresa, :email_empresa, :telefone_empresa, :endereco_empresa, :usuario_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nome_empresa', $nome_empresa, PDO::PARAM_STR);
    $stmt->bindParam(':email_empresa', $email_empresa, PDO::PARAM_STR);
    $stmt->bindParam(':telefone_empresa', $telefone_empresa, PDO::PARAM_STR);
    $stmt->bindParam(':endereco_empresa', $endereco_empresa, PDO::PARAM_STR);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirecionar para o perfil do usuário
    header('Location: perfil.php');
    exit();
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
