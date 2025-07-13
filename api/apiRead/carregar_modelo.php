<?php
$pdo = new PDO("mysql:host=localhost;dbname=crmx", "root", "");
$id = $_GET['id'] ?? 0;

$modelo = $pdo->prepare("SELECT * FROM modelos_contratos WHERE id_modelo = ?");
$modelo->execute([$id]);
$m = $modelo->fetch();

// Modifique a consulta SQL para incluir tipo, nome_ref e pai:
$clausulas = $pdo->prepare("
    SELECT 
        c._id_clausula, 
        c.titulo, 
        c.descricao, 
        c.tipo,
        c.nome_ref,
        p.titulo as pai
    FROM clausulas c
    LEFT JOIN clausulas p ON c.id_pai = p._id_clausula
    JOIN modelos_contratos_clausulas mc ON c._id_clausula = mc.id_clausula
    WHERE mc.id_modelo = ?
    ORDER BY mc.ordem
");
$clausulas->execute([$id]);

echo json_encode([
  'nome_modelo' => $m['nome_modelo'],
  'clausulas' => $clausulas->fetchAll(PDO::FETCH_ASSOC)
]);
