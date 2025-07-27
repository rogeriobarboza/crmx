<?php
//include_once __DIR__ . '/../env/env.php';

/**
 * Conexão com um banco de dados SQLite usando PDO.
 *
 * Este script demonstra como se conectar a um banco de dados SQLite
 * baseado em arquivo.
 */

// O DSN (Data Source Name) para SQLite começa com 'sqlite:'.
// Para um banco de dados em arquivo, você especifica o caminho para o arquivo.
// Se o arquivo não existir, o SQLite tentará criá-lo.
$db_path = __DIR__ . '/../dbSqlite/crmx.sqlite';

// É uma boa prática garantir que o diretório do banco de dados exista.
$db_dir = dirname($db_path);
if (!is_dir($db_dir)) {
    mkdir($db_dir, 0775, true);
}

try {
    // Instancia o PDO para a conexão com o SQLite
    $sqlite = new PDO('sqlite:' . $db_path);

    // Define o modo de erro do PDO para exceção. É a forma recomendada de lidar com erros.
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Conectado ao SQLite com sucesso!<br><hr>';


} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe uma mensagem e termina o script.
    // Em um ambiente de produção, você deve registrar o erro em vez de exibi-lo.
    die("Erro ao conectar com o SQLite: " . $e->getMessage());
}

// EXEMPLOS

try {

    //// Define o modo de erro do PDO para exceção. É a forma recomendada de lidar com erros.
    //$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'Conectado ao SQLite com sucesso!<br><hr>';

    // --- EXEMPLOS DE QUERIES ---

    // 1. CREATE TABLE: Criar uma tabela (se ela não existir)
    // Usamos exec() porque este comando não retorna dados.
    $sqlite->exec("CREATE TABLE IF NOT EXISTS contatos (
                        id INTEGER PRIMARY KEY,
                        nome TEXT NOT NULL,
                        email TEXT NOT NULL UNIQUE,
                        criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
                   )");
    echo "Tabela 'contatos' criada ou já existente.<br>";

    // 2. INSERT: Inserir dados de forma segura com prepare() e execute()
    // "INSERT OR IGNORE" evita erros se tentarmos inserir um email que já existe (devido à restrição UNIQUE).
    $sql = "INSERT OR IGNORE INTO contatos (nome, email) VALUES (:nome, :email)";
    $stmt = $sqlite->prepare($sql);

    // Insere o primeiro contato
    $stmt->execute([':nome' => 'João Silva', ':email' => 'joao.silva@example.com']);
    if ($stmt->rowCount() > 0) {
        echo "Contato 'João Silva' inserido.<br>";
    }

    // Insere o segundo contato
    $stmt->execute([':nome' => 'Maria Souza', ':email' => 'maria.souza@example.com']);
    if ($stmt->rowCount() > 0) {
        echo "Contato 'Maria Souza' inserido.<br>";
    }

    // 3. SELECT: Consultar dados
    // Usamos query() para uma consulta simples. O resultado é percorrido com fetchAll().
    echo "<h3>Contatos no banco:</h3>";
    $query = $sqlite->query("SELECT id, nome, email FROM contatos");
    $contatos = $query->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($contatos);
    echo "</pre>";

    // 4. UPDATE: Atualizar um registro
    $sql_update = "UPDATE contatos SET email = :novo_email WHERE nome = :nome";
    $stmt_update = $sqlite->prepare($sql_update);
    $stmt_update->execute([
        ':novo_email' => 'joao.silva.novo@email.com',
        ':nome' => 'João Silva'
    ]);
    echo "Email do contato 'João Silva' atualizado.<br>";

    // 5. DELETE: Deletar um registro
    $sql_delete = "DELETE FROM contatos WHERE email = :email";
    $stmt_delete = $sqlite->prepare($sql_delete);
    $stmt_delete->execute([':email' => 'maria.souza@example.com']);
    echo "Contato 'Maria Souza' deletado.<br>";

    // Verificando o resultado final
    echo "<h3>Contatos após UPDATE e DELETE:</h3>";
    $query_final = $sqlite->query("SELECT id, nome, email FROM contatos");
    $contatos_finais = $query_final->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    print_r($contatos_finais);
    echo "</pre>";

    // Define o modo de erro do PDO para exceção. É a forma recomendada de lidar com erros.
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Conectado ao SQLite com sucesso!<br><hr>';

} catch (PDOException $e) {
    // Em caso de erro na conexão, exibe uma mensagem e termina o script.
    // Em um ambiente de produção, você deve registrar o erro em vez de exibi-lo.
    die("Erro ao conectar com o SQLite: " . $e->getMessage());
}

