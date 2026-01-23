<?php
// Configurações do sistema - Coloque este arquivo na mesma pasta que index.php

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestao_empresas');
define('DB_USER', 'root');
define('DB_PASS', '');

// Modo de armazenamento (database ou json)
define('STORAGE_MODE', 'json'); // Pode ser 'database' ou 'json'

// Caminhos - ATUALIZADO para caminhos relativos
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('STORAGE_PATH', BASE_PATH . 'storage' . DIRECTORY_SEPARATOR);
define('CONFIG_FILE', STORAGE_PATH . 'configuracoes.json');
define('ASSETS_PATH', BASE_PATH . 'assets' . DIRECTORY_SEPARATOR);

// Configurações da sessão
session_start();

// Timezone de Portugal
date_default_timezone_set('Europe/Lisbon');

// Configurações de segurança
define('MAX_LOGIN_ATTEMPTS', 5);
define('SESSION_TIMEOUT', 3600); // 1 hora

// URLs - ajuste conforme sua instalação
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

define('BASE_URL', $protocol . $host . $path . '/');
define('LOGIN_URL', BASE_URL . 'login.php');
define('DASHBOARD_URL', BASE_URL . 'dashboard.php');

// Verificar se o storage existe
if (!file_exists(STORAGE_PATH)) {
    if (!mkdir(STORAGE_PATH, 0777, true)) {
        die('Erro: Não foi possível criar a pasta de storage');
    }
}

// Verificar se o arquivo de configurações existe
if (!file_exists(CONFIG_FILE)) {
    $initialConfig = json_encode([], JSON_PRETTY_PRINT);
    if (file_put_contents(CONFIG_FILE, $initialConfig) === false) {
        die('Erro: Não foi possível criar o arquivo de configurações');
    }
}

// Função para debug
function debug($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

// Função para registrar erros
function registrarErro($mensagem) {
    $logFile = STORAGE_PATH . 'erros.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $mensagem" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>