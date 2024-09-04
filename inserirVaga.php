<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Vaga</title>
    <link rel="stylesheet" href="./styles/styleInserirVaga.css">
    <script src="./src/inserirVaga.js" defer></script>
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
        <div class="vagas-section">
            <h2>Inserir Nova Vaga</h2>
            <form id="vagaForm" action="processaVaga.php" method="POST">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
                
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
                
                <button type="submit">Inserir Vaga</button>
            </form>
        </div>
    </div>
</body>
</html>
