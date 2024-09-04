<?php
session_start();
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Instanciar a conexão com o banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // Preparar a consulta para verificar o usuário
    $query = "SELECT id, senha FROM usuarios WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Iniciar a sessão e redirecionar para a página principal
            $_SESSION['usuario_id'] = $usuario['id'];
            header('Location: paginaPrincipal.php');
            exit();
        } else {
            echo "Email ou senha incorretos.";
        }
    } else {
        echo "Email ou senha incorretos.";
    }
}
?>
