<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

function buscarContatos() {
    try {
        require_once __DIR__ . '/../../db_conn/dbConn.php';
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $query = "SELECT * FROM contatos ORDER BY nome_completo ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar contatos: " . $e->getMessage());
        return false;
    }
}

function buscarContatoPorId($id) {
    try {
        require_once __DIR__ . '/../../db_conn/dbConn.php';
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
      
        $query = "SELECT * FROM contatos WHERE _id_contato = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar cadastro por ID: " . $e->getMessage());
        return false;
    }
}

function buscarContatoPorCPF($cpf) {
    try {
        require_once __DIR__ . '/../../db_conn/dbConn.php';
        $dbConn = new DbConn();
        $conn = $dbConn->connect();
     
        $query = "SELECT empresas.*, contatos.*
        FROM contatos 
        INNER JOIN empresas ON contatos._id_empresa = empresas._id
        WHERE contatos.cpf = :cpf;";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar cadastro por nome: " . $e->getMessage());
        return false;
    }
}

function buscarPedidoTransacaoPorId($_id_pedido) {
    try {
        require_once __DIR__ . '/../../db_conn/dbConn.php';
        $dbConn = new DbConn();
        $conn = $dbConn->connect();

        $query = "SELECT pedidos.*, transacoes.*
                FROM pedidos 
                LEFT JOIN transacoes ON transacoes._id_pedido = pedidos._id_pedido
                WHERE pedidos._id_pedido = :id_pedido;";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_pedido', $_id_pedido, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res;
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar dados completos: " . $e->getMessage());
        return false;
    }
}

// Roteamento com switch
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch (true) {
        case isset($_GET['id']):
            $id = intval($_GET['id']);
            $contato = buscarContatoPorId($id);
            if ($contato) {
                echo json_encode(['success' => true, 'data' => $contato]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Contato não encontrado']);
            }
            break;

        case isset($_GET['cpf']):
            $cpf = $_GET['cpf'];
            $contatos = buscarContatoPorCPF($cpf);
            if ($contatos) {
                echo json_encode(['success' => true, 'data' => $contatos]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Contato não encontrado']);
            }
            break;

        case isset($_GET['id_pedido']):
            $id_pedido = intval($_GET['id_pedido']);
            $pedido = buscarPedidoTransacaoPorId($id_pedido);
            if ($pedido) {
                echo json_encode(['success' => true, 'data' => $pedido]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Pedido não encontrado']);
            }
            break;

        default:
            $contatos = buscarContatos();
            echo json_encode(['success' => true, 'data' => $contatos]);
            break;
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
