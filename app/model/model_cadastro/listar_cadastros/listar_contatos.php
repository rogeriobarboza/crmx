<?php

require_once('../db_conn/dbConn.php');

class ListarContatos extends DbConn {

    public function buscarContatos() {
        try {
            $conn = $this->connect();
            
            $query = "SELECT * FROM contatos ORDER BY timestamp ASC";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar contatos: " . $e->getMessage());
            return false;
        }
    }

    public function buscarContatoPorId($id) {
        try {
            $conn = $this->connect();
            
            $query = "SELECT * FROM contatos WHERE cpf:id";
                     
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastro por ID: " . $e->getMessage());
            return false;
        }
    }

    public function buscarContatoPorCPF($cpf) {
        try {
            $conn = $this->connect();
            
            $query = "SELECT empresas.*, contatos.*
            FROM contatos 
            INNER JOIN empresas ON contatos._id_empresa = empresas._id
            WHERE contatos.cpf = :cpf;";
                     
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastro por nome: " . $e->getMessage());
            return false;
        }
    }


    public function buscarPedidoTransacaoPorId($_id_pedido) {
        try {
            $conn = $this->connect();
            
            // Query para contatos + empresas
            $query = "SELECT pedidos.*, transacoes.*
                    FROM pedidos 
                    LEFT JOIN transacoes ON transacoes._id_pedido = pedidos._id_pedido
                    WHERE pedidos._id_pedido = :id_pedido;";
    
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_pedido', $_id_pedido, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar dados completos: " . $e->getMessage());
            return false;
        }
    }
 
    

} // FIM DA CLASSE Listarcontatos