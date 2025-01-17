<?php
include_once './DataBase.php';
include_once './InserirTransacao.php';
// Criar a conexão
$database = new Database();
$db = $database->getConexao();

$publicKeyPath = 'chavePublica.pem';
$publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));


// Consulta para selecionar os dados
$query = "SELECT id, id_utilizador,	tipo_transaccao, montante, descricao, saldo_antes, saldo_depois, dataRegisto FROM transacções_financeiras";
$result = mysqli_query($db, $query);

// Verificar se existem resultados
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        openssl_public_decrypt(base64_decode($row['montante']), $montanteDescriptografado, $publicKey);
        openssl_public_decrypt(base64_decode($row['saldo_antes']), $saldo_antesDescriptografado, $publicKey);
        openssl_public_decrypt(base64_decode($row['saldo_depois']), $saldo_depoisDescriptografado, $publicKey);

        // Exibir os dados do utilizador
        echo "ID: " . $row['id'] . "<br>";
        echo "TIPO DE TRANSACÇÃO: " . $row['tipo_transaccao'] . "<br>";
        echo "MONTANTE: " . $montanteDescriptografado . "<br>";
        echo "DESCRIÇÂO: " .  $row['descricao'] . "<br>";
        echo "SALDO ANTES: " . $saldo_antesDescriptografado . "<br>";
        echo "SALDO DEPOIS: " . $saldo_depoisDescriptografado . "<br>";
       
        
        //echo "Mensagem Descriptografada: " . $descriptografado . "\n";
    }
} else {
    echo "Nenhum utilizador encontrado.";
}

mysqli_close($db);
?>



