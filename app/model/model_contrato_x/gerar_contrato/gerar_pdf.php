<?php
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'portrait');

// HTML do PDF (DomPDF)
require_once '../app/model/model_contrato_x/gerar_contrato/contrato_abc.php';
$html = 
    $contrato_abc
;


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

<!-- HTML da Página -->
<!DOCTYPE html>
    <html>
        <head>
            <title>Visualização do PDF</title>
            <style>
                .pdf-container {
                    width: 50%;
                    height: 75vh;
                    margin: 50px auto;
                    border: 1px solid #ccc;
                }

                .controls {
                    margin: 10px 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
            </style>
        </head>
            <body>
                <div class="pdf-container">
                    <embed 
                        src="data:application/pdf;base64,<?php echo $pdfBase64; ?>"
                        type="application/pdf"
                        width="100%"
                        height="100%"
                    />
                </div>
                <div class="controls" style="margin: 10px 0;">
                    <a href="data:application/pdf;base64,<?php echo $pdfBase64; ?>" download="documento.pdf">
                        <button>Download PDF</button>
                    </a>
                </div>
            </body>
    </html>
