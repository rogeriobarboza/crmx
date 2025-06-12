<?php
            $pdo = new PDO("mysql:host=localhost;dbname=contrato_x", "root", "");
            $idModelo = $modelo_contrato;

            // Query modelo de contrato
            $modelo = $pdo->prepare("SELECT * FROM modelos_contratos WHERE id_modelo = ?");
            $modelo->execute([$idModelo]);
            $m = $modelo->fetch(PDO::FETCH_ASSOC);

            // Atribuição de valor_pgtoes da query a variaveis para uso no HTML
            $id_modelo = $m['id_modelo'];
            $nome_modelo = $m['nome_modelo'];
            
            // Substituição de Strings - verifica se o nome do modelo contém "Denise" e substitui por "Rogerio"
            $texto = $m['nome_modelo'];
            $nome_modelo = str_ireplace('Denise', 'Rogerio', $texto);

            // Query cláusulas do modelo
            $clausulas = $pdo->prepare("
                SELECT 
                    c.id, 
                    c.titulo, 
                    c.descricao, 
                    c.tipo,
                    c.nome_ref,
                    p.titulo as pai
                FROM clausulas c
                LEFT JOIN clausulas p ON c.id_pai = p.id
                JOIN modelos_contratos_clausulas mc ON c.id = mc.id_clausula 
                WHERE mc.id_modelo = ?
                ORDER BY mc.ordem
            ");
            $clausulas->execute([$idModelo]);
            $clausulas = $clausulas->fetchAll(PDO::FETCH_ASSOC);

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

<html>
        <head>
            <style>
                * {font-family: Times New Roman, serif;
                    font-size: 11pt;}
            
                @page {
                    margin: 125px 50px;
                }

                body {
                    counter-reset: page;
                }

                header {
                    position: fixed;
                    top: -100px;
                    left: 0;
                    right: 0;
                    height: 80px;
                    font-size: 14px;
                    border-bottom: 1px solid #000;
                }

                .linha-superior {
                    display: table;
                    width: 100%;
                    table-layout: fixed;
                }

                .coluna {
                    display: table-cell;
                    vertical-align: middle;
                }

                .coluna-esquerda {
                    text-align: left;
                }

                .coluna-centro {
                    text-align: center;
                }

                .coluna-direita {
                    text-align: right;
                }

                .linha-centralizada {
                    text-align: center;
                    margin-top: 2px;
                    font-size: 13px;
                }

                .linha-centralizada strong {
                    font-size: 14px;
                }

                .page-number:after {
                    content: "Página " counter(page) "/";
                }

                footer {
                    position: fixed;
                    bottom: -125px;
                    left: 0;
                    right: 0;
                    height: 60px;
                    text-align: center;
                    font-size: 12px;
                    border-top: 1px solid #000;

                    line-height: 35px; /* mesmo valor_pgto da height */
                }

                .content {
                    font-size: 14px;
                    text-align: justify;
                }

                #descricao-pedido {
                    padding-left: 20px; /* Adiciona identação */
                }
                
                #descricao-pedido p {
                    margin: 5px 0;
                }

                /* Identação clausulas*/
                .subclausula {
                    margin-left: 30px;
                }
                .item {
                    margin-left: 60px;
                }
            </style>
        </head>
        <body>

            <header>
                <br><div class="linha-superior">
                    <div class="coluna coluna-esquerda" style="vertical-align: top;">ABCfotoevideo.com.br</div>
                    <div class="coluna coluna-centro" style="vertical-align: top;"><strong><?=$nome_modelo?> ABC foto e video nº <?=date('Y')?>-30329490842</strong></div>
                    <div class="coluna coluna-direita"></div>
                </div>
                <!-- <div class="linha-centralizada"><strong>de Fotografia e filmagem</strong></div>
                <div class="linha-centralizada">Casamento Debutante Aniversário</div> -->
            </header>

            <footer>
                <div>Rodapé institucional da empresa</div>
            </footer>

            <div class="content">

            <!-- ------------ Aqui você pode adicionar o conteúdo do PDF ----------- -->

            <?php

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
            // Fim do conteúdo do PDF

            ?>

            <!--
            <h1>DAS PARTES (carregar_modelo.php)</h1>

            <div id="descricao-pedido"><?php 
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
            ?></div>

            
            Conteudo exemplo:
                <h1>Conteúdo do PDF</h1>
                <p>' . str_repeat("Esse é um parágrafo de exemplo para preencher várias páginas do PDF. ", 300) . '</p>
            
            </div>
            -->

        </body>
    </html>

    <?php
    //var_dump($clausulas);
    // ##############

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
    
    // Exemplo de uso:
    /*
    $clausulas = converterBlocoParaArray($descricao_pedido);
    
    // Resultado esperado para o exemplo:
    [
        [
            'tipo' => 'subclausula',
            'titulo' => 'Making Of',
            'descricao' => "Categoria: Filmagem\nDescrição: Filmagem dos bastidores"
        ],
        [
            'tipo' => 'item',
            'descricao' => 'Vídeo resumo de 3-5 minutos, edição completa'
        ],
        [
            'tipo' => 'item',
            'descricao' => 'Preço: R$ 600.00'
        ],
        [
            'tipo' => 'item',
            'descricao' => 'Status: ativo'
        ]
    ]
    */

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