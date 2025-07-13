<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização do PDF</title>
    <!-- <link rel="stylesheet" href="public/assets/css/style.css"> -->
</head>
            <body>
                <?php
                //include $_SERVER['DOCUMENT_ROOT'] . '/projetos/crm/public/navLinks.php';
                include_once 'gerar_pdf.php';
                ?>
                <br><br>HTML da Página de visualização do PDF
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