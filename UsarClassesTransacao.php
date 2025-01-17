<?php
include_once './DataBase.php';
include_once './InserirTransacao.php';
// Instanciar a conexão com a base de dados
$database = new Database();
$db = $database->getConexao();


// Inserir uma transacção
$transacao = new Transaccao($db);
$transacao->inserir(1, "DEPOSITO", "500.00", "Depósito inicial", "0.00", "500.00");
?>

