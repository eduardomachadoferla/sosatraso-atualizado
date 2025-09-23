<?php
session_start();

include('../../config/conexao.php');
include('../../config/base.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) {
        $id = (int)$_POST['id'];

        // Verifica se o usuário existe (opcional)
        $sqlCheck = "SELECT * FROM usuarios WHERE id = :id";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':id' => $id]);
        $usuario = $stmtCheck->fetch();

        if ($usuario) {
            // Executa a exclusão
            $sqlDelete = "DELETE FROM usuarios WHERE id = :id";
            $stmtDelete = $pdo->prepare($sqlDelete);
            if ($stmtDelete->execute([':id' => $id])) {
                // Exclusão feita com sucesso, redireciona
                header("Location: listar-usuarios.php?msg=excluido");
                exit();
            } else {
                echo "Erro ao excluir usuário.";
            }
        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "ID inválido.";
    }
} else {
    echo "Método inválido.";
}
?>
