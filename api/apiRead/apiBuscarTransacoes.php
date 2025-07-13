<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';

// Define os cabeçalhos para a resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // Para desenvolvimento. Em produção, restrinja o domínio.
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Instancia a conexão com o banco de dados
    $dbConn = new DbConn();
    $conn = $dbConn->connect();

    // Define a consulta SQL base com as colunas solicitadas
    $sql = "SELECT 
                criado,
                modificado,
                _id_transacao,
                _id_pedido,
                _id_contato,
                venc_mensal,
                transacao,
                situacao,
                data_transacao,
                num_pgto,
                valor_pgto,
                metodo_pgto,
                pedido,
                contato,
                metodos_contato,
                info_adicional
            FROM transacoes";

    // Verifica se um termo de busca foi fornecido via GET para filtragem
    $termo = $_GET['termo'] ?? '';

    if (!empty($termo)) {
        // Adiciona a cláusula WHERE para filtrar os resultados
        $sql .= " WHERE pedido LIKE :termo 
                   OR contato LIKE :termo
                   OR info_adicional LIKE :termo
                   OR _id_transacao LIKE :termo
                   OR _id_pedido LIKE :termo";
    }

    // Adiciona ordenação para um resultado consistente
    $sql .= " ORDER BY venc_mensal ASC";

    // Prepara a consulta
    $stmt = $conn->prepare($sql);

    // Se houver um termo de busca, associa o parâmetro para segurança
    if (!empty($termo)) {
        $searchTerm = "%{$termo}%";
        $stmt->bindParam(':termo', $searchTerm, PDO::PARAM_STR);
    }

    $stmt->execute();
    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os resultados como JSON
    echo json_encode(['success' => true, 'data' => $transacoes]);

} catch (Exception $e) {
    // Em caso de erro, retorna uma resposta JSON com status 500
    http_response_code(500);
    error_log("Erro na API de transações: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro no servidor ao buscar transações.']);
}

?>