<?php
require_once('../app/controller/ctrl_pedido/ctrl_pedido.php');
$lista_pedido = new ctrl_pedido();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Transações</title>
    <link rel="stylesheet" href="public/assets/css/lista_pedido.css">
</head>
<body>

<?php
require_once('../db_conn/dbConn.php');
$DbConnObj = new DbConn();
$conn = $DbConnObj->connect();
$sql = "SELECT * FROM transacoes ORDER BY venc_mensal";
$st = $conn->prepare($sql);
$st->execute();
$transacoes = $st->fetchAll(PDO::FETCH_ASSOC);
//var_dump($transacoes);

echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";

    echo "<th>timestamp</th>";
    echo "<th>_id_transacao</th>";
    echo "<th>_id_pedido</th>";
    echo "<th>_id_contato</th>";
    echo "<th>venc_mensal</th>";
    echo "<th>transacao</th>";
    echo "<th>situacao</th>";
    echo "<th>data_transacao</th>";
    echo "<th>num_pgto</th>";
    echo "<th>valor_pgto</th>";
    echo "<th>metodo_pgto</th>";
    echo "<th>pedido</th>";
    echo "<th>contato</th>";
    echo "<th>metodos_contato</th>";
    echo "<th>info_adicional</th>";

echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($transacoes as $transacao) {
    echo "<tr>";

    echo "<td>" . $transacao['timestamp'] . "</td>";
    echo "<td>" . $transacao['_id_transacao'] . "</td>";
    echo "<td>" . $transacao['_id_pedido'] . "</td>";
    echo "<td>" . $transacao['_id_contato'] . "</td>";
    echo "<td>" . $transacao['venc_mensal'] . "</td>";
    echo "<td>" . $transacao['transacao'] . "</td>";
    echo "<td>" . $transacao['situacao'] . "</td>";
    echo "<td>" . $transacao['data_transacao'] . "</td>";
    echo "<td>" . $transacao['num_pgto'] . "</td>";
    echo "<td>" . $transacao['valor_pgto'] . "</td>";
    echo "<td>" . $transacao['metodo_pgto'] . "</td>";
    echo "<td>" . $transacao['pedido'] . "</td>";
    echo "<td>" . $transacao['contato'] . "</td>";
    echo "<td>" . $transacao['metodos_contato'] . "</td>";
    echo "<td>" . $transacao['info_adicional'] . "</td>";

    echo "</tr>";
}

echo "</tbody>";
echo "</table>";



?>

</body>
</html>