<?php
//var_dump($_GET['url'] ?? '');




// Obtém a URL requisitada
$url = isset($_GET['url']) && !empty($_GET['url']) ? $_GET['url'] : 'home';

$url = trim($url, '/'); // Remove as barras no início e no final da URL

// Lê o conteúdo do arquivo index.php
$codigo = '';
$indexPath = __FILE__; // Corrigido para ler o próprio arquivo atual
if (file_exists($indexPath)) {
    $codigo = file_get_contents($indexPath);
} else {
    echo "Arquivo index.php não encontrado.<br>";
}

// Captura os valores dos cases
preg_match_all('/case\s+[\'"]([^\'"]+)[\'"]\s*\:/', $codigo, $matches);

echo '<div class="nav-links">';
// Gera os links em linha ?url=
if (!empty($matches[1])) {
    foreach ($matches[1] as $case) {
        echo "<a href='{$case}'>".ucfirst($case)."</a>";
    }
    echo "<br>";
} else {
    echo "Nenhum case encontrado.";
}
echo '</div>';

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

    case 'atualizar-contato':
        require_once '../app/view/view_cadastro/vFormContatoUp.php';
        break;

    case 'cadastrar-pedido':
        // Redireciona para a página de contato
        
        require_once '../app/view/view_pedido/form_pedido.php';
        break;

    case 'atualizar-pedido':
        // Redireciona para a página de contato
        
        require_once '../app/view/view_pedido/fmPedidoUp.php';
        break;

    case 'pedidos':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/view_pedido/lista_pedidos.php';
        break;
    
    case 'transacoes':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/view_transacoes/lista_transacoes.php';
        break;
    
    case 'produtos':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/vProdutos/vListaProd.php';
        break;

    case 'atualizar-produtos':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/vProdutos/vFormProdUp.php';
        break;
    
    case 'pacotes':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/vPacotes/vListaPac.php';
        break;
    
    case 'gerar-contrato':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/model/model_contrato_x/gerar_contrato/gerar_pdf.php';
        break;

    case 'form-contrato':
        // Redireciona para view "lista_pedidos.php"]
        require_once '../app/view/view_contrato/form_contrato.php';
        break;

    default:
        // Página não encontrada
        //header("HTTP/1.0 404 Not Found");
        echo "Página não encontrada!<br><br>";
        break;
}





?>