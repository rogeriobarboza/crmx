<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Produtos</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

<?php

include '../public/navLinks.php';
require_once('../db_conn/dbConn.php');
$conn = new dbConn();

?>

<?php

// Traz todos os produtos com uma consulta SQL simplificada
$query = $conn->connect()->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
//var_dump($query);

echo "<table border='1'>";
echo "<thead>";
echo "<tr>";

echo "<th>criado</th>";
echo "<th>modificado</th>";
echo "<th>_id_empresa</th>";
echo "<th>_id_produto</th>";
echo "<th>categoria</th>";
echo "<th>nome_produto</th>";
echo "<th>descr_prod</th>";
echo "<th>detalhar_prod</th>";
echo "<th>custo_prod</th>";
echo "<th>preco_prod</th>";
echo "<th>status</th>";

echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($query as $produto) {
    echo "<tr>";

    echo "<td>" . $produto['criado'] . "</td>";
    echo "<td>" . $produto['modificado'] . "</td>";
    echo "<td>" . $produto['_id_empresa'] . "</td>";
    echo "<td>" . $produto['_id_produto'] . "</td>";
    echo "<td>" . $produto['categoria'] . "</td>";
    echo "<td>" . $produto['nome_produto'] . "</td>";
    echo "<td>" . $produto['descr_prod'] . "</td>";
    echo "<td>" . $produto['detalhar_prod'] . "</td>";
    echo "<td>" . $produto['custo_prod'] . "</td>";
    echo "<td>" . $produto['preco_prod'] . "</td>";
    echo "<td>" . $produto['status'] . "</td>";

    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "<br><br>";

?>

    
</body>
</html>