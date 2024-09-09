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
    <title>Detalhes da Empresa</title>
    <link rel="stylesheet" href="./styles/styleEmpresaDetalhes.css">
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
        <h2>Detalhes da Empresa</h2>
        <h3><?php echo htmlspecialchars($empresa['nome']); ?></h3>
        <p>Email: <?php echo htmlspecialchars($empresa['email']); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($empresa['telefone']); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($empresa['endereco']); ?></p>
        <p>Descrição: <?php echo htmlspecialchars($empresa['descricao']); ?></p>

        <div class="update-empresa">
            <a href="atualizaEmpresa.php?id=<?php echo htmlspecialchars($empresa_id); ?>" class="btn">Atualizar Empresa</a>
        </div>

        <!-- Botão para deletar empresa -->
        <div class="delete-empresa">
            <form action="deletarEmpresa.php" method="POST" onsubmit="return confirm('Tem certeza de que deseja deletar esta empresa? Esta ação é irreversível.');">
                <input type="hidden" name="empresa_id" value="<?php echo htmlspecialchars($empresa_id); ?>">
                <button type="submit" class="btn btn-danger">Deletar Empresa</button>
            </form>
        </div>
    </div>
</body>
</html>
