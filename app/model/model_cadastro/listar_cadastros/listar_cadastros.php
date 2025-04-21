<?php

require_once('../db_conn/dbConn.php');

class ListarCadastros extends DbConn {

    public function buscarCadastros() {
        try {
            $conn = $this->connect();
            
            $query = "SELECT * FROM cadastros ORDER BY timestamp ASC";

            $stmt = $conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastros: " . $e->getMessage());
            return false;
        }
    }

    public function buscarCadastroPorId($id) {
        try {
            $conn = $this->connect();
            
            $query = "SELECT * FROM cadastros WHERE _id_cadastro = :id";
                     
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastro por ID: " . $e->getMessage());
            return false;
        }
    }

    public function buscarCadastroPorNome($nome) {
        try {
            $conn = $this->connect();
            
            $query = "SELECT _id_empresa, _id_cadastro, tipo_cadastro, nome_completo, telefone, email 
                     FROM cadastros 
                     WHERE nome_completo LIKE :nome";
                     
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':nome', '%' . $nome . '%', PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastro por nome: " . $e->getMessage());
            return false;
        }
    }


    public function buscarDadosCompletosPorId($id) {
        try {
            $conn = $this->connect();
            
            // Query para cadastros + empresas
            $query = "SELECT empresas.*, cadastros.*, pedidos.*, transacoes.*
                            FROM cadastros 
                            INNER JOIN empresas ON cadastros._id_empresa = empresas._id
                            LEFT JOIN pedidos ON pedidos._id_cadastro = cadastros._id_cadastro
                            LEFT JOIN transacoes ON transacoes._id_pedido = pedidos._id_pedido
                            WHERE cadastros._id_cadastro = :id;";
    
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            return $res;
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar dados completos: " . $e->getMessage());
            return false;
        }
    }
 
    

} // FIM DA CLASSE ListarCadastros