<?php
// ...caminho sugerido: api/apiCreate/apiCreateClausula.php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new DbConn();
    $pdo = $conn->connect();

    $dados = [
        'id_pai' => filter_input(INPUT_POST, 'id_pai', FILTER_SANITIZE_NUMBER_INT) ?: null,
        'tipo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT))),
        'titulo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT))),
        'nome_ref' => htmlspecialchars(trim(filter_input(INPUT_POST, 'nome_ref', FILTER_DEFAULT))),
        'descricao' => htmlspecialchars(trim(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT)))
    ];

    try {
        $sql = "INSERT INTO clausulas (id_pai, tipo, titulo, nome_ref, descricao)
                VALUES (:id_pai, :tipo, :titulo, :nome_ref, :descricao)";
        $stmt = $pdo->prepare($sql);
        $resultado = $stmt->execute([
            ':id_pai' => $dados['id_pai'],
            ':tipo' => $dados['tipo'],
            ':titulo' => $dados['titulo'],
            ':nome_ref' => $dados['nome_ref'],
            ':descricao' => $dados['descricao']
        ]);

        if ($resultado) {
            $novo_id = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'id' => $novo_id, 'message' => 'Cláusula criada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao criar cláusula.']);
        }
    } catch (PDOException $e) {
        error_log("Erro ao criar cláusula: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro ao processar a operação.']);
    }
}