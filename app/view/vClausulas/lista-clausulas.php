<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lista Clausulas</title>
</head>
<body>
    <?php include '../public/navLinks.php'; ?>

<h1>View Lista Clausulas</h1>
    
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";

// Processar exclusão quando o formulário for enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletar'])) {
    try {
        $conn = new dbConn();
        $conn = $conn->connect();
        $id = $_POST['id'];
        
        $stmt = $conn->prepare("DELETE FROM clausulas WHERE id = ?");
        $stmt->execute([$id]);
        
        echo "<p style='color: green;'>Cláusula excluída com sucesso!</p>";
    } catch(PDOException $e) {
        echo "<p style='color: red;'>Erro ao excluir cláusula: " . $e->getMessage() . "</p>";
    }
}

// Consulta para exibir as cláusulas
$conn = new dbConn();
$conn = $conn->connect();
$sql = "SELECT * FROM clausulas ORDER BY titulo ASC";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>ID Pai</th>
                <th>Tipo</th>
                <th>Nome Referência</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['_id_clausula']}</td>
                <td>{$row['id_pai']}</td>
                <td>{$row['tipo']}</td>
                <td>{$row['nome_ref']}</td>
                <td>{$row['titulo']}</td>
                <td>{$row['descricao']}</td>
                <td>
                    <form method='post' onsubmit='return confirm(\"Tem certeza que deseja excluir esta cláusula?\");'>
                        <input type='hidden' name='id' value='{$row['_id_clausula']}'>
                        <button type='submit' name='deletar'>Excluir</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhuma cláusula encontrada.";
}


?>

</body>
</html>