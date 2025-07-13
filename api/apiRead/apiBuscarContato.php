<?php

header('Content-Type: application/json');

// Conexão com o banco
$host = 'localhost';
$dbName = 'crmx';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$termoProduto = $_GET['termoContato'] ?? '';
$idEmpresa = $_GET['idEmpresa'] ?? '';

if ($termoProduto && $idEmpresa) {
    // ##### CONSULTA SQL MODIFICADA #####
    // A consulta agora une 'contatos' (c) com 'empresas_contatos' (ec)
    // para encontrar os contatos associados ao '_id_empresa' fornecido.
    $sql = "SELECT c.*
            FROM contatos c
            INNER JOIN empresas_contatos ec ON c._id_contato = ec._id_contato
            WHERE ec._id_empresa = :idEmpresa
            AND (c.nome_completo LIKE :termo OR c._id_contato LIKE :termo)
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