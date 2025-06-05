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
        '_id_empresa' => filter_input(INPUT_POST, '_id_empresa', FILTER_VALIDATE_INT),
        '_id_contato' => filter_input(INPUT_POST, '_id_contato', FILTER_VALIDATE_INT),
        'tipo_contato' => htmlspecialchars(trim(filter_input(INPUT_POST, 'tipo_contato', FILTER_DEFAULT))),
        'nome_completo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'nome_completo', FILTER_DEFAULT))),
        'rg' => htmlspecialchars(trim(filter_input(INPUT_POST, 'rg', FILTER_DEFAULT))),
        'cpf' => htmlspecialchars(trim(filter_input(INPUT_POST, 'cpf', FILTER_DEFAULT))),
        'data_nasc' => htmlspecialchars(trim(filter_input(INPUT_POST, 'data_nasc', FILTER_DEFAULT))),
        'naturalidade' => htmlspecialchars(trim(filter_input(INPUT_POST, 'naturalidade', FILTER_DEFAULT))),
        'profissao' => htmlspecialchars(trim(filter_input(INPUT_POST, 'profissao', FILTER_DEFAULT))),
        'cep' => htmlspecialchars(trim(filter_input(INPUT_POST, 'cep', FILTER_DEFAULT))),
        'rua' => htmlspecialchars(trim(filter_input(INPUT_POST, 'rua', FILTER_DEFAULT))),
        'numero' => htmlspecialchars(trim(filter_input(INPUT_POST, 'numero', FILTER_DEFAULT))),
        'complemento' => htmlspecialchars(trim(filter_input(INPUT_POST, 'complemento', FILTER_DEFAULT))),
        'bairro' => htmlspecialchars(trim(filter_input(INPUT_POST, 'bairro', FILTER_DEFAULT))),
        'cidade' => htmlspecialchars(trim(filter_input(INPUT_POST, 'cidade', FILTER_DEFAULT))),
        'estado' => htmlspecialchars(trim(filter_input(INPUT_POST, 'estado', FILTER_DEFAULT))),
        'telefone' => htmlspecialchars(trim(filter_input(INPUT_POST, 'telefone', FILTER_DEFAULT))),
        'email' => htmlspecialchars(trim(filter_input(INPUT_POST, 'email', FILTER_DEFAULT))),
        'redes_sociais' => htmlspecialchars(trim(filter_input(INPUT_POST, 'redes_sociais', FILTER_DEFAULT))),
        'contato_recados' => htmlspecialchars(trim(filter_input(INPUT_POST, 'contato_recados', FILTER_DEFAULT))),
        'telefone_recados' => htmlspecialchars(trim(filter_input(INPUT_POST, 'telefone_recados', FILTER_DEFAULT))),
        'email_recados' => htmlspecialchars(trim(filter_input(INPUT_POST, 'email_recados', FILTER_DEFAULT))),
        'origem' => htmlspecialchars(trim(filter_input(INPUT_POST, 'origem', FILTER_DEFAULT)))
    ];

    // Validação básica
    if (!$dados['_id_contato'] || !$dados['_id_empresa'] || empty($dados['nome_completo'])) {
        throw new Exception('Campos obrigatórios não preenchidos!');
    }

    // Prepara a query de atualização
    $sql = "UPDATE contatos SET 
            modificado = :modificado,
            tipo_contato = :tipo_contato,
            nome_completo = :nome_completo,
            rg = :rg,
            cpf = :cpf,
            data_nasc = :data_nasc,
            naturalidade = :naturalidade,
            profissao = :profissao,
            cep = :cep,
            rua = :rua,
            numero = :numero,
            complemento = :complemento,
            bairro = :bairro,
            cidade = :cidade,
            estado = :estado,
            telefone = :telefone,
            email = :email,
            redes_sociais = :redes_sociais,
            contato_recados = :contato_recados,
            telefone_recados = :telefone_recados,
            email_recados = :email_recados,
            origem = :origem
            WHERE _id_contato = :_id_contato AND _id_empresa = :_id_empresa";

    // Prepara e executa a query
    $stmt = $conn->prepare($sql);
    $stmt->execute($dados);

    if ($stmt->rowCount() > 0) {
        echo "<script>
                alert('Contato atualizado com sucesso!');
                window.location.href = '../../../atualizar-contato';
              </script>";
    } else {
        throw new Exception('Nenhum registro foi atualizado.');
    }

} catch (Exception $e) {
    echo "<script>
            alert('Erro ao atualizar contato: " . $e->getMessage() . "');
            //window.location.href = '../../../atualizar-contato';
          </script>";
    error_log("Erro na atualização do contato: " . $e->getMessage());
}

$conn = null;
?>