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

    // Recebe o ID do pedido a ser deletado
    $_id_pedido = $_POST['_id_pedido'] ?? null;

    // Validação do ID do pedido
    if (empty($_id_pedido)) {
        throw new Exception('ID do pedido não fornecido');
    }

    // Verifica se o pedido existe antes de deletar
    $sql_check = "SELECT * FROM pedidos WHERE _id_pedido = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bindValue(1, $_id_pedido, PDO::PARAM_INT);
    $stmt_check->execute();
    $result = $stmt_check->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) === 0) {
        throw new Exception('Pedido não encontrado');
    }

    // Prepara a query SQL para deletar
    $sql = "DELETE FROM pedidos WHERE _id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $_id_pedido, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Pedido deletado com sucesso'
            ]);
        } else {
            throw new Exception('Nenhum pedido foi deletado');
        }
    } else {
        throw new Exception("Erro ao deletar pedido: " . implode(" ", $stmt->errorInfo()));
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