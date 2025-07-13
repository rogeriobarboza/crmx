<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <?php include '../public/navLinks.php'; ?>
    
    <h1>Todos os pedidos cadastrados no sistema</h1>

    <h1>Lista de Pedidos</h1>

    <table id="tabela-pedidos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Os pedidos serão inseridos aqui via JavaScript -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabelaBody = document.querySelector('#tabela-pedidos tbody');

            function formatarData(dataString) {
                if (!dataString) return '';
                const data = new Date(dataString);
                // Adiciona a verificação para datas inválidas e corrige o fuso horário
                if (isNaN(data.getTime())) return dataString;
                data.setDate(data.getDate() + 1);
                return data.toLocaleDateString('pt-BR');
            }

            function formatarValor(valor) {
                if (valor === null || valor === undefined) return '';
                return parseFloat(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            }

            function carregarPedidos() {
                fetch('api/apiRead/apiBuscarPedido.php')
                    .then(response => response.ok ? response.json() : Promise.reject(response))
                    .then(result => {
                        tabelaBody.innerHTML = ''; // Limpa a tabela

                        // A API retorna { status: 'sucesso', dados: [...] }
                        if (result.status === 'sucesso' && result.dados.length > 0) {
                            result.dados.forEach(pedido => {
                                const tr = document.createElement('tr');
                                // Corrigindo as colunas para corresponder ao cabeçalho da tabela
                                // e usando a variável 'pedido' do loop.
                                tr.innerHTML = `
                                    <td>${pedido._id_pedido}</td>
                                    <td>${pedido.nome_contato}</td>
                                    <td>${formatarData(pedido.data_reservada)}</td>
                                    <td>Pendente</td> <!-- Status não disponível nos dados, usando placeholder -->
                                    <td>${formatarValor(pedido.valor_total)}</td>
                                 `;
                                tabelaBody.appendChild(tr);
                            });
                        } else {
                            tabelaBody.innerHTML = '<tr><td colspan="5">Nenhum pedido encontrado.</td></tr>';
                        }
                    }).catch(erro => {
                        console.error('Erro:', erro);
                        tabelaBody.innerHTML = '<tr><td colspan="5">Erro ao carregar pedidos.</td></tr>';
                    });
            }

            // Carrega ao abrir a página
            carregarPedidos();
        });
    </script>
</body>
</html>
