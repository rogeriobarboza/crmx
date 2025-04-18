<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Contratante</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
    
</head>
<body>
    <h1>Formulário Cadastro</h1>
    <a href="home">Home</a><br><br>

    <form action="app/controller/ctrl_cadastro/ctrl_cadastrar.php" method="POST">

        <h2>Contratante</h2>

        <label for="_id_empresa">ID Empresa:</label>
        <input type="text" id="_id_empresa" name="_id_empresa" required><br><br>

        <label for="tipo_cadastro">Tipo de Cadastro</label>
        <select id="tipo_cadastro" name="tipo_cadastro" required>
            <option value="cliente">Cliente</option>
            <option value="colaborador">Colaborador</option>
            <option value="parceiro">Parceiro</option>
        </select><br><br>


        <label for="nome">Nome completo:</label>
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


        <button type="submit">Cadastrar</button>
    </form>

    <?php
    

    ?>
    
</body>
</html>