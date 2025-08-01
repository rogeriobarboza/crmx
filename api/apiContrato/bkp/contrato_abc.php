<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>contrato ABC</title>
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
                        top: -85px;
                        left: 0;
                        right: 0;
                        height: 70px;
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
                        content: "Página " counter(page) "/4";
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

                        line-height: 35px; /* mesmo valor da height */
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
                </style>
    </head>

        <body>

            <header>
                <div class="linha-superior">
                    <div class="coluna coluna-esquerda"><strong>ABC foto e video</strong></div>
                    <div class="coluna coluna-centro"><strong>Contrato de Prestação de Serviços</strong></div>
                    <div class="coluna coluna-direita page-number"></div>
                </div>
                <div class="linha-centralizada"><strong>de Fotografia e filmagem</strong></div>
                <div class="linha-centralizada">Casamento Debutante Aniversário</div>
            </header>

            <footer>
                <div>Rodapé institucional da empresa</div>
            </footer>

            <div class="content">

            <!-- ------------ Aqui você pode adicionar o conteúdo do PDF ----------- -->

            <p>Por este instrumento particular, as partes a seguir nomeadas e no final assinadas, têm entre si, certo e convencionado o contrato de prestação de serviços de FOTOGRAFIA, e ou, FILMAGEM:</p>

            <h1>DAS PARTES (ABc)</h1>

            <p>De um lado, como CONTRATANTE, <strong><?=$nome_completo?></strong>, RG 423731907, CPF 429.927.548-97, residente e domiciliado na Rua Vinte e Oito de Agosto, 34, Casa 4, Vila São Pedro, São Bernardo do Campo - SP, 09784125, e-mail renanxk2022@gmail.com, telefone 11 95113-8690.
Contato para recados: Aline Siqueira, e-mail alinesiqueiraline0@gmail.com, telefone 11 95113-8690.
</p>
            <p>De outro lado, como CONTRATADA, ROGERIO MORAIS BARBOZA, atuando sob o nome fantasia ABC foto e vídeo, CPF 303.294.908-42, com sede na Rua dos Maristas, 65 - Jardim Santo André, Santo André - SP, 09132-430, telefone (11) 97187-2119, e-mail contato@abcfotoevideo.com.br, website https://abcfotoevideo.com.br.</p>

            <h1>Relatório de Cliente</h1>
            <p>Nome: <strong><?= $nome ?></strong></p>
            <p>Data de geração: <strong><?= $data ?></strong></p><br><br>

            <?= $teste ?>

            <div id="descricao-pedido"><?php 
            // Primeiro adiciona quebras de linha antes e depois dos hifens
            $texto_com_quebras = preg_replace('/([-]{2,})/', "\n$1\n", $descricao_pedido);
            
            // Depois aplica o negrito aos números e primeira palavra
            //$texto_formatado = preg_replace('/(\d+\.\d+\.\s*)/', '<strong>$1$2</strong>', $texto_com_quebras);

            // Depois aplica o negrito aos números e primeira palavra até o hífen
            $texto_formatado = preg_replace('/^(.*?)\s*-/', '<strong>$1</strong> -', $texto_com_quebras);
            
            // Envolve cada linha em uma tag p para melhor controle do espaçamento
            $linhas = explode("\n", $texto_formatado);
            $texto_final = array_map(function($linha) {
                return trim($linha) ? "<p>$linha</p>" : $linha;
            }, $linhas);
            
            echo implode("\n", $texto_final);
            ?></div>

            
            <!-- Conteudo exemplo:
                <h1>Conteúdo do PDF</h1>
                <p>' . str_repeat("Esse é um parágrafo de exemplo para preencher várias páginas do PDF. ", 300) . '</p>
            -->
            </div>

        </body>
    </html>