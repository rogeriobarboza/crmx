<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/db_conn/dbConn.php';

class ListarPedidos {
    private $conn;

    public function __construct() {
        $db = new DbConn();
        $this->conn = $db->connect();
    }

    /**
     * Recupera todos os pedidos
     * @return array|false
     */
    public function getTodosPedidos() {
        try {
            $sql = "SELECT 
                    _id_pedido,
                    titulo_evento,
                    nome_contato,
                    data_reservada
                    FROM pedidos 
                    ORDER BY data_reservada DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (PDOException $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca pedidos pelo título do evento
     * @param string $titulo
     * @return array|false
     */
    public function getPedidosPorTitulo($titulo) {
        try {
            $sql = "SELECT 
                    _id_pedido,
                    titulo_evento,
                    nome_contato,
                    data_reservada
                    FROM pedidos 
                    WHERE titulo_evento LIKE :titulo
                    ORDER BY data_reservada DESC";
            
            $stmt = $this->conn->prepare($sql);
            $titulo = "%{$titulo}%";
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar pedidos por título: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca pedido pelo ID
     * @param int $id
     * @return array|false
     */
    public function getPedidoPorId($id) {
        try {
            $sql = "SELECT 
                    _id_pedido,
                    titulo_evento,
                    nome_contato,
                    data_reservada
                    FROM pedidos 
                    WHERE _id_pedido = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar pedido por ID: " . $e->getMessage());
            return false;
        }
    }
}

//$teste = new ListarPedidos();
//$pedidos = $teste->getTodosPedidos();
//var_dump($pedidos); // Para teste, remova ou comente esta linha em produção