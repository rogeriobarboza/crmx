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
    .pagina-a4 {
      background: white;
      width: 210mm;
      min-height: 297mm;
      padding: 15mm;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
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
    /* Delimitador A4 */
    
    
  </style>
</head>
<body>
  <div class="form-topo">
    <label for="modelo">Selecione o modelo:</label>
    <select id="modelo" onchange="carregarModelo(this.value)">
      <option value="">-- Escolha --</option>
    </select>
  </div>
  <div class="pagina-a4" id="visualizacao">
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
          // Aguarda o conteúdo ser renderizado
          setTimeout(() => {
            const conteudo = document.getElementById('conteudo_modelo');
            const totalAltura = conteudo.scrollHeight;
            const passo = 1122; // ~297mm
            const qtd = Math.floor(totalAltura / passo);
            // Remove marcadores anteriores se existirem
            const marcadoresAntigos = conteudo.querySelectorAll('.page-break-marker');
            marcadoresAntigos.forEach(m => m.remove());
            for (let i = 1; i <= qtd; i++) {
              const marcador = document.createElement('div');
              marcador.className = 'page-break-marker';
              marcador.innerHTML = '';
              // Posiciona no ponto exato
              marcador.style.top = `${i * passo}px`;
              conteudo.appendChild(marcador);
            }
          }, 100); // Pequeno delay para garantir que o conteúdo foi renderizado
        });
    }
  </script>
</body>
</html>
