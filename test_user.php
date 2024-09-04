<?php
// Incluir o arquivo de conexão ao banco de dados
include_once 'db.php';
include_once 'user.php';

// Instanciar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto User
$user = new User($db);

// Criar um novo usuário
if ($user->create('Miguel Machado', 'miguel@gmail.com', 'senha123')) {
    echo "Usuário criado com sucesso!<br>";
}

// Ler todos os usuários
$stmt = $user->read();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $nome = $row['nome'];
    $email = $row['email'];
    $data_criacao = $row['data_criacao'];
    echo "ID: {$id} - Nome: {$nome} - Email: {$email} - Data de Criação: {$data_criacao}<br>";
}

// Atualizar um usuário pelo ID
if ($user->update(1, 'Miguel Silva')) {
    echo "Usuário atualizado com sucesso!<br>";
}

// Deletar um usuário pelo ID
if ($user->delete(1)) {
    echo "Usuário deletado com sucesso!<br>";
}
?>
