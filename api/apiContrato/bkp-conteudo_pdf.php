<?php

    // Adiciona o estilo CSS para as margens
    echo "<style>
        
        body {
            margin: 1cm 0cm 1cm 0cm; /* Exemplo: Margens de 2cm em cima e embaixo, 3cm nas laterais */
            font-family: times-new-roman, serif; /* Define uma fonte padrão */
            font-size: 14px; /* Define um tamnho padrão */
        }
        
        h1 {
            margin-top: 0cm;
            margin-bottom: 0cm;
            font-size: 22px;
        }

        h2 {
            margin-top: 0cm; /* Espaçamento acima dos títulos de cláusula */
            margin-bottom: 0cm; /* Espaçamento acima dos títulos de cláusula */
            font-size: 18px;
        }

        .clausula {
            margin-left: 0cm; /* Indenta as cláusulas */
            margin-bottom: 0cm;
            font-size: 18px;
        }

        .subclausula {
            margin-left: 0cm; /* Indenta as sub-cláusulas */
            margin-bottom: 0cm;
        }

        .item {
            margin-left: 0cm; /* Indenta os itens */
            margin-bottom: 0cm;
        }
        
    </style>";

    require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";
    $conn = new dbConn();
    $pdo = $conn->connect();
    //$pdo = new PDO("mysql:host=localhost;dbname=crmx", "root", "");
    
    $idModelo = $idModelo_contrato;

    // Query modelo de contrato
    $modelo = $pdo->prepare("SELECT * FROM modelos_contratos WHERE id_modelo = ?");
    $modelo->execute([$idModelo]);
    $m = $modelo->fetch(PDO::FETCH_ASSOC);

    // Atribuição de valor_pgtos da query a variaveis para uso no HTML
    $id_modelo = $m['id_modelo'];
    $nome_modelo = $m['nome_modelo'];
    
    // Substituição de Strings - verifica se o nome do modelo contém "Denise" e substitui por "Rogerio"
    $texto = $m['nome_modelo'];
    $nome_modelo = str_ireplace('Denise', 'Rogerio', $texto);

    // Query cláusulas do modelo
    $clausulas = $pdo->prepare("
        SELECT 
            c._id_clausula, 
            c.titulo, 
            c.descricao, 
            c.tipo,
            c.nome_ref,
            p.titulo as pai
        FROM clausulas c
        LEFT JOIN clausulas p ON c.id_pai = p._id_clausula
        JOIN modelos_contratos_clausulas mc ON c._id_clausula = mc.id_clausula 
        WHERE mc.id_modelo = ?
        ORDER BY mc.ordem
    ");
    $clausulas->execute([$idModelo]);
    $clausulas = $clausulas->fetchAll(PDO::FETCH_ASSOC);

    


    // Converte o texto do pedido em array de subclausulas
    $subclausulas_pedido = converterBlocoParaArray($descricao_pedido);

    // Encontra a cláusula "Objeto do contrato" e adiciona as subclausulas
    foreach($clausulas as $key => $clausula) {
        if($clausula['tipo'] === 'clausula' && stripos($clausula['titulo'], 'Objeto do contrato') !== false) {
            // Insere as subclausulas logo após a cláusula pai
            array_splice($clausulas, $key + 1, 0, $subclausulas_pedido);
            break;
        }
    }

    

    


    // Agora continua com o loop principal existente
    $nClausulas = 0;
    $nSubclausulas = 0;
    $letra = 'a';

    foreach ($clausulas as $linha) {
        $tipo = $linha['tipo'];
        switch ($tipo) {
            case 'observacao':
                echo "<h2>" . htmlspecialchars($linha['titulo']) . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($linha['descricao'])) . "</p>";
                break;

            case 'clausula':
                $nClausulas++;
                $nSubclausulas = 0; // Reset contador de subclausulas
                $letra = 'a'; // Reset da letra
                echo "<h2>" . $nClausulas . ". " . htmlspecialchars($linha['titulo']) . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($linha['descricao'])) . "</p>";
                
                // Adiciona as transações após a cláusula "Forma de Pagamento"
                if(stripos($linha['titulo'], 'Forma de Pagamento') !== false) {
                    echo "<div class='subclausula'>";
                    getTransacoes($pdo, $_id_pedido);
                    echo "</div>";
                }
                break;

            case 'subclausula':
                $nSubclausulas++;
                $letra = 'a'; // Reset da letra para cada nova subcláusula
                echo "<h3 class='subclausula'>" . $nClausulas . "." . $nSubclausulas . ". " 
                    . htmlspecialchars($linha['titulo']) . "</h3>";
                echo "<p class='subclausula'>" . nl2br(htmlspecialchars($linha['descricao'])) . "</p>";
                break;

            case 'item':
                echo "<p class='item'><strong>" . $letra . ")</strong> " 
                    . nl2br(htmlspecialchars($linha['descricao'])) . "</p>";
                $letra++; // Incrementa a letra para o próximo item
                break;
        }
    }


    // Data de criação do contrato
    $dataCriacao = dataPorExtenso();
    echo "<br><p class='linha-centralizada'>Santo André, $dataCriacao</p><br>";

    // Campos de assinaturas
    echo "<p class='linha-centralizada'>Assinatura do contratante: ____________________________</p><br>";
    echo "<p class='linha-centralizada'>Assinatura do contratado: ____________________________</p><br>";
    
    // Exemplo de conteúdo adicional
    echo "<p class='linha-centralizada'>Este é um exemplo de conteúdo adicional que pode ser adicionado ao PDF.</p>";

    // Fim do conteúdo do PDF #######################################################################################



    // Primeiro adiciona quebras de linha antes e depois dos hifens
    $texto_com_quebras = preg_replace('/([-]{2,})/', "\n$1\n", $descricao_pedido);
    
    // Depois aplica o negrito aos números e primeira palavra
    $texto_formatado = preg_replace('/(\d+\.\d+\.\s*)/', '<strong>$1$2</strong>', $texto_com_quebras);

    // Depois aplica o negrito aos números e primeira palavra até o hífen
    $texto_formatado = preg_replace('/^(.*?)\s*-/', '<strong>$1</strong> -', $texto_com_quebras);
    
    // Envolve cada linha em uma tag p para melhor controle do espaçamento
    $linhas = explode("\n", $texto_formatado);
    $texto_final = array_map(function($linha) {
        return trim($linha) ? "<p>$linha</p>" : $linha;
    }, $linhas);
    
    echo implode("\n", $texto_final);






// FUNÇÕES ######################################################################################################

    // Função para converter o texto de blocos em um array estruturado
    /**
     * Converte um texto de blocos separados por hífens em um array estruturado.
     *
     * @param string $texto O texto a ser convertido.
     * @return array O array estruturado com as informações dos blocos.
     */
    function converterBlocoParaArray($texto) {
        // Divide o texto em blocos usando hífens como separador
        $blocos = preg_split('/\-{2,}/', $texto);
        $resultado = [];
        
        foreach($blocos as $bloco) {
            if(empty(trim($bloco))) continue;
            
            $linhas = explode("\n", trim($bloco));
            $descricao = [];
            $atual = [];
            
            foreach($linhas as $linha) {
                $linha = trim($linha);
                if(empty($linha)) continue;
                
                // Se encontrar linha começando com "Produto:"
                if(strpos($linha, 'Produto:') === 0) {
                    if(!empty($atual)) {
                        $resultado[] = $atual;
                    }
                    $atual = [
                        'tipo' => 'subclausula',
                        'titulo' => trim(substr($linha, 8)), // Remove "Produto:"
                        'descricao' => ''
                    ];
                }
                // Se encontrar linha começando com "item:"
                elseif(strpos($linha, 'item:') === 0) {
                    if(!empty($atual['descricao'])) {
                        $resultado[] = $atual;
                    }
                    $atual = [
                        'tipo' => 'item',
                        'descricao' => trim(substr($linha, 5)) // Remove "item:"
                    ];
                    $descricao = []; // Reinicia o array de descrição para o item
                }
                // Se não for Produto: mas estiver após um item:, acumula na descrição do item
                elseif(!empty($atual['tipo'])) {
                    if($atual['tipo'] == 'item') {
                        $atual['descricao'] .= "\n" . $linha;
                    } else {
                        $descricao[] = $linha;
                        $atual['descricao'] = implode("\n", $descricao);
                    }
                }
            }
            
            // Adiciona o último item se existir
            if(!empty($atual)) {
                $resultado[] = $atual;
            }
        }
        
        return $resultado;
    }


    function dataPorExtenso() {
        $meses = array(
            1 => 'janeiro',
            2 => 'fevereiro',
            3 => 'março',
            4 => 'abril',
            5 => 'maio',
            6 => 'junho',
            7 => 'julho',
            8 => 'agosto',
            9 => 'setembro',
            10 => 'outubro',
            11 => 'novembro',
            12 => 'dezembro'
        );
        
        $dia = date('d');
        $mes = $meses[date('n')];
        $ano = date('Y');
        
        return "$dia de $mes de $ano";
    }



    // Query transações pagamentos do pedido
    function getTransacoes($pdo, $_id_pedido) {
        $transacoes_pedido = $pdo->prepare("SELECT * FROM transacoes WHERE _id_pedido = ?");
        $transacoes_pedido->execute([$_id_pedido]);
        $transacoes_pedido = $transacoes_pedido->fetchAll(PDO::FETCH_ASSOC);

        foreach ($transacoes_pedido as $key => $transacao) {
            // Converte a string para DateTime usando createFromFormat
            $data = DateTime::createFromFormat('Y-m-d', $transacao['venc_mensal']);
            // Formata a data no padrão brasileiro
            $data_formatada = $data->format('d/m/Y');
            
            // Formata o valor_pgto da transação
            $valor_formatado = number_format($transacao['valor_pgto'], 2, ',', '.');

            $metodo_pgto = $transacao['metodo_pgto'];
            $info_adicional = $transacao['info_adicional'];

            // Número do pagamento
            $nPagamento = $key + 1;
            
            echo $nPagamento . "º pagamento " . " Dia " . $data_formatada . " no valor de R$ " . $valor_formatado . " através de " . $metodo_pgto . ". Obs:  " . $info_adicional . ".<br>";
        }
    }

    ?>