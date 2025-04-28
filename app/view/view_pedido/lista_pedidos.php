<?php
require_once('../app/controller/ctrl_pedido/ctrl_pedido.php');
$lista_pedido = new ctrl_pedido();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="public/assets/css/lista_pedido.css">
</head>
<body>

<?php
$pedidos = $lista_pedido->exibirTodosPedidos(); // Chama o método para buscar os pedidos

try {   
    if ($pedidos) {
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Título do Evento</th>";
        echo "<th>Contato</th>";
        echo "<th>Data Reservada</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach ($pedidos as $pedido) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($pedido['titulo_evento']) . "</td>";
            echo "<td>" . htmlspecialchars($pedido['nome_contato']) . "</td>";
            echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($pedido['data_reservada']))) . "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Nenhum pedido encontrado.</p>";
    }

} catch (Exception $e) {
    echo "<p>Erro ao exibir pedidos: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
    
</body>
</html>