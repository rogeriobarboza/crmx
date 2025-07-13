<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pedido</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

<?php include '../public/navLinks.php'; ?>

    <h1>Gerenciar Pedido</h1>

    <form method="POST">
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
                    fetch('api/apiRead/apiBuscarEmpresa.php?termo=' + encodeURIComponent(termo))
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
                fetch('api/apiRead/apiBuscarContato.php?termoContato=' + encodeURIComponent(termoContato) + '&idEmpresa=' + encodeURIComponent(idEmpresa))
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
                                    document.getElementById('_id_contato').value = item._id_contato;
                                    document.getElementById('tipo_contato').value = item.tipo_contato;
                                    document.getElementById('nome_contato').value = item.nome_completo;
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


        <label for="nome_contato">Nome completo:</label>
        <input type="text" id="nome_contato" name="nome_contato" required><br><br><hr><br>

        <!-- ############ -->

        <label for="titulo_pedido">Título do Pedido</label>
        <div class="campo-container-titulo">
            <input type="text" id="titulo_pedido" name="titulo_pedido" required autocomplete="off">
            <div id="sugestoes-titulo"></div>
        </div>
        <br><br>

        <script>
        // Autocomplete para Título do Pedido com preenchimento automático dos campos seguintes
        const inputTitulo = document.getElementById('titulo_pedido');
        const sugestoesTitulo = document.getElementById('sugestoes-titulo');

        inputTitulo.addEventListener('keyup', function() {
            const termo = inputTitulo.value.trim();
            const idContato = document.getElementById('_id_contato').value; // Pega o ID do contato selecionado
            if (termo.length >= 1 && idContato) {
                fetch('api/apiRead/apiBuscarPedido.php?termoPedido=' + encodeURIComponent(termo) + '&_id_contato=' + encodeURIComponent(idContato))
                    .then(response => response.json())
                    .then(resposta => {
                        const dados = resposta.dados || [];
                        sugestoesTitulo.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestao');
                                div.textContent = `ID: ${item._id_pedido} - ${item.titulo_pedido} (${item.nome_contato})`;
                                div.addEventListener('click', function() {
                                    // Preenche os campos do formulário com os dados do pedido
                                    document.getElementById('_id_pedido').value = item._id_pedido;
                                    document.getElementById('_id_contato').value = item._id_contato;
                                    inputTitulo.value = item.titulo_pedido;
                                    if(document.getElementById('seguimento')) document.getElementById('seguimento').value = item.seguimento || '';
                                    if(document.getElementById('data_reservada')) document.getElementById('data_reservada').value = item.data_reservada || '';
                                    if(document.getElementById('descricao_pedido')) document.getElementById('descricao_pedido').value = item.descricao_pedido || '';
                                    if(document.getElementById('participantes')) document.getElementById('participantes').value = item.participantes || '';
                                    if(document.getElementById('observacoes')) document.getElementById('observacoes').value = item.observacoes || '';
                                    if(document.getElementById('numero_convidados')) document.getElementById('numero_convidados').value = item.numero_convidados || '';
                                    if(document.getElementById('horario_convite')) document.getElementById('horario_convite').value = item.horario_convite || '';
                                    if(document.getElementById('horario_inicio')) document.getElementById('horario_inicio').value = item.horario_inicio || '';
                                    if(document.getElementById('valor_original')) document.getElementById('valor_original').value = item.valor_original || '';
                                    if(document.getElementById('valor_desconto')) document.getElementById('valor_desconto').value = item.valor_desconto || '';
                                    if(document.getElementById('valor_total')) document.getElementById('valor_total').value = item.valor_total || '';
                                    if(document.getElementById('forma_pagamento')) document.getElementById('forma_pagamento').value = item.forma_pagamento || '';
                                    if(document.getElementById('numero_pagamentos')) document.getElementById('numero_pagamentos').value = item.numero_pagamentos || '';
                                    if(document.getElementById('valor_pagamento_1')) document.getElementById('valor_pagamento_1').value = item.valor_pagamento_1 || '';
                                    if(document.getElementById('data_pagamento_1')) document.getElementById('data_pagamento_1').value = item.data_pagamento_1 || '';
                                    if(document.getElementById('vencimento_mensal')) document.getElementById('vencimento_mensal').value = item.vencimento_mensal || '';
                                    if(document.getElementById('reserva_equipe')) document.getElementById('reserva_equipe').value = item.reserva_equipe || '';
                                    if(document.getElementById('estimativa_custo')) document.getElementById('estimativa_custo').value = item.estimativa_custo || '';
                                    sugestoesTitulo.innerHTML = '';
                                });
                                sugestoesTitulo.appendChild(div);
                            });
                        } else {
                            sugestoesTitulo.innerHTML = '<div class="sugestao">Nenhum título encontrado</div>';
                        }
                    });
            } else {
                sugestoesTitulo.innerHTML = idContato ? '' : '<div class="sugestao">Selecione um contato primeiro</div>';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.campo-container-titulo')) {
                sugestoesTitulo.innerHTML = '';
            }
        });
        </script>

        

        <label for="_id_pedido">ID Pedido</label>
        <input type="number" id="_id_pedido" name="_id_pedido" readonly><br><br>

        <!-- <label for="nome_contato">Nome do Contato</label>
        <input type="text" id="nome_contato" name="nome_contato" readonly><br><br> -->

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
        // Script para buscar produtos/serviços e adicionar à descrição do pedido
        // Seleciona os elementos do DOM
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

        <!-- ####### -->

        <input type="submit" id="btnCadastrarPedido" value="Cadastrar Pedido"><br><br>

            <script>
            // Seleciona o formulário
            const formPedido = document.querySelector('form');
            const btnCadastrar = document.getElementById('btnCadastrarPedido');

            // Intercepta o submit do formulário
            formPedido.addEventListener('submit', function(e) {
                // Verifica se o botão clicado foi o "Cadastrar Pedido"
                if (document.activeElement === btnCadastrar) {
                    e.preventDefault();

                    // Monta os dados do formulário
                    const formData = new FormData(formPedido);

                    fetch('api/apiCreate/apiCreatePedido.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(resp => resp.json())
                    .then(json => {
                        if (json.status === 'sucesso') {
                            alert('Pedido cadastrado com sucesso! ID: ' + json._id_pedido);
                            formPedido.reset();
                        } else {
                            alert('Erro ao cadastrar pedido: ' + (json.mensagem || 'Erro desconhecido'));
                        }
                    })
                    .catch(err => {
                        alert('Erro na requisição: ' + err);
                    });
                }
            });
            </script>
        
        <!-- ####### -->

        <input type="submit" id="btnAtualizarPedido" value="Atualizar Pedido"><br><br>

            <script>
            // Seleciona o formulário e os botões
            const btnAtualizar = document.getElementById('btnAtualizarPedido');

            // Intercepta o submit do formulário
            formPedido.addEventListener('submit', function(e) {
                // Se o botão clicado foi o "Atualizar Pedido"
                if (document.activeElement === btnAtualizar) {
                    e.preventDefault();

                    // Monta os dados do formulário
                    const formData = new FormData(formPedido);

                    let idPedido = document.getElementById('_id_pedido').value
                    // Adiciona o campo '_id_pedido' para compatibilidade com o endpoint
                    formData.append('_id_pedido', idPedido);

                    fetch('api/apiUpdate/apiUpdatePedido.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(resp => resp.json())
                    .then(json => {
                        if (json.status === 'sucesso') {
                            alert('Pedido atualizado com sucesso!');
                            // Opcional: formPedido.reset();
                        } else {
                            alert('Erro ao atualizar pedido: ' + (json.mensagem || 'Erro desconhecido'));
                        }
                    })
                    .catch(err => {
                        alert('Erro na requisição: ' + err);
                    });
                }
            });
            </script>
        
        <!-- ####### -->


        <button type="button" id="btnDeletarPedido">Deletar Pedido</button>
            <script>
            // Seleciona o botão de deletar
            const btnDeletar = document.getElementById('btnDeletarPedido');
            
            btnDeletar.addEventListener('click', function() {
                const idPedido = document.getElementById('_id_pedido').value;
            
                if (!idPedido) {
                    alert('Selecione um pedido para deletar.');
                    return;
                }
            
                if (!confirm('Tem certeza que deseja deletar este pedido? Esta ação não pode ser desfeita.')) {
                    return;
                }
            
                const formData = new FormData();
                formData.append('_id_pedido', idPedido);
            
                fetch('api/apiDelete/apiDeletePedido.php', {
                    method: 'POST',
                    body: formData
                })
                .then(resp => resp.json())
                .then(json => {
                    if (json.status === 'sucesso') {
                        alert('Pedido deletado com sucesso!');
                        document.querySelector('form').reset();
                    } else {
                        alert('Erro ao deletar pedido: ' + (json.mensagem || 'Erro desconhecido'));
                    }
                })
                .catch(err => {
                    alert('Erro na requisição: ' + err);
                });
            });
            </script>
        

    </form>

    
    
</body>
</html>