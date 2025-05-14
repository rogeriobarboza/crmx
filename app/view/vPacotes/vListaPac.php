<?php
require_once('../db_conn/dbConn.php');
$conn = new dbConn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Pacotes</title>
    <link rel="stylesheet" href="public/assets/css/lista_pedido.css">
</head>

<body>

<?php
// Traz todos os pacotes com uma consulta SQL simplificada
$pacs = $conn->connect()->query("SELECT * FROM pacotes")->fetchAll(PDO::FETCH_ASSOC);
//var_dump($pacs);

echo "<table border='1'>";
    echo "<thead>";
        echo "<tr>";

        echo "<th>timestamp</th>";
        echo "<th>_id_pacote</th>";
        echo "<th>_id_empresa</th>";
        echo "<th>nome_pacote</th>";
        echo "<th>descr_pacote</th>";
        echo "<th>detalhar_pacote</th>";
        echo "<th>_ids_produtos</th>";
        echo "<th>custo_pacote</th>";
        echo "<th>preco_pacote</th>";
        echo "<th>status</th>";

        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";

        foreach ($pacs as $pac) {
            echo "<tr>";
                echo "<td>$pac[timestamp]</td>";
                echo "<td>$pac[_id_pacote]</td>";
                echo "<td>$pac[_id_empresa]</td>";
                echo "<td>$pac[nome_pacote]</td>";
                echo "<td>$pac[descr_pacote]</td>";
                echo "<td>$pac[detalhar_pacote]</td>";
                echo "<td>$pac[_ids_produtos]</td>";
                echo "<td>$pac[custo_pacote]</td>";
                echo "<td>$pac[preco_pacote]</td>";
                echo "<td>$pac[status]</td>";

            echo "</tr>";
        }

        echo "</tbody>";
echo "</table><br><br>";

?>

<form action="">

        <label for="pacote">Pacote</label>
        <select name="pacote" id="pacote" onchange="preencherIdContato(this)">
            <option value="">Selecione o Pacote</option>
            <?php
                foreach ($pacs as $pac) {
                    echo '<option value="' . htmlspecialchars($pac['_id_pacote']) . '"data-detalhar="' . $pac['detalhar_pacote'] .  '">' . $pac['nome_pacote'] . ' - ID: ' . $pac['_id_pacote'] . '</option>';
                }
            ?>
        </select>
        <br><br>
        <!-- Substituir o textarea por um div editável -->
        <div id="descricao" contenteditable="true" style="border: 1px solid #ccc; min-height: 100px; padding: 10px;">
        </div>

        <script>
            function preencherIdContato(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                
                // Pegar nome do Pacote
                const nomePacote = selectedOption.text.split(' - ID: ')[0];
                
                // Pegar descrição do pacote
                const descricaoPacote = selectedOption.getAttribute('data-detalhar');
                
                // Preencher o campo de descrição com formatação HTML
                const descricaoElement = document.getElementById('descricao');
                descricaoElement.innerHTML = `<b>${nomePacote}</b>, ${descricaoPacote}` || '';
                
                // Aplicar estilos ao div
                descricaoElement.style.fontFamily = 'times new roman';
                descricaoElement.style.padding = '10px';
                descricaoElement.style.border = '1px solid #ccc';
                descricaoElement.style.borderRadius = '4px';
                descricaoElement.style.width = '100%';
                descricaoElement.style.minHeight = '100px';
            }
        </script>

</form>
    
</body>
</html>