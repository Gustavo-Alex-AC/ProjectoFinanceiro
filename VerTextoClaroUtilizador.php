<?php
include_once './DataBase.php';
include_once './InserirUtilizador.php';
// Criar a conexão
$database = new Database();
$db = $database->getConexao();

$publicKeyPath = 'chavePublica.pem';
$publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));


// Consulta para selecionar os dados
$query = "SELECT id, nome, email, telefone, endereco, password, dataRegisto FROM utilizador";
$result = mysqli_query($db, $query);

// Verificar se existem resultados
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        openssl_public_decrypt(base64_decode($row['email']), $emailDescriptografado, $publicKey);
        openssl_public_decrypt(base64_decode($row['telefone']), $telefoneDescriptografado, $publicKey);
        openssl_public_decrypt(base64_decode($row['endereco']), $enderecoDescriptografado, $publicKey);

        // Exibir os dados do utilizador
        echo "ID: " . $row['id'] . "<br>";
        echo "Nome: " . $row['nome'] . "<br>";
        echo "Email: " . $emailDescriptografado . "<br>";
        echo "Telefone: " . $telefoneDescriptografado . "<br>";
        echo "Endereço: " . $enderecoDescriptografado . "<br>";
        echo "Password: " . $row['password'] . "<br>";
        echo "Data de Criação: " . $row['dataRegisto'] . "<br><br>";
        
        //echo "Mensagem Descriptografada: " . $descriptografado . "\n";
    }
} else {
    echo "Nenhum utilizador encontrado.";
}

mysqli_close($db);
?>



