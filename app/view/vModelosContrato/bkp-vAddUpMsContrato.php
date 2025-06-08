<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crm/db_conn/dbConn.php";

// API para busca
if(isset($_GET['termo'])) {
    header('Content-Type: application/json');
    
    $conn = new dbConn();
    $pdo = $conn->connect();
    
    $termo = $_GET['termo'];
    
    if ($termo) {
        $stmt = $pdo->prepare("
            SELECT id_modelo, nome_modelo 
            FROM modelos_contratos 
            WHERE id_modelo LIKE :termo 
            OR nome_modelo LIKE :termo 
            LIMIT 10
        ");
        $stmt->execute([':termo' => "%$termo%"]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultados);
        exit;
    } else {
        echo json_encode([]);
        exit;
    }
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new dbConn();
    $pdo = $conn->connect();
    
    // Captura e sanitiza os dados
    $dados = [
        'id_modelo' => filter_input(INPUT_POST, 'id_modelo', FILTER_SANITIZE_NUMBER_INT),
        'nome_modelo' => filter_input(INPUT_POST, 'nome_modelo', FILTER_SANITIZE_STRING)
    ];

    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    try {
        // ATUALIZAR
        if ($action === 'atualizar' && $dados['id_modelo']) {
            $sql = "UPDATE modelos_contratos 
                   SET nome_modelo = :nome_modelo 
                   WHERE id_modelo = :id_modelo";
            
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':id_modelo' => $dados['id_modelo'],
                ':nome_modelo' => $dados['nome_modelo']
            ]);

            if ($resultado) {
                echo "<script>alert('Modelo atualizado com sucesso!');</script>";
            }
        }

        // EXCLUIR
        else if ($action === 'excluir' && $dados['id_modelo']) {
            $sql = "DELETE FROM modelos_contratos WHERE id_modelo = :id_modelo";
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([':id_modelo' => $dados['id_modelo']]);

            if ($resultado) {
                echo "<script>
                        alert('Modelo excluído com sucesso!');
                        window.location.href = 'view-modelos-contrato';
                      </script>";
            }
        }

        // ADICIONAR
        else if (!$dados['id_modelo']) {
            $sql = "INSERT INTO modelos_contratos (nome_modelo) VALUES (:nome_modelo)";
            
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([':nome_modelo' => $dados['nome_modelo']]);

            if ($resultado) {
                $novo_id = $pdo->lastInsertId();
                echo "<script>
                        alert('Modelo criado com sucesso! ID: " . $novo_id . "');
                        document.getElementById('id_modelo').value = '" . $novo_id . "';
                      </script>";
            }
        }

    } catch (PDOException $e) {
        error_log("Erro na operação com modelos de contrato: " . $e->getMessage());
        echo "<script>alert('Erro ao processar a operação. Por favor, tente novamente.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Modelos de Contrato</title>
    <style>
        .campo-container {
            position: relative;
            margin-bottom: 10px;
        }
        
        .sugestoes {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .sugestao {
            padding: 8px;
            cursor: pointer;
        }
        
        .sugestao:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>Gerenciar Modelos de Contrato</h1>

    <form method="POST">
        <div class="campo-container">
            <label for="buscar_modelo">Buscar Modelo:</label>
            <input type="text" id="buscar_modelo" placeholder="Digite para buscar..." autocomplete="off">
            <div id="sugestoes" class="sugestoes"></div>
        </div>

        <input type="hidden" id="id_modelo" name="id_modelo">
        
        <label for="nome_modelo">Nome do Modelo:</label>
        <input type="text" id="nome_modelo" name="nome_modelo" required><br><br>

        <button type="submit" name="action" value="adicionar">Adicionar</button><br><br>
        <button type="submit" name="action" value="atualizar">Atualizar</button><br><br>
        <button type="submit" name="action" value="excluir" onclick="return confirm('Tem certeza que deseja excluir este modelo?')">Excluir</button>
    </form>

    <script>
        const input = document.getElementById('buscar_modelo');
        const sugestoes = document.getElementById('sugestoes');

        input.addEventListener('keyup', function() {
            const termo = input.value.trim();

            if (termo.length >= 1) {
                fetch('app/view/vModelosContrato/vAddUpMsContrato.php?termo=' + encodeURIComponent(termo))
                    .then(response => response.json())
                    .then(dados => {
                        sugestoes.innerHTML = '';

                        if (dados.length > 0) {
                            dados.forEach(item => {
                                const div = document.createElement('div');
                                div.classList.add('sugestao');
                                div.textContent = `ID: ${item.id_modelo} - ${item.nome_modelo}`;
                                
                                div.addEventListener('click', function() {
                                    document.getElementById('id_modelo').value = item.id_modelo;
                                    document.getElementById('nome_modelo').value = item.nome_modelo;
                                    input.value = item.nome_modelo;
                                    sugestoes.innerHTML = '';
                                });
                                
                                sugestoes.appendChild(div);
                            });
                        } else {
                            sugestoes.innerHTML = '<div class="sugestao">Nenhum modelo encontrado</div>';
                        }
                    });
            } else {
                sugestoes.innerHTML = '';
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.campo-container')) {
                sugestoes.innerHTML = '';
            }
        });
    </script>
</body>
</html>