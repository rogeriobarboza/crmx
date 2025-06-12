<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Contrado</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

    <!-- ##### Dados do Contratante ###### -->
    <h1># Dados do contratante</h1>

    <form action="gerar-contrato" method="POST">

    <!-- Form para buscar a empresa -->
        <h2>Buscar Empresa</h2>
    <div class="campo-container">
        <input type="text" id="pesquisa" placeholder="Digite o nome..." autocomplete="off">
        <div id="sugestoes"></div>
    </div>
    
        <label for="_id_empresa">ID Empresa</label>
        <input type="number" id="_id_empresa" name="_id_empresa" readonly><br><br>

        <label for="nome_empresa">Nome Empresa</label>
        <input type="text" id="nome_empresa" name="nome_empresa" readonly><br><br>

    <script>
        const input = document.getElementById('pesquisa');
        const sugestoes = document.getElementById('sugestoes');

        input.addEventListener('keyup', function () {
            const termo = input.value.trim();

            if (termo.length >= 1) {
                fetch('app/view/vContato/fnBuscarEmpresa.php?termo=' + encodeURIComponent(termo))
                    .then(response => response.json())
                    .then(dados => {
                        sugestoes.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestao');
                                // Alterando para usar as propriedades corretas do JSON
                                div.textContent = "ID: " + item._id + ' - ' + item.empresa;
                                div.addEventListener('click', function () {
                                    input.value = item.empresa;
                                    // Opcional: se precisar guardar o ID da empresa
                                    document.getElementById('_id_empresa').value = item._id;
                                    document.getElementById('nome_empresa').value = item.empresa;
                                    sugestoes.innerHTML = '';
                                });
                                sugestoes.appendChild(div);
                            });
                        } else {
                            sugestoes.innerHTML = '<div class="sugestao">Nenhum resultado encontrado</div>';
                        }
                    });
            } else {
                sugestoes.innerHTML = '';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.campo-container')) {
                sugestoes.innerHTML = '';
            }
        });
    </script>
    <br><br>

    
    <!-- Form para buscar o Contato -->
        <h2>Buscar Contato</h2>
    <div class="campo-container-contato">
        <input type="text" id="pesquisa-contato" placeholder="Digite o nome..." autocomplete="off">
        <div id="sugestoes-contato"></div>
    </div>

    <script>
        const inputContato = document.getElementById('pesquisa-contato');
        const sugestoesContato = document.getElementById('sugestoes-contato');

        inputContato.addEventListener('keyup', function () {
            const termoContato = inputContato.value.trim();
            const idEmpresa = document.getElementById('_id_empresa').value; // Pega o ID da empresa selecionada

            if (termoContato.length >= 1 && idEmpresa) {
                fetch('app/view/vContato/fnBuscarContato.php?termoContato=' + encodeURIComponent(termoContato) + '&idEmpresa=' + encodeURIComponent(idEmpresa))
                    .then(response => response.json())
                    .then(dados => {
                        sugestoesContato.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestaoContato');
                                // Alterando para usar as propriedades corretas do JSON
                                div.textContent = "ID: " + item._id_contato + ' - ' + item.nome_completo;
                                div.addEventListener('click', function () {
                                    inputContato.value = item.nome_completo;
                                    // Preenchendo todos os campos do formulário
                                    document.getElementById('_id_empresa').value = item._id_empresa;
                                    document.getElementById('_id_contato').value = item._id_contato;
                                    document.getElementById('tipo_contato').value = item.tipo_contato;
                                    document.getElementById('nome_completo').value = item.nome_completo;
                                    document.getElementById('rg').value = item.rg;
                                    document.getElementById('cpf').value = item.cpf;
                                    document.getElementById('data_nasc').value = item.data_nasc;
                                    document.getElementById('naturalidade').value = item.naturalidade;
                                    document.getElementById('profissao').value = item.profissao;
                                    document.getElementById('cep').value = item.cep;
                                    document.getElementById('rua').value = item.rua;
                                    document.getElementById('numero').value = item.numero;
                                    document.getElementById('complemento').value = item.complemento;
                                    document.getElementById('bairro').value = item.bairro;
                                    document.getElementById('cidade').value = item.cidade;
                                    document.getElementById('estado').value = item.estado;
                                    document.getElementById('telefone').value = item.telefone;
                                    document.getElementById('email').value = item.email;
                                    document.getElementById('redes_sociais').value = item.redes_sociais;
                                    document.getElementById('contato_recados').value = item.contato_recados;
                                    document.getElementById('telefone_recados').value = item.telefone_recados;
                                    document.getElementById('email_recados').value = item.email_recados;
                                    document.getElementById('origem').value = item.origem;
                                    sugestoesContato.innerHTML = '';
                                });
                                sugestoesContato.appendChild(div);
                            });
                        } else {
                            sugestoesContato.innerHTML = '<div class="sugestaoContato">Nenhum resultado encontrado</div>';
                        }
                    });
            } else {
                sugestoesContato.innerHTML = idEmpresa ? '' : '<div class="sugestaoContato">Selecione uma empresa primeiro</div>';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.campo-container-contato')) {
                sugestoesContato.innerHTML = '';
            }
        });
    </script>
    <br><br>

        <label for="_id_contato">ID Contato</label>
        <input type="number" id="_id_contato" name="_id_contato" readonly><br><br>

        <label for="tipo_contato">Tipo de Cadastro</label>
        <select id="tipo_contato" name="tipo_contato" required>
            <option value="cliente">Cliente</option>
            <option value="colaborador">Colaborador</option>
            <option value="parceiro">Parceiro</option>
        </select><br><br>


        <label for="nome_completo">Nome completo:</label>
        <input type="text" id="nome_completo" name="nome_completo" required><br><br>

        <label for="rg">RG</label>
        <input type="text" id="rg" name="rg" required><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br><br>

        <label for="data_nasc">Data de nascimento</label>
        <input type="date" id="data_nasc" name="data_nasc" required><br><br>

        <label for="naturalidade">Natural de</label>
        <input type="text" id="naturalidade" name="naturalidade" required><br><br>

        <label for="profissao">Profissão</label>
        <input type="text" id="profissao" name="profissao" required><br><br>

        <!--ENDEREÇO-->
        <h2>Endereço</h2>
        <label for="cep">CEP</label>
        <input type="text" id="cep" name="cep" required><br><br>

        <label for="rua">Endereço</label>
        <input type="text" id="rua" name="rua" required><br><br>

        <label for="numero">Número</label>
        <input type="text" id="numero" name="numero" required><br><br>

        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="complemento"><br><br>

        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" required><br><br>

        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" required><br><br>

        <label for="estado">Estado</label>
        <input type="text" id="estado" name="estado" required><br><br>

        <!--CONTATO-->
        <h2>Contato</h2>
        
        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="redes_sociais">Redes sociais</label>
        <input type="text" id="redes_sociais" name="redes_sociais" placeholder="Redes sociais"><br><br>

        <!--CONTATO PARA RECADOS-->
        <h2>Contato para recados</h2>
        <label for="contato_recados">Nome:</label>
        <input type="text" id="contato_recados" name="contato_recados" required><br><br>

        <label for="telefone_recados">Telefone:</label>
        <input type="tel" id="telefone_recados" name="telefone_recados" required><br><br>

        <label for="email_recados">Email:</label>
        <input type="email" id="email_recados" name="email_recados" required><br><br>

        <!-- OUTROS DADOS -->
        <h2>Outros dados</h2>        
        <label for="origem">Como chegou até nós</label>
        <input type="text" id="origem" name="origem" placeholder="Como chegou até nós"><br><br>
        <br><br>
        <!-- ------------------------- -->


    <!-- ##### Dados do Pedido ###### -->
    <h1># Dados do Pedido</h1>

    <!-- Form para buscar o pedido -->
    <h2>Buscar Pedido</h2>
    <div class="campo-container-pedido">
        <input type="text" id="pesquisa-produto" placeholder="Digite o nome..." autocomplete="off">
        <div id="sugestoes-pedido"></div>
    </div>

    <script>
        const inputPedido = document.getElementById('pesquisa-produto');
        const sugestoesPedido = document.getElementById('sugestoes-pedido');

        inputPedido.addEventListener('keyup', function () {
            const termoPedido = inputPedido.value.trim();
            const idContato = document.getElementById('_id_contato').value; // Pega o ID da empresa selecionada

            if (termoPedido.length >= 1 && idContato) {
                fetch('api/apiRead/apiBuscarPedido.php?termoPedido=' + encodeURIComponent(termoPedido) + '&_id_contato=' + encodeURIComponent(idContato))
                    .then(response => response.json())
                    .then(dados => {
                        sugestoesPedido.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestaoPedido');
                                // Alterando para usar as propriedades corretas do JSON
                                div.textContent = "ID: " + item._id_pedido + ' - ' + item.produto_servico;
                                div.addEventListener('click', function () {
                                    inputPedido.value = item.produto_servico;
                                    // Preenchendo todos os campos do formulário
                                    document.getElementById('_id_pedido').value = item._id_pedido;
                                    document.getElementById('produto_servico').value = item.produto_servico;
                                    document.getElementById('seguimento').value = item.seguimento;
                                    document.getElementById('titulo_evento').value = item.titulo_evento;
                                    document.getElementById('data_reservada').value = item.data_reservada;
                                    document.getElementById('descricao_pedido').value = item.descricao_pedido;
                                    document.getElementById('participantes').value = item.participantes;
                                    document.getElementById('observacoes').value = item.observacoes;
                                    document.getElementById('numero_convidados').value = item.numero_convidados;
                                    document.getElementById('horario_convite').value = item.horario_convite;
                                    document.getElementById('horario_inicio').value = item.horario_inicio;
                                    document.getElementById('valor_original').value = item.valor_original;
                                    document.getElementById('valor_desconto').value = item.valor_desconto;
                                    document.getElementById('valor_total').value = item.valor_total;
                                    document.getElementById('forma_pagamento').value = item.forma_pagamento;
                                    document.getElementById('numero_pagamentos').value = item.numero_pagamentos;
                                    document.getElementById('valor_pagamento_1').value = item.valor_pagamento_1;
                                    document.getElementById('data_pagamento_1').value = item.data_pagamento_1;
                                    document.getElementById('vencimento_mensal').value = item.vencimento_mensal;
                                    document.getElementById('reserva_equipe').value = item.reserva_equipe;
                                    document.getElementById('estimativa_custo').value = item.estimativa_custo;
                                    sugestoesPedido.innerHTML = '';
                                });
                                sugestoesPedido.appendChild(div);
                            });
                        } else {
                            sugestoesPedido.innerHTML = '<div class="sugestaoPedido">Nenhum resultado encontrado</div>';
                        }
                    });
            } else {
                sugestoesPedido.innerHTML = idContato ? '' : '<div class="sugestaoPedido">Selecione uma empresa primeiro</div>';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.campo-container-pedido')) {
                sugestoesPedido.innerHTML = '';
            }
        });
    </script>
    <br><br>
        <label for="_id_pedido">ID Pedido</label>
        <input type="number" id="_id_pedido" name="_id_pedido" readonly><br><br>

        <label for="produto_servico">Produto/Serviço</label>
        <input type="text" id="produto_servico" name="produto_servico" required><br><br>

        <label for="seguimento">Seguimento</label>
        <input type="text" id="seguimento" name="seguimento" required></input><br><br>

        <label for="titulo_evento">Título do Evento</label>
        <input type="text" id="titulo_evento" name="titulo_evento" required><br><br>

        <label for="data_reservada">Data Reservada</label>
        <input type="date" id="data_reservada" name="data_reservada" required><br><br>

        <label for="descricao_pedido">Descrição do Pedido (Objeto do Contrato)</label>

        <textarea id="descricao_pedido" name="descricao_pedido" rows="10" required></textarea><br><br>

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
        <input type="number" id="valor_pagamento_1" name="valor_pagamento_1" step="0.01"><br><br>

        <label for="data_pagamento_1">Data do Primeiro Pagamento</label>
        <input type="date" id="data_pagamento_1" name="data_pagamento_1"><br><br>

        <label for="vencimento_mensal">Data do 1º Vencimento Mensal</label>
        <input type="date" id="vencimento_mensal" name="vencimento_mensal" required><br><br>

        <label for="reserva_equipe">Reserva de Equipe</label>
        <textarea id="reserva_equipe" name="reserva_equipe" rows="4"></textarea><br><br>

        <label for="estimativa_custo">Estimativa de Custo</label>
        <input type="number" id="estimativa_custo" name="estimativa_custo" step="0.01"><br><br>
        <!-- Fim dos dados do pedido -->

    <!-- -->
        <label for="modelo_contrato">Selecione o modelo de contrato</label>
        <select id="modelo_contrato" name="modelo_contrato" required>
            <option value="">Selecione um modelo</option>
            <?php
                $pdo = new PDO("mysql:host=localhost;dbname=contrato_x", "root", "");
                
                $stmt = $pdo->prepare("SELECT id_modelo, nome_modelo FROM modelos_contratos ORDER BY nome_modelo");
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $modelo) {
                    echo '<option value="' . htmlspecialchars($modelo['id_modelo']) . '">ID: ' . htmlspecialchars($modelo['id_modelo']) . " - "  . htmlspecialchars($modelo['nome_modelo']) . '</option>';
                }
            ?>
            
        </select><br><br>

        <input type="reset" value="Limpar Campos"><br><br>
        <input type="submit" value="Preencher Contrato"><br><br>


    </form>
    
</body>
</html>
