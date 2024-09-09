<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit();
}

// Inclua seu arquivo de conexão ao banco de dados aqui
include_once 'db.php';

// Verificar se o ID da vaga foi fornecido via GET
if (isset($_GET['id'])) {
    $vaga_id = $_GET['id'];

    // Instanciar a conexão com o banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // Buscar detalhes da vaga
    $query = "SELECT * FROM vagas WHERE id = :vaga_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':vaga_id', $vaga_id, PDO::PARAM_INT);
    $stmt->execute();
    $vaga = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se o formulário foi enviado para atualizar os dados
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : $vaga['titulo'];
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : $vaga['descricao'];

        // Atualizar a vaga no banco de dados
        $query = "UPDATE vagas SET titulo = :titulo, descricao = :descricao WHERE id = :vaga_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':vaga_id', $vaga_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirecionar para a página principal com mensagem de sucesso
            $_SESSION['message'] = "Vaga atualizada com sucesso!";
            header('Location: paginaPrincipal.php');
            exit();
        } else {
            $_SESSION['message'] = "Erro ao tentar atualizar a vaga. Tente novamente.";
        }
    }
} else {
    // Redirecionar de volta se o ID não foi fornecido
    header('Location: paginaPrincipal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="./styles/styleeditarVaga.css">
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
        <h2>Editar Vaga</h2>
        <form action="editarVaga.php?id=<?php echo $vaga_id; ?>" method="POST">
            <label for="titulo">Título da Vaga:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($vaga['titulo']); ?>" required>

            <label for="descricao">Descrição da Vaga:</label>
            <textarea name="descricao" id="descricao" required><?php echo htmlspecialchars($vaga['descricao']); ?></textarea>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
