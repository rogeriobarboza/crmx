<?php
require_once('../app/controller/ctrl_cadastro/ctrl_cadastro.php');
$lista_cadastro = new CtrlCadastro();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Cadastro</title>
    <link rel="stylesheet" href="public/assets/css/lista_cadastro.css">
</head>
<body>

<?php

$cadastros = $lista_cadastro->exibirCadastros(); // Chama o método para buscar os cadastros

try {   
    if ($cadastros) {
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Nome</th>";
        echo "<th>Email</th>";
        echo "<th>Telefone</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach ($cadastros as $cadastro) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($cadastro['_id_cadastro']) . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['nome_completo']) . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['email']) . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['telefone']) . "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Nenhum cadastro encontrado.</p>";
    }

    } catch (Exception $e) {
        echo "<p>Erro ao exibir cadastros: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
?>
    
</body>
</html>