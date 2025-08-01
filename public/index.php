<?php
include_once '../config/config.php';
//var_dump($_GET['url'] ?? '');




// Obtém a URL requisitada
$url = isset($_GET['url']) && !empty($_GET['url']) ? $_GET['url'] : '';

$url = trim($url, '/'); // Remove as barras no início e no final da URL

// Define as rotas usando switch
switch ($url) {
    
    case '':
        require_once ROOT_PATH.'app/view/vContato/lista-contatos.php';
        break;
    
    case 'home':
        header('Location: /projetos/crmx/', true, 301);
        exit;
        break;
    
    case 'lista-contatos':
        require_once ROOT_PATH.'app/view/vContato/lista-contatos.php';
        break;
    
    case 'gerenciar-contato':
        require_once ROOT_PATH.'app/view/vContato/gerenciar_contato.php';
        break;

    case 'gerenciar-pedido':
        // Redireciona para view "form_pedido.php"]
        require_once ROOT_PATH.'app/view/vPedido/gerenciar_pedido.php';
        break;

    case 'lista-pedidos':
        // Redireciona para view "lista_pedidos.php"]
        require_once ROOT_PATH.'app/view/vPedido/lista_pedidos.php';
        break;
    
    case 'lista-transacoes':
        require_once ROOT_PATH.'app/view/vTransacao/lista_transacoes.php';
        break;
    
    case 'lista-produtos':
        require_once ROOT_PATH.'app/view/vProduto/vListaProd.php';
        break;

    case 'gerenciar-produto':
        require_once ROOT_PATH.'app/view/vProduto/vGerenciarProduto.php';
        break;
    
    case 'lista-pacotes':
        require_once ROOT_PATH.'app/view/vPacote/vListaPac.php';
        break;
    
    case 'gerar-contrato':
        require_once ROOT_PATH.'api/apiContrato/gerar_pdf.php';
        break;

    case 'form-contrato':
        require_once ROOT_PATH.'app/view/vContrato/form_contrato.php';
        break;

    case 'lista-clausulas':
        require_once ROOT_PATH.'app/view/vClausulas/lista-clausulas.php';
        break;

    case 'gerenciar-clausulas.php':
        require_once ROOT_PATH.'app/view/vClausulas/gerenciar-clausulas.php';
        break;

    case 'lista-modelos-contrato':
        require_once ROOT_PATH.'app/view/vModelosContrato/lista_modelos_contrato.php';
        break;

    case 'gerenciar-modelos-contrato':
        require_once ROOT_PATH.'app/view/vModelosContrato/gerenciar_modelos_contrato.php';
        break;

    case 'visualizar-modelo-contrato':
        require_once ROOT_PATH.'app/view/vModelosContrato/visualizar_modelo_contrato.php';
        break;

    case 'visualizar-modelo-contrato-A4':
        require_once ROOT_PATH.'app/view/vModelosContrato/visualizar_modelo_contrato-A4.php';
        break;

    default:
        // Página não encontrada
        //header("HTTP/1.0 404 Not Found");
        echo "Página não encontrada!<br><br>";
        break;
}





?>