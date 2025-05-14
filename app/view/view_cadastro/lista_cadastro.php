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
        echo "<th>timestamp</th>";
        echo "<th>_id_contato</th>";
        echo "<th>_id_empresa</th>";
        echo "<th>tipo_cadastro</th>";
        echo "<th>nome_completo</th>";
        echo "<th>rg</th>";
        echo "<th>cpf</th>";
        echo "<th>data_nasc</th>";
        echo "<th>naturalidade</th>";
        echo "<th>profissao</th>";
        echo "<th>cep</th>";
        echo "<th>rua</th>";
        echo "<th>numero</th>";
        echo "<th>complemento</th>";
        echo "<th>bairro</th>";
        echo "<th>cidade</th>";
        echo "<th>estado</th>";
        echo "<th>telefone</th>";
        echo "<th>email</th>";
        echo "<th>redes_sociais</th>";
        echo "<th>contato_recados</th>";
        echo "<th>telefone_recados</th>";
        echo "<th>email_recados</th>";
        echo "<th>origem</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach ($cadastros as $cadastro) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($cadastro['timestamp'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['_id_contato'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['_id_empresa'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['tipo_cadastro'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['nome_completo'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['rg'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['cpf'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['data_nasc'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['naturalidade'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['profissao'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['cep'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['rua'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['numero'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['complemento'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['bairro'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['cidade'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['estado'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['telefone'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['email'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['redes_sociais'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['contato_recados'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['telefone_recados'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['email_recados'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($cadastro['origem'] ?? '') . "</td>";
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