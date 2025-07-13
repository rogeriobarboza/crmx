<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lista Clausulas</title>
    <style>
        .campo-container {
            position: relative;
            margin-bottom: 10px;
        }
        
        .sugestoes {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        #sugestoes {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ddd;
            z-index: 1000;
        }
        
        .sugestao {
            padding: 8px;
            cursor: pointer;
        }
        
        .sugestao:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<?php include '../public/navLinks.php'; ?>

<h1>Adicionar/atualizar Clausula</h1>

<form method="POST">
    <div class="campo-container">
        <label for="buscar_clausula">Buscar Clausula</label>
        <input type="text" id="buscar_clausula" name="buscar_clausula" placeholder="Buscar cláusula..." autocomplete="off">
        <div id="sugestoes"></div>
    </div>

    <label for="id">ID Clausula:</label>
    <input type="text" id="id" name="id" ><br>

    <div class="campo-container">
        <label for="src_clausula_pai">Buscar Clausula Pai</label>
        <input type="text" id="src_clausula_pai" name="src_clausula_pai" 
               placeholder="Buscar cláusula pai (opcional)" autocomplete="off">
        <div id="sugestoes-pai" class="sugestoes"></div>
    </div>

    <label for="id_pai">ID Pai:</label>
    <input type="text" id="id_pai" name="id_pai" placeholder="ID da cláusula pai (opcional)" autocomplete="off"><br>

    <label for="tipo">Tipo:</label>
    <input type="text" id="tipo" name="tipo" required><br>

    <div class="campo-container">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required autocomplete="off">
        <div id="sugestoes-titulo" class="sugestoes"></div>
    </div>

    <label for="nome_ref">Nome Referência:</label>
    <input type="text" id="nome_ref" name="nome_ref" required><br>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required></textarea><br>

    <button type="button" id="btnAtualizar">Atualizar</button><br><br>
    <button type="button" id="btnExcluir">Excluir</button><br><br>
    <button type="button" id="btnAdicionar">Adicionar</button><br><br>
</form>

<script>
// Script para buscar cláusulas e preencher o formulário
const input = document.getElementById('buscar_clausula');
const sugestoes = document.getElementById('sugestoes');

input.addEventListener('keyup', function() {
    const termo = input.value.trim();

    if (termo.length >= 1) {
        fetch('api/apiRead/apiBuscarClausula.php?termo=' + encodeURIComponent(termo) + '&campo=busca_geral')
            .then(response => response.json())
            .then(dados => {
                sugestoes.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = `ID: ${item.id} - ${item.titulo}`;
                        
                        div.addEventListener('click', function() {
                            // Preenche todos os campos do formulário
                            document.getElementById('id').value = item.id;
                            document.getElementById('id_pai').value = item.id_pai;
                            document.getElementById('tipo').value = item.tipo;
                            document.getElementById('titulo').value = item.titulo;
                            document.getElementById('nome_ref').value = item.nome_ref;
                            document.getElementById('descricao').value = item.descricao;
                            
                            input.value = item.titulo;
                            sugestoes.innerHTML = '';
                        });
                        
                        sugestoes.appendChild(div);
                    });
                } else {
                    sugestoes.innerHTML = '<div class="sugestao">Nenhum resultado encontrado</div>';
                }
            });
    } else {
        sugestoes.innerHTML = '';
    }
});

// Adicionar este script junto aos outros scripts
// Script para buscar títulos similares e preencher o campo de título
const inputTitulo = document.getElementById('titulo');
const sugestoesTitulo = document.getElementById('sugestoes-titulo');

inputTitulo.addEventListener('keyup', function() {
    const termo = inputTitulo.value.trim();

    if (termo.length >= 1) {
        fetch(`api/apiRead/apiBuscarClausula.php?termo=${encodeURIComponent(termo)}&campo=titulo`)
            .then(response => response.json())
            .then(dados => {
                sugestoesTitulo.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = item.titulo;
                        
                        div.addEventListener('click', function() {
                            inputTitulo.value = item.titulo;
                            sugestoesTitulo.innerHTML = '';
                        });
                        
                        sugestoesTitulo.appendChild(div);
                    });
                } else {
                    sugestoesTitulo.innerHTML = '<div class="sugestao">Nenhum título similar encontrado</div>';
                }
            });
    } else {
        sugestoesTitulo.innerHTML = '';
    }
});

// Script para buscar cláusula pai
const inputPai = document.getElementById('src_clausula_pai');
const sugestoesPai = document.getElementById('sugestoes-pai');

inputPai.addEventListener('keyup', function() {
    const termo = inputPai.value.trim();

    if (termo.length >= 1) {
        fetch('api/apiRead/apiBuscarClausula.php?termo=' + encodeURIComponent(termo) + '&campo=busca_geral')
            .then(response => response.json())
            .then(dados => {
                sugestoesPai.innerHTML = '';

                if (dados.length > 0) {
                    dados.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('sugestao');
                        div.textContent = `ID: ${item.id} - ${item.titulo}`;
                        
                        div.addEventListener('click', function() {
                            // Preenche apenas os campos relacionados à cláusula pai
                            document.getElementById('id_pai').value = item.id;
                            inputPai.value = item.titulo;
                            sugestoesPai.innerHTML = '';
                        });
                        
                        sugestoesPai.appendChild(div);
                    });
                } else {
                    sugestoesPai.innerHTML = '<div class="sugestao">Nenhuma cláusula pai encontrada</div>';
                }
            });
    } else {
        sugestoesPai.innerHTML = '';
    }
});

// Esconde sugestões ao clicar fora
document.addEventListener('click', function(e) {
    if (!e.target.closest('.campo-container')) {
        sugestoes.innerHTML = '';
        sugestoesTitulo.innerHTML = '';
        sugestoesPai.innerHTML = '';
    }
});
// Fim Script para buscar cláusulas e preencher o formulário

// Função auxiliar para coletar dados do formulário
function getFormData() {
    return {
        id: document.getElementById('id').value,
        id_pai: document.getElementById('id_pai').value,
        tipo: document.getElementById('tipo').value,
        titulo: document.getElementById('titulo').value,
        nome_ref: document.getElementById('nome_ref').value,
        descricao: document.getElementById('descricao').value
    };
}

// Adicionar
document.getElementById('btnAdicionar').onclick = function() {
    const dados = getFormData();
    // Remove o id para garantir que é um novo registro
    delete dados.id;
    fetch('api/apiCreate/apiCreateClausula.php', {
        method: 'POST',
        body: new URLSearchParams(dados)
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if (res.success && res.id) {
            document.getElementById('id').value = res.id;
        }
    });
};

// Atualizar
document.getElementById('btnAtualizar').onclick = function() {
    const dados = getFormData();
    if (!dados.id) {
        alert('Selecione uma cláusula para atualizar.');
        return;
    }
    fetch('api/apiUpdate/apiUpdateClausula.php', {
        method: 'POST',
        body: new URLSearchParams(dados)
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
    });
};

// Excluir
document.getElementById('btnExcluir').onclick = function() {
    const dados = getFormData();
    if (!dados.id) {
        alert('Selecione uma cláusula para excluir.');
        return;
    }
    if (!confirm('Tem certeza que deseja excluir esta cláusula?')) return;
    fetch('api/apiDelete/apiDeleteClausula.php', {
        method: 'POST',
        body: new URLSearchParams({id: dados.id})
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if (res.success) {
            // Limpa o formulário
            document.getElementById('id').value = '';
            document.getElementById('id_pai').value = '';
            document.getElementById('tipo').value = '';
            document.getElementById('titulo').value = '';
            document.getElementById('nome_ref').value = '';
            document.getElementById('descricao').value = '';
        }
    });
};
</script>


</body>
</html>