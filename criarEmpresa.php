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
    <title>Criar Empresa</title>
    <link rel="stylesheet" href="./styles/styleCriarEmpresa.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./images/logoConecTsi.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="paginaPrincipal.php">Página Inicial</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Criar Nova Empresa</h2>
        <form action="processarCriarEmpresa.php" method="POST">
            <label for="nome_empresa">Nome da Empresa:</label>
            <input type="text" id="nome_empresa" name="nome_empresa" required>
            
            <label for="email_empresa">Email:</label>
            <input type="email" id="email_empresa" name="email_empresa" required>

            <label for="telefone_empresa">Telefone:</label>
            <input type="tel" id="telefone_empresa" name="telefone_empresa" required>

            <label for="endereco_empresa">Endereço:</label>
            <textarea id="endereco_empresa" name="endereco_empresa" required></textarea>
            
            <button type="submit" class="btn">Criar Empresa</button>
        </form>
    </div>
</body>
</html>
