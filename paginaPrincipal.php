<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}

// Inclua seu arquivo de conexão ao banco de dados aqui
include_once 'db.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Obter palavra-chave do filtro
$searchKeyword = isset($_POST['search']) ? $_POST['search'] : '';

// Consultar vagas com base na palavra-chave
$query = "SELECT id, titulo, descricao FROM vagas WHERE titulo LIKE :searchKeyword OR descricao LIKE :searchKeyword";
$stmt = $db->prepare($query);
$searchKeywordParam = "%{$searchKeyword}%";
$stmt->bindParam(':searchKeyword', $searchKeywordParam, PDO::PARAM_STR);
$stmt->execute();
$vagas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="./styles/stylepagPrincipal.css">
    <script src="./src/paginaPrincipal.js" defer></script>
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
        <div class="search-bar">
            <form action="paginaPrincipal.php" method="POST" id="searchForm">
                <input type="text" name="search" placeholder="Buscar vagas..." value="<?php echo htmlspecialchars($searchKeyword); ?>">
                <button class="buscar" type="submit">Buscar</button>
            </form>
        </div>

        <div class="vagas-section">
            <h2>Vagas Disponíveis</h2>
            <?php if (count($vagas) > 0): ?>
                <?php foreach ($vagas as $vaga): ?>
                    <?php
                    // Limitar a descrição a 2 ou 3 palavras
                    $words = explode(' ', $vaga['descricao']);
                    $shortDescription = implode(' ', array_slice($words, 0, 3));
                    ?>
                    <div class="vaga-card">
                        <h3><?php echo htmlspecialchars($vaga['titulo']); ?></h3>
                        <p class="short-description"><?php echo htmlspecialchars($shortDescription); ?></p>
                        <p class="full-description"><?php echo htmlspecialchars($vaga['descricao']); ?></p>
                        <button class="toggle-details-btn">Ver Mais</button>
                        <a href="vagaDetalhes.php?id=<?php echo $vaga['id']; ?>" class="btn">Ver Detalhes</a>
                        <!-- Adicionar botão de edição e exclusão -->
                        <a href="editarVaga.php?id=<?php echo $vaga['id']; ?>" class="btn editar-btn">Editar</a>
                        <a href="excluirVaga.php?id=<?php echo $vaga['id']; ?>" class="btn excluir-btn">Excluir</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Atualmente, não há vagas disponíveis no sistema.</p>
            <?php endif; ?>
            <button onclick="window.location.href='inserirVaga.php'">Inserir Nova Vaga</button>
        </div>
    </div>
</body>
</html>
