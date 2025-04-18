<?php

$contrato_abc = '
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
                <h1>Conteúdo do PDF</h1>
                <p>' . str_repeat("Esse é um parágrafo de exemplo para preencher várias páginas do PDF. ", 300) . '</p>
            </div>

        </body>
    </html>
';