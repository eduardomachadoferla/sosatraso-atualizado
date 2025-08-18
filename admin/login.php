<?php
session_start();
include('../config/conexao.php');

$css = ['geral.css', 'index.css', 'estilo.css'];
include('../includes/header.php');
?>

</head>
<body>
<div class="bg-white w-[40%] mx-auto rounded-lg drop-shadow-lg mt-22 px-10 py-10 h-[auto]">
    <h3 style="text-align:center;" class="text-xl font-bold mb-6">ACESSO RESTRITO</h3>

    <!-- MENSAGEM DE ERRO -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center mb-4" role="alert">
            <strong class="font-bold">Erro:</strong>
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- FORMULÁRIO -->
    <form action="logar.php" method="post" id="cadastroForm" class="cadastroForm text-center">

        <!-- Setor -->
        <input 
            type="text" 
            class="border w-full border-gray-400 rounded-md p-3 mb-5" 
            id="setor" 
            name="setor" 
            placeholder="Setor" 
            required
        >

        <!-- Senha -->
        <input 
            type="password" 
            class="border w-full border-gray-400 rounded-md p-3 mb-5" 
            id="senha" 
            name="senha" 
            placeholder="Senha" 
            required
        >

        <!-- Link Esqueci minha senha -->
        <a 
            href="./recuperacao-de-senha/esqueci_senha.php" 
            class="text-blue-600 underline block mb-4"
        >Esqueci minha senha</a>

        <!-- Botões -->
        <div class="flex justify-center gap-4 mt-6">
            <a 
                href="<?php echo BASE_URL; ?>" 
                class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg"
            >Voltar à Home</a>

            <button 
                type="submit" 
                class="bg-marista text-white px-6 py-2 rounded-lg drop-shadow-lg"
            >ACESSAR RELATÓRIO</button>
        </div>
    </form>
</div>
</body>
</html>
