<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../../db_conn/dbConn.php';

    // Verifica se a requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Recebe o ID do pedido a ser deletado
    $id_pedido = $_POST['id_pedido'] ?? null;

    // Validação do ID do pedido
    if (empty($id_pedido)) {
        throw new Exception('ID do pedido não fornecido');
    }

    // Verifica se o pedido existe antes de deletar
    $sql_check = "SELECT * FROM pedidos WHERE id_pedido = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_pedido);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        throw new Exception('Pedido não encontrado');
    }

    // Prepara a query SQL para deletar
    $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pedido);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Pedido deletado com sucesso'
            ]);
        } else {
            throw new Exception('Nenhum pedido foi deletado');
        }
    } else {
        throw new Exception("Erro ao deletar pedido: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}

$conn->close();
?>