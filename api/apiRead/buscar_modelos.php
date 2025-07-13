<?php
$pdo = new PDO("mysql:host=localhost;dbname=crmx", "root", "");
$q = '%' . ($_GET['q'] ?? '') . '%';
$stmt = $pdo->prepare("SELECT id_modelo, nome_modelo FROM modelos_contratos WHERE nome_modelo LIKE ? LIMIT 10");
$stmt->execute([$q]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
