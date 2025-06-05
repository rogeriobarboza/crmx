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
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <h1>Todos os pedidos cadastrados no sistema</h1>

<?php
$pedidos = $lista_pedido->exibirTodosPedidos(); // Chama o método para buscar os pedidos

try {   
    if ($pedidos) {
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";

        echo "<th>Ações</th>"; // Nova coluna
        echo "<th>criado</th>";
        echo "<th>modificado</th>";
        echo "<th>_id_contato</th>";
        echo "<th>_id_pedido</th>";
        echo "<th>nome_contato</th>";
        echo "<th>produto_servico</th>";
        echo "<th>seguimento</th>";
        echo "<th>titulo_evento</th>";
        echo "<th>data_reservada</th>";
        echo "<th>descricao_pedido</th>";
        echo "<th>participantes</th>";
        echo "<th>observacoes</th>";
        echo "<th>numero_convidados</th>";
        echo "<th>horario_convite</th>";
        echo "<th>horario_inicio</th>";
        echo "<th>valor_original</th>";
        echo "<th>valor_desconto</th>";
        echo "<th>valor_total</th>";
        echo "<th>forma_pagamento</th>";
        echo "<th>numero_pagamentos</th>";
        echo "<th>valor_pagamento_1</th>";
        echo "<th>data_pagamento_1</th>";
        echo "<th>vencimento_mensal</th>";
        echo "<th>reserva_equipe</th>";
        echo "<th>estimativa_custo</th>";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        foreach ($pedidos as $pedido) {
            echo "<tr>";

            echo "<td><button class='btn-editar'>Editar</button>
                      <button class='btn-excluir'>Excluir</button>
                  </td>";
            echo "<td>" . htmlspecialchars($pedido['criado'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['modificado'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['_id_contato'] ?? "Não informado") . "</td>";
            echo "<td class='id-pedido'>" . htmlspecialchars($pedido['_id_pedido'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['nome_contato'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['produto_servico'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['seguimento'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['titulo_evento'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['data_reservada'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['descricao_pedido'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['participantes'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['observacoes'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['numero_convidados'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['horario_convite'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['horario_inicio'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['valor_original'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['valor_desconto'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['valor_total'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['forma_pagamento'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['numero_pagamentos'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['valor_pagamento_1'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['data_pagamento_1'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['vencimento_mensal'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['reserva_equipe'] ?? "Não informado") . "</td>";
            echo "<td>" . htmlspecialchars($pedido['estimativa_custo'] ?? "Não informado") . "</td>";

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
    
<script>
    function redirectToDelete() {
        document.querySelectorAll('.btn-excluir').forEach(function(button) {
            button.addEventListener('click', function() {
            const linha = this.closest('tr');
            const id = linha.querySelector('.id-pedido').textContent;
            
            // Criar um formulário dinamicamente
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/projetos/crm/app/model/deleteById.php';
            
            // Criar input hidden para o ID
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_id_pedido';
            input.value = id;
            
            // Adicionar input ao form
            form.appendChild(input);
            
            // Adicionar form ao body
            document.body.appendChild(form);
            
            // Confirmar antes de enviar
            if (confirm('Tem certeza que deseja excluir este pedido?')) {
                form.submit();
            } else {
                document.body.removeChild(form);
            }
            });
        });
    }

    redirectToDelete();
    
</script>

</body>
</html>