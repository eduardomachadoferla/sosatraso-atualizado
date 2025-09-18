<?php
session_start();

include('../../config/conexao.php'); // precisa definir $pdo aqui
include('../../config/base.php');

if (!isset($_SESSION['login']['auth'])) {
    header("Location: " . BASE_ADMIN . 'login.php');
    exit();
}

include('../include/header.php');

if (!isset($_GET['id'])) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>ID do usuário não fornecido.</div>";
    exit();
}

$id = (int)$_GET['id'];

// Buscar dados do usuário
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<div class='text-red-600 text-center mt-6 font-semibold'>Usuário não encontrado.</div>";
    exit();
}

// Permissões atuais (string → array)
$permissoesAtuais = explode(',', $usuario['permissao']);

// Setores atuais (string → array)
$setoresAtuais = explode(',', $usuario['setor']);

// Lista de permissões possíveis
$listaPermissoes = [
    'admin' => 'Admin',
    'gerenciar_alunos' => 'Gerenciar alunos',
    'ver_relatorios' => 'Ver relatórios',
    'editar_turmas' => 'Editar turmas'
];

// Lista de setores possíveis
$listaSetores = [
    'Admin' => 'Admin',
    'Educador' => 'Educador',
    'Coordenação' => 'Coordenação',
];

// Atualizar dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    // Pega setores enviados
    $setores = isset($_POST['setor']) ? $_POST['setor'] : [];
    $setorStr = implode(',', $setores);

    // Pega permissões enviadas
    $permissoes = isset($_POST['permissao']) ? $_POST['permissao'] : [];
    $permissaoStr = implode(',', $permissoes);

    $senha = trim($_POST['senha']);

    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE usuarios 
                      SET nome = :nome, email = :email, setor = :setor, permissao = :permissao, senha = :senha 
                      WHERE id = :id";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':setor' => $setorStr,
            ':permissao' => $permissaoStr,
            ':senha' => $senhaHash,
            ':id' => $id,
        ];
    } else {
        $sqlUpdate = "UPDATE usuarios 
                      SET nome = :nome, email = :email, setor = :setor, permissao = :permissao 
                      WHERE id = :id";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':setor' => $setorStr,
            ':permissao' => $permissaoStr,
            ':id' => $id,
        ];
    }

    $stmtUpdate = $pdo->prepare($sqlUpdate);
    if ($stmtUpdate->execute($params)) {
        header("Location: listar-usuarios.php");
        exit();
    } else {
        echo "<div class='text-red-600 text-center mt-6 font-semibold'>Erro ao atualizar usuário.</div>";
    }
}
?>

<div class="bg-white max-w-3xl mx-auto p-8 mt-10 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-center text-marista">Editar Usuário</h2>

    <form action="" method="post" class="space-y-6">
        <div>
            <label class="block mb-2 font-medium text-gray-700">Nome:</label>
            <input 
                type="text" 
                name="nome" 
                value="<?= htmlspecialchars($usuario['nome']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">E-mail:</label>
            <input 
                type="email" 
                name="email" 
                value="<?= htmlspecialchars($usuario['email']) ?>" 
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
                required
            >
        </div>

        <!-- Checkboxes de Setores -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Setores:</label>
            <div class="space-y-2">
                <?php foreach ($listaSetores as $valor => $label): ?>
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="setor[]" 
                            value="<?= $valor ?>"
                            class="mr-2"
                            <?= in_array($valor, $setoresAtuais) ? 'checked' : '' ?>
                        >
                        <?= $label ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Checkboxes de Permissões -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Permissões:</label>
            <div class="space-y-2">
                <?php foreach ($listaPermissoes as $valor => $label): ?>
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="permissao[]" 
                            value="<?= $valor ?>"
                            class="mr-2"
                            <?= in_array($valor, $permissoesAtuais) ? 'checked' : '' ?>
                        >
                        <?= $label ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-700">Senha:</label>
            <input 
                type="password" 
                name="senha" 
                placeholder="Deixe em branco para manter a senha atual"
                class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-marista"
            >
        </div>

        <div class="flex justify-between mt-6">
            <a href="../usuarios/listar-usuarios.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
                Voltar
            </a>

            <div>
                <!-- Botão salvar -->
                <button type="submit" class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg hover:bg-marista2 transition mr-3">
                    Salvar alterações
                </button>

                <!-- Formulário para excluir -->
                <form action="apagar-usuario.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    </form>
</div>
