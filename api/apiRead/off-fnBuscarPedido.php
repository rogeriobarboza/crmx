<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../../db_conn/dbConn.php';

    if (isset($_GET['termo'])) {
        $termo = $_GET['termo'];
        
        $sql = "SELECT p.*, c.nome_completo as nome_contato 
                FROM pedidos p 
                LEFT JOIN contatos c ON p._id_contato = c._id_contato 
                WHERE p._id LIKE ? OR p.titulo_evento LIKE ?";
                
        $stmt = $conn->prepare($sql);
        $termoBusca = "%$termo%";
        $stmt->bind_param("ss", $termoBusca, $termoBusca);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $pedidos = array();
        while ($row = $resultado->fetch_assoc()) {
            $pedidos[] = $row;
        }
        
        echo json_encode($pedidos, JSON_THROW_ON_ERROR);
        
    } else {
        echo json_encode(array('erro' => 'Termo de busca não fornecido'));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array('erro' => 'Erro ao buscar pedidos: ' . $e->getMessage()));
}
?>