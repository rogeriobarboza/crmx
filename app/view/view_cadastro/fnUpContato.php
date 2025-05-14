<?php
require_once '../../../db_conn/dbConn.php';

try {
    // Instancia a conexão
    $dbConn = new DbConn();
    $conn = $dbConn->connect();

    // Recebe e valida os dados do formulário
    $modificado = date('Y-m-d H:i:s');
    $dados = [
        'modificado' => $modificado,	
        'categoria' => htmlspecialchars(trim(filter_input(INPUT_POST, 'categoria', FILTER_DEFAULT))),
        'nome_produto' => htmlspecialchars(trim(filter_input(INPUT_POST, 'nome_produto', FILTER_DEFAULT))),
        'descr_prod' => htmlspecialchars(trim(filter_input(INPUT_POST, 'descr_prod', FILTER_DEFAULT))),
        'detalhar_prod' => htmlspecialchars(trim(filter_input(INPUT_POST, 'detalhar_prod', FILTER_DEFAULT))),
        'custo_prod' => htmlspecialchars(trim(filter_input(INPUT_POST, 'custo_prod', FILTER_DEFAULT))),
        'preco_prod' => htmlspecialchars(trim(filter_input(INPUT_POST, 'preco_prod', FILTER_DEFAULT))),
        'status' => htmlspecialchars(trim(filter_input(INPUT_POST, 'status', FILTER_DEFAULT))),
        '_id_empresa' => filter_input(INPUT_POST, '_id_empresa', FILTER_VALIDATE_INT),
        '_id_produto' => filter_input(INPUT_POST, '_id_produto', FILTER_VALIDATE_INT)
    ];

    // Validação básica
    if (!$dados['_id_produto'] || !$dados['_id_empresa'] || empty($dados['nome_produto'])) {
        throw new Exception('Campos obrigatórios não preenchidos!');
    }

    // Converte valores monetários
    $dados['custo_prod'] = str_replace(',', '.', $dados['custo_prod']);
    $dados['preco_prod'] = str_replace(',', '.', $dados['preco_prod']);

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

    // Prepara e executa a query
    $stmt = $conn->prepare($sql);
    $stmt->execute($dados);

    if ($stmt->rowCount() > 0) {
        echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location.href = '../../../atualizar-produtos';
              </script>";
    } else {
        throw new Exception('Nenhum registro foi atualizado.');
    }

} catch (Exception $e) {
    echo "<script>
            alert('Erro ao atualizar produto: " . $e->getMessage() . "');
            //window.location.href = '../../../atualizar-produtos';
          </script>";
    error_log("Erro na atualização do produto: " . $e->getMessage());
}

$conn = null;
?>