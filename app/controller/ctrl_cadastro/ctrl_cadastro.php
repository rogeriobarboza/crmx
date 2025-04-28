<?php
// Listar cadastros
require_once('../app/model/model_cadastro/listar_cadastros/listar_contatos.php');



class CtrlCadastro {
    private $ListarContatos;
    private $listarPedidos;
    public $id;
    private $listarNome;
    private $_id_pedido;

    public function __construct() {
        $this->ListarContatos = new ListarContatos();
    }

    public function exibirCadastros() {
        $cadastros = $this->ListarContatos->buscarContatos(); 
        return $cadastros;   
    }

    public function exibirCadastroPorCPF($cpf) {
        $cadastro = $this->ListarContatos->buscarContatoPorCPF($cpf);
        return $cadastro;
    }


    public function exibirPedidoTransacaoPorId($_id_pedido) {
        $cadastro = $this->ListarContatos->buscarPedidoTransacaoPorId($_id_pedido); // <-- atenção aqui
        return $cadastro;
    }  

    public function exibirPedidos() {
        $pedidos = $this->listarPedidos->getTodosPedidos();
    }

    
        
    
}
