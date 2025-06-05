// Mensagem teste link js
//alert('Teste: Links ordenados com sucesso!');

// Ordenar Links
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelector('.nav-links');
    if (navLinks) {
        const links = Array.from(navLinks.getElementsByTagName('a'));
        
        // Ordena os links alfabeticamente pelo texto
        links.sort((a, b) => a.textContent.localeCompare(b.textContent, 'pt-BR'));
        
        // Remove os links existentes
        while (navLinks.firstChild) {
            navLinks.removeChild(navLinks.firstChild);
        }
        
        // Adiciona os links ordenados
        links.forEach(link => {
            navLinks.appendChild(link);
        });
    }
});

