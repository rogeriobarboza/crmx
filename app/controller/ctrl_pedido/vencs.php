<?php
// Lógica para calcular os 12 vencimentos mensais a partir do primeiro vencimento
// Suponha que a data foi recebida via POST
//$primeiroVencimento = $_POST['vencimento']; // Ex: "2025-05-31"
$vencimento_mensal = "2025-05-31"; // Data de vencimento mensal recebida (exemplo)

// Converte para DateTime e força o primeiro dia do mês
$data = DateTime::createFromFormat('Y-m-d', $vencimento_mensal)->modify('first day of this month');

// Array para armazenar as 12 datas (primeira + 11 próximas)
$vencimentos = [];

for ($i = 0; $i < 12; $i++) {
    // Clona a data original para não alterar a referência
    $novaData = clone $data;
    // Adiciona $i meses
    $novaData->modify("+$i months");
    // Define para o último dia do mês
    $novaData->modify('last day of this month');
    // Adiciona ao array (formato desejado: Y-m-d)
    $vencimentos[] = $novaData->format('Y-m-d');
}

// Exemplo de saída
//print_r($vencimentos);
var_dump($vencimentos); // Exibe as datas formatadas
