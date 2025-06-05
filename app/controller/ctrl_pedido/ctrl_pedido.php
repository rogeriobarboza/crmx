<?php

// Listar pedidos
require_once('../app/model/mPedido/listar_pedidos/listar_pedidos.php');

class ctrl_pedido {
    private $listarPedidos;

    public function __construct() {
        $this->listarPedidos = new ListarPedidos();
    }

    public function exibirTodosPedidos() {
        $pedidos = $this->listarPedidos->getTodosPedidos(); 
        return $pedidos;   
    }

    public function buscarPedidoPorTitulo($titulo) {
        $pedidos = $this->listarPedidos->getPedidosPorTitulo($titulo); 
        return $pedidos;   
    }
}

?>