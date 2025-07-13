<?php

header('Content-Type: application/json');

// Usa a classe de conexão centralizada
require_once('../../db_conn/dbConn.php');
$db = new DbConn();
$pdo = $db->connect();

// Recebe parâmetros
$termoProduto = $_GET['termoProduto'] ?? '';
$idEmpresa = $_GET['idEmpresa'] ?? '';

if ($termoProduto && $idEmpresa) {
    $sql = "SELECT 
                criado,
                modificado,
                _id_empresa,
                _id_produto,
                categoria,
                nome_produto,
                descr_prod,
                detalhar_prod,
                custo_prod,
                preco_prod,
                status
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