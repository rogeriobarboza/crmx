<?php

class DbConn {
    private $host = 'localhost';
    private $dbName = 'contrato_x';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Database connection successful.\n";
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
            error_log("Database connection error: " . $e->getMessage());
        }

        return $this->conn;
    }

/* */
    public function getTablesAndColumns() {
        $tablesAndColumns = [];

        try {
            $query = $this->conn->query("SHOW TABLES");
            $tables = $query->fetchAll(PDO::FETCH_COLUMN);

            foreach ($tables as $table) {
                $columnsQuery = $this->conn->query("SHOW COLUMNS FROM {$table}");
                $columns = $columnsQuery->fetchAll(PDO::FETCH_COLUMN);
                $tablesAndColumns[$table] = $columns;
            }
        } catch (PDOException $e) {
            error_log("Error fetching tables and columns: " . $e->getMessage());
        }

        return $tablesAndColumns;
    }


} // FIM DA CLASSE DbConn

// Instância da classe DbConn
//$dbConn = new DbConn();
//
//// Conectar ao banco de dados
//$conn = $dbConn->connect();
//
//// Exibe as tabelas e colunas para depuração
//var_dump($dbConn->getTablesAndColumns());