<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crm/db_conn/dbConn.php';

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
        $valor_pagamento_1,
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
                    valor_pagamento_1,
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
                    :valor_pagamento_1, 
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
                $stmt->bindParam(':valor_pagamento_1', $valor_pagamento_1);
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


    // Método para pegar o "id do pedido" após o cadastro do pedido
    public function getIdPedido($_id_contato) {
        
        $queryIdPedido = "SELECT _id_pedido FROM pedidos WHERE _id_contato = $_id_contato ORDER BY timestamp DESC LIMIT 1";
        $stmt = $this->conn->prepare($queryIdPedido);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_id_pedido = $result['_id_pedido'];

        return $_id_pedido;
        
    } // Fim metodo getIdPedido


    // Método para inserir transação
    public function addTransacao(
        $_id_pedido,
        $_id_contato,
        $venc_mensal,
        $transacao,
        $situacao,
        $num_pgto,
        $valor_pgto,
        $metodo_pgto,
        $pedido,
        $contato,
        $metodos_contato,
        $info_adicional) {

            try {
                // Inserir transação
                $queryAddTransacao = "INSERT INTO transacoes (
                    _id_pedido,
                    _id_contato,
                    venc_mensal,
                    transacao,
                    situacao,
                    num_pgto,
                    valor_pgto,
                    metodo_pgto,
                    pedido,
                    contato,
                    metodos_contato,
                    info_adicional)
                  VALUES (
                    :_id_pedido,
                    :_id_contato,
                    :venc_mensal,
                    :transacao,
                    :situacao,
                    :num_pgto,
                    :valor_pgto,
                    :metodo_pgto,
                    :pedido,
                    :contato,
                    :metodos_contato,
                    :info_adicional)";

                $stmt = $this->conn->prepare($queryAddTransacao);

                // Bind parameters
                $stmt->bindParam(':_id_pedido', $_id_pedido);
                $stmt->bindParam(':_id_contato', $_id_contato);
                $stmt->bindParam(':venc_mensal', $venc_mensal);
                $stmt->bindParam(':transacao', $transacao);
                $stmt->bindParam(':situacao', $situacao);
                $stmt->bindParam(':num_pgto', $num_pgto);
                $stmt->bindParam(':valor_pgto', $valor_pgto);
                $stmt->bindParam(':metodo_pgto', $metodo_pgto);
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


    public function metodosContato($_id_contato) {
        // Lógica para buscar metodos de contato -------------
        $info_contato = "SELECT telefone,email FROM contatos WHERE _id_contato = :_id_contato"; // buscar o contato por ID
        $stmt = $this->conn->prepare($info_contato);
        $stmt->bindParam(':_id_contato', $_id_contato, PDO::PARAM_INT);
        $stmt->execute();
        $contato_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $contato_info; // Retorna o contato encontrado
    }


    public function vencs($data,$i) {
        // Lógica para calcular o vencimento para o ultimo dia do mês a partir do primeiro vencimento
        // Suponha que a data foi recebida via POST
        //$primeiroVencimento = $_POST['vencimento']; // Ex: "2025-05-31"
        //$vencimento1 = "2025-05-31"; // Data de vencimento mensal recebida (exemplo)

        // Converte para DateTime e força o primeiro dia do mês
        //$data = DateTime::createFromFormat('Y-m-d', $vencimento1)->modify('first day of this month');

        // Array para armazenar as 12 datas (primeira + 11 próximas)
        //$vencimentos = 0;
        //$i = 1; // Número de meses a serem adicionados (0 para o primeiro vencimento, 1 para o segundo, etc.)

        // Cria o objeto DateTime a partir da data recebida
        $data = new DateTime($data);

        // Clona a data original para não alterar a referência
        $novaData = clone $data;
        // Adiciona $i meses
        $novaData->modify("+$i months");
        // Define para o último dia do mês
        //$novaData->modify('last day of this month');
        // Adiciona ao array (formato desejado: Y-m-d)
        $vencimentos = $novaData->format('Y-m-d');

        return $vencimentos; // Retorna o array com as datas de vencimento
    }


    public function vencs31($vencimento1,$i) {
        // Lógica para calcular o vencimento para o ultimo dia do mês a partir do primeiro vencimento
        // Suponha que a data foi recebida via POST
        //$primeiroVencimento = $_POST['vencimento']; // Ex: "2025-05-31"
        //$vencimento1 = "2025-05-31"; // Data de vencimento mensal recebida (exemplo)

        // Converte para DateTime e força o primeiro dia do mês
        $data = DateTime::createFromFormat('Y-m-d', $vencimento1)->modify('first day of this month');

        // Array para armazenar as 12 datas (primeira + 11 próximas)
        $vencimentos = 0;
        //$i = 1; // Número de meses a serem adicionados (0 para o primeiro vencimento, 1 para o segundo, etc.)

        // Clona a data original para não alterar a referência
        $novaData = clone $data;
        // Adiciona $i meses
        $novaData->modify("+$i months");
        // Define para o último dia do mês
        $novaData->modify('last day of this month');
        // Adiciona ao array (formato desejado: Y-m-d)
        $vencimentos = $novaData->format('Y-m-d');

        return $vencimentos; // Retorna o array com as datas de vencimento
    }


    public function vencs12($vencimento1) {
        // Lógica para calcular os 12 vencimentos mensais a partir do primeiro vencimento
        // Suponha que a data foi recebida via POST
        //$primeiroVencimento = $_POST['vencimento']; // Ex: "2025-05-31"
        //$vencimento1 = "2025-05-31"; // Data de vencimento mensal recebida (exemplo)

        // Converte para DateTime e força o primeiro dia do mês
        $data = DateTime::createFromFormat('Y-m-d', $vencimento1)->modify('first day of this month');

        // Array para armazenar as 12 datas (primeira + 11 próximas)
        $vencimentos = [];

        for ($i = 0; $i < 12; $i++) {
            // Clona a data original para não alterar a referência
            $novaData = clone $data;
            // Adiciona $i meses
            $novaData->modify("+$i months");
            // Define para o último dia do mês
            $novaData->modify('last day of this month');
            // Adiciona ao array (formato desejado: Y-m-d)
            $vencimentos[] = $novaData->format('Y-m-d');
        }

        // Exemplo de saída
        //print_r($vencimentos);
        //var_dump($vencimentos); // Exibe as datas formatadas
    }



} // fim classe addPedido

//Exemplo de saída

//$_id_contato = 3; // Exemplo de ID de contato
//$obj = new addPedido();
//$page = $teste->getIdPedido($_id_contato);
//var_dump($page);


//$vencimento1 = "2025-05-31"; // Data de vencimento mensal recebida (exemplo)
//$obj = new addPedido();
//$proxVenc = $obj->vencs($vencimento1);
//print_r($vencimentos);
//var_dump($proxVenc); // Exibe as datas formatadas