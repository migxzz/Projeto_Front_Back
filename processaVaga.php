<?php
// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Obter dados do formulário
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

// Preparar a query para inserir a nova vaga
$query = "INSERT INTO vagas (titulo, descricao) VALUES (:titulo, :descricao)";
$stmt = $db->prepare($query);

// Vincular os parâmetros
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':descricao', $descricao);

// Executar a query e redirecionar
if ($stmt->execute()) {
    // Redirecionar para a página principal
    header("Location: paginaPrincipal.php");
    exit();
} else {
    echo "Erro ao inserir vaga.";
}
?>
