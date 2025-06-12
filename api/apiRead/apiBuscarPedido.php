<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    require_once '../../config/database.php';
    
    if (!isset($_GET['termo'])) {
        throw new Exception('Termo de busca não fornecido');
    }
    
    $termo = $_GET['termo'];
    $pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT p.*, c.nome_completo as nome_contato 
            FROM pedidos p 
            LEFT JOIN contatos c ON p._id_contato = c._id_contato 
            WHERE p.titulo_evento LIKE :termo 
            OR p._id LIKE :termo 
            OR c.nome_completo LIKE :termo 
            LIMIT 10";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['termo' => '%' . $termo . '%']);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'sucesso',
        'dados' => $resultados
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}
?>