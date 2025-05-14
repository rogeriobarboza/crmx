<?php

$tb = 'pedidos';


// GETs
$_id_contato = $_POST['_id_contato'] ?? null;
$_id_pedido = $_POST['_id_pedido'] ?? null;

$nome_contato = $_POST['nome_contato'] ?? null;
$produto_servico = $_POST['produto_servico'] ?? null;
$seguimento = $_POST['seguimento'] ?? null;
$titulo_evento = $_POST['titulo_evento'] ?? null;
$data_reservada = $_POST['data_reservada'] ?? null;
$descricao_pedido = $_POST['descricao_pedido'] ?? null;
$participantes = $_POST['participantes'] ?? null;
$observacoes = $_POST['observacoes'] ?? null;
$numero_convidados = $_POST['numero_convidados'] ?? null;
$horario_convite = $_POST['horario_convite'] ?? null;
$horario_inicio = $_POST['horario_inicio'] ?? null;
$valor_original = $_POST['valor_original'] ?? null;
$valor_desconto = $_POST['valor_desconto'] ?? null;
$valor_total = $_POST['valor_total'] ?? null;
$forma_pagamento = $_POST['forma_pagamento'] ?? null;
$numero_pagamentos = $_POST['numero_pagamentos'] ?? null;
$valor_pagamento_1 = $_POST['valor_pagamento_1'] ?? null;
$data_pagamento_1 = $_POST['data_pagamento_1'] ?? null;
$vencimento_mensal = $_POST['vencimento_mensal'] ?? null;
$reserva_equipe = $_POST['reserva_equipe'] ?? null;
$estimativa_custo = $_POST['estimativa_custo'] ?? null;

require_once '../app/model/selectById.php';
selectById($tb, $id);

function updateById($tb, $id, $data) {
    require_once '../db_conn/dbConn.php';
    $conn = new DbConn();
    $query = "UPDATE $tb SET
        nome_contato = :nome_contato,
        produto_servico = :produto_servico,
        seguimento = :seguimento,
        titulo_evento = :titulo_evento,
        data_reservada = :data_reservada,
        descricao_pedido = :descricao_pedido,
        participantes = :participantes,
        observacoes = :observacoes,
        numero_convidados = :numero_convidados,
        horario_convite = :horario_convite,
        horario_inicio = :horario_inicio,
        valor_original = :valor_original,
        valor_desconto = :valor_desconto,
        valor_total = :valor_total,
        forma_pagamento = :forma_pagamento,
        numero_pagamentos = :numero_pagamentos,
        valor_pagamento_1 = :valor_pagamento_1,
        data_pagamento_1 = :data_pagamento_1,
        vencimento_mensal = :vencimento_mensal,
        reserva_equipe = :reserva_equipe,
        estimativa_custo = :estimativa_custo
        WHERE _id_pedido = :_id_pedido";

    $stmt = $conn->connect()->prepare($query);
    $stmt->execute($data);
}

    return $stmt->rowCount() > 0;

//