<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../db_conn/dbConn.php';
    $DB = new dbConn();
    $conn = $DB->connect();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new Exception('Método não permitido');
    }

    $_id_contato = $_POST['_id_contato'] ?? null;

    if (empty($_id_contato)) {
        http_response_code(400);
        throw new Exception('ID do contato não fornecido');
    }

    // A restrição ON DELETE CASCADE na tabela empresas_contatos
    // garante que os registros associados serão deletados automaticamente.
    // Portanto, só precisamos deletar da tabela contatos.

    $sql_delete = "DELETE FROM contatos WHERE _id_contato = :_id_contato";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bindValue(':_id_contato', $_id_contato, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Contato deletado com sucesso.'
        ]);
    } else {
        // Se nenhuma linha foi afetada, pode ser que o contato já não existia.
        http_response_code(404);
        throw new Exception('Contato não encontrado ou nenhuma linha afetada.');
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Captura o código de status HTTP se já tiver sido definido
    $code = $e->getCode() > 0 ? $e->getCode() : 500;
    http_response_code($code);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}