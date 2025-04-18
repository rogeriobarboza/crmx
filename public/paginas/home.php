<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Contrato X</title>
    
</head>
<body>
    <div class="container">
        <h1>Página Home Contrato X</h1>

            <a href="cadastrar">Formulário de Cadastro</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="cadastrar-pedido">Cadastro de Pedidos</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="pedidos">Pedidos</a><br><br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="gerar-contrato">Gerar Contrato</a><br><br>
        
        <?php
        //require_once '../db_conn/dbConn.php';
        //$db_contrato_x = new DbConn();
        //$conn = $db_contrato_x->connect();
        //$info = $db_contrato_x->getTablesAndColumns();
        //echo "<h2>Tabelas e Colunas</h2>";
        //echo "<pre>";
        //print_r($info);
        //echo "</pre>";

        echo "Todas as pessoas cadastradas no sistema:<br><br>";
        include_once '../app/view/view_cadastro/lista_cadastro.php'

        ?>

    </div>
</body>
</html>