<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Visualizar Modelo de Contrato</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .form-topo {
      margin-bottom: 20px;
    }
    /* Removed A4 specific styles */
    h1.modelo-titulo {
      text-align: center;
      margin-top: 0;
    }
    .clausula {
      margin-bottom: 20px;
    }
    .clausula .titulo {
      font-weight: bold;
    }
    .clausula .descricao {
      margin-top: 5px;
      text-align: justify;
    }
    .clausula.tipo-clausula { margin-left: 0; }
    .clausula.tipo-subclausula { margin-left: 20px; }
    .clausula.tipo-item { margin-left: 40px; }
    #conteudo_modelo {
      width: 210mm; /* Largura padrão A4 */
      margin: 0 auto; /* Centraliza horizontalmente */
      position: relative;
    }

  </style>

</head>

<body>
  <div class="form-topo">
    <label for="modelo">Selecione o modelo:</label>
    <select id="modelo" onchange="carregarModelo(this.value)">
      <option value="">-- Escolha --</option>
    </select>
  </div>
  <div id="visualizacao">
    <h1 class="modelo-titulo" id="titulo_modelo"></h1>
    <div id="conteudo_modelo"></div>
  </div>
  <script>
    // Carrega a lista de modelos
    fetch('app/view/vModelosContrato/buscar_modelos.php')
      .then(r => r.json())
      .then(data => {
        const select = document.getElementById('modelo');
        data.forEach(m => {
          const opt = document.createElement('option');
          opt.value = m.id_modelo;
          opt.textContent = m.nome_modelo;
          select.appendChild(opt);
        });
      });
    // Carrega o conteúdo do modelo
    function carregarModelo(id) {
      if (!id) return;
      fetch('app/view/vModelosContrato/carregar_modelo.php?id=' + id)
        .then(r => r.json())
        .then(data => {
          document.getElementById('titulo_modelo').textContent = data.nome_modelo;
          const conteudo = document.getElementById('conteudo_modelo');
          conteudo.innerHTML = '';
          data.clausulas.forEach(c => {
            const div = document.createElement('div');
            div.classList.add('clausula', 'tipo-' + c.tipo);
            const titulo = document.createElement('div');
            titulo.classList.add('titulo');
            titulo.textContent = c.titulo;
            const descricao = document.createElement('div');
            descricao.classList.add('descricao');
            descricao.innerHTML = c.descricao.replace(/\n/g, '<br>');
            div.appendChild(titulo);
            div.appendChild(descricao);
            conteudo.appendChild(div);
          });
          // Removed A4 page break marker logic
        });
    }
  </script>
</body>
</html>