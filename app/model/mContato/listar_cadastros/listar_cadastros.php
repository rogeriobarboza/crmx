<?php

require_once('../db_conn/dbConn.php');

class ListarCadastros extends DbConn {

    public function buscarCadastros() {
        try {
            $conn = $this->connect();
            
            $query = "SELECT _id_empresa, _id_cadastro, tipo_cadastro, nome_completo, telefone, email 
                     FROM cadastros 
                     ORDER BY nome_completo ASC";
                     
            $stmt = $conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar cadastros: " . $e->getMessage());
            return false;
        }
    }
    
}