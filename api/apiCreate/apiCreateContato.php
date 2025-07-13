<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../db_conn/dbConn.php';
    $DB = new dbConn();
    $conn = $DB->connect();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new Exception('Método não permitido');
    }

    $dados = [
        'tipo_contato' => $_POST['tipo_contato'] ?? null,
        'nome_completo' => $_POST['nome_completo'] ?? null,
        'rg' => $_POST['rg'] ?? null,
        'cpf' => $_POST['cpf'] ?? null,
        'data_nasc' => $_POST['data_nasc'] ?? null,
        'naturalidade' => $_POST['naturalidade'] ?? null,
        'profissao' => $_POST['profissao'] ?? null,
        'cep' => $_POST['cep'] ?? null,
        'rua' => $_POST['rua'] ?? null,
        'numero' => $_POST['numero'] ?? null,
        'complemento' => $_POST['complemento'] ?? null,
        'bairro' => $_POST['bairro'] ?? null,
        'cidade' => $_POST['cidade'] ?? null,
        'estado' => $_POST['estado'] ?? null,
        'telefone' => $_POST['telefone'] ?? null,
        'email' => $_POST['email'] ?? null,
        'redes_sociais' => $_POST['redes_sociais'] ?? null,
        'contato_recados' => $_POST['contato_recados'] ?? null,
        'telefone_recados' => $_POST['telefone_recados'] ?? null,
        'email_recados' => $_POST['email_recados'] ?? null,
        'origem' => $_POST['origem'] ?? null,
    ];
    
    $_id_empresa = $_POST['_id_empresa'] ?? null;

    $camposObrigatorios = [
        'nome_completo', 'cpf', 'data_nasc', 'telefone', '_id_empresa'
    ];

    foreach ($camposObrigatorios as $campo) {
        if (empty($_POST[$campo])) {
            http_response_code(400);
            throw new Exception("O campo obrigatório '$campo' não foi preenchido.");
        }
    }

    $conn->beginTransaction();

    $sql_contato = "INSERT INTO contatos (
        tipo_contato, nome_completo, rg, cpf, data_nasc, naturalidade, profissao, cep, rua, numero, 
        complemento, bairro, cidade, estado, telefone, email, redes_sociais, contato_recados, 
        telefone_recados, email_recados, origem
    ) VALUES (
        :tipo_contato, :nome_completo, :rg, :cpf, :data_nasc, :naturalidade, :profissao, :cep, :rua, :numero, 
        :complemento, :bairro, :cidade, :estado, :telefone, :email, :redes_sociais, :contato_recados, 
        :telefone_recados, :email_recados, :origem
    )";

    $stmt_contato = $conn->prepare($sql_contato);
    $stmt_contato->execute($dados);

    if ($stmt_contato->rowCount() > 0) {
        $_id_contato = $conn->lastInsertId();

        $sql_empresa_contato = "INSERT INTO empresas_contatos (_id_empresa, _id_contato) VALUES (:_id_empresa, :_id_contato)";
        $stmt_empresa_contato = $conn->prepare($sql_empresa_contato);
        $stmt_empresa_contato->execute(['_id_empresa' => $_id_empresa, '_id_contato' => $_id_contato]);

        if($stmt_empresa_contato->rowCount() > 0) {
            $conn->commit();
            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Contato criado e associado à empresa com sucesso',
                '_id_contato' => $_id_contato
            ]);
        } else {
            $conn->rollBack();
            throw new Exception('Falha ao associar contato à empresa.');
        }
    } else {
        $conn->rollBack();
        throw new Exception('Nenhum contato foi criado');
    }

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    http_response_code(500);
    // Verifica se é um erro de chave duplicada
    if ($e->getCode() == 23000) {
         echo json_encode(['status' => 'erro', 'mensagem' => 'Erro: CPF ou RG já cadastrado.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}