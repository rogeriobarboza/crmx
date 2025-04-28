<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/app/model/model_pedido/inserir_pedidos/model_addPedido.php';

$addPedido = new addPedido();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Preparar dados de PEDIDO para inserção
    $_id_contato = $_POST['_id_contato'] ?? "Não informado";
    $nome_contato = $_POST['nome_contato'] ?? "Não informado";
    $produto_servico = $_POST['produto_servico'] ?? "Não informado";
    $seguimento = $_POST['seguimento'] ?? "Não informado";
    $titulo_evento = $_POST['titulo_evento'] ?? "Não informado";
    $data_reservada = $_POST['data_reservada'] ?? "Não informado";
    $descricao_pedido = $_POST['descricao_pedido'] ?? "Não informado";
    $participantes = $_POST['participantes'] ?? "Não informado";
    $observacoes = $_POST['observacoes'] ?? "Não informado";
    $numero_convidados = $_POST['numero_convidados'] ?? "Não informado";
    $horario_convite = $_POST['horario_convite'] ?? "Não informado";
    $horario_inicio = $_POST['horario_inicio'] ?? "Não informado";
    $valor_original = $_POST['valor_original'] ?? "Não informado";
    $valor_desconto = $_POST['valor_desconto'] ?? "Não informado";
    $valor_total = $_POST['valor_total'] ?? "Não informado";
    $forma_pagamento = $_POST['forma_pagamento'] ?? "Não informado";
    $numero_pagamentos = $_POST['numero_pagamentos'] ?? "Não informado";
    $data_pagamento_1 = $_POST['data_pagamento_1'] ?? "Não informado";
    $vencimento_mensal = $_POST['vencimento_mensal'] ?? "Não informado";
    $reserva_equipe = $_POST['reserva_equipe'] ?? "Não informado";
    $estimativa_custo = $_POST['estimativa_custo'] ?? "Não informado";

    // Chama o método para inserir o pedido

    $pedido = $addPedido->addPedido(
        $_id_contato,
        $nome_contato,
        $produto_servico,
        $seguimento,
        $titulo_evento,
        $data_reservada,
        $descricao_pedido,
        $participantes,
        $observacoes,
        $numero_convidados,
        $horario_convite,
        $horario_inicio,
        $valor_original,
        $valor_desconto,
        $valor_total,
        $forma_pagamento,
        $numero_pagamentos,
        $data_pagamento_1,
        $vencimento_mensal,
        $reserva_equipe,
        $estimativa_custo);

    echo json_encode($pedido); // Retorna o ID do pedido inserido
    
}

$_id_contato; // ID do contato que está fazendo o pedido.

// Preparar dados de TRANSAÇÃO "RECEITA" para inserção
$venc_mensal = $vencimento_mensal;
$transacao = "ENTRADA-teste1";
$situacao = "A RECEBER";
$num_pgto = 1; // Fazer a LÓGICA para calcular o número da parcela/pagamento (1, 2, 3...)
$valor_pgto = 100; // valor da parcela
$metodo_pgto = "pix"; // se PiX, Cartão, Boleto, etc...
$_id_pedido = $addPedido->getIdPedido($_id_contato); // Recupera o ID do pedido inserido
$pedido = "Casamento Maria e João, por exemplo"; // Titulo do pedido. Casamento Maria e João, por exemplo.
$contato = "Contato referente ao pedido"; // Nome do cliente/contratante cadastrado. Maria da Silva, por exemplo.
$metodos_contato = "telefone, email ou whatsapp"; // telefone, email ou whatsapp do cliente/contratante.
$info_adicional = "Ex: Lembrar de fazer a foto na avenida"; // Informações adicionais sobre o pedido. Ex: "Lembrar de fazer a foto na avenida".


$transacao = $addPedido->addTransacao(
    $venc_mensal,
    $transacao,
    $situacao,
    $num_pgto,
    $valor_pgto,
    $metodo_pgto,
    $_id_pedido,
    $pedido,
    $contato,
    $metodos_contato,
    $info_adicional
);

echo json_encode($transacao); // Retorna o ID da transação inserida


?>