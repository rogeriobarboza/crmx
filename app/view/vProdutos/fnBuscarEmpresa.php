<?php
//require_once('../db_conn/dbConn.php');
//$conn = new dbConn();

header('Content-Type: application/json');

// Conexão com o banco
$host = 'localhost';
$dbName = 'contrato_x';
$username = 'root';
$password = '';
$conn;

$pdo = new PDO("mysql:host={$host};dbname={$dbName}", $username, $password);
//$pdo = new PDO("mysql:host=localhost;dbname=contrato_x;", "root", "");

$termo = $_GET['termo'] ?? '';

if ($termo) {
    $stmt = $pdo->prepare("SELECT _id, empresa FROM empresas WHERE _id LIKE :termo OR empresa LIKE :termo LIMIT 10");
    $stmt->execute([':termo' => "%$termo%"]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultados);
} else {
    echo json_encode([]);
}
