<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Modelos de Contrato</title>
</head>
<body>
    <?php include '../public/navLinks.php'; ?>
    <h1>Lista Modelos de Contrato</h1>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";
    $conn = new dbConn();
    $conn = $conn->connect();

    // var_dump();
    //'modelos_contratos' => 
    //array (size=2)
    //  0 => string 'id_modelo' (length=9)
    //  1 => string 'nome_modelo' (length=11)

    // Consulta para obter os modelos de contrato
    $sql = "SELECT * FROM modelos_contratos ORDER BY nome_modelo ASC";
    // Executa a consulta
    $result = $conn->query($sql);
    if ($result->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID Modelo</th>
                    <th>Nome do Modelo</th>
                </tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['id_modelo']}</td>
                    <td>{$row['nome_modelo']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum modelo de contrato encontrado.";
    }
    
    ?>

    
    
    
</body>
</html>