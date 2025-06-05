<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Produto</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

    <h1>Atualizar Produto</h1>

    <form action="app/view/vProduto/fnUpProduto.php" method="POST">

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
                fetch('app/view/vProduto/fnBuscarEmpresa.php?termo=' + encodeURIComponent(termo))
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
        <input type="text" id="nome_empresa" name="nome_empresa" readonly><br><br>

    <!-- Form para buscar o produto -->
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
                fetch('app/view/vProduto/fnBuscarProduto.php?termoProduto=' + encodeURIComponent(termoProduto) + '&idEmpresa=' + encodeURIComponent(idEmpresa))
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

        <label for="_id_produto">ID Produto</label>
        <input type="number" id="_id_produto" name="_id_produto" readonly><br><br>

        <label for="nome_produto">Nome Produto</label>
        <input type="text" id="nome_produto" name="nome_produto"><br><br>

        <label for="categoria">Categoria</label>
        <input type="text" id="categoria" name="categoria"><br><br>

        <label for="descr_prod">Descrição Produto</label>
        <input type="text" id="descr_prod" name="descr_prod"><br><br>

        <label for="detalhar_prod">Detalhar Produto</label>
        <input type="text" id="detalhar_prod" name="detalhar_prod"><br><br>

        <label for="custo_prod">Custo Produto</label>
        <input type="text" id="custo_prod" name="custo_prod"><br><br>
        
        <label for="preco_prod">Preço Produto</label>
        <input type="text" id="preco_prod" name="preco_prod"><br><br>

        <label for="status">Status</label>
        <input type="text" id="status" name="status"><br><br>

        <input type="submit" value="Atualizar Produto">

        <input type="reset" value="Limpar Campos"><br><br>

    </form>
    
</body>
</html>
