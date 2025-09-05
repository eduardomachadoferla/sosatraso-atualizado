    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    date_default_timezone_set('America/Sao_Paulo');

    // Evita redefinir as constantes caso já estejam definidas
    if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/sosatraso-main-verificar/');
    if (!defined('BASE_ADMIN')) define('BASE_ADMIN', 'http://localhost/sosatraso-main-verificar/admin/');
    if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
    if (!defined('DB_NAME')) define('DB_NAME', 'teste3007');
    if (!defined('DB_USER')) define('DB_USER', 'root');
    if (!defined('DB_PASS')) define('DB_PASS', '');  // Senha do banco (geralmente vazia no XAMPP)
    if (!defined('BASE_ROOT')) define('BASE_ROOT', dirname(__dir__) . DIRECTORY_SEPARATOR );
    if (!defined('ROOT_ADMIN')) define('ROOT_ADMIN', dirname(__dir__) . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR);
    ?>
