<?php
session_start();

// Verificar se o ID da empresa foi passado via GET
if (!isset($_GET['id'])) {
    echo 'ID da empresa não fornecido.';
    exit();
}

$empresa_id = $_GET['id'];

// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Consultar informações da empresa
$query = "SELECT nome, email, telefone, endereco, descricao FROM empresas WHERE id = :empresa_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
$stmt->execute();
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empresa) {
    echo 'Empresa não encontrada.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Empresa</title>
    <link rel="stylesheet" href="./styles/styleAtualizaEmpresa.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/logoConecTsi.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="paginaPrincipal.php">Página Inicial</a></li>
                <li><a href="inserirVaga.php">Inserir Vaga</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Atualizar Empresa</h2>
        <form action="processarAtualizaEmpresa.php" method="POST">
            <input type="hidden" name="empresa_id" value="<?php echo htmlspecialchars($empresa_id); ?>">

            <label for="nome_empresa">Nome:</label>
            <input type="text" id="nome_empresa" name="nome_empresa" value="<?php echo htmlspecialchars($empresa['nome']); ?>" required>

            <label for="email_empresa">Email:</label>
            <input type="email" id="email_empresa" name="email_empresa" value="<?php echo htmlspecialchars($empresa['email']); ?>" required>

            <label for="telefone_empresa">Telefone:</label>
            <input type="text" id="telefone_empresa" name="telefone_empresa" value="<?php echo htmlspecialchars($empresa['telefone']); ?>" required>

            <label for="endereco_empresa">Endereço:</label>
            <input type="text" id="endereco_empresa" name="endereco_empresa" value="<?php echo htmlspecialchars($empresa['endereco']); ?>" required>

            <label for="descricao_empresa">Descrição:</label>
            <textarea id="descricao_empresa" name="descricao_empresa" required><?php echo htmlspecialchars($empresa['descricao']); ?></textarea>

            <button type="submit" class="btn">Atualizar Empresa</button>
        </form>
    </div>
</body>
</html>
