<?php

    require '../vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->setPaper('A4', 'portrait');



    // HTML do PDF (DomPDF) - INÍCIO CONTRATO ===================================


    // Variáveis form - PEGAR URL DO FORMULÁRIO e passar para VARIÁVEIS #################################
    $nome_completo = $_POST['nome_completo'] ?? 'Nome Não Informado';
    $descricao_pedido = $_POST['descricao_pedido'] ?? 'Descrição Não Informada';
    $_id_pedido = 61; //$_POST['id_pedido'] ?? 'ID Não Informado';
    $idModelo_contrato = $_POST['modelo_contrato'] ?? 'Modelo não informado';



    // Capturar o HTML gerado
    ob_start();

    // Inserir o require aqui, entre ob_start() e ob_get_clean()

        // CARREGAR MODELO DE CONTRATO #############################################
        require "../api/apiContrato/conteudo_pdf.php";


    // aqui ele executa o PHP dentro do modelo
    $ob_get = ob_get_clean();
    $html = $ob_get; // aqui pega o conteúdo gerado

    // HTML do PDF (DomPDF) - FIM CONTRATO ===================================


    $dompdf->loadHtml($html);
    $dompdf->render();


    // Contagem o total de páginas
    $totalPaginas = $dompdf->getCanvas()->get_page_count();
    //echo "Total de páginas: $totalPaginas";

    // Adiciona o número da página e total de páginas no rodapé (820px de altura) ou no cabeçalio (20px de altura)
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(520, 22, "Página {PAGE_NUM}/{PAGE_COUNT}", null, 11);
    //$canvas->page_text(20, 22, "abcfotoevideo.com.br", null, 11);
    //$canvas->page_text(20,32, "____________________________________________________________________________________________________", null, 11);
    //$font = $dompdf->getFontMetrics()->getFont('helvetica', 'bold');
    //$canvas->page_text(190, 20, "Contrato de prestação de serviços", $font, 14, [0,0,0]);
    


    $pdfContent = $dompdf->output();
    $pdfBase64 = base64_encode($pdfContent);




// EXIBIR O PDF NO NAVEGADOR #######################################################################################


    // Configura os cabeçalhos para exibir o PDF no navegador
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="documento.pdf"');

    // Envia o conteúdo do PDF para o navegador
    echo $dompdf->output();


// FIM - EXIBIR O PDF NO NAVEGADOR #######################################################################################



?>