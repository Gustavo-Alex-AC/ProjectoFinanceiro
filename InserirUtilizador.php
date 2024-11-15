<?php

class Utilizador {

    private $conn;
    private $table_name = "utilizador";

    // Construtor
    public function __construct($db) {
        $this->conn = $db;
    }
    // Inserir novo utilizador
    public function inserir($nome, $email, $telefone, $endereco, $password) {

        // Caminho para as chaves geradas
        $privateKeyPath = 'chavePrivada.pem';
       
// Carrega a chave privada
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));
// Criptografa a mensagem com a chave privada
        openssl_private_encrypt($email, $emailCriptografado, $privateKey);
        openssl_private_encrypt($telefone, $telefoneCriptografado, $privateKey);
        openssl_private_encrypt($endereco, $enderecoCriptografado, $privateKey);
        // Gerar o hash da password com SHA-256
        $passwordHash = hash('sha256', $password);

        $emailCriptografado = base64_encode($emailCriptografado);
        $telefoneCriptografado = base64_encode($telefoneCriptografado);
        $enderecoCriptografado = base64_encode($enderecoCriptografado);
        // Inserir dados na base de dados
        $query = "INSERT INTO " . $this->table_name . " (nome, email, telefone, endereco, password) VALUES ('$nome', '$emailCriptografado', '$telefoneCriptografado', '$enderecoCriptografado', '$passwordHash')";

        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            echo "Erro: " . mysqli_error($this->conn);
            return false;
        }
    }

}
?>

