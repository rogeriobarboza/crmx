<?php
require_once('../db_conn/dbConn.php');
$conn = new dbConn();

$_id_empresa = $_POST['_id_empresa'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$nome_produto = $_POST['nome_produto'] ?? '';
$descr_prod = $_POST['descr_prod'] ?? '';
$detalhar_prod = $_POST['detalhar_prod'] ?? '';
$custo_prod = $_POST['custo_prod'] ?? '';
$preco_prod = $_POST['preco_prod'] ?? '';
$status = $_POST['status'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Adiciona o produto ao banco de dados
        $stmt = $conn->connect()->prepare("INSERT INTO produtos (_id_empresa, categoria, nome_produto, descr_prod, detalhar_prod, custo_prod, preco_prod, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_id_empresa, $categoria, $nome_produto, $descr_prod, $detalhar_prod, $custo_prod, $preco_prod, $status]);
        
        echo "<script>alert('Produto adicionado com sucesso!');</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Erro ao adicionar produto: " . addslashes($e->getMessage()) . "');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Produtos</title>
    <link rel="stylesheet" href="public/assets/css/lista_pedido.css">
</head>
<body>

<?php

// Traz todos os produtos com uma consulta SQL simplificada
$query = $conn->connect()->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
//var_dump($query);

echo "<table border='1'>";
echo "<thead>";
echo "<tr>";

echo "<th>timestamp</th>";
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

    echo "<td>" . $produto['timestamp'] . "</td>";
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

<h1>Adicionar Produto</h1>

<form action="produtos" method="POST">

    <label for="empresa">Cadastro Empresa</label>
    <input type="text" id="empresa" name="empresa" required><br><br>

    <label for="_id_empresa">ID Empresa</label>
    <input type="text" id="_id_empresa" name="_id_empresa" required><br><br>

    <label for="nome_empresa">Nome Empresa</label>
    <input type="text" id="nome_empresa" name="nome_empresa" required><br><br>

    <label for="categoria">Categoria</label>
    <select id="categoria" name="categoria" required>
        <option value="casamento">Casamento</option>
        <option value="debutante">Debutante</option>
        <option value="aniversario">Aniversário</option>
        <option value="corporativo">Corporativo</option>
        <option value="outro">Outro</option>
    </select><br><br>

    <label for="nome_produto">Nome Produto</label>
    <input type="text" id="nome_produto" name="nome_produto" required><br><br>

    <label for="descr_prod">Descrição Produto</label>
    <input type="text" id="descr_prod" name="descr_prod" required><br><br>

    <label for="detalhar_prod">Detalhar Produto</label>
    <input type="text" id="detalhar_prod" name="detalhar_prod" required><br><br>

    <label for="custo_prod">Custo Produto</label>
    <input type="text" id="custo_prod" name="custo_prod" required><br><br>
    
    <label for="preco_prod">Preço Produto</label>
    <input type="text" id="preco_prod" name="preco_prod" required><br><br>

    <label for="status">Status</label>
    <select id="status" name="status" required>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
    </select><br><br>

    <input type="submit" value="Adicionar Produto">

    <input type="reset" value="Limpar Campos"><br><br>

</form>

    
</body>
</html>