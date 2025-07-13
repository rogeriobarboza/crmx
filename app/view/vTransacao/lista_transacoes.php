<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Transações</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <h1>Todas as transações</h1>

    <?php include '../public/navLinks.php'; ?>

    <!-- Campo de busca -->
    <div class="search-container" style="margin-bottom: 20px;">
        <label for="busca">Buscar Transação:</label>
        <input type="text" id="busca" placeholder="Busque por pedido, contato, ID, etc...">
    </div>

    <table border="1" id="tabela-transacoes">
        <thead>
            <tr>
                <th>Criado</th>
                <th>Modificado</th>
                <th>ID Transação</th>
                <th>ID Pedido</th>
                <th>ID Contato</th>
                <th>Vencimento</th>
                <th>Transação</th>
                <th>Situação</th>
                <th>Data Transação</th>
                <th>Nº Pgto</th>
                <th>Valor (R$)</th>
                <th>Método Pgto</th>
                <th>Pedido</th>
                <th>Contato</th>
                <th>Métodos Contato</th>
                <th>Info Adicional</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os dados serão inseridos aqui via JavaScript -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabelaBody = document.querySelector('#tabela-transacoes tbody');
            const campoBusca = document.getElementById('busca');

            // Função para formatar a data (ex: dd/mm/aaaa)
            function formatarData(dataString) {
                if (!dataString) return '';
                const data = new Date(dataString);
                // Adiciona a verificação para datas inválidas
                if (isNaN(data.getTime())) return dataString; 
                // Adiciona 1 dia para corrigir o fuso horário
                data.setDate(data.getDate() + 1);
                return data.toLocaleDateString('pt-BR');
            }

            // Função para formatar valor monetário
            function formatarValor(valor) {
                if (valor === null || valor === undefined) return '';
                return parseFloat(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }

            // Função para carregar e exibir os dados
            function carregarTransacoes(termo = '') {
                let apiUrl = 'api/apiRead/apiBuscarTransacoes.php';
                if (termo) {
                    apiUrl += `?termo=${encodeURIComponent(termo)}`;
                }

                fetch(apiUrl)
                    .then(response => response.ok ? response.json() : Promise.reject(response))
                    .then(result => {
                        tabelaBody.innerHTML = ''; // Limpa a tabela

                        if (result.success && result.data.length > 0) {
                            result.data.forEach(t => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${formatarData(t.criado)}</td>
                                    <td>${formatarData(t.modificado)}</td>
                                    <td>${t._id_transacao || ''}</td>
                                    <td>${t._id_pedido || ''}</td>
                                    <td>${t._id_contato || ''}</td>
                                    <td>${formatarData(t.venc_mensal)}</td>
                                    <td>${t.transacao || ''}</td>
                                    <td>${t.situacao || ''}</td>
                                    <td>${formatarData(t.data_transacao)}</td>
                                    <td>${t.num_pgto || ''}</td>
                                    <td>${formatarValor(t.valor_pgto)}</td>
                                    <td>${t.metodo_pgto || ''}</td>
                                    <td>${t.pedido || ''}</td>
                                    <td>${t.contato || ''}</td>
                                    <td>${t.metodos_contato || ''}</td>
                                    <td>${t.info_adicional || ''}</td>
                                `;
                                tabelaBody.appendChild(tr);
                            });
                        } else {
                            tabelaBody.innerHTML = '<tr><td colspan="16">Nenhuma transação encontrada.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar transações:', error);
                        tabelaBody.innerHTML = `<tr><td colspan="16">Erro ao carregar os dados. Verifique o console.</td></tr>`;
                    });
            }

            // Adiciona um "debounce" para não fazer requisições a cada tecla digitada
            let timeoutId;
            campoBusca.addEventListener('input', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    carregarTransacoes(this.value);
                }, 300); // Atraso de 300ms
            });

            // Carrega todas as transações inicialmente
            carregarTransacoes();
        });
    </script>
</body>
</html>