    <?php
    session_start();
    include('../config/conexao.php');

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!$email || !$senha) {
        $_SESSION['error'] = "Preencha todos os campos.";
        header("Location: login.php");
        exit;
    }

    $sql = 'SELECT * FROM usuarios WHERE email = :email LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetchObject();

    if (!$usuario || !password_verify($senha, $usuario->senha)) {
        $_SESSION['error'] = "Usuário ou senha inválido!";
        header("Location: login.php");
        exit;
    }

    $_SESSION['login'] = [
        'auth' => true,
        'id' => $usuario->id,
        'nome' => $usuario->nome ?? $usuario->email, // se tiver campo nome
        'permissao' => $usuario->permissao,
        'email' => $usuario->email
    ];

    header("Location: index.php");
    exit;
