<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crm/app/model/mPedido/inserir_pedidos/model_addPedido.php';

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
    $valor_pagamento_1 = $_POST['valor_pagamento_1'] ?? "Não informado";
    $data_pagamento_1 = $_POST['data_pagamento_1'] ?? "Não informado";
    $vencimento_mensal = $_POST['vencimento_mensal'] ?? "Não informado";
    $reserva_equipe = $_POST['reserva_equipe'] ?? "Não informado";
    $estimativa_custo = $_POST['estimativa_custo'] ?? "Não informado";
    $info_add = $_POST['info_adicional'] ?? "Não informado";

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
        $valor_pagamento_1,
        $data_pagamento_1,
        $vencimento_mensal,
        $reserva_equipe,
        $estimativa_custo);

    echo json_encode($pedido); // Retorna o ID do pedido inserido
    
}



// PREPARANDO DADOS PARA INSERÇÃO NA TABELA DE TRANSAÇÕES ==

// PARÂMETROS PARA INSERÇÃO NA TABELA DE TRANSAÇÕES == Preparar dados de TRANSAÇÃO "RECEITA" para inserção
$_id_pedido = $addPedido->getIdPedido($_id_contato); // Ok - Recupera o ID do pedido inserido
$_id_contato; // Ok - Ja capturado acima com metodo $_POST
$venc_mensal; // Ok - Se entrada = 0, data do 1º vencimento ja capturado acima com metodo $_POST.
$transacao = "RECEITA"; // Ok - Tipo de transação para cadastro de pedidos.
$situacao = "A RECEBER"; // Ok - Situação da transação para cadastro de pedidos.
$data_transacao; // É a data em que o pagamento foi realizado, ou seja, é preenchido somente quando o pagamento é feito. Se não for feito, fica em branco.
$num_pgto; // Número do pagamento (entrada)
$valor_pgto; // Valor do pagamento
$metodo_pgto = $forma_pagamento; // Ok - Ja capturado acima com metodo $_POST
$pedido = $titulo_evento; // Ok - Ja capturado acima com metodo $_POST
$contato = $nome_contato; // Ok - Ja capturado acima com metodo $_POST
// -----------------------------------------------------------------
    $info_metodos_contato = $addPedido->metodosContato($_id_contato); // Ok - Recupera os métodos de contato do cliente/contratante.
        $telefone = $info_metodos_contato['telefone'] ?? "Não informado"; // Ok - telefone do cliente/contratante.
        $email = $info_metodos_contato['email'] ?? "Não informado"; // Ok - email do cliente/contratante.
$metodos_contato = $telefone . ", ". $email; // Ok - telefone, email ou whatsapp do cliente/contratante.
$info_adicional = $info_add; // Ok - Ja capturado acima com metodo $_POST


// Fazer a LÓGICA para definir o NÚMERO e VALOR do pagamento e INSERIR no DB
if($valor_pagamento_1 > 0) {
    $venc_mensal = $data_pagamento_1; // Data do primeiro pagamento (entrada)
    $num_pgto = 1; // Número do pagamento (entrada)
    $valor_pgto = $valor_pagamento_1; // Valor do pagamento (entrada)
    $info_adicional = "Entrada | $info_add"; // Informação adicional para o pagamento de entrada
    // Chama o método para inserir a transação de entrada
    $addPedido->addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
    $parcelas = $numero_pagamentos - 1; // Número de pagamentos restantes (parcelas)
    
    while($num_pgto <= $parcelas) {
        if ($num_pgto == 1) {
            $venc_mensal = $vencimento_mensal; // form ->Data do 1º Vencimento Mensal
        } else {
            $num_pgto--; // Decrementa o número do pagamento para calcular o vencimento mensal
            $venc_mensal = $addPedido->vencs($vencimento_mensal,$num_pgto); // Data do vencimento mensal
            $num_pgto++;
        }
        
        $num_pgto++; // Incrementa o número do pagamento
        $valor_pgto = ($valor_total - $valor_pagamento_1) / $parcelas; // Valor do pagamento
        $info_adicional = $info_add;
        // Chama o método para inserir a transação de entrada
        $addPedido->addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
    }
} elseif($valor_pagamento_1 == 0) {
    $num_pgto = 0; // Número do pagamento (entrada)
    $info_adicional = $info_add;
    
    while($num_pgto < $numero_pagamentos) {
        if ($num_pgto < 1) {
            $venc_mensal = $vencimento_mensal; // form ->Data do 1º Vencimento Mensal
        } else {
            $venc_mensal = $addPedido->vencs($vencimento_mensal,$num_pgto); // Data do vencimento mensal
        }
         // Data do vencimento mensal
        $num_pgto++; // Incrementa o número do pagamento
        $valor_pgto = $valor_total / $numero_pagamentos; // Valor do pagamento
        // Chama o método para inserir a transação de entrada
        $addPedido->addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
    }

    echo json_encode($transacao); // Retorna o ID da transação inserida

} else {echo "Nenhuma entrada informada.";}








?>