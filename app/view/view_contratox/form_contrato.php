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

        // Simulação de dados para exibição
        $dados = [
            '1' => ['nome' => 'João Silva', 'telefone' => '1234-5678', 'email' => 'joao@email.com'],
            '2' => ['nome' => 'Maria Oliveira', 'telefone' => '9876-5432', 'email' => 'maria@email.com']
        ];

        if (array_key_exists($id, $dados)) {
            $cadastro = $dados[$id];
            echo '<h3>Dados do Cadastro</h3>';
            echo '<p><strong>Nome:</strong> ' . htmlspecialchars($cadastro['nome']) . '</p>';
            echo '<p><strong>Telefone:</strong> ' . htmlspecialchars($cadastro['telefone']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($cadastro['email']) . '</p>';
        } else {
            echo '<p>ID não encontrado.</p>';
        }
    }
    ?>
</body>
</html>