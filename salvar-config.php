<?php
require_once 'config.php';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Coletar dados do formulário
$dados = [
    'sistema_tipo' => $_POST['sistema_tipo'] ?? '',
    'empresa_nome' => $_POST['empresa_nome'] ?? '',
    'empresa_setor' => $_POST['empresa_setor'] ?? '',
    'empresa_dimensao' => $_POST['empresa_dimensao'] ?? '',
    'armazens_qtd' => intval($_POST['armazens_qtd'] ?? 1),
    'relatorios_frequencia' => $_POST['relatorios_frequencia'] ?? 'semanal',
    'empresa_email' => $_POST['empresa_email'] ?? '',
    'empresa_telefone' => $_POST['empresa_telefone'] ?? '',
    'modulos_selecionados' => $_POST['modulos'] ?? [],
    'data_configuracao' => date('Y-m-d H:i:s'),
    'usuario_id' => $_SESSION['usuario_id'] ?? 'admin_1'
];

// Validar dados obrigatórios
if (empty($dados['sistema_tipo']) || empty($dados['empresa_nome']) || empty($dados['empresa_setor'])) {
    $_SESSION['erro'] = 'Por favor, preencha todos os campos obrigatórios';
    header('Location: index.php');
    exit();
}

// Salvar configuração de acordo com o modo escolhido
if (STORAGE_MODE === 'json') {
    salvarConfiguracaoJSON($dados);
} elseif (STORAGE_MODE === 'database') {
    salvarConfiguracaoDB($dados);
}

// Atualizar sessão
$_SESSION['sistema_configurado'] = true;
$_SESSION['config_sistema'] = $dados;
$_SESSION['empresa_nome'] = $dados['empresa_nome'];
$_SESSION['sistema_tipo'] = $dados['sistema_tipo'];

// Redirecionar para dashboard
header('Location: dashboard.php');
exit();

// Funções de armazenamento
function salvarConfiguracaoJSON($dados) {
    // Ler configurações existentes
    $configuracoes = [];
    if (file_exists(CONFIG_FILE)) {
        $conteudo = file_get_contents(CONFIG_FILE);
        $configuracoes = json_decode($conteudo, true) ?? [];
    }
    
    // Adicionar nova configuração
    $id = uniqid('config_', true);
    $dados['id'] = $id;
    $configuracoes[$id] = $dados;
    
    // Salvar no arquivo
    file_put_contents(CONFIG_FILE, json_encode($configuracoes, JSON_PRETTY_PRINT));
    
    return $id;
}

function salvarConfiguracaoDB($dados) {
    // Esta função seria implementada se estivesse usando MySQL
    // Exemplo básico:
    /*
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS
    );
    
    $sql = "INSERT INTO configuracoes_sistema (...) VALUES (...)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([...]);
    */
}
?>