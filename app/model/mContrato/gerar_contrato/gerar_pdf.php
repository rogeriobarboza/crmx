<?php
require '../vendor/autoload.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/projetos/crm/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

// HTML do PDF (DomPDF) - INÍCIO CONTRATO ===================================

// Suas variáveis - PEGAR URL DO FORMULÁRIO e passar para VARIÁVEIS
$teste = 'Teste HEREDOC - conteúdo da variavel para o PDF';
$nome = "João Silva";
$data = date('d/m/Y');
$nome_completo = $_POST['nome_completo'] ?? 'Nome Não Informado';
$descricao_pedido = $_POST['descricao_pedido'] ?? 'Descrição Não Informada';

// HTML do PDF (DomPDF) - FIM CONTRATO ===================================
// Modelo de contrato - PODE SER DINÂMICO, dependendo do que o usuário escolher
// Aqui você pode definir o modelo de contrato que deseja gerar
// Exemplo: 'contrato_abc', 'contrato_xyz', etc.
$modelo_contrato = $_POST['modelo_contrato'] ?? 'contrato_abc';
// Capturar o HTML gerado
ob_start();
// Inserir o require aqui, entre ob_start() e ob_get_clean()
require "../app/model/mContrato/gerar_contrato/$modelo_contrato.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/projetos/crm/app/model/mContrato/gerar_contrato/$modelo_contrato.php";
// aqui ele executa o PHP dentro do modelo
$ob_get = ob_get_clean();
$html = $ob_get; // aqui pega o conteúdo gerado 
// FIM CONTRATO ===================================

$dompdf->loadHtml($html);
$dompdf->render();

$pdfContent = $dompdf->output();
$pdfBase64 = base64_encode($pdfContent);

// EXIBIR O PDF NO NAVEGADOR

    // Configura os cabeçalhos para exibir o PDF no navegador
    //header('Content-Type: application/pdf');
    //header('Content-Disposition: inline; filename="documento.pdf"');

    // Envia o conteúdo do PDF para o navegador
    //echo $dompdf->output();

// FIM - EXIBIR O PDF NO NAVEGADOR

?>

<!-- HTML da Página de visualização do PDF-->
<!DOCTYPE html>
    <html>
        <head>
            <title>Visualização do PDF</title>
            <link rel="stylesheet" href="public/assets/css/style.css">
            
        </head>
            <body>
                <div class="pdf-container">
                    <embed 
                        src="data:application/pdf;base64,<?php echo $pdfBase64; ?>"
                        type="application/pdf"
                        width="100%"
                        height="100%"
                        allowfullscreen="true"
                        allow="fullscreen"
                    />
                </div>
                <div class="controls" style="margin: 10px 0;">
                    <a href="data:application/pdf;base64,<?php echo $pdfBase64; ?>" download="documento.pdf">
                        <button>Download PDF</button>
                    </a>
                </div>
            </body>
    </html>
