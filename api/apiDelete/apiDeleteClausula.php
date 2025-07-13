<?php
// ...caminho sugerido: api/apiDelete/apiDeleteClausula.php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new DbConn();
    $pdo = $conn->connect();

    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID da cláusula não informado.']);
        exit;
    }

    try {
        // Verifica se existem cláusulas filhas
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clausulas WHERE id_pai = :id");
        $stmt->execute([':id' => $id]);
        $tem_filhos = $stmt->fetchColumn() > 0;

        if ($tem_filhos) {
            echo json_encode(['success' => false, 'message' => 'Não é possível excluir! Esta cláusula possui subcláusulas.']);
        } else {
            $sql = "DELETE FROM clausulas WHERE _id_clausula = :id";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([':id' => $id]);

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Cláusula excluída com sucesso!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir cláusula.']);
            }
        }
    } catch (PDOException $e) {
        error_log("Erro ao excluir cláusula: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Erro ao processar a operação.']);
    }
}