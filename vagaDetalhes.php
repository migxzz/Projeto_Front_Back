<?php
// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'] ?? 0;

// Preparar a query para buscar os detalhes da vaga
$query = "SELECT * FROM vagas WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$vaga = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vaga) {
    echo "Vaga não encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Vaga</title>
    <link rel="stylesheet" href="./styles/styleDetalhesVaga.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/logoConecTsi.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="./paginaPrincipal.php">Página Inicial</a></li>
                <li><a href="./inserirVaga.php">Inserir Vaga</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <div class="vaga-detalhes">
            <h2><?php echo htmlspecialchars($vaga['titulo']); ?></h2>
            <p><?php echo htmlspecialchars($vaga['descricao']); ?></p>
            <form action="favoritarVaga.php" method="POST">
                <input type="hidden" name="vaga_id" value="<?php echo htmlspecialchars($vaga['id']); ?>">
                <button type="submit">Marcar como Favorita</button>
            </form>
            <a href="./paginaPrincipal.php">Voltar</a>
        </div>
    </div>
</body>
</html>
