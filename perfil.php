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

// Consultar informações do usuário
$query = "SELECT nome, email, foto FROM usuarios WHERE id = :usuario_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultar vagas favoritas
$query = "SELECT vagas.id, vagas.titulo, vagas.descricao FROM vagas
          INNER JOIN aplicacoes_favoritas ON vagas.id = aplicacoes_favoritas.vaga_id
          WHERE aplicacoes_favoritas.usuario_id = :usuario_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':usuario_id', $_SESSION['usuario_id'], PDO::PARAM_INT);
$stmt->execute();
$vagasFavoritas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="./styles/stylePerfil.css">
    <script src="./src/geolocation.js" defer></script>
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Perfil de <?php echo htmlspecialchars($usuario['nome']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>
        <div class="foto-perfil">
            <!-- Ajustar o caminho para a imagem -->
            <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de perfil">
        </div>

        <h3>Vagas Favoritas</h3>
        <ul>
            <?php if (count($vagasFavoritas) > 0): ?>
                <?php foreach ($vagasFavoritas as $vaga): ?>
                    <li class="vaga-favorita">
                        <h4>
                            <a href="vagaDetalhes.php?id=<?php echo htmlspecialchars($vaga['id']); ?>">
                                <?php echo htmlspecialchars($vaga['titulo']); ?>
                            </a>
                        </h4>
                        <p><?php echo htmlspecialchars(substr($vaga['descricao'], 0, 100)) . '...'; ?></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você ainda não tem vagas favoritas.</p>
            <?php endif; ?>
        </ul>

        <h3>Localização Atual</h3>
        <p id="location">Obtendo localização...</p>
        
        <!-- Botão para atualizar perfil -->
        <div class="update-profile">
            <a href="atualizaPerfil.php" class="btn">Atualizar Perfil</a>
        </div>
    </div>
</body>
</html>
