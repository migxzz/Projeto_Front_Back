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

// Obter os dados do formulário
$empresa_id = $_POST['empresa_id'];
$nome_empresa = $_POST['nome_empresa'];
$email_empresa = $_POST['email_empresa'];
$telefone_empresa = $_POST['telefone_empresa'];
$endereco_empresa = $_POST['endereco_empresa'];
$descricao_empresa = $_POST['descricao_empresa'];

// Atualizar a empresa no banco de dados
$query = "UPDATE empresas SET nome = :nome_empresa, email = :email_empresa, telefone = :telefone_empresa, endereco = :endereco_empresa, descricao = :descricao_empresa WHERE id = :empresa_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':nome_empresa', $nome_empresa, PDO::PARAM_STR);
$stmt->bindParam(':email_empresa', $email_empresa, PDO::PARAM_STR);
$stmt->bindParam(':telefone_empresa', $telefone_empresa, PDO::PARAM_STR);
$stmt->bindParam(':endereco_empresa', $endereco_empresa, PDO::PARAM_STR);
$stmt->bindParam(':descricao_empresa', $descricao_empresa, PDO::PARAM_STR);
$stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
$stmt->execute();

// Redirecionar para a página de detalhes da empresa
header('Location: empresaDetalhes.php?id=' . $empresa_id);
exit();
?>
