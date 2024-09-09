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

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];

    // Deletar o usuário
    $query = "DELETE FROM usuarios WHERE id = :usuario_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Encerrar a sessão e redirecionar para a página inicial
        session_destroy();
        header('Location: index.html');
        exit();
    } else {
        echo "Erro ao deletar a conta. Tente novamente mais tarde.";
    }
} else {
    header('Location: perfil.php');
    exit();
}
?>
