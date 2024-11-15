<?php
include_once './DataBase.php';
include_once './InserirUtilizador.php';
// Instanciar a conexão com a base de dados
$database = new Database();
$db = $database->getConexao();

// Inserir um utilizador
$utilizador = new Utilizador($db);
$utilizador->inserir("João Silva", "joao@email.com", "+351912345678", "Rua ABC, 123", "minhaSenhaSegura");

// Inserir uma transacção
//$transaccao = new Transaccao($db);
//$transaccao->inserir(1, "DEPOSITO", "500.00", "Depósito inicial", "0.00", "500.00");
?>

