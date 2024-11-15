<?php

class Database {

    private $host = "localhost";
    private $db_name = "financeira";
    private $username = "root";
    private $password = "";
    public $conn;

    // Conectar-se à base de dados usando mysqli_connect
    public function getConexao() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

        if (mysqli_connect_errno()) {
            die("Falha na conexão: " . mysqli_connect_error());
        }

        return $this->conn;
    }

}
?>

