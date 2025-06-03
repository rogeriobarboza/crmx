<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wcpfth=device-wcpfth, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
    <script src="public/assets/js/script.js" defer></script>
</head>
<body>
    <form method="POST" action="">
        <label for="cpf">cpf:</label>
        <input type="text" cpf="cpf" name="cpf" required>
        <label for="id_pedido">ID Pedido</label>
        <input type="text" id="id_pedido" name="id_pedido" required>
        <button type="submit">Buscar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cpf']) && isset($_POST['id_pedido'])) {
        $cpf = htmlspecialchars($_POST['cpf']);
        $_id_pedido = htmlspecialchars($_POST['id_pedido']);

        //var_dump($_POST['cpf']);

        require_once('../app/controller/ctrl_cadastro/ctrl_cadastro.php');
        $form_contrato = new CtrlCadastro();
        //$cadastro = $ctrlCadastro->exibirCadastroPorcpf($cpf);
        $contato = $form_contrato->exibirCadastroPorCPF($cpf);
        $pedidoTransacoes = $form_contrato->exibirPedidoTransacaoPorId($_id_pedido);
        var_dump($contato);
        var_dump($pedidoTransacoes);

        $nome = $cadastro['nome_completo'] ?? 'Nome não encontrado';
        $telefone = $cadastro['telefone'] ?? 'Telefone não encontrado';
        
        $html = <<<HTML
        <h2>Cadastro Detalhado</h2>
        <p><strong>cpf:</strong> $cpf</p>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>Telefone:</strong> $telefone</p>
        HTML;

        //echo $html;
        
        //var_dump($nome);

    } else {
        echo '<p>cpf não encontrado.</p>';
    }
    ?>
</body>
</html>