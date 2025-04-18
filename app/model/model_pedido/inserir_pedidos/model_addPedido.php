<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/db_conn/dbConn.php';

class addPedido {
    private $conn;

    public function __construct() {
        $db = new DbConn();
        $this->conn = $db->connect();
    }

    public function addPedido(
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
        $estimativa_custo) {

            try {
                $sql = "INSERT INTO pedidos (
                    _id_cadastro,
                    nome_contratante,
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
                    estimativa_custo
                ) VALUES (
                    :_id_cadastro, 
                    :nome_contratante, 
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
                    :estimativa_custo
                )";

                $stmt = $this->conn->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':_id_cadastro', $_id_cadastro);
                $stmt->bindParam(':nome_contratante', $nome_contratante);
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



} // fim classe addPedido



?>