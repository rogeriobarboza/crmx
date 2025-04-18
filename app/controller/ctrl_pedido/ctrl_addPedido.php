<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/app/model/model_pedido/inserir_pedidos/model_addPedido.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $addPedido = new addPedido();

    // Preparar dados para inserção
    $_id_cadastro = $_POST['_id_cadastro'];
    $nome_contratante = $_POST['nome_contratante'];
    $produto_servico = $_POST['produto_servico'];
    $seguimento = $_POST['seguimento'];
    $titulo_evento = $_POST['titulo_evento'];
    $data_reservada = $_POST['data_reservada'];
    $descricao_pedido = $_POST['descricao_pedido'];
    $participantes = $_POST['participantes'];
    $observacoes = $_POST['observacoes'];
    $numero_convidados = $_POST['numero_convidados'];
    $horario_convite = $_POST['horario_convite'];
    $horario_inicio = $_POST['horario_inicio'];
    $valor_original = $_POST['valor_original'];
    $valor_desconto = $_POST['valor_desconto'];
    $valor_total = $_POST['valor_total'];
    $forma_pagamento = $_POST['forma_pagamento'];
    $numero_pagamentos = $_POST['numero_pagamentos'];
    $data_pagamento_1 = $_POST['data_pagamento_1'];
    $vencimento_mensal = $_POST['vencimento_mensal'];
    $reserva_equipe = $_POST['reserva_equipe'];
    $estimativa_custo = $_POST['estimativa_custo'];

    // Chama o método para inserir o pedido

    $resultado = $addPedido->addPedido(
        $_id_cadastro,
        $nome_contratante,
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

    echo json_encode($resultado); // Retorna o ID do pedido inserido
    
}



?>