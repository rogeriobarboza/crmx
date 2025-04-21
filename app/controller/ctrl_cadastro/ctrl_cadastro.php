<?php
// Listar cadastros
require_once('../app/model/model_cadastro/listar_cadastros/listar_cadastros.php');



class CtrlCadastro {
    private $listarCadastros;
    private $listarPedidos;
    public $id;
    private $listarNome;

    public function __construct() {
        $this->listarCadastros = new ListarCadastros();
    }

    public function exibirCadastros() {
        $cadastros = $this->listarCadastros->buscarCadastros(); 
        return $cadastros;   
    }

    public function exibirCadastroPorId($id) {
        $cadastro = $this->listarCadastros->buscarCadastroPorId($id);
        return $cadastro;
    }


    public function exibirDadosCompletosPorId($id) {
        $cadastro = $this->listarCadastros->buscarDadosCompletosPorId($id); // <-- atenção aqui
        return $cadastro;
    }  

    public function exibirPedidos() {
        $pedidos = $this->listarPedidos->getTodosPedidos();
    }

    
        
    
}
