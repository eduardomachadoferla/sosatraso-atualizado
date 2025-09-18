<?php
include('config/conexao.php');

// Validação de nome exato
if (isset($_GET['validar'])) {
    $nome = trim($_GET['nome']);
    $sql = "SELECT * FROM alunos WHERE nome = :nome";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nome' => $nome]);
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aluno) {
        echo "valido";
    } else {
        echo "invalido";
    }
    exit;
}

// Busca de sugestões
if (isset($_GET['nome'])) {
    $nome = $_GET['nome'] . "%";
    $sql = "SELECT nome, turma FROM alunos WHERE nome LIKE :nome LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($alunos) {
        foreach ($alunos as $aluno) {
            echo "<div onclick=\"selecionarNome('" . $aluno['nome'] . "|" . $aluno['turma'] ."')\" 
                       style='cursor:pointer; padding:5px; border-bottom:1px solid #ccc;'>" 
                 . $aluno['nome'] . " - " . $aluno['turma'] . 
                 "</div>";
        }
    } else {
        echo "<div style='color:red; padding:5px;'>Nenhum aluno encontrado</div>";
    }
}
?>
