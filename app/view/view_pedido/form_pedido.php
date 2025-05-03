<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pedidos</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <h1>Cadastro Pedidos</h1>

    <a href="home">Home</a><br><br>

    <form action="app/controller/ctrl_pedido/ctrl_addPedido.php" method="POST">
        <h2>Pedido</h2>

        <label for="_id_contato">ID Cadastro</label>
        <input type="text" id="_id_contato" name="_id_contato" required><br><br>

        <label for="nome_contato">Nome do Contratante</label>
        <input type="text" id="nome_contato" name="nome_contato" required><br><br>

        <label for="produto_servico">Produto/Serviço</label>
        <input type="text" id="produto_servico" name="produto_servico" required><br><br>

        <label for="seguimento">Seguimento</label>
        <select id="seguimento" name="seguimento" required>
            <option value="casamento">Casamento</option>
            <option value="debutante">Debutante</option>
            <option value="aniversario">Aniversário</option>
            <option value="corporativo">Corporativo</option>
            <option value="outro">Outro</option>
        </select><br><br>

        <label for="titulo_evento">Título do Evento</label>
        <input type="text" id="titulo_evento" name="titulo_evento" required><br><br>

        <label for="data_reservada">Data Reservada</label>
        <input type="date" id="data_reservada" name="data_reservada" required><br><br>

        <label for="descricao_pedido">Descrição do Pedido</label>
        <textarea id="descricao_pedido" name="descricao_pedido" rows="4" required></textarea><br><br>

        <label for="participantes">Participantes</label>
        <input type="text" id="participantes" name="participantes"><br><br>

        <label for="observacoes">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="4"></textarea><br><br>

        <label for="numero_convidados">Número de Convidados</label>
        <input type="number" id="numero_convidados" name="numero_convidados" required><br><br>

        <label for="horario_convite">Horário do Convite</label>
        <input type="time" id="horario_convite" name="horario_convite" required><br><br>

        <label for="horario_inicio">Horário de Início</label>
        <input type="time" id="horario_inicio" name="horario_inicio" required><br><br>

        <h3>Informações Financeiras</h3>

        <label for="valor_original">Valor Original</label>
        <input type="number" id="valor_original" name="valor_original" step="0.01" required><br><br>

        <label for="valor_desconto">Valor Desconto</label>
        <input type="number" id="valor_desconto" name="valor_desconto" step="0.01"><br><br>

        <label for="valor_total">Valor Total</label>
        <input type="number" id="valor_total" name="valor_total" step="0.01" required><br><br>

        <label for="forma_pagamento">Forma de Pagamento</label>
        <select id="forma_pagamento" name="forma_pagamento" required>
            <option value="dinheiro">Dinheiro</option>
            <option value="cartao">Cartão</option>
            <option value="pix">PIX</option>
            <option value="transferencia">Transferência</option>
        </select><br><br>

        <label for="numero_pagamentos">Número de Pagamentos (entrada + parcelas)</label>
        <input type="number" id="numero_pagamentos" name="numero_pagamentos" required><br><br>

        <label for="valor_pagamento_1">Valor do Primeiro Pagamento (entrada)</label>
        <input type="number" id="valor_pagamento_1" name="valor_pagamento_1" step="0.01" required><br><br>

        <label for="data_pagamento_1">Data do Primeiro Pagamento</label>
        <input type="date" id="data_pagamento_1" name="data_pagamento_1"><br><br>

        <label for="vencimento_mensal">Data do 1º Vencimento Mensal</label>
        <input type="date" id="vencimento_mensal" name="vencimento_mensal" required><br><br>

        <label for="reserva_equipe">Reserva de Equipe</label>
        <textarea id="reserva_equipe" name="reserva_equipe" rows="4"></textarea><br><br>

        <label for="estimativa_custo">Estimativa de Custo</label>
        <input type="number" id="estimativa_custo" name="estimativa_custo" step="0.01"><br><br>

        <label for="info_adicional">Informações Adicionais</label>
        <input type="text" id="info_adicional" name="info_adicional"></label>


        <input type="submit" value="Cadastrar Pedido">
    </form>
    
</body>
</html>