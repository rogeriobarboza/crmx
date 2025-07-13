<?php

header('Content-Type: application/json');

// Conexão com o banco
$host = 'localhost';
$dbName = 'crmx';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$termoProduto = $_GET['termoProduto'] ?? '';
$idEmpresa = $_GET['idEmpresa'] ?? '';

if ($termoProduto && $idEmpresa) {
    $sql = "SELECT *
            FROM produtos 
            WHERE nome_produto LIKE :termo 
            AND _id_empresa = :idEmpresa
            LIMIT 10";
            
    $stmt = $pdo->prepare($sql);
    $termo = "%{$termoProduto}%";
    $stmt->bindParam(':termo', $termo, PDO::PARAM_STR);
    $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
    $stmt->execute();
    
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($produtos);
} else {
    echo json_encode([]);
}
?>
