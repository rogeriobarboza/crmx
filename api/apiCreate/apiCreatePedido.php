<?php
header('Content-Type: application/json; charset=utf-8');

//require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';
//require_once '../../db_conn/dbConn.php';
//$DB = new dbConn();
//$conn = $DB->connect();

try {
    require_once '../../db_conn/dbConn.php';
    $DB = new dbConn();
    $conn = $DB->connect();

    // Verifica se a requisição é POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido');
    }

    // Recebe os dados do formulário
    $dados = [
        '_id_contato' => $_POST['_id_contato'] ?? null,
        'nome_contato' => $_POST['nome_contato'] ?? null,
        'titulo_pedido' => $_POST['titulo_pedido'] ?? null,
        'seguimento' => $_POST['seguimento'] ?? null,
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
    ];

    // Validação básica dos campos obrigatórios
    $camposObrigatorios = ['_id_contato', 'titulo_pedido', 'data_reservada', 'valor_total'];
    foreach ($camposObrigatorios as $campo) {
        if (empty($dados[$campo])) {
            throw new Exception("Campo obrigatório não preenchido: $campo");
        }
    }

    // Prepara a query SQL para inserção
    $sql = "INSERT INTO pedidos (
        _id_contato, 
        nome_contato, 
        titulo_pedido, 
        seguimento, 
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
        estimativa_custo
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $params = [
        $dados['_id_contato'],
        $dados['nome_contato'],
        $dados['titulo_pedido'],
        $dados['seguimento'],
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
        $dados['estimativa_custo']
    ];

    // Executa a query
    if ($stmt->execute($params)) {
        // Pedido criado com sucesso, agora insere as transações financeiras
        $_id_pedido = $conn->lastInsertId();
        $_id_contato = $dados['_id_contato'];
        $nome_contato = $dados['nome_contato'];
        $titulo_pedido = $dados['titulo_pedido'];
        $forma_pagamento = $dados['forma_pagamento'];
        $numero_pagamentos = (int)$dados['numero_pagamentos'];
        $valor_pagamento_1 = floatval($dados['valor_pagamento_1']);
        $data_pagamento_1 = $dados['data_pagamento_1'];
        $vencimento_mensal = $dados['vencimento_mensal'];
        $valor_total = floatval($dados['valor_total']);
        $info_add = $dados['observacoes'] ?? '';
        
        $transacao = "RECEITA";
        $situacao = "A RECEBER";
        $pedido = $titulo_pedido;
        $contato = $nome_contato;
        $metodo_pgto = $forma_pagamento;

        // Métodos de contato
        $info_metodos_contato = metodosContato($_id_contato);
        $telefone = $info_metodos_contato['telefone'] ?? "Não informado";
        $email = $info_metodos_contato['email'] ?? "Não informado";
        $metodos_contato = $telefone . ", " . $email;

        // Lógica de inserção das transações
        if ($valor_pagamento_1 > 0) {
            // Entrada
            $venc_mensal = $data_pagamento_1;
            $num_pgto = 1;
            $valor_pgto = $valor_pagamento_1;
            $info_adicional = "Entrada | $info_add";
            addTransacao($_id_pedido, $_id_contato, $venc_mensal, $transacao, $situacao, $num_pgto, $valor_pgto, $metodo_pgto, $pedido, $contato, $metodos_contato, $info_adicional);

            // Parcelas restantes
            $parcelas = $numero_pagamentos - 1;
            for ($i = 1; $i <= $parcelas; $i++) {
                $num_pgto = $i + 1;
                if ($i == 1) {
                    $venc_mensal = $vencimento_mensal;
                } else {
                    $venc_mensal = vencs($vencimento_mensal, $i - 1);
                }
                $valor_pgto = ($valor_total - $valor_pagamento_1) / $parcelas;
                $info_adicional = $info_add;
                addTransacao($_id_pedido, $_id_contato, $venc_mensal, $transacao, $situacao, $num_pgto, $valor_pgto, $metodo_pgto, $pedido, $contato, $metodos_contato, $info_adicional);
            }
        } else {
            // Sem entrada, tudo parcelado
            for ($i = 0; $i < $numero_pagamentos; $i++) {
                $num_pgto = $i + 1;
                if ($i == 0) {
                    $venc_mensal = $vencimento_mensal;
                } else {
                    $venc_mensal = vencs($vencimento_mensal, $i);
                }
                $valor_pgto = $valor_total / $numero_pagamentos;
                $info_adicional = $info_add;
                addTransacao($_id_pedido, $_id_contato, $venc_mensal, $transacao, $situacao, $num_pgto, $valor_pgto, $metodo_pgto, $pedido, $contato, $metodos_contato, $info_adicional);
            }
        }

        echo json_encode([
            'status' => 'sucesso',
            'mensagem' => 'Pedido criado com sucesso',
            '_id_pedido' => $conn->lastInsertId()
        ]);

    } else {
        $errorInfo = $stmt->errorInfo();
        throw new Exception("Erro ao criar pedido: " . $errorInfo[2]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => $e->getMessage()
    ]);

        
}

// Inserir transação após o cadastro do pedido ##############
/*
// INSERÇÃO NA TABELA DE TRANSAÇÕES
        // PREPARANDO DADOS/PARÂMETROS e INSERINDO NA TABELA DE TRANSAÇÕES == Prepara dados de TRANSAÇÃO "RECEITA" para inserção
        $_id_pedido = getIdPedido($_id_contato); // Ok - Recupera o ID do pedido inserido
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
        $info_metodos_contato = metodosContato($_id_contato); // Ok - Recupera os métodos de contato do cliente/contratante.
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
            addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
            $parcelas = $numero_pagamentos - 1; // Número de pagamentos restantes (parcelas)
            
            while($num_pgto <= $parcelas) {
                if ($num_pgto == 1) {
                    $venc_mensal = $vencimento_mensal; // form ->Data do 1º Vencimento Mensal
                } else {
                    $num_pgto--; // Decrementa o número do pagamento para calcular o vencimento mensal
                    $venc_mensal = vencs($vencimento_mensal,$num_pgto); // Data do vencimento mensal
                    $num_pgto++;
                }
                
                $num_pgto++; // Incrementa o número do pagamento
                $valor_pgto = ($valor_total - $valor_pagamento_1) / $parcelas; // Valor do pagamento
                $info_adicional = $info_add;
                // Chama o método para inserir a transação de entrada
                addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
            }
        } elseif($valor_pagamento_1 == 0) {
            $num_pgto = 0; // Número do pagamento (entrada)
            $info_adicional = $info_add;
            
            while($num_pgto < $numero_pagamentos) {
                if ($num_pgto < 1) {
                    $venc_mensal = $vencimento_mensal; // form ->Data do 1º Vencimento Mensal
                } else {
                    $venc_mensal = vencs($vencimento_mensal,$num_pgto); // Data do vencimento mensal
                }
                // Data do vencimento mensal
                $num_pgto++; // Incrementa o número do pagamento
                $valor_pgto = $valor_total / $numero_pagamentos; // Valor do pagamento
                // Chama o método para inserir a transação de entrada
                addTransacao($_id_pedido,$_id_contato,$venc_mensal,$transacao,$situacao,$num_pgto,$valor_pgto,$metodo_pgto,$pedido,$contato,$metodos_contato,$info_adicional);
            }
            //echo json_encode($transacao); // Retorna o ID da transação inserida

        } //else {echo "Nenhuma entrada informada.";}
        // FIM INSERÇÃO NA TABELA DE TRANSAÇÕES
    */



// FUNÇÕES #####################################


    // Função para adicionar um pedido (obsoleto)
    function addPedido(
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
        
        require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';
        //require_once '../../db_conn/dbConn.php';
        $DB = new dbConn();
        $conn = $DB->connect();

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

                $stmt = $conn->prepare($queryAddPedido);

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
                      
    } // fim function addPedido


    // Função para pegar o "id do pedido" após o cadastro do pedido
    function getIdPedido($_id_contato) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';
        //require_once '../../db_conn/dbConn.php';
        $DB = new dbConn();
        $conn = $DB->connect();
        
        $queryIdPedido = "SELECT _id_pedido FROM pedidos WHERE _id_contato = $_id_contato ORDER BY criado DESC LIMIT 1";
        $stmt = $conn->prepare($queryIdPedido);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_id_pedido = $result['_id_pedido'];

        return $_id_pedido;
        
    } // Fim função getIdPedido


    // Função para inserir transação
    function addTransacao(
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
            require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';
            //require_once '../../db_conn/dbConn.php';
            $DB = new dbConn();
            $conn = $DB->connect();

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

                $stmt = $conn->prepare($queryAddTransacao);

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


    function metodosContato($_id_contato) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crmx/db_conn/dbConn.php';
        //require_once '../../db_conn/dbConn.php';
        $DB = new dbConn();
        $conn = $DB->connect();
        // Lógica para buscar metodos de contato -------------
        $info_contato = "SELECT telefone,email FROM contatos WHERE _id_contato = :_id_contato"; // buscar o contato por ID

        $stmt = $conn->prepare($info_contato);
        $stmt->bindParam(':_id_contato', $_id_contato, PDO::PARAM_INT);
        $stmt->execute();
        $contato_info = $stmt->fetch(PDO::FETCH_ASSOC);
        return $contato_info; // Retorna o contato encontrado
    }


    function vencs($data,$i) {
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


    function vencs31($vencimento1,$i) {
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


    function vencs12($vencimento1) {
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


// fim classe addPedido

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