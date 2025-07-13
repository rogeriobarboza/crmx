<?php
// ...caminho sugerido: api/apiUpdate/apiUpdateClausula.php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new DbConn();
    $pdo = $conn->connect();

    $dados = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT),
        'id_pai' => filter_input(INPUT_POST, 'id_pai', FILTER_SANITIZE_NUMBER_INT) ?: null,
        'tipo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT))),
        'titulo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT))),
        'nome_ref' => htmlspecialchars(trim(filter_input(INPUT_POST, 'nome_ref', FILTER_DEFAULT))),
        'descricao' => htmlspecialchars(trim(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT)))
    ];

    if (!$dados['id']) {
        echo json_encode(['success' => false, 'message' => 'ID da cláusula não informado.']);
        exit;
    }

    try {
        $sql = "UPDATE clausulas 
                SET id_pai = :id_pai,
                    tipo = :tipo,
                    titulo = :titulo,
                    nome_ref = :nome_ref,
                    descricao = :descricao
                WHERE _id_clausula = :id";
        $stmt = $pdo->prepare($sql);
        $resultado = $stmt->execute([
            ':id' => $dados['id'],
            ':id_pai' => $dados['id_pai'],
            ':tipo' => $dados['tipo'],
            ':titulo' => $dados['titulo'],
            ':nome_ref' => $dados['nome_ref'],
            ':descricao' => $dados['descricao']
        ]);

        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Cláusula atualizada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar cláusula.']);
        }
    } catch (PDOException $e) {
        error_log("Erro ao atualizar cláusula: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro ao processar a operação.']);
    }
}