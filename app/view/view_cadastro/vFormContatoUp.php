<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Contato</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>

    <h1>Atualizar contato</h1>

    <form action="app/view/view_cadastro/fnUpContato.php" method="POST">

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
                fetch('app/view/view_cadastro/fnBuscarEmpresa.php?termo=' + encodeURIComponent(termo))
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
                fetch('app/view/view_cadastro/fnBuscarContato.php?termoContato=' + encodeURIComponent(termoContato) + '&idEmpresa=' + encodeURIComponent(idEmpresa))
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



        <input type="submit" value="Atualizar Contato">

        <input type="reset" value="Limpar Campos"><br><br>

    </form>
    
</body>
</html>
