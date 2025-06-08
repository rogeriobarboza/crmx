function inicializarBuscaEmpresa(config = {}) {
    // Configurações padrão
    const defaults = {
        inputId: 'pesquisa',
        sugestoesId: 'sugestoes',
        idEmpresaId: '_id_empresa',
        nomeEmpresaId: 'nome_empresa',
        containerClass: 'campo-container',
        urlBusca: 'app/view/vContato/fnBuscarEmpresa.php',
        minLength: 1
    };

    // Mescla configurações padrão com as fornecidas
    const settings = { ...defaults, ...config };

    // Elementos DOM
    const input = document.getElementById(settings.inputId);
    const sugestoes = document.getElementById(settings.sugestoesId);

    if (!input || !sugestoes) {
        console.error('Elementos necessários não encontrados');
        return;
    }

    // Função para buscar empresas
    async function buscarEmpresas(termo) {
        try {
            const response = await fetch(`${settings.urlBusca}?termo=${encodeURIComponent(termo)}`);
            const dados = await response.json();
            return dados;
        } catch (error) {
            console.error('Erro ao buscar empresas:', error);
            return [];
        }
    }

    // Função para renderizar sugestões
    function renderizarSugestoes(dados) {
        sugestoes.innerHTML = '';

        if (dados.length > 0) {
            dados.forEach(item => {
                const div = document.createElement('div');
                div.classList.add('sugestao');
                div.textContent = `ID: ${item._id} - ${item.empresa}`;
                div.addEventListener('click', () => selecionarEmpresa(item));
                sugestoes.appendChild(div);
            });
        } else {
            sugestoes.innerHTML = '<div class="sugestao">Nenhum resultado encontrado</div>';
        }
    }

    // Função para selecionar empresa
    function selecionarEmpresa(item) {
        input.value = item.empresa;
        document.getElementById(settings.idEmpresaId).value = item._id;
        document.getElementById(settings.nomeEmpresaId).value = item.empresa;
        sugestoes.innerHTML = '';
    }

    // Event Listeners
    input.addEventListener('keyup', async function() {
        const termo = input.value.trim();

        if (termo.length >= settings.minLength) {
            const dados = await buscarEmpresas(termo);
            renderizarSugestoes(dados);
        } else {
            sugestoes.innerHTML = '';
        }
    });

    // Esconde sugestões ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest(`.${settings.containerClass}`)) {
            sugestoes.innerHTML = '';
        }
    });
}