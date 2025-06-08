<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crm/db_conn/dbConn.php";


// API
// Verifica se é uma requisição AJAX
if(isset($_GET['termo']) && isset($_GET['campo'])) {
    header('Content-Type: application/json');
    
    $conn = new dbConn();
    $pdo = $conn->connect();
    
    $termo = $_GET['termo'];
    $campo = $_GET['campo'];
    
    if ($termo) {
        if ($campo === 'busca_geral') {
            // Busca existente para o campo de busca geral
            $stmt = $pdo->prepare("
                SELECT id, id_pai, tipo, titulo, nome_ref, descricao 
                FROM clausulas 
                WHERE id LIKE :termo 
                OR titulo LIKE :termo 
                OR nome_ref LIKE :termo 
                LIMIT 10
            ");
            $stmt->execute([':termo' => "%$termo%"]);
        } 
        else if ($campo === 'titulo') {
            // Nova busca específica para títulos similares
            $stmt = $pdo->prepare("
                SELECT DISTINCT titulo 
                FROM clausulas 
                WHERE titulo LIKE :termo 
                ORDER BY titulo 
                LIMIT 10
            ");
            $stmt->execute([':termo' => "%$termo%"]);
        }
        
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultados);
        exit;
    } else {
        echo json_encode([]);
        exit;
    }
}
// Fim API

// Atualizar, Excluir ou Adicionar cláusulas
// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new dbConn();
    $pdo = $conn->connect();
    
    // Captura e sanitiza os dados do formulário
    $dados = [
        'id' => filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT),
        'id_pai' => filter_input(INPUT_POST, 'id_pai', FILTER_SANITIZE_NUMBER_INT) ?: null,
        'tipo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'tipo', FILTER_DEFAULT))),
        'titulo' => htmlspecialchars(trim(filter_input(INPUT_POST, 'titulo', FILTER_DEFAULT))),
        'nome_ref' => htmlspecialchars(trim(filter_input(INPUT_POST, 'nome_ref', FILTER_DEFAULT))),
        'descricao' => htmlspecialchars(trim(filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT)))
    ];

    // Verifica qual ação foi solicitada
    $action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);

    try {
        // LÓGICA PARA ATUALIZAR
        if ($action === 'atualizar' && $dados['id']) {
            $sql = "UPDATE clausulas 
                   SET id_pai = :id_pai,
                       tipo = :tipo,
                       titulo = :titulo,
                       nome_ref = :nome_ref,
                       descricao = :descricao
                   WHERE id = :id";
            
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':id' => $dados['id'],
                ':id_pai' => $dados['id_pai'],
                ':tipo' => $dados['tipo'],
                ':titulo' => $dados['titulo'],
                ':nome_ref' => $dados['nome_ref'],
                ':descricao' => $dados['descricao']
            ]);

            if ($resultado) {
                echo "<script>alert('Cláusula atualizada com sucesso!');</script>";
            }
        }

        // LÓGICA PARA EXCLUIR
        else if ($action === 'excluir' && $dados['id']) {
            // Primeiro verifica se existem cláusulas filhas
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM clausulas WHERE id_pai = :id");
            $stmt->execute([':id' => $dados['id']]);
            $tem_filhos = $stmt->fetchColumn() > 0;

            if ($tem_filhos) {
                echo "<script>alert('Não é possível excluir! Esta cláusula possui subcláusulas.');</script>";
            } else {
                $sql = "DELETE FROM clausulas WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $resultado = $stmt->execute([':id' => $dados['id']]);

                if ($resultado) {
                    echo "<script>
                            alert('Cláusula excluída com sucesso!');
                            window.location.href = 'view-clausulas';
                          </script>";
                }
            }
        }

        // LÓGICA PARA ADICIONAR
        else if (!$dados['id']) {
            $sql = "INSERT INTO clausulas (id_pai, tipo, titulo, nome_ref, descricao)
                   VALUES (:id_pai, :tipo, :titulo, :nome_ref, :descricao)";
            
            $stmt = $pdo->prepare($sql);
            $resultado = $stmt->execute([
                ':id_pai' => $dados['id_pai'],
                ':tipo' => $dados['tipo'],
                ':titulo' => $dados['titulo'],
                ':nome_ref' => $dados['nome_ref'],
                ':descricao' => $dados['descricao']
            ]);

            if ($resultado) {
                $novo_id = $pdo->lastInsertId();
                echo "<script>
                        alert('Cláusula criada com sucesso! ID: " . $novo_id . "');
                        document.getElementById('id').value = '" . $novo_id . "';
                      </script>";
            }
        }

    } catch (PDOException $e) {
        // Log do erro
        error_log("Erro na operação com cláusulas: " . $e->getMessage());
        echo "<script>alert('Erro ao processar a operação. Por favor, tente novamente.');</script>";
    }
}
// FIM Atualizar, Excluir ou Adicionar cláusulas




?>
<!-- ########################### -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lista Clausulas</title>
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
        
        #sugestoes {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
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

<h1>Adicionar/atualizar Clausula</h1>

<form action="AddUpClausulas" method="POST">
    <div class="campo-container">
        <label for="buscar_clausula">Buscar Clausula</label>
        <input type="text" id="buscar_clausula" name="buscar_clausula" placeholder="Buscar cláusula..." autocomplete="off">
        <div id="sugestoes"></div>
    </div>

    <label for="id">ID Clausula:</label>
    <input type="text" id="id" name="id" ><br>

    <div class="campo-container">
        <label for="src_clausula_pai">Buscar Clausula Pai</label>
        <input type="text" id="src_clausula_pai" name="src_clausula_pai" 
               placeholder="Buscar cláusula pai (opcional)" autocomplete="off">
        <div id="sugestoes-pai" class="sugestoes"></div>
    </div>

    <label for="id_pai">ID Pai:</label>
    <input type="text" id="id_pai" name="id_pai" placeholder="ID da cláusula pai (opcional)" autocomplete="off"><br>

    <label for="tipo">Tipo:</label>
    <input type="text" id="tipo" name="tipo" required><br>

    <div class="campo-container">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required autocomplete="off">
        <div id="sugestoes-titulo" class="sugestoes"></div>
    </div>

    <label for="nome_ref">Nome Referência:</label>
    <input type="text" id="nome_ref" name="nome_ref" required><br>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required></textarea><br>

    <button type="submit" name="action" value="atualizar">Atualizar</button><br><br>

    <button type="submit" name="action" value="excluir" onclick="return confirm('Tem certeza que deseja excluir esta cláusula?');">Excluir</button><br><br>

    <button type="submit">Adicionar</button><br><br>

</form>

<script>
// Script para buscar cláusulas e preencher o formulário
const input = document.getElementById('buscar_clausula');
const sugestoes = document.getElementById('sugestoes');

input.addEventListener('keyup', function() {
    const termo = input.value.trim();

    if (termo.length >= 1) {
        fetch('app/view/vClausulas/vAddUpClausulas.php?termo=' + encodeURIComponent(termo) + '&campo=busca_geral')
            .then(response => response.json())
            .then(dados => {
                sugestoes.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = `ID: ${item.id} - ${item.titulo}`;
                        
                        div.addEventListener('click', function() {
                            // Preenche todos os campos do formulário
                            document.getElementById('id').value = item.id;
                            document.getElementById('id_pai').value = item.id_pai;
                            document.getElementById('tipo').value = item.tipo;
                            document.getElementById('titulo').value = item.titulo;
                            document.getElementById('nome_ref').value = item.nome_ref;
                            document.getElementById('descricao').value = item.descricao;
                            
                            input.value = item.titulo;
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

// Adicionar este script junto aos outros scripts
// Script para buscar títulos similares e preencher o campo de título
const inputTitulo = document.getElementById('titulo');
const sugestoesTitulo = document.getElementById('sugestoes-titulo');

inputTitulo.addEventListener('keyup', function() {
    const termo = inputTitulo.value.trim();

    if (termo.length >= 1) {
        fetch(`app/view/vClausulas/vAddUpClausulas.php?termo=${encodeURIComponent(termo)}&campo=titulo`)
            .then(response => response.json())
            .then(dados => {
                sugestoesTitulo.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = item.titulo;
                        
                        div.addEventListener('click', function() {
                            inputTitulo.value = item.titulo;
                            sugestoesTitulo.innerHTML = '';
                        });
                        
                        sugestoesTitulo.appendChild(div);
                    });
                } else {
                    sugestoesTitulo.innerHTML = '<div class="sugestao">Nenhum título similar encontrado</div>';
                }
            });
    } else {
        sugestoesTitulo.innerHTML = '';
    }
});

// Script para buscar cláusula pai
const inputPai = document.getElementById('src_clausula_pai');
const sugestoesPai = document.getElementById('sugestoes-pai');

inputPai.addEventListener('keyup', function() {
    const termo = inputPai.value.trim();

    if (termo.length >= 1) {
        fetch('app/view/vClausulas/vAddUpClausulas.php?termo=' + encodeURIComponent(termo) + '&campo=busca_geral')
            .then(response => response.json())
            .then(dados => {
                sugestoesPai.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = `ID: ${item.id} - ${item.titulo}`;
                        
                        div.addEventListener('click', function() {
                            // Preenche apenas os campos relacionados à cláusula pai
                            document.getElementById('id_pai').value = item.id;
                            inputPai.value = item.titulo;
                            sugestoesPai.innerHTML = '';
                        });
                        
                        sugestoesPai.appendChild(div);
                    });
                } else {
                    sugestoesPai.innerHTML = '<div class="sugestao">Nenhuma cláusula pai encontrada</div>';
                }
            });
    } else {
        sugestoesPai.innerHTML = '';
    }
});

// Esconde sugestões ao clicar fora
document.addEventListener('click', function(e) {
    if (!e.target.closest('.campo-container')) {
        sugestoes.innerHTML = '';
        sugestoesTitulo.innerHTML = '';
        sugestoesPai.innerHTML = '';
    }
});
// Fim Script para buscar cláusulas e preencher o formulário
</script>


</body>
</html>