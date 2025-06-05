<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crm/app/model/mContato/inserir_cadastros/model_cadastrar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cadastrar = new CadastrarContato();

    /*
    // Validação do CPF
    if (!$cadastrar->validarCPF($_POST['cpf'])) {
        echo json_encode([
            'success' => false,
            'message' => 'CPF inválido'
        ]);
        exit;
    }

    // Verificar se CPF já existe
    if ($cadastrar->verificarCPFExistente($_POST['cpf'])) {
        echo json_encode([
            'success' => false,
            'message' => 'CPF já cadastrado'
        ]);
        exit;
    }
    */

    // Preparar dados para inserção
        $_id_empresa = $_POST['_id_empresa'];
        $tipo_cadastro = $_POST['tipo_cadastro']; 
        $nome_completo = $_POST['nome_completo'];
        $rg = $_POST['rg'];
        $cpf = $_POST['cpf'];
        $data_nasc = $_POST['data_nasc'];
        $naturalidade = $_POST['naturalidade'];
        $profissao = $_POST['profissao'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $redes_sociais = $_POST['redes_sociais'];
        $contato_recados = $_POST['contato_recados'];
        $telefone_recados = $_POST['telefone_recados'];
        $email_recados = $_POST['email_recados'];
        $origem = $_POST['origem'];

        $resultado = $cadastrar->inserirCadastro(
            $_id_empresa,
            $tipo_cadastro,
            $nome_completo,
            $rg,
            $cpf,
            $data_nasc,
            $naturalidade,
            $profissao,
            $cep,
            $rua,
            $numero,
            $complemento,
            $bairro,
            $cidade,
            $estado,
            $telefone,
            $email,
            $redes_sociais,
            $contato_recados,
            $telefone_recados,
            $email_recados,
            $origem);
            
        echo json_encode($resultado);
}