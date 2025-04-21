<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
        <button type="submit">Buscar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = htmlspecialchars($_POST['id']);

        //var_dump($_POST['id']);

        require_once('../app/controller/ctrl_cadastro/ctrl_cadastro.php');
        $ctrlCadastro = new CtrlCadastro();
        //$cadastro = $ctrlCadastro->exibirCadastroPorId($id);
        $cadastro = $ctrlCadastro->exibirDadosCompletosPorId($id);
        var_dump($cadastro);

        $nome = $cadastro['nome_completo'] ?? 'Nome não encontrado';
        $telefone = $cadastro['telefone'] ?? 'Telefone não encontrado';
        
        $html = <<<HTML
        <h2>Cadastro Detalhado</h2>
        <p><strong>ID:</strong> $id</p>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>Telefone:</strong> $telefone</p>
        HTML;

        //echo $html;
        
        //var_dump($nome);

    } else {
        echo '<p>ID não encontrado.</p>';
    }
    ?>
</body>
</html>