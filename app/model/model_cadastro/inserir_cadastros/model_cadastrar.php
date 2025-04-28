<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/contrato_x/db_conn/dbConn.php';

class CadastrarContato {
    private $conn;

    public function __construct() {
        $db = new DbConn();
        $this->conn = $db->connect();
    }

    public function inserirContato(
        $_id_empresa,
        $tipo_contato,
        $nome_completo,
        $rg,
        $cpf,
        $data_nasc,
        $naturalidade,
        $profissao,
        $cep,
        $rua,
        $numero,
        $complemento,
        $bairro,
        $cidade,
        $estado,
        $telefone,
        $email,
        $redes_sociais,
        $contato_recados,
        $telefone_recados,
        $email_recados,
        $origem) {
        try {
            $sql = "INSERT INTO contatos (
                _id_empresa,
                tipo_contato,
                nome_completo,
                rg,
                cpf,
                data_nasc,
                naturalidade,
                profissao,
                cep,
                rua,
                numero,
                complemento,
                bairro,
                cidade,
                estado,
                telefone,
                email,
                redes_sociais,
                contato_recados,
                telefone_recados,
                email_recados,
                origem
            ) VALUES (
                :_id_empresa,
                :tipo_contato,
                :nome_completo,
                :rg,
                :cpf,
                :data_nasc,
                :naturalidade,
                :profissao,
                :cep,
                :rua,
                :numero,
                :complemento,
                :bairro,
                :cidade,
                :estado,
                :telefone,
                :email,
                :redes_sociais,
                :contato_recados,
                :telefone_recados,
                :email_recados,
                :origem
            )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':_id_empresa', $_id_empresa);
            $stmt->bindValue(':tipo_contato', $tipo_contato);
            $stmt->bindValue(':nome_completo', $nome_completo);
            $stmt->bindValue(':rg', $rg);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':data_nasc', $data_nasc);
            $stmt->bindValue(':naturalidade', $naturalidade);
            $stmt->bindValue(':profissao', $profissao);
            $stmt->bindValue(':cep', $cep);
            $stmt->bindValue(':rua', $rua);
            $stmt->bindValue(':numero', $numero);
            $stmt->bindValue(':complemento', $complemento);
            $stmt->bindValue(':bairro', $bairro);
            $stmt->bindValue(':cidade', $cidade);
            $stmt->bindValue(':estado', $estado);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':redes_sociais', $redes_sociais);
            $stmt->bindValue(':contato_recados', $contato_recados);
            $stmt->bindValue(':telefone_recados', $telefone_recados);
            $stmt->bindValue(':email_recados', $email_recados);
            $stmt->bindValue(':origem', $origem);

            $stmt->execute();
            return [
                'success' => true,
                'message' => 'contato realizado com sucesso',
                'id' => $this->conn->lastInsertId()
            ];

        } catch (PDOException $e) {
            error_log("Erro ao inserir contato: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro ao realizar contato',
                'error' => $e->getMessage()
            ];
        }
    }

    public function validarCPF($cpf) {
        // Remove caracteres especiais
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1*$/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                return false;
            }
        }
        return true;
    }

    public function verificarCPFExistente($cpf) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM contatos WHERE cpf = :cpf");
            $stmt->bindValue(':cpf', $cpf);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar CPF: " . $e->getMessage());
            return false;
        }
    }
}