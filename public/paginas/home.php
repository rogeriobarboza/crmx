<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Contrato X</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
    
</head>
<body>
    <div class="container">
        <h1>Página Home Contrato X</h1>

        <!--
            <a href="cadastrar">Formulário de Cadastro</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="cadastrar-pedido">Cadastro de Pedidos</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="pedidos">Pedidos</a><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="gerar-contrato">Gerar Contrato</a><br><br>
        -->

        
        <?php

        /*
        // Lê o conteúdo do arquivo index.php
        $codigo = '';
        $indexPath = __DIR__ . '/../index.php';
        if (file_exists($indexPath)) {
            $codigo = file_get_contents($indexPath);
        } else {
            echo "Arquivo index.php não encontrado.<br>";
        }

        // Captura os valores dos cases
        preg_match_all('/case\s+[\'"]([^\'"]+)[\'"]\s*\:/', $codigo, $matches);

        // Gera os links em linha
        if (!empty($matches[1])) {
            foreach ($matches[1] as $i => $case) {
                echo "<a href='{$case}'>".ucfirst($case)."</a>";
                if ($i < count($matches[1]) - 1) {
                    echo " &nbsp;|&nbsp; ";
                }
            }
            echo "<br>";
        } else {
            echo "Nenhum case encontrado.";
        }
        */

        //require_once '../db_conn/dbConn.php';
        //$db_contrato_x = new DbConn();
        //$conn = $db_contrato_x->connect();
        //$info = $db_contrato_x->getTablesAndColumns();
        //echo "<h2>Tabelas e Colunas</h2>";
        //echo "<pre>";
        //print_r($info);
        //echo "</pre>";

        include_once '../app/view/vContato/lista_cadastro.php'

        ?>

    </div>
</body>
</html>