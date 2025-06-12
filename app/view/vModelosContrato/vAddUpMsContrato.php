<?php
// Conexão com MySQL
$pdo = new PDO("mysql:host=localhost;dbname=contrato_x", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// CRUD básico de modelos
$mensagem = '';
$acao = $_POST['acao'] ?? '';
$nome = trim($_POST['nome_modelo'] ?? '');
$ordem = $_POST['ordem_clausulas'] ?? '';
$id_modelo = $_POST['id_modelo'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($acao === 'excluir' && $id_modelo) {
    $pdo->prepare("DELETE FROM modelos_contratos_clausulas WHERE id_modelo = ?")->execute([$id_modelo]);
    $pdo->prepare("DELETE FROM modelos_contratos WHERE id_modelo = ?")->execute([$id_modelo]);
    $mensagem = "✅ Modelo excluído com sucesso.";
  }

  if (($acao === 'criar' || $acao === 'salvar') && $nome && $ordem) {
    if ($acao === 'criar') {
      $stmt = $pdo->prepare("SELECT id_modelo FROM modelos_contratos WHERE nome_modelo = ?");
      $stmt->execute([$nome]);
      if ($stmt->rowCount() > 0) {
        $id_modelo = $stmt->fetchColumn();
      } else {
        $pdo->prepare("INSERT INTO modelos_contratos (nome_modelo) VALUES (?)")->execute([$nome]);
        $id_modelo = $pdo->lastInsertId();
      }
    }

    if ($acao === 'salvar' && $id_modelo) {
      $pdo->prepare("UPDATE modelos_contratos SET nome_modelo = ? WHERE id_modelo = ?")->execute([$nome, $id_modelo]);
      $pdo->prepare("DELETE FROM modelos_contratos_clausulas WHERE id_modelo = ?")->execute([$id_modelo]);
    }

    $ids = explode(',', $ordem);
    $stmt = $pdo->prepare("INSERT INTO modelos_contratos_clausulas (id_modelo, id_clausula, ordem) VALUES (?, ?, ?)");
    foreach ($ids as $index => $id_clausula) {
      $stmt->execute([$id_modelo, $id_clausula, $index + 1]);
    }

    $mensagem = "✅ Modelo salvo com sucesso.";
  }
}

//$clausulas = $pdo->query("SELECT id, titulo, descricao FROM clausulas WHERE id_pai IS NULL ORDER BY id")->fetchAll();

// Carrega cláusulas principais
$clausulas = $pdo->query("
  SELECT id, titulo, nome_ref, tipo
  FROM clausulas
  WHERE tipo = 'clausula'
  ORDER BY titulo
")->fetchAll();

// Carrega subcláusulas com nome da cláusula pai
$subclausulas = $pdo->query("
  SELECT s.id, s.titulo, s.nome_ref, p.titulo AS pai
  FROM clausulas s
  JOIN clausulas p ON s.id_pai = p.id
  WHERE s.tipo = 'subclausula'
  ORDER BY s.titulo
")->fetchAll();

// Carrega itens com nome da subcláusula pai
$itens = $pdo->query("
  SELECT i.id, i.titulo, i.nome_ref, p.titulo AS pai
  FROM clausulas i
  JOIN clausulas p ON i.id_pai = p.id
  WHERE i.tipo = 'item'
  ORDER BY i.titulo
")->fetchAll();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Modelos de Contrato</title>
  <style>
    body { font-family: sans-serif; max-width: 900px; margin: 20px auto; }
    .msg { background: #e6ffe6; padding: 10px; border: 1px solid #8f8; margin-bottom: 20px; }
    .lista { border: 2px dashed #ccc; padding: 10px; min-height: 50px; margin: 20px 0; }
    .clausula {
      border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;
      background: #f9f9f9; cursor: grab; position: relative;
    }
    .clausula:hover { background: #eef; }
    .clausula button {
      position: absolute; top: 5px; right: 5px;
      background: transparent; border: none; font-size: 16px; cursor: pointer;
    }
    ul.sugestoes { border: 1px solid #ccc; list-style: none; padding: 0; margin: 0; max-height: 150px; overflow-y: auto; }
    ul.sugestoes li { padding: 5px 10px; cursor: pointer; }
    ul.sugestoes li:hover { background: #def; }

    .clausula.tipo-clausula { margin-left: 0; }
    .clausula.tipo-subclausula { margin-left: 30px; background: #fdfdfd; }
    .clausula.tipo-item { margin-left: 60px; background: #fcfcfc; }

  </style>
</head>
<body>

<h1>Gerenciar Modelos de Contrato</h1>

<?php if ($mensagem): ?>
  <div class="msg"><?= $mensagem ?></div>
<?php endif; ?>

<form method="post">

  <label>Nome do Modelo (digite para buscar ou criar):</label><br>
  <input type="text" name="nome_modelo" id="nome_modelo" autocomplete="off" required>
  <ul id="sugestoes" class="sugestoes" style="display: none;"></ul>
  <input type="hidden" name="id_modelo" id="id_modelo"><br><br>

  <h2>Adicionar Cláusulas ao Modelo</h2>

  <label>Adicionar Cláusula:</label><br>
  <select id="select_clausula">
    <option value="">-- Escolha --</option>
    <?php foreach ($clausulas as $c): ?>
      <option value="<?= $c['id'] ?>" data-titulo="<?= htmlspecialchars($c['titulo']) ?>" data-descricao="" data-ref="<?= $c['nome_ref'] ?>">
        <?= $c['titulo'] ?> (ref: <?= $c['nome_ref'] ?>)
      </option>
    <?php endforeach; ?>
  </select>
  <button type="button" onclick="adicionarSelecionada('clausula')">➕</button><br><br>

  <label>Adicionar Subcláusula:</label><br>
  <select id="select_subclausula">
    <option value="">-- Escolha --</option>
    <?php foreach ($subclausulas as $s): ?>
      <option value="<?= $s['id'] ?>" data-titulo="<?= htmlspecialchars($s['titulo']) ?>" data-descricao="" data-ref="<?= $s['nome_ref'] ?>" data-pai="<?= htmlspecialchars($s['pai']) ?>">
        <?= $s['titulo'] ?> (ref: <?= $s['nome_ref'] ?>) — Cláusula: <?= $s['pai'] ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="button" onclick="adicionarSelecionada('subclausula')">➕</button><br><br>

  <label>Adicionar Item:</label><br>
  <select id="select_item">
    <option value="">-- Escolha --</option>
    <?php foreach ($itens as $i): ?>
      <option value="<?= $i['id'] ?>" data-titulo="<?= htmlspecialchars($i['titulo']) ?>" data-descricao="" data-ref="<?= $i['nome_ref'] ?>" data-pai="<?= htmlspecialchars($i['pai']) ?>">
        <?= $i['titulo'] ?> (ref: <?= $i['nome_ref'] ?>) — Subcláusula: <?= $i['pai'] ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="button" onclick="adicionarSelecionada('item')">➕</button>


    <h2>Cláusulas do Modelo (arraste para ordenar)</h2>

  <div id="clausulas-modelo" class="lista" aria-placeholder="Adicione e arraste aqui">
    <p style="font-style: italic; font-family: 'Times New Roman', Times, serif;">Cláusulas adicionadas</p>
  </div>

  <input type="hidden" name="ordem_clausulas" id="ordem_clausulas">

  <div style="margin-top: 20px;">
    <button type="submit" name="acao" value="criar">Criar Novo</button><br><br>
    <button type="submit" name="acao" value="salvar">Salvar Alterações</button><br><br>
    <button type="submit" name="acao" value="excluir" onclick="return confirm('Deseja excluir este modelo?')">Excluir</button>
  </div>
</form>

<script>
  let dragged;

  document.addEventListener('dragstart', e => {
    if (e.target.classList.contains('clausula')) dragged = e.target;
  });

  document.getElementById('clausulas-modelo').addEventListener('dragover', e => e.preventDefault());

  document.getElementById('clausulas-modelo').addEventListener('drop', e => {
    if (dragged) {
      const after = getDragAfterElement(e.currentTarget, e.clientY);
      if (!after) e.currentTarget.appendChild(dragged);
      else e.currentTarget.insertBefore(dragged, after);
    }
  });

  function getDragAfterElement(container, y) {
    const els = [...container.querySelectorAll('.clausula:not(.dragging)')];
    return els.reduce((closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;
      return offset < 0 && offset > closest.offset ? { offset, element: child } : closest;
    }, { offset: Number.NEGATIVE_INFINITY }).element;
  }

  //function adicionarSelecionada() {
  //  const select = document.getElementById('select_clausula');
  //  const id = select.value;
  //  if (!id) return;
  //  const titulo = select.options[select.selectedIndex].dataset.titulo;
  //  const descricao = select.options[select.selectedIndex].dataset.descricao;
//
  //  const div = document.createElement('div');
  //  div.className = 'clausula';
  //  div.setAttribute('draggable', 'true');
  //  div.setAttribute('data-id', id);
  //  div.innerHTML = `<button onclick="this.parentElement.remove()">🗑️</button>
  //    <strong>${titulo}</strong><br><small>${descricao}</small>`;
//
  //  document.getElementById('clausulas-modelo').appendChild(div);
  //  select.value = '';
  //}

  function adicionarSelecionada(tipo) {
  let select;
  if (tipo === 'clausula') select = document.getElementById('select_clausula');
  if (tipo === 'subclausula') select = document.getElementById('select_subclausula');
  if (tipo === 'item') select = document.getElementById('select_item');
  if (!select || !select.value) return;

  const id = select.value;
  const titulo = select.options[select.selectedIndex].dataset.titulo;
  const ref = select.options[select.selectedIndex].dataset.ref;
  const pai = select.options[select.selectedIndex].dataset.pai || '';
  const descricao = select.options[select.selectedIndex].dataset.descricao || '';

  const div = document.createElement('div');
  div.className = 'clausula';
  div.setAttribute('draggable', 'true');
  div.setAttribute('data-id', id);
  div.innerHTML = `
    <button onclick="this.parentElement.remove()">🗑️</button>
    <strong>${titulo}</strong><br>
    <small>ref: ${ref}</small><br>
    ${pai ? `<small><em>Pai: ${pai}</em></small><br>` : ''}
    <small>${descricao}</small>
  `;

  document.getElementById('clausulas-modelo').appendChild(div);
  select.value = '';
  div.className = 'clausula tipo-' + tipo;

}
// ###

  document.querySelector('form').addEventListener('submit', () => {
    const ids = Array.from(document.querySelectorAll('#clausulas-modelo .clausula')).map(c => c.dataset.id);
    document.getElementById('ordem_clausulas').value = ids.join(',');
  });

  // Autocomplete do campo nome_modelo
  const inputNome = document.getElementById('nome_modelo');
  const sugestoes = document.getElementById('sugestoes');

  inputNome.addEventListener('input', () => {
    const termo = inputNome.value;
    if (termo.length < 1) return sugestoes.style.display = 'none';

    fetch(`app/view/vModelosContrato/buscar_modelos.php?q=${encodeURIComponent(termo)}`)
      .then(r => r.json())
      .then(data => {
        sugestoes.innerHTML = '';
        data.forEach(item => {
          const li = document.createElement('li');
          li.textContent = item.nome_modelo;
          li.onclick = () => {
            fetch(`app/view/vModelosContrato/carregar_modelo.php?id=${item.id_modelo}`)
               .then(r => r.json())
               .then(data => {
                  inputNome.value = data.nome_modelo;
                  document.getElementById('id_modelo').value = item.id_modelo;

                  const container = document.getElementById('clausulas-modelo');
                  container.innerHTML = '';
                  data.clausulas.forEach(c => {
                      const div = document.createElement('div');
                      // Corrigido: adiciona as classes corretamente
                      div.className = `clausula tipo-${c.tipo}`; // Adiciona ambas as classes
                      div.setAttribute('draggable', 'true');
                      div.setAttribute('data-id', c.id);
                      div.innerHTML = `<button onclick="this.parentElement.remove()">🗑️</button>
                        <strong>${c.titulo}</strong><br>
                        <small>ref: ${c.nome_ref}</small><br>
                        ${c.pai ? `<small><em>Pai: ${c.pai}</em></small><br>` : ''}
                        <small>${c.descricao || ''}</small>`;
                      container.appendChild(div);
                  });

                  sugestoes.style.display = 'none';
                });
            };

          sugestoes.appendChild(li);
        });
        sugestoes.style.display = data.length ? 'block' : 'none';
      });
  });

  document.addEventListener('click', e => {
    if (!e.target.closest('#sugestoes') && e.target !== inputNome) sugestoes.style.display = 'none';
  });

  function carregarModelo(id) {
    fetch(`carregar_modelo.php?id=${id}`)
      .then(r => r.json())
      .then(data => {
        const container = document.getElementById('clausulas-modelo');
        container.innerHTML = '';
        data.clausulas.forEach(c => {
          const div = document.createElement('div');
          div.classList.add('clausula', 'tipo-' + c.tipo); // Aplica classe de tipo
          div.setAttribute('draggable', 'true');
          div.setAttribute('data-id', c.id);
          div.innerHTML = `<button onclick="this.parentElement.remove()">🗑️</button>
            <strong>${c.titulo}</strong><br><small>${c.descricao}</small>`;
          container.appendChild(div);
        });

      });
  }
</script>

</body>
</html>
