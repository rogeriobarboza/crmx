<?php
var_dump($_GET['url'] ?? '');

// Obtém a URL requisitada
$url = isset($_GET['url']) && !empty($_GET['url']) ? $_GET['url'] : 'home';

$url = trim($url, '/'); // Remove as barras no início e no final da URL

// Define as rotas usando switch
switch ($url) {
    case '':
        require_once '../public/paginas/home.php';
        break;

    case 'home':
        require_once '../public/paginas/home.php';
        break;

    case 'sobre':
        require_once '../public/paginas/sobre.php';
        break;

    case 'contato':
        require_once '../public/paginas/contato.php';
        break;
    
    
    case 'cadastrar':
        require_once '../app/view/view_cadastro/form_cadastro.php';
        break;

    case 'cadastrar-pedido':
        // Redireciona para a página de contato
        
        require_once '../app/view/view_pedido/form_pedido.php';
        break;

    case 'pedidos':
        echo "<a href='home'>Voltar para a Home</a>";
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/view_pedido/lista_pedidos.php';
        break;
    
    case 'gerar-contrato':
        echo "<a href='home'>Voltar para a Home</a>";
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/model/model_contrato_x/gerar_contrato/gerar_pdf.php';
        break;

    case 'form-contrato':
        echo "<a href='home'>Voltar para a Home</a><br><br>";
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/view_contratox/form_contrato.php';
        break;

    default:
        // Página não encontrada
        //header("HTTP/1.0 404 Not Found");
        echo "Página não encontrada!<br><br>";
        echo "<a href='home'>Voltar para a Home</a>";
        break;
}
