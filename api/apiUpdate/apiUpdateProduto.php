<?php
header('Content-Type: application/json; charset=utf-8');
require_once('../../db_conn/dbConn.php');

try {
    // Instancia a conexão
    $dbConn = new DbConn();
    $conn = $dbConn->connect();

    // Recebe e valida os dados do formulário
    $modificado = date('Y-m-d H:i:s');
    $dados = [
        'modificado'      => $modificado,
        'categoria'       => htmlspecialchars(trim($_POST['categoria'] ?? '')),
        'nome_produto'    => htmlspecialchars(trim($_POST['nome_produto'] ?? '')),
        'descr_prod'      => htmlspecialchars(trim($_POST['descr_prod'] ?? '')),
        'detalhar_prod'   => htmlspecialchars(trim($_POST['detalhar_prod'] ?? '')),
        'custo_prod'      => str_replace(',', '.', trim($_POST['custo_prod'] ?? '0.00')),
        'preco_prod'      => str_replace(',', '.', trim($_POST['preco_prod'] ?? '0.00')),
        'status'          => htmlspecialchars(trim($_POST['status'] ?? '')),
        '_id_empresa'     => intval($_POST['_id_empresa'] ?? 0),
        '_id_produto'     => intval($_POST['_id_produto'] ?? 0)
    ];

    // Validação básica
    if (
        !$dados['_id_produto'] ||
        !$dados['_id_empresa'] ||
        empty($dados['nome_produto']) ||
        empty($dados['categoria']) ||
        empty($dados['descr_prod']) ||
        empty($dados['preco_prod']) ||
        empty($dados['status'])
    ) {
        throw new Exception('Campos obrigatórios não preenchidos!');
    }

    // Prepara a query de atualização
    $sql = "UPDATE produtos SET 
                modificado = :modificado,
                categoria = :categoria,
                nome_produto = :nome_produto,
                descr_prod = :descr_prod,
                detalhar_prod = :detalhar_prod,
                custo_prod = :custo_prod,
                preco_prod = :preco_prod,
                status = :status
            WHERE _id_empresa = :_id_empresa 
              AND _id_produto = :_id_produto";

    $stmt = $conn->prepare($sql);
    $stmt->execute($dados);

    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Produto atualizado com sucesso!'
        ]);
    } else {
        throw new Exception('Nenhum registro foi atualizado.');
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao atualizar produto: ' . $e->getMessage()
    ]);
    error_log("Erro na atualização do produto: " . $e->getMessage());
}

$conn = null;
?>