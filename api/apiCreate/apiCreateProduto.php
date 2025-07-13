<?php

header('Content-Type: application/json; charset=utf-8');

require_once('../../db_conn/dbConn.php');
$db = new DbConn();
$conn = $db->connect();

// Recebe os dados do POST
$_id_empresa    = $_POST['_id_empresa']    ?? '';
$categoria      = $_POST['categoria']      ?? '';
$nome_produto   = $_POST['nome_produto']   ?? '';
$descr_prod     = $_POST['descr_prod']     ?? '';
$detalhar_prod  = $_POST['detalhar_prod']  ?? '';
$custo_prod     = $_POST['custo_prod']     ?? '';
$preco_prod     = $_POST['preco_prod']     ?? '';
$status         = $_POST['status']         ?? '';
$criado         = date('Y-m-d H:i:s');
$modificado     = $criado;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validação básica
        if (!$_id_empresa || !$nome_produto) {
            throw new Exception('ID da empresa e nome do produto são obrigatórios.');
        }

        // Prepara e executa o insert
        $stmt = $conn->prepare("INSERT INTO produtos 
            (criado, modificado, _id_empresa, categoria, nome_produto, descr_prod, detalhar_prod, custo_prod, preco_prod, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $criado,
            $modificado,
            $_id_empresa,
            $categoria,
            $nome_produto,
            $descr_prod,
            $detalhar_prod,
            $custo_prod,
            $preco_prod,
            $status
        ]);

        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Produto criado com sucesso!'
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro ao adicionar produto: ' . $e->getMessage()
        ]);
    } catch(Exception $e) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Método não permitido.'
    ]);
}

?>

