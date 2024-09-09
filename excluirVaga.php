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

if (isset($_GET['id'])) {
    $vagaId = $_GET['id'];

    try {
        // Iniciar uma transação
        $db->beginTransaction();

        // Primeiro, exclua as aplicações favoritas que referenciam a vaga
        $stmt = $db->prepare("DELETE FROM aplicacoes_favoritas WHERE vaga_id = :vaga_id");
        $stmt->bindParam(':vaga_id', $vagaId, PDO::PARAM_INT);
        $stmt->execute();

        // Agora, exclua a vaga
        $stmt = $db->prepare("DELETE FROM vagas WHERE id = :id");
        $stmt->bindParam(':id', $vagaId, PDO::PARAM_INT);
        $stmt->execute();

        // Confirmar a transação
        $db->commit();

        // Redirecionar com mensagem de sucesso
        echo "<script>
                alert('Vaga excluída com sucesso.');
                window.location.href = 'paginaPrincipal.php';
              </script>";
    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        $db->rollBack();
        echo "<script>
                alert('Erro ao excluir a vaga: " . addslashes($e->getMessage()) . "');
                window.location.href = 'paginaPrincipal.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID da vaga não especificado.');
            window.location.href = 'paginaPrincipal.php';
          </script>";
}
?>
