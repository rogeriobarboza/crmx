<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/db_conn/dbConn.php';

class addPedido {
    private $conn;

    public function __construct() {
        $db = new DbConn();
        $this->conn = $db->connect();
    }

    public function addPedido(
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
        $estimativa_custo) {

            try {
                $queryAddPedido = "INSERT INTO pedidos (
                    _id_contato,
                    nome_contato,
                    produto_servico,
                    seguimento,
                    titulo_evento,
                    data_reservada,
                    descricao_pedido,
                    participantes,
                    observacoes,
                    numero_convidados,
                    horario_convite,
                    horario_inicio,
                    valor_original,
                    valor_desconto,
                    valor_total,
                    forma_pagamento,
                    numero_pagamentos,
                    data_pagamento_1,
                    vencimento_mensal,
                    reserva_equipe,
                    estimativa_custo)
                  VALUES (
                    :_id_contato, 
                    :nome_contato, 
                    :produto_servico, 
                    :seguimento, 
                    :titulo_evento, 
                    :data_reservada, 
                    :descricao_pedido, 
                    :participantes, 
                    :observacoes, 
                    :numero_convidados, 
                    :horario_convite, 
                    :horario_inicio, 
                    :valor_original, 
                    :valor_desconto, 
                    :valor_total, 
                    :forma_pagamento, 
                    :numero_pagamentos, 
                    :data_pagamento_1, 
                    :vencimento_mensal, 
                    :reserva_equipe, 
                    :estimativa_custo)";

                $stmt = $this->conn->prepare($queryAddPedido);

                // Bind parameters
                $stmt->bindParam(':_id_contato', $_id_contato);
                $stmt->bindParam(':nome_contato', $nome_contato);
                $stmt->bindParam(':produto_servico', $produto_servico);
                $stmt->bindParam(':seguimento', $seguimento);
                $stmt->bindParam(':titulo_evento', $titulo_evento);
                $stmt->bindParam(':data_reservada', $data_reservada);
                $stmt->bindParam(':descricao_pedido', $descricao_pedido);
                $stmt->bindParam(':participantes', $participantes);
                $stmt->bindParam(':observacoes', $observacoes);
                $stmt->bindParam(':numero_convidados', $numero_convidados);
                $stmt->bindParam(':horario_convite', $horario_convite);
                $stmt->bindParam(':horario_inicio', $horario_inicio);
                $stmt->bindParam(':valor_original', $valor_original);
                $stmt->bindParam(':valor_desconto', $valor_desconto);
                $stmt->bindParam(':valor_total', $valor_total);
                $stmt->bindParam(':forma_pagamento', $forma_pagamento);
                $stmt->bindParam(':numero_pagamentos', $numero_pagamentos);
                $stmt->bindParam(':data_pagamento_1', $data_pagamento_1);
                $stmt->bindParam(':vencimento_mensal', $vencimento_mensal);
                $stmt->bindParam(':reserva_equipe', $reserva_equipe);
                $stmt->bindParam(':estimativa_custo', $estimativa_custo);

                $stmt->execute();
                return true; // Retorna verdadeiro se a inserção for bem-sucedida
                echo json_encode('Pedido cadastrado com sucesso!');

            } catch (PDOException $e) {
                // Tratar erro de inserção
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao cadastrar pedido: ' . $e->getMessage()
                ]);
                return false; // Retorna falso se ocorrer um erro
            }
                      
    } // fim metodo addPedido

    public function addTransacao(
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
        $info_adicional) {

            try {
                // Inserir transação
                $queryAddTransacao = "INSERT INTO transacoes (
                    venc_mensal,
                    transacao,
                    situacao,
                    num_pgto,
                    valor_pgto,
                    metodo_pgto,
                    _id_pedido,
                    pedido,
                    contato,
                    metodos_contato,
                    info_adicional)
                  VALUES (
                    :venc_mensal,
                    :transacao,
                    :situacao,
                    :num_pgto,
                    :valor_pgto,
                    :metodo_pgto,
                    :_id_pedido,
                    :pedido,
                    :contato,
                    :metodos_contato,
                    :info_adicional)";

                $stmt = $this->conn->prepare($queryAddTransacao);

                // Bind parameters
                $stmt->bindParam(':venc_mensal', $venc_mensal);
                $stmt->bindParam(':transacao', $transacao);
                $stmt->bindParam(':situacao', $situacao);
                $stmt->bindParam(':num_pgto', $num_pgto);
                $stmt->bindParam(':valor_pgto', $valor_pgto);
                $stmt->bindParam(':metodo_pgto', $metodo_pgto);
                $stmt->bindParam(':_id_pedido', $_id_pedido);
                $stmt->bindParam(':pedido', $pedido);
                $stmt->bindParam(':contato', $contato);
                $stmt->bindParam(':metodos_contato', $metodos_contato);
                $stmt->bindParam(':info_adicional', $info_adicional);

                $stmt->execute();
                return true; // Retorna verdadeiro se a inserção for bem-sucedida

                echo json_encode('Transação cadastrada com sucesso!');
            } catch (PDOException $e) {
                // Tratar erro de inserção
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao cadastrar transação: ' . $e->getMessage()
                ]);
                return false; // Retorna falso se ocorrer um erro
            }
    } // fim metodo addTransacao

    /* $queryIdPedido = "SELECT * FROM pedidos ORDER BY timestamp DESC LIMIT 1"; */
    public function getIdPedido($_id_contato) {
        
        $queryIdPedido = "SELECT _id_pedido FROM pedidos WHERE _id_contato = $_id_contato ORDER BY timestamp DESC LIMIT 1";
        $stmt = $this->conn->prepare($queryIdPedido);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_id_pedido = $result['_id_pedido'];

        return $_id_pedido;
    }


} // fim classe addPedido

//$_id_contato = 3; // Exemplo de ID de contato
//$teste = new addPedido();
//$page = $teste->getIdPedido($_id_contato);
//var_dump($page);