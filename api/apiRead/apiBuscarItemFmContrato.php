<?php

header('Content-Type: application/json');

// Conexão com o banco
$host = 'localhost';
$dbName = 'crmx';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Pega apenas o parâmetro termoProduto
    $termoProduto = $_GET['termoProduto'] ?? '';

    if ($termoProduto) {
        $sql = "SELECT 
                _id_produto,
                nome_produto,
                categoria,
                descr_prod,
                detalhar_prod,
                preco_prod,
                status
            FROM produtos 
            WHERE nome_produto LIKE :termo 
            OR _id_produto LIKE :termo
            LIMIT 10";
            
        $stmt = $pdo->prepare($sql);
        $termo = "%{$termoProduto}%";
        $stmt->bindParam(':termo', $termo, PDO::PARAM_STR);
        $stmt->execute();
        
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($produtos);
    } else {
        echo json_encode([
            "error" => "Termo de busca não fornecido"
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Erro no servidor",
        "message" => $e->getMessage()
    ]);
}
?>