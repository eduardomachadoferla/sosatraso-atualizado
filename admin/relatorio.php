<?php
    // Inicia sessão (necessário para autenticação e PDF)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include('../config/conexao.php');

    // Proteção de rota
    if (!isset($_SESSION['login']['auth'])) {
        header("Location: " . BASE_URL . 'login.php');
        exit;
    }

    // ====== PARÂMETROS DE FILTRO (aceita POST e GET) ======
    $filterTurma = isset($_POST['turma']) ? $_POST['turma'] : (isset($_GET['turma']) ? $_GET['turma'] : '');
    $filterData1 = isset($_POST['data1']) ? $_POST['data1'] : (isset($_GET['data1']) ? $_GET['data1'] : '');
    $filterData2 = isset($_POST['data2']) ? $_POST['data2'] : (isset($_GET['data2']) ? $_GET['data2'] : '');

    // ====== PAGINAÇÃO ======
    $limit  = 20;
    $pagina = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
    if ($pagina < 1) $pagina = 1;

    // ====== BUSCA TURMAS (para o select) ======
    $stmt2 = $pdo->prepare("SELECT * FROM turmas");
    $stmt2->execute();
    $turmas = $stmt2->fetchAll();

    // ====== MONTA WHERE PARAMETRIZADO ======
    $where   = [];
    $params  = [];

    if (!empty($filterTurma)) {
        $where[]            = "turma = :turma";
        $params[':turma']   = $filterTurma;
    }

    // Datas
    if (!empty($filterData1) && !empty($filterData2)) {
        $where[]             = "data BETWEEN :data1 AND :data2";
        $params[':data1']    = $filterData1 . " 00:00:00";
        $params[':data2']    = $filterData2 . " 23:59:59";
    } elseif (!empty($filterData1)) {
        // Apenas data1 -> considera o dia inteiro
        $where[]             = "data BETWEEN :data1 AND :data1_end";
        $params[':data1']    = $filterData1 . " 00:00:00";
        $params[':data1_end']= $filterData1 . " 23:59:59";
    } elseif (!empty($filterData2)) {
        // Apenas data2 -> considera o dia inteiro
        $where[]              = "data BETWEEN :data2_start AND :data2_end";
        $params[':data2_start']= $filterData2 . " 00:00:00";
        $params[':data2_end']  = $filterData2 . " 23:59:59";
    }

    $baseSql  = " FROM sosatraso";
    $whereSql = $where ? (" WHERE " . implode(" AND ", $where)) : "";

    // ====== TOTAL DE REGISTROS ======
    $countSql = "SELECT COUNT(*)" . $baseSql . $whereSql;
    $stmtCount = $pdo->prepare($countSql);
    $stmtCount->execute($params);
    $totalRegistros = (int)$stmtCount->fetchColumn();

    $totalPaginas = max(1, (int)ceil($totalRegistros / $limit));
    if ($pagina > $totalPaginas) { $pagina = $totalPaginas; }
    $offset = ($pagina - 1) * $limit;

    // ====== RELATÓRIO (ordem do mais antigo para o mais recente) ======
    // Obs.: offset/limit são inteiros já validados, então podem ser interpolados
    $selectSql = "SELECT *" . $baseSql . $whereSql . " ORDER BY data ASC LIMIT $offset, $limit";
    $stmtRelatorio = $pdo->prepare($selectSql);
    $stmtRelatorio->execute($params);
    $dataRelatorio = $stmtRelatorio->fetchAll();

    // ====== DADOS PARA O PDF (mesmo filtro e ordem) ======
    $pdfSql = "SELECT *" . $baseSql . $whereSql . " ORDER BY data ASC";
    $stmtPdf = $pdo->prepare($pdfSql);
    $stmtPdf->execute($params);

    $_SESSION['pdf_title'] = "Relatório de atrasos";
    $_SESSION['pdf']       = $stmtPdf->fetchAll();

    // ====== QUERY STRING para manter filtros na paginação ======
    $qs = [];
    if (!empty($filterTurma)) $qs['turma'] = $filterTurma;
    if (!empty($filterData1)) $qs['data1'] = $filterData1;
    if (!empty($filterData2)) $qs['data2'] = $filterData2;
    $qsBase = http_build_query($qs);
    $qsSep  = $qsBase ? '&' : '';

    $css = ['index.css', 'estilo.css'];
    include("include/header.php");
    unset($_SESSION['ALUNO']);
?>
<div class="bg-white w-6xl mx-auto p-6 rounded-lg">
    <p class="text-2xl mx-auto text-center font-black text-marista mb-6">CONSULTAR ALUNOS</p>

    <form action="relatorio.php" method="post" id="cadastroForm" class="cadastroForm">
        <div class="formulario">
            <div class="data">
                <input class="border w-ms border-gray-400 rounded-md p-3" type="date" name="data1" id="data1"
                       value="<?php echo htmlspecialchars($filterData1 ?: '', ENT_QUOTES); ?>"> até
                <input class="border w-ms border-gray-400 rounded-md p-3" type="date" name="data2" id="data2"
                       value="<?php echo htmlspecialchars($filterData2 ?: '', ENT_QUOTES); ?>">
            </div>
            <div class="data">
                <select class="border w-md border-gray-400 rounded-md p-3" name="turma" id="turma">
                    <option value="">Selecionar turma...</option>
                    <?php foreach ($turmas as $t) { ?>
                        <option value="<?php echo $t['id']; ?>"
                            <?php echo (!empty($filterTurma) && (string)$filterTurma === (string)$t['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($t['turma'], ENT_QUOTES); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <button class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg" type="submit">
                    CONSULTAR RELATÓRIO
                </button>
            </div>
        </div>
    </form>

    <div id="resultados">
        <br><br>

        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Turma</th>
                    <th>Motivo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <?php if (!empty($dataRelatorio)) { ?>
                <tbody>
                    <?php foreach ($dataRelatorio as $dado) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dado['nome'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($dado['turma'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($dado['motivo'], ENT_QUOTES); ?></td>
                            <td>
                                <?php
                                    // Formata a data YYYY-MM-DD HH:MM:SS -> DD/MM/YYYY - HH:MM:SS
                                    $partes = explode(' ', $dado['data']);
                                    $dataBr = implode('/', array_reverse(explode('-', $partes[0])));
                                    echo $dataBr . ' - ' . $partes[1];
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="4">Sem registro na data selecionada!</td>
                    </tr>
                </tbody>
            <?php } ?>
        </table>
    </div>

    <!-- Paginação -->
    <div class="mt-6 flex justify-center">
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs mx-auto" aria-label="Pagination">

            <!-- Botão Anterior -->
            <?php if ($pagina > 1) { ?>
                <a href="relatorio.php?<?php echo $qsBase . $qsSep; ?>pagination=<?php echo $pagina - 1; ?>"
                   class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                    <span class="sr-only">Anterior</span>
                    &#9664;
                </a>
            <?php } else { ?>
                <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset cursor-not-allowed">
                    &#9664;
                </span>
            <?php } ?>

            <!-- Números -->
            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                <a href="relatorio.php?<?php echo $qsBase . $qsSep; ?>pagination=<?php echo $i; ?>"
                   class="<?php echo ($pagina == $i) ? 'bg-marista text-white' : 'bg-marista2 text-white'; ?> relative inline-flex items-center px-4 py-2 text-sm font-semibold">
                    <?php echo $i; ?>
                </a>
            <?php } ?>

            <!-- Botão Próximo -->
            <?php if ($pagina < $totalPaginas) { ?>
                <a href="relatorio.php?<?php echo $qsBase . $qsSep; ?>pagination=<?php echo $pagina + 1; ?>"
                   class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
                    <span class="sr-only">Próximo</span>
                    &#9654;
                </a>
            <?php } else { ?>
                <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-gray-300 ring-inset cursor-not-allowed">
                    &#9654;
                </span>
            <?php } ?>
        </nav>
    </div>

    <br>
    <center>
        <a href="relatorio_pdf.php" target="_blank">
            <button class="bg-marista2 text-white px-6 py-2 rounded-lg drop-shadow-lg mt-6">GERAR PDF</button>
        </a>
    </center>
    <br>
</div>

<script>
    // JS antigo (se necessário)
    var expanded = false;
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
</script>

</body>
</html>
