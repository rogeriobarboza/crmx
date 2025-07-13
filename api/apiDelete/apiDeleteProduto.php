<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../db_conn/dbConn.php';
    $DB = new dbConn();
    $conn = $DB->connect();

    // Verifica se a requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Recebe o ID do produto a ser deletado
    $_id_produto = $_POST['_id_produto'] ?? null;

    // Validação do ID do produto
    if (empty($_id_produto)) {
        throw new Exception('ID do produto não fornecido');
    }

    // Verifica se o produto existe antes de deletar
    $sql_check = "SELECT * FROM produtos WHERE _id_produto = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindValue(1, $_id_produto, PDO::PARAM_INT);
    $stmt_check->execute();
    $result = $stmt_check->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) === 0) {
        throw new Exception('Produto não encontrado');
    }

    // Prepara a query SQL para deletar
    $sql = "DELETE FROM produtos WHERE _id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $_id_produto, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Produto deletado com sucesso!'
            ]);
        } else {
            throw new Exception('Nenhum produto foi deletado');
        }
    } else {
        throw new Exception("Erro ao deletar produto: " . implode(" ", $stmt->errorInfo()));
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}

$conn = null;
?>