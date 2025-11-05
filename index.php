<?php
include('config/base.php');
include('config/conexao.php');
include('includes/header.php');

$sql2 = 'SELECT * FROM alunos';
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$turmas = $stmt2->fetchAll();

// mantém seus CSS (inclui autorizacao.css se você tiver)
$css = ['geral.css', 'index.css', 'estilo.css', 'autorizacao.css'];

// mensagem de erro (sessão), se houver
if (isset($_SESSION['erro'])) {
    echo '<div style="color:red; text-align:center; margin:10px 0; font-weight:bold;">'
        . $_SESSION['erro'] . '</div>';
    unset($_SESSION['erro']);
}

unset($_SESSION['ALUNO']);
?>

<!-- CSS mínimo crítico pra sugestões e container -->
<style>
  .pesquisa { position: relative; }
  .sugestoes{
    max-height:180px; overflow-y:auto; background:#fff; position:absolute; width:100%;
    z-index:1000; box-shadow:0 6px 18px rgba(0,0,0,.12); border-radius:.5rem; border:1px solid #e5e7eb;
  }
  .sugestoes div{ padding:.6rem .8rem; cursor:pointer; border-bottom:1px solid #f1f5f9; font-size:.975rem; }
  .sugestoes div:last-child{ border-bottom:0; }
  .sugestoes div:hover{ background:#f8fafc; }
  #mensagemErro{ color:#dc2626; font-size:.9rem; margin:-.25rem 0 .5rem 0; min-height:1em; }
</style>
<div class="bg-white w-full max-w-md mx-auto rounded-lg drop-shadow-lg mt-22 px-4 md:px-10 py-10 h-auto">
    <form action="autorizacao.php" method="post" id="cadastroForm" class="flex flex-col justify-center ite
  <form action="autorizacao.php method="post" id="cadastroForm" class="flex flex-col justify-center items-center mt-4" onsubmit="return prepararEnvio()">

    <!-- Campo de pesquisa de aluno -->
    <div class="w-full pesquisa">
      <input
        class="border border-gray-400 rounded-md p-3 mb-2 w-full"
        type="text" id="nome" name="nome" placeholder="Nome Completo"
        required autocomplete="off" onkeyup="buscarNomes()" onblur="validarNome()">
      <input type="hidden" id="turma" name="turma">

      <div id="mensagemErro"></div>
      <div id="sugestoes" class="sugestoes"></div>
    </div>

    <!-- Motivo do atraso -->
    <select
      class="border border-gray-400 rounded-md p-3 mb-5 w-full"
      id="motivo_atraso" name="motivo_atraso" required onchange="mostrarCaixaTexto()">
      <option value="">Motivo do Atraso</option>
      <option value="Perdi o horário">Perdi o horário</option>
      <option value="Chuva">Chuva</option>
      <option value="Imprevisto com o meio de transporte">Imprevisto com o meio de transporte</option>
      <option value="Outro">Outro</option>
    </select>

    <!-- Outro motivo -->
    <div id="outro_motivo" class="w-full mb-5 hidden">
      <input class="border border-gray-400 rounded-md p-3 w-full" type="text" id="outro_text" name="outro_text" placeholder="Especifique o Motivo">
    </div>

    <!-- Botão -->
    <div class="text-center">
      <button class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg mt-2" type="submit">
        GERAR BILHETE
      </button>
    </div>
  </form>
</div>

<script>
  // debounce simples para a busca
  let debounceTimer = null;

  function buscarNomes() {
    const nomeEl = document.getElementById("nome");
    const sugestoesEl = document.getElementById("sugestoes");
    const nome = nomeEl.value.trim();

    if (debounceTimer) clearTimeout(debounceTimer);

    if (nome.length < 2) {
      sugestoesEl.innerHTML = "";
      return;
    }

    debounceTimer = setTimeout(function () {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "buscar_alunos.php?nome=" + encodeURIComponent(nome), true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          sugestoesEl.innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }, 200);
  }

  // Espera formato "NOME|TURMA" vindo do backend
  function selecionarNome(valor) {
    const [nome, turma] = String(valor || "").split("|");
    document.getElementById("nome").value = (nome || "").trim();
    document.getElementById("turma").value = (turma || "").trim();
    document.getElementById("sugestoes").innerHTML = "";
    const msg = document.getElementById("mensagemErro");
    if (msg) msg.innerText = "";
  }

  document.addEventListener('DOMContentLoaded', function() {
    // garante estado inicial do "outro"
    document.getElementById("outro_motivo").classList.add("hidden");
    document.getElementById("outro_text").removeAttribute("required");
  });

  function mostrarCaixaTexto() {
    const selectElement = document.getElementById("motivo_atraso");
    const outroMotivoDiv = document.getElementById("outro_motivo");
    const outroTextInput = document.getElementById("outro_text");

    if (selectElement.value === "Outro") {
      outroMotivoDiv.classList.remove("hidden");
      outroTextInput.setAttribute("required", "required");
    } else {
      outroMotivoDiv.classList.add("hidden");
      outroTextInput.removeAttribute("required");
      outroTextInput.value = "";
    }
  }

  function validarNome() {
    const nome = document.getElementById("nome").value.trim();
    const msg = document.getElementById("mensagemErro");
    const turma = document.getElementById("turma");

    if (!nome) return;

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "buscar_alunos.php?validar=1&nome=" + encodeURIComponent(nome), true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if (xhr.responseText.trim() === "invalido") {
          if (msg) msg.innerText = "⚠ Nome não encontrado. Selecione um aluno válido!";
          document.getElementById("nome").value = "";
          if (turma) turma.value = "";
        } else {
          if (msg) msg.innerText = "";
        }
      }
    };
    xhr.send();
  }

  // valida antes de enviar
  function prepararEnvio() {
    const nome = document.getElementById("nome").value.trim();
    const turma = document.getElementById("turma").value.trim();
    const msg = document.getElementById("mensagemErro");
    if (!nome || !turma) {
      if (msg) msg.innerText = "⚠ Selecione um aluno válido na lista!";
      return false;
    }
    return true;
  }

  // fecha a lista de sugestões ao clicar fora
  document.addEventListener('click', function (e) {
    const wrap = document.querySelector('.pesquisa');
    const sug = document.getElementById('sugestoes');
    if (wrap && sug && !wrap.contains(e.target)) {
      sug.innerHTML = '';
    }
  });
</script>

  <footer class="bg-marista text-center py-3 mt-35 ">
            <p class="text-sm text-gray-500">
                Criado por 
                <strong class="text-gray-700">Eduardo Machado Ferla</strong> e 
                <strong class="text-gray-700">Gabrielly Heloyse Oviedo</strong> 
                | <span class="italic">Projeto SOS Atraso</span>
            </p>
            <small class="block text-xs text-gray-400 mt-1">
                &copy; <?php echo date("Y"); ?> Todos os direitos reservados a Marista Escola Social Cascavel | <a href="http://192.168.1.2/sosatraso-atualizado/admin/login.php">Admin</a>
            </small>
        </footer>
</body>
</html>
