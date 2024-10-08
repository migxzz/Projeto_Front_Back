<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'conectsi';
    private $username = 'root'; // Usuário padrão do MySQL no XAMPP
    private $password = ''; // Senha padrão do MySQL no XAMPP (deixe em branco se não estiver configurada)
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    } //Essa função tenta se conectar a um banco de dados MySQL usando as credenciais fornecidas e retorna a conexão. Se houver um erro, ele captura a exceção e exibe a mensagem de erro correspondente.
}
?>
