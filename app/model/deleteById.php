<?php

$tb = 'pedidos';
$id = $_POST['_id_pedido'] ?? null;
var_dump($id); // Retorna o ID do pedido excluído

//require_once '../app/model/selectById.php';
//selectById($tb, $id);

function deleteById($id) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/db_conn/dbConn.php';
    $conn = new DbConn();
    $query = "DELETE FROM pedidos WHERE _id_pedido = ?";
    $stmt = $conn->connect()->prepare($query);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();

}


deleteById($id);

//var_dump($id); // Retorna o ID do pedido excluído

?>