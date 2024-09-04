<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public $nome;
    public $sobrenome;
    public $email;
    public $data_nascimento;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para criar um usuário
    public function create() {
        // Verifica se o email já está registrado
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return false; // Email já registrado
        }

        // Insere o novo usuário
        $query = "INSERT INTO " . $this->table_name . " SET nome = :nome, sobrenome = :sobrenome, email = :email, data_nascimento = :data_nascimento, senha = :senha";
        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->sobrenome = htmlspecialchars(strip_tags($this->sobrenome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->data_nascimento = htmlspecialchars(strip_tags($this->data_nascimento));
        $this->senha = htmlspecialchars(strip_tags($this->senha));

        // Criptografa a senha
        $this->senha = password_hash($this->senha, PASSWORD_BCRYPT);

        // Vincula os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':sobrenome', $this->sobrenome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':data_nascimento', $this->data_nascimento);
        $stmt->bindParam(':senha', $this->senha);

        // Executa a query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
