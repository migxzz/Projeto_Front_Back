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

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $foto = $_FILES['foto']['name'] ?? '';
    $foto_temp = $_FILES['foto']['tmp_name'] ?? '';

    // Validação básica
    if (empty($nome) || empty($email)) {
        echo "Nome e email são obrigatórios.";
    } else {
        try {
            // Atualiza as informações do usuário
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':nome' => $nome, ':email' => $email, ':id' => $_SESSION['usuario_id']]);

            // Processa o upload da foto, se houver
            if (!empty($foto)) {
                // Define o diretório de upload e o caminho do arquivo
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($foto);

                // Move o arquivo para o diretório de upload
                if (move_uploaded_file($foto_temp, $target_file)) {
                    // Atualiza o caminho da foto no banco de dados
                    $sql = "UPDATE usuarios SET foto = :foto WHERE id = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([':foto' => $target_file, ':id' => $_SESSION['usuario_id']]);
                } else {
                    echo "Erro ao fazer upload da foto.";
                }
            }

            echo "Perfil atualizado com sucesso.";
            // Redireciona para a página do perfil após a atualização
            header('Location: perfil.php');
            exit();

        } catch (PDOException $e) {
            echo "Erro ao atualizar perfil: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Perfil</title>
    <link rel="stylesheet" href="styles/styleatualizaPerfil.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logoConecTsi.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="paginaPrincipal.php">Página Inicial</a></li>
                <li><a href="perfil.php">Perfil</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <div class="perfil-card">
            <div class="perfil-section">
                <h2>Atualizar Perfil</h2>
                <form action="atualizaPerfil.php" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

                    <label for="foto">Foto de Perfil:</label>
                    <input type="file" id="foto" name="foto">

                    <button type="submit" class="btn">Atualizar Perfil</button>
                </form>
            </div>

            <div class="foto-perfil">
                <img src="<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de Perfil">
            </div>
        </div>
    </div>
</body>
</html>
