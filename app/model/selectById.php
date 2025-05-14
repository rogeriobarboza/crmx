<?php
function selectById($tb, $id) {
    require_once '../db_conn/dbConn.php';
    $conn = new DbConn();
    $query = "SELECT * FROM $tb WHERE _id_pedido = $id";
    $stmt = $conn->connect()->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

function selectByIdEcho($tb, $id) {
    require_once '../db_conn/dbConn.php';
    $conn = new DbConn();
    $query = "SELECT * FROM $tb WHERE _id_pedido = $id";
    $stmt = $conn->connect()->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}




?>