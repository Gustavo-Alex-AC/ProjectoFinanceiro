<?php

class Transacao {

    private $conn;
    private $table_name = "transacções_financeiras";

    // Construtor
    public function __construct($db) {
        $this->conn = $db;
    }
    // Inserir nova transacao
    
    public function inserir($id_utilizador, $tipo_transaccao, $montante, $descricao, $saldo_antes, $saldo_depois) {

        // Caminho para as chaves geradas
        $privateKeyPath = 'chavePrivada.pem';
       
// Carrega a chave privada
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));
// Criptografa a mensagem com a chave privada
        openssl_private_encrypt($montante, $montanteCriptografado, $privateKey);
        openssl_private_encrypt($saldo_antes, $saldo_antesCriptografado, $privateKey);
        openssl_private_encrypt($saldo_depois, $saldo_depoisCriptografado, $privateKey);
        // Gerar o hash da password com SHA-256
        //$passwordHash = hash('sha256', $password);

        $montante = base64_encode($montante);
        $saldo_antes = base64_encode($saldo_antes);
        $saldo_depois = base64_encode($saldo_depois);
        
        // Inserir dados na base de dados
        $query = "INSERT INTO " . $this->table_name . " (id_utilizador, tipo_transaccao, montante, descricao, saldo_antes, saldo_depois) VALUES ('$id_utilizador', '$tipo_transaccao', '$montante', '$descricao', '$saldo_antes', '$saldo_depois')";

        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            echo "Erro: " . mysqli_error($this->conn);
            return false;
        }
    }

}
?>

