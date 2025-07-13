<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produto</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

<?php include '../public/navLinks.php'; ?>

<h1>Gerenciar Produto</h1>

<<form method="POST">
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
                        // response: Não é um nome fixo, você pode escolher qualquer nome para esse parâmetro. Ele representa o objeto de resposta retornado pela função fetch(). Por padrão, muitos exemplos usam "response" para indicar que ali está a resposta da requisição HTTP feita ao servidor.
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
    
        <label for="_id_empresa">ID Empresa</label>
        <input type="number" id="_id_empresa" name="_id_empresa" readonly><br><br>

        <label for="nome_empresa">Nome Empresa</label>
        <input type="text" id="nome_empresa" name="nome_empresa" readonly><br><br><hr><br>

    
    <!-- Form para buscar o Produto -->
     <h2>Buscar Produto</h2>
     <div class="campo-container-produto">
        <input type="text" id="pesquisa-produto" placeholder="Digite o nome..." autocomplete="off">
        <div id="sugestoes-produto"></div>
    </div>

    <script>
        const inputProduto = document.getElementById('pesquisa-produto');
        const sugestoesProduto = document.getElementById('sugestoes-produto');

        inputProduto.addEventListener('keyup', function () {
            const termoProduto = inputProduto.value.trim();
            const idEmpresa = document.getElementById('_id_empresa').value; // Pega o ID da empresa selecionada

            if (termoProduto.length >= 1 && idEmpresa) {
                fetch('api/apiRead/apiBuscarProduto.php?termoProduto=' + encodeURIComponent(termoProduto) + '&idEmpresa=' + encodeURIComponent(idEmpresa))
                    .then(response => response.json())
                    .then(dados => {
                        sugestoesProduto.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestaoProduto');
                                // Alterando para usar as propriedades corretas do JSON
                                div.textContent = "ID: " + item._id_produto + ' - ' + item.nome_produto;
                                div.addEventListener('click', function () {
                                    inputProduto.value = item.nome_produto;
                                    // Preenchendo todos os campos do formulário
                                    document.getElementById('_id_produto').value = item._id_produto;
                                    document.getElementById('nome_produto').value = item.nome_produto;
                                    document.getElementById('categoria').value = item.categoria;
                                    document.getElementById('descr_prod').value = item.descr_prod;
                                    document.getElementById('detalhar_prod').value = item.detalhar_prod;
                                    document.getElementById('custo_prod').value = item.custo_prod;
                                    document.getElementById('preco_prod').value = item.preco_prod;
                                    document.getElementById('status').value = item.status;
                                    sugestoesProduto.innerHTML = '';
                                });
                                sugestoesProduto.appendChild(div);
                            });
                        } else {
                            sugestoesProduto.innerHTML = '<div class="sugestaoProduto">Nenhum resultado encontrado</div>';
                        }
                    });
            } else {
                sugestoesProduto.innerHTML = idEmpresa ? '' : '<div class="sugestaoProduto">Selecione uma empresa primeiro</div>';
            }
        });

        // Esconde sugestões ao clicar fora
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.campo-container-produto')) {
                sugestoesProduto.innerHTML = '';
            }
        });
    </script>
    <br><br>

    <!-- ref -->
    <label for="_id_produto">ID Produto</label>
    <input type="number" id="_id_produto" name="_id_produto" readonly><br><br>

    <label for="nome_produto">Nome Produto</label>
    <input type="text" id="nome_produto" name="nome_produto" required list="lista-produtos" autocomplete="off">
    <datalist id="lista-produtos"></datalist>
    <br><br>
    
    <!-- Dados do Produto -->

    <label for="categoria">Categoria</label>
    <input type="text" id="categoria" name="categoria" required><br><br>

    <label for="descr_prod">Descrição Produto</label>
    <input type="text" id="descr_prod" name="descr_prod" required><br><br>

    <label for="detalhar_prod">Detalhar Produto</label>
    <textarea id="detalhar_prod" name="detalhar_prod" rows="3" required></textarea><br><br>

    <label for="custo_prod">Custo Produto</label>
    <input type="text" id="custo_prod" name="custo_prod" required placeholder="Ex: 10.50"><br><br>
    
    <label for="preco_prod">Preço Produto</label>
    <input type="text" id="preco_prod" name="preco_prod" required placeholder="Ex: 15.99"><br><br>

    <label for="status">Status</label>
    <input type="text" id="status" name="status" required><br><br>

    <!-- ######## -->

        <input type="submit" id="btnCadastrarProduto" value="Cadastrar Produto"><br><br>

            <script>
            // Seleciona o formulário
            const formProduto = document.querySelector('form');
            const btnCadastrar = document.getElementById('btnCadastrarProduto');

            // Intercepta o submit do formulário
            formProduto.addEventListener('submit', function(e) {
                // Verifica se o botão clicado foi o "Cadastrar Produto"
                if (document.activeElement === btnCadastrar) {
                    e.preventDefault();

                    // Monta os dados do formulário
                    const formData = new FormData(formProduto);

                    fetch('api/apiCreate/apiCreateProduto.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(resp => resp.json())
                    .then(json => {
                        if (json.status === 'sucesso') {
                            alert('Produto cadastrado com sucesso! ID: ' + json._id_produto);
                            formProduto.reset();
                        } else {
                            alert('Erro ao cadastrar Produto: ' + (json.mensagem || 'Erro desconhecido'));
                        }
                    })
                    .catch(err => {
                        alert('Erro na requisição: ' + err);
                    });
                }
            });
            </script>
        
        <!-- ####### -->

        <input type="submit" id="btnAtualizarProduto" value="Atualizar Produto"><br><br>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnAtualizar = document.getElementById('btnAtualizarProduto');

            formProduto.addEventListener('submit', function (e) {
                if (document.activeElement === btnAtualizar) {
                    e.preventDefault();

                    const formData = new FormData(formProduto);

                    // Adiciona o campo '_id_produto' (caso ainda não esteja no form)
                    const idProduto = document.getElementById('_id_produto')?.value;
                    if (idProduto) {
                        formData.set('_id_produto', idProduto);
                    }

                    fetch('api/apiUpdate/apiUpdateProduto.php', {
                        method: 'POST',
                        body: formData // NÃO definir Content-Type aqui!
                    })
                    .then(resp => resp.json())
                    .then(json => {
                        if (json.status === 'sucesso') {
                            alert('Produto atualizado com sucesso!');
                            // formProduto.reset(); // Se quiser limpar o formulário
                        } else {
                            alert('Erro ao atualizar Produto: ' + (json.mensagem || 'Erro desconhecido'));
                        }
                    })
                    .catch(err => {
                        alert('Erro na requisição: ' + err);
                    });
                }
            });
        });
        </script>

        
        <!-- ####### -->


        <input type="button" id="btnDeletarProduto" value="Deletar Produto"><br><br>
            <script>
            // Seleciona o botão de deletar
            const btnDeletar = document.getElementById('btnDeletarProduto');
            
            btnDeletar.addEventListener('click', function() {
                const idProduto = document.getElementById('_id_produto').value;
            
                if (!idProduto) {
                    alert('Selecione um Produto para deletar.');
                    return;
                }
            
                if (!confirm('Tem certeza que deseja deletar este produto? Esta ação não pode ser desfeita.')) {
                    return;
                }
            
                const formData = new FormData();
                formData.append('_id_produto', idProduto);
            
                console.log('Antes do fetch');
                fetch('api/apiDelete/apiDeleteProduto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(resp => resp.json())
                .then(json => {
                    console.log(json); // Verificar o retorno
                    if (json.status === 'sucesso') {
                        alert('Produto deletado com sucesso!');
                        document.querySelector('form').reset();
                    } else {
                        alert('Erro ao deletar produto: ' + (json.mensagem || 'Erro desconhecido'));
                    }
                })
                .catch(err => {
                    console.error(err); // Adicione isso para verificar o erro
                    alert('Erro na requisição: ' + err);
                });
            });
            </script>

        <!-- ######## -->

        <input type="reset" value="Limpar Campos"><br><br>

</form>

</body>
</html>
