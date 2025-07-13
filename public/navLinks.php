<?php
// Caminho absoluto do index.php (ajuste conforme a estrutura do seu projeto)
$indexPath = __DIR__ . '/index.php';

$codigo = '';
if (file_exists($indexPath)) {
    $codigo = file_get_contents($indexPath);
} else {
    echo "<div class='nav-error'>Arquivo index.php não encontrado.</div>";
    return;
}

// Captura os valores dos cases do switch
preg_match_all('/case\s+[\'"]([^\'"]+)[\'"]\s*\:/', $codigo, $matches);

// Evita múltiplas inclusões desnecessárias de CSS e JS
echo '<link rel="stylesheet" href="public/assets/css/style.css">';
echo '<script src="public/assets/js/script.js" defer></script>';

// Geração dos links
echo '<div class="nav-links">';
if (!empty($matches[1])) {
    foreach ($matches[1] as $case) {
        echo "<a href='/projetos/crmx/$case'>" . ucfirst($case) . "</a>";
    }
} else {
    echo "Nenhum case encontrado.";
}
echo '</div>';
