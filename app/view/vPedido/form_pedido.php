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

    <form action="app/controller/ctrl_pedido/ctrl_addPedido.php" method="POST">
        <h2>Pedido</h2>

        <!-- Form para buscar a empresa -->
        <h2>Buscar Empresa</h2>
    <div class="campo-container">
        <input type="text" id="pesquisa" placeholder="Digite o nome..." autocomplete="off">
        <div id="sugestoes"></div>
    </div>

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


        <label for="_id_empresa">ID Empresa</label>
        <input type="number" id="_id_empresa" name="_id_empresa" readonly><br><br>

        <label for="nome_empresa">Nome Empresa</label>
        <input type="text" id="nome_empresa" name="nome_empresa" readonly><br><br><hr>



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
        <input type="text" id="nome_completo" name="nome_completo" required><br><br><hr><br>

        <!-- ############ -->

        <label for="titulo_pedido">Titulo Pedido</label>
        <input type="text" id="titulo_pedido" name="titulo_pedido" required><br><br>

        <label for="seguimento">Seguimento</label>
        <select id="seguimento" name="seguimento" required>
            <option value="casamento">Casamento</option>
            <option value="debutante">Debutante</option>
            <option value="aniversario">Aniversário</option>
            <option value="corporativo">Corporativo</option>
            <option value="outro">Outro</option>
        </select><br><br>

        <label for="data_reservada">Data Reservada</label>
        <input type="date" id="data_reservada" name="data_reservada" required><br><br>


        <!-- Lógica para buscar e adicionar produto/serviço -->

        <label for="descricao_pedido">Descrição do Pedido (Objeto do Contrato)</label>

        <p>Buscar Item</p>
        <div class="campo-container-item">
            <input type="text" id="pesquisa_item" name="pesquisa_item" placeholder="Pesquisar por nome ou ID do Produto/Serviço/Pacote" autocomplete="off">
            <div id="sugestoes-item"></div>
        </div>

        <textarea id="descricao_pedido" name="descricao_pedido" rows="10" required></textarea><br><br>

        <script>
        const inputAddItem = document.getElementById('pesquisa_item');
        const sugestoesItem = document.getElementById('sugestoes-item');
        const descricaoPedido = document.getElementById('descricao_pedido');

        inputAddItem.addEventListener('keyup', function () {
            const termoProduto = inputAddItem.value.trim();

            if (termoProduto.length >= 1) {
            fetch('api/apiRead/apiBuscarItemFmContrato.php?termoProduto=' + encodeURIComponent(termoProduto))
                .then(response => response.json())
                .then(dados => {
                sugestoesItem.innerHTML = '';

                if (Array.isArray(dados) && dados.length > 0) {
                    dados.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('sugestaoPedido');
                    // Formatação da sugestão
                    div.textContent = "ID: " + item._id_produto + ' - ' + item.nome_produto + ' (' + item.categoria + ')';
                    div.title = item.descr_prod || '';
                    div.addEventListener('click', function () {
                        // Monta a descrição formatada do produto
                        const texto =
                        `Produto: ${item.nome_produto}\n` +
                        `Categoria: ${item.categoria}\n` +
                        (item.descr_prod ? `Descrição: ${item.descr_prod}\n` : '') +
                        (item.detalhar_prod ? `Detalhes: ${item.detalhar_prod}\n` : '') +
                        (item.preco_prod ? `Preço: R$ ${parseFloat(item.preco_prod).toFixed(2)}\n` : '') +
                        `Status: ${item.status}\n` +
                        `---\n`;
                        // Bkp 26 hiféns: --------------------------

                        // Adiciona ao textarea (acumula produtos)
                        if (descricaoPedido.value.trim() !== '') {
                        descricaoPedido.value += '\n' + texto;
                        } else {
                        descricaoPedido.value = texto;
                        }
                        sugestoesItem.innerHTML = '';
                        inputAddItem.value = '';
                    });
                    sugestoesItem.appendChild(div);
                    });
                } else {
                    sugestoesItem.innerHTML = '<div class="sugestaoPedido">Nenhum resultado encontrado</div>';
                }
                })
                .catch(error => {
                    sugestoesItem.innerHTML = '<div class="sugestaoPedido">Erro ao buscar produtos</div>';
                    console.error('Erro ao buscar produtos:', error);
                });
            } else {
            sugestoesItem.innerHTML = '';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.campo-container-item')) {
            sugestoesItem.innerHTML = '';
            }
        });
        </script>
        <!-- Fim da lógica para buscar e adicionar produto/serviço -->

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

        <label for="info_adicional">Informações Adicionais</label>
        <input type="text" id="info_adicional" name="info_adicional"></label>


        <input type="submit" value="Cadastrar Pedido">
        <input type="submit" value="Atualizar Pedido">
        <input type="submit" value="Deletar Pedido">
    </form>
    
</body>
</html>