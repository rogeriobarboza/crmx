<?php

header('Content-Type: application/json');

// Conexão com o banco
$host = 'localhost';
$dbName = 'contrato_x';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$idContato = $_GET['_id_contato'] ?? '';
$termoPedido = $_GET['termoPedido'] ?? '';

if ($idContato && $termoPedido) {
    $sql = "SELECT *
            FROM pedidos 
            WHERE produto_servico LIKE :termo 
            AND _id_contato = :idContato
            LIMIT 10";
            
    $stmt = $pdo->prepare($sql);
    $termo = "%{$termoPedido}%";
    $stmt->bindParam(':termo', $termo, PDO::PARAM_STR);
    $stmt->bindParam(':idContato', $idContato, PDO::PARAM_INT);
    $stmt->execute();
    
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($pedidos);
} else {
    echo json_encode([]);
}
?>
