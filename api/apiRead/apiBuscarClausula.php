<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crmx/db_conn/dbConn.php";


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
                SELECT _id_clausula AS id, id_pai, tipo, titulo, nome_ref, descricao 
                FROM clausulas 
                WHERE _id_clausula LIKE :termo 
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