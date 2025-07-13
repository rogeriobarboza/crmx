<?php
require_once '../../db_conn/dbConn.php';

header("Content-Type: application/json; charset=UTF-8");

$conn = null;
try {
    $DB = new dbConn();
    $conn = $DB->connect();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        throw new Exception("Método não permitido.");
    }
    
    // Captura o _id_empresa e o remove dos dados do POST para não ser usado no update de 'contatos'
    if (!isset($_POST['_id_empresa']) || empty($_POST['_id_empresa'])) {
        throw new Exception("O ID da empresa é obrigatório.");
    }
    $_id_empresa = $_POST['_id_empresa'];
    unset($_POST['_id_empresa']);


    $campos = [
        'tipo_contato', 'nome_completo', 'rg', 'cpf', 'data_nasc',
        'naturalidade', 'profissao', 'cep', 'rua', 'numero', 'complemento',
        'bairro', 'cidade', 'estado', 'telefone', 'email', 'redes_sociais',
        'contato_recados', 'telefone_recados', 'email_recados', 'origem', '_id_contato'
    ];

    $dados = [];
    foreach ($campos as $campo) {
        if (!isset($_POST[$campo])) {
            http_response_code(400);
            throw new Exception("Campo obrigatório faltando: $campo");
        }
        $dados[$campo] = trim($_POST[$campo]);
    }
    
    $conn->beginTransaction();

    $sql_contato = "
        UPDATE contatos SET 
            tipo_contato = :tipo_contato, nome_completo = :nome_completo, rg = :rg,
            cpf = :cpf, data_nasc = :data_nasc, naturalidade = :naturalidade,
            profissao = :profissao, cep = :cep, rua = :rua, numero = :numero,
            complemento = :complemento, bairro = :bairro, cidade = :cidade,
            estado = :estado, telefone = :telefone, email = :email,
            redes_sociais = :redes_sociais, contato_recados = :contato_recados,
            telefone_recados = :telefone_recados, email_recados = :email_recados,
            origem = :origem
        WHERE _id_contato = :_id_contato
    ";

    $stmt_contato = $conn->prepare($sql_contato);
    $stmt_contato->execute($dados);
    
    // Atualiza a tabela de associação
    // Esta implementação assume que um contato pode ser movido entre empresas.
    $sql_assoc = "
        UPDATE empresas_contatos 
        SET _id_empresa = :_id_empresa 
        WHERE _id_contato = :_id_contato";
        
    $stmt_assoc = $conn->prepare($sql_assoc);
    $stmt_assoc->bindValue(':_id_empresa', $_id_empresa, PDO::PARAM_INT);
    $stmt_assoc->bindValue(':_id_contato', $dados['_id_contato'], PDO::PARAM_INT);
    $stmt_assoc->execute();


    if ($stmt_contato->rowCount() > 0 || $stmt_assoc->rowCount() > 0) {
        $conn->commit();
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Contato atualizado com sucesso',
            '_id_contato' => $dados['_id_contato']
        ]);
    } else {
        $conn->rollBack();
        throw new Exception("Nenhuma alteração detectada.");
    }

} catch (PDOException $e) {
    if ($conn && $conn->inTransaction()) {
        $conn->rollBack();
    }
    http_response_code(500);
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro: CPF ou RG já pertence a outro contato.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }
} catch (Exception $e) {
    if ($conn && $conn->inTransaction()) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
} finally {
    $conn = null;
}