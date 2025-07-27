<?php
// Caminho absoluto do index.php (ajuste conforme a estrutura do seu projeto)
$indexPath = ROOT_PATH . 'public/index.php';

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
echo '<link rel="stylesheet" href="'.URL.'public/assets/css/style.css">';
echo '<script src="'.URL.'public/assets/js/script.js" defer></script>';

// Geração dos links
echo '<div class="nav-links">';
if (!empty($matches[1])) {
    foreach ($matches[1] as $case) {
        echo "<a href='" . URL . "$case'>" . ucfirst($case) . "</a>";
    }
} else {
    echo "Nenhum case encontrado.";
}
echo '</div>';
