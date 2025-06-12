<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pedidos</title>
    <!-- <link rel="stylesheet" href="public/assets/css/style.css"> -->
    <style>
        .campo-container-pedido {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        #sugestoes-pedido {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ccc;
            border-top: none;
            z-index: 1000;
        }

        .sugestaoPedido {
            padding: 8px;
            cursor: pointer;
        }

        .sugestaoPedido:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>Form Pedidos</h1>

    <form id="formPedido" method="POST">
        <h2>Pedido</h2>

        <label for="buscar_pedido">Buscar Pedido</label>
        <div class="campo-container-pedido">
            <input type="text" id="buscar_pedido" name="buscar_pedido" autocomplete="off">
            <div id="sugestoes-pedido"></div>
        </div>

        <label for="titulo_evento">Título do Evento/Pedido</label>
        <input type="text" id="titulo_evento" name="titulo_evento" required><br><br>

        <label for="contato">Buscar Contato</label>
        <select id="contato" name="contato" required onchange="preencherIdContato(this);">
            <option value="">Selecione o Contato</option>
            <?php
            require_once('../app/model/mContato/listar_cadastros/listar_contatos.php');
            $contatos = new ListarContatos();
            $contatos = $contatos->buscarContatos();
            foreach ($contatos as $contato) {
                echo '<option value="' . $contato['_id_contato'] . '" ' .
                     'data-nome="' . $contato['nome_completo'] . '"> Nome: ' . 
                     $contato['nome_completo'] . ' - ID: ' . $contato['_id_contato'] . 
                     '</option>';
            }
            ?>
        </select><br><br>

        <label for="_id_contato">ID do Contato</label>
        <input type="text" id="_id_contato" name="_id_contato" readonly><br><br>

        <label for="nome_contato">Nome do Contratante</label>
        <input type="text" id="nome_contato" name="nome_contato" required readonly><br><br>

        <script>
            function preencherIdContato(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                
                // Pegar o ID do value
                const idContato = selectedOption.value;
                // Pegar o nome do data-nome
                const nomeContato = selectedOption.getAttribute('data-nome');
                
                // Preencher o campo de exibição do ID
                document.getElementById('_id_contato').value = idContato || '';
                // Preencher o campo de nome
                document.getElementById('nome_contato').value = nomeContato || '';
                // Manter o valor do ID no campo hidden para o formulário
                //document.getElementById('_id_contato').value = idContato || '';
            }
        </script>

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
        <label for="descricao_pedido">Buscar itens/serviços/produtos (Objeto do Contrato)</label>

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

        <!-- Adicione um campo hidden para armazenar o ID do pedido -->
        <input type="hidden" id="id_pedido" name="id_pedido">

        <!-- Botões de ação -->
        <button type="button" id="btnCadastrar" onclick="cadastrarPedido()">Cadastrar Pedido</button>
        <button type="button" id="btnAtualizar" onclick="atualizarPedido()">Atualizar Pedido</button>
        <button type="button" id="btnDeletar" onclick="deletarPedido()">Deletar Pedido</button>

        <script>
        // Função para cadastrar novo pedido
        function cadastrarPedido() {
            if (!validarCamposObrigatorios()) {
                alert('Por favor, preencha todos os campos obrigatórios');
                return;
            }
            
            const formData = new FormData(document.getElementById('formPedido'));
            enviarPedido('api/apiCreate/apiCreatePedido.php', formData, 'Pedido cadastrado com sucesso!');
        }

        // Função para atualizar pedido
        function atualizarPedido() {
            if (!validarCamposObrigatorios()) {
                alert('Por favor, preencha todos os campos obrigatórios');
                return;
            }

            const idPedido = document.getElementById('id_pedido').value;
            if (!idPedido) {
                alert('Selecione um pedido para atualizar');
                return;
            }
            
            const formData = new FormData(document.getElementById('formPedido'));
            enviarPedido('api/apiUpdate/apiUpdatePedido.php', formData, 'Pedido atualizado com sucesso!');
        }

        // Função genérica para enviar pedido
        function enviarPedido(url, formData, mensagemSucesso) {
            const btnClicado = event.target;
            btnClicado.disabled = true;
            btnClicado.textContent = 'Enviando...';

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'sucesso') {
                    alert(mensagemSucesso);
                    window.location.href = 'lista_pedidos.php';
                } else {
                    alert('Erro: ' + data.mensagem);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao processar o pedido');
            })
            .finally(() => {
                btnClicado.disabled = false;
                btnClicado.textContent = btnClicado.textContent.replace('Enviando...', 
                    btnClicado.id === 'btnCadastrar' ? 'Cadastrar Pedido' : 'Atualizar Pedido');
            });
        }

        const inputBuscarPedido = document.getElementById('buscar_pedido');
        const sugestoesPedido = document.getElementById('sugestoes-pedido');

        // Modifique a função que preenche os dados do pedido na busca
        inputBuscarPedido.addEventListener('keyup', function() {
            const termo = inputBuscarPedido.value.trim();

            if (termo.length >= 1) {
                fetch('api/apiRead/apiBuscarPedido.php?termo=' + encodeURIComponent(termo))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na resposta do servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        sugestoesPedido.innerHTML = '';

                        if (data.status === 'sucesso' && Array.isArray(data.dados)) {
                            if (data.dados.length > 0) {
                                data.dados.forEach(pedido => {
                                    const div = document.createElement('div');
                                    div.classList.add('sugestaoPedido');
                                    div.textContent = `ID: ${pedido._id} - ${pedido.titulo_evento} - ${pedido.nome_contato || 'Sem contato'}`;
                                    
                                    div.addEventListener('click', function() {
                                        preencherFormularioPedido(pedido);
                                    });
                                    
                                    sugestoesPedido.appendChild(div);
                                });
                            } else {
                                sugestoesPedido.innerHTML = '<div class="sugestaoPedido">Nenhum pedido encontrado</div>';
                            }
                        } else {
                            throw new Error('Formato de dados inválido');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar pedidos:', error);
                        sugestoesPedido.innerHTML = '<div class="sugestaoPedido">Erro ao buscar pedidos: ' + error.message + '</div>';
                    });
            } else {
                sugestoesPedido.innerHTML = '';
            }
        });

        // Função auxiliar para preencher o formulário
        function preencherFormularioPedido(pedido) {
            document.getElementById('id_pedido').value = pedido._id;
            document.getElementById('titulo_evento').value = pedido.titulo_evento;
            document.getElementById('_id_contato').value = pedido._id_contato;
            document.getElementById('nome_contato').value = pedido.nome_contato;
            document.getElementById('seguimento').value = pedido.seguimento;
            document.getElementById('data_reservada').value = pedido.data_reservada;
            document.getElementById('descricao_pedido').value = pedido.descricao_pedido;
            document.getElementById('participantes').value = pedido.participantes;
            document.getElementById('observacoes').value = pedido.observacoes;
            document.getElementById('numero_convidados').value = pedido.numero_convidados;
            document.getElementById('horario_convite').value = pedido.horario_convite;
            document.getElementById('horario_inicio').value = pedido.horario_inicio;
            document.getElementById('valor_original').value = pedido.valor_original;
            document.getElementById('valor_desconto').value = pedido.valor_desconto;
            document.getElementById('valor_total').value = pedido.valor_total;
            
            sugestoesPedido.innerHTML = '';
            inputBuscarPedido.value = '';
        }
        </script>
    </form>
    
</body>
</html>