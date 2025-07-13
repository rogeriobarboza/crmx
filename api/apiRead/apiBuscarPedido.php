<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../db_conn/dbConn.php';

/**
 * Busca pedidos com base em um termo de pesquisa e um ID de contato.
 *
 * @param PDO $conn A conexão com o banco de dados.
 * @param string $termo O termo para buscar no título do pedido, ID do pedido ou nome do contato.
 * @param int $idContato O ID do contato para filtrar os pedidos.
 * @return array Os pedidos encontrados.
 */
function buscarPedidoPorTermoEContato($conn, $termo, $idContato) {
    $sql = "SELECT p.*, c.nome_completo as nome_contato 
            FROM pedidos p 
            LEFT JOIN contatos c ON p._id_contato = c._id_contato 
            WHERE (p.titulo_pedido LIKE :termo 
                OR p._id_pedido LIKE :termo 
                OR c.nome_completo LIKE :termo)
            AND p._id_contato = :id_contato
            LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'termo' => '%' . $termo . '%',
        'id_contato' => $idContato
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Busca todos os pedidos, juntando o nome do contato.
 *
 * @param PDO $conn A conexão com o banco de dados.
 * @return array Todos os pedidos.
 */
function buscarTodosPedidos($conn) {
    $sql = "SELECT p.*, c.nome_completo as nome_contato 
            FROM pedidos p 
            LEFT JOIN contatos c ON p._id_contato = c._id_contato 
            ORDER BY p.criado DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

try {
    $dbConn = new DbConn();
    $conn = $dbConn->connect();

    $resultados = [];

    // Roteamento com base nos parâmetros GET
    switch (true) {
        case isset($_GET['termoPedido']) && isset($_GET['_id_contato']):
            $termo = $_GET['termoPedido'];
            $idContato = $_GET['_id_contato'];
            $resultados = buscarPedidoPorTermoEContato($conn, $termo, $idContato);
            break;

        default:
            $resultados = buscarTodosPedidos($conn);
            break;
    }

    echo json_encode([
        'status' => 'sucesso',
        'dados' => $resultados
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}

?>
