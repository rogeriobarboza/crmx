<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once '../../../db_conn/dbConn.php';

    // Verifica se a requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Recebe os dados do formulário
    $dados = [
        '_id_contato' => $_POST['_id_contato'] ?? null,
        'nome_contato' => $_POST['nome_contato'] ?? null,
        'produto_servico' => $_POST['produto_servico'] ?? null,
        'seguimento' => $_POST['seguimento'] ?? null,
        'titulo_evento' => $_POST['titulo_evento'] ?? null,
        'data_reservada' => $_POST['data_reservada'] ?? null,
        'descricao_pedido' => $_POST['descricao_pedido'] ?? null,
        'participantes' => $_POST['participantes'] ?? null,
        'observacoes' => $_POST['observacoes'] ?? null,
        'numero_convidados' => $_POST['numero_convidados'] ?? null,
        'horario_convite' => $_POST['horario_convite'] ?? null,
        'horario_inicio' => $_POST['horario_inicio'] ?? null,
        'valor_original' => $_POST['valor_original'] ?? null,
        'valor_desconto' => $_POST['valor_desconto'] ?? null,
        'valor_total' => $_POST['valor_total'] ?? null,
        'forma_pagamento' => $_POST['forma_pagamento'] ?? null,
        'numero_pagamentos' => $_POST['numero_pagamentos'] ?? null,
        'valor_pagamento_1' => $_POST['valor_pagamento_1'] ?? null,
        'data_pagamento_1' => $_POST['data_pagamento_1'] ?? null,
        'vencimento_mensal' => $_POST['vencimento_mensal'] ?? null,
        'reserva_equipe' => $_POST['reserva_equipe'] ?? null,
        'estimativa_custo' => $_POST['estimativa_custo'] ?? null,
        'info_adicional' => $_POST['info_adicional'] ?? null
    ];

    // Validação básica dos campos obrigatórios
    $camposObrigatorios = ['_id_contato', 'titulo_evento', 'data_reservada', 'valor_total'];
    foreach ($camposObrigatorios as $campo) {
        if (empty($dados[$campo])) {
            throw new Exception("Campo obrigatório não preenchido: $campo");
        }
    }

    // Prepara a query SQL
    $sql = "INSERT INTO pedidos (
        _id_contato, nome_contato, produto_servico, seguimento, titulo_evento,
        data_reservada, descricao_pedido, participantes, observacoes,
        numero_convidados, horario_convite, horario_inicio, valor_original,
        valor_desconto, valor_total, forma_pagamento, numero_pagamentos,
        valor_pagamento_1, data_pagamento_1, vencimento_mensal,
        reserva_equipe, estimativa_custo, info_adicional
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssssssissdddsisssssds",
        $dados['_id_contato'],
        $dados['nome_contato'],
        $dados['produto_servico'],
        $dados['seguimento'],
        $dados['titulo_evento'],
        $dados['data_reservada'],
        $dados['descricao_pedido'],
        $dados['participantes'],
        $dados['observacoes'],
        $dados['numero_convidados'],
        $dados['horario_convite'],
        $dados['horario_inicio'],
        $dados['valor_original'],
        $dados['valor_desconto'],
        $dados['valor_total'],
        $dados['forma_pagamento'],
        $dados['numero_pagamentos'],
        $dados['valor_pagamento_1'],
        $dados['data_pagamento_1'],
        $dados['vencimento_mensal'],
        $dados['reserva_equipe'],
        $dados['estimativa_custo'],
        $dados['info_adicional']
    );

    if ($stmt->execute()) {
        $id_pedido = $conn->insert_id;
        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Pedido criado com sucesso',
            'id_pedido' => $id_pedido
        ]);
    } else {
        throw new Exception("Erro ao inserir pedido: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);
}

$conn->close();
?>