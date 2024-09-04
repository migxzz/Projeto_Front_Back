<?php
// Inclui a classe Database e User
include_once 'db.php';
include_once 'user.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data-nascimento'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar-senha'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        die("As senhas não coincidem.");
    }

    // Instancia a classe Database
    $database = new Database();
    $db = $database->getConnection();

    // Instancia a classe User
    $user = new User($db);

    // Define as propriedades do usuário
    $user->nome = $nome;
    $user->sobrenome = $sobrenome;
    $user->email = $email;
    $user->data_nascimento = $data_nascimento;
    $user->senha = $senha;

    // Tenta criar o usuário
    if($user->create()) {
        echo "<script>
                alert('Usuário cadastrado com sucesso!');
                window.location.href = 'index.html';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar o usuário.');
                window.history.back();
              </script>";
    }
}
?>
