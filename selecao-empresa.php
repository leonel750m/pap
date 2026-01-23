<?php
session_start();

// Se já tem configuração salva, redireciona para o dashboard
if (isset($_SESSION['sistema_configurado']) && $_SESSION['sistema_configurado'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Inicializar variáveis da sessão se não existirem
if (!isset($_SESSION['config_sistema'])) {
    $_SESSION['config_sistema'] = [];
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Tipo de Sistema - Gestão Empresarial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Estilos principais do sistema */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

body {
    background-color: #f5f7fa;
    color: #333;
    min-height: 100vh;
    background-image: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    margin-bottom: 30px;
}

.logo {
    display: flex;
    align-items: center;
}

.logo i {
    font-size: 28px;
    color: #2a5298;
    margin-right: 10px;
}

.logo h1 {
    font-size: 24px;
    color: #1e3c72;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

.logout-btn {
    padding: 8px 16px;
    background-color: #f5f7fa;
    color: #666;
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s;
}

.logout-btn:hover {
    background-color: #e4edf5;
}

/* Wizard Container */
.wizard-container {
    background-color: white;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    padding: 40px;
    margin-top: 20px;
}

.wizard-header {
    text-align: center;
    margin-bottom: 40px;
}

.wizard-header h2 {
    font-size: 32px;
    color: #1e3c72;
    margin-bottom: 10px;
}

.wizard-header p {
    color: #666;
    font-size: 16px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Steps */
.wizard-steps {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
    position: relative;
}

.wizard-steps::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 50px;
    right: 50px;
    height: 3px;
    background-color: #e0e6ef;
    z-index: 1;
}

.step {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
    max-width: 200px;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e0e6ef;
    color: #777;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin: 0 auto 10px;
    transition: all 0.3s;
}

.step.active .step-circle {
    background-color: #2a5298;
    color: white;
    transform: scale(1.1);
}

.step.completed .step-circle {
    background-color: #11998e;
    color: white;
}

.step.completed .step-circle::after {
    content: '✓';
    font-weight: bold;
}

.step-label {
    font-weight: 500;
    color: #777;
}

.step.active .step-label {
    color: #2a5298;
    font-weight: 600;
}

.step.completed .step-label {
    color: #11998e;
}

/* Sistema de escolha de tipo */
.system-selection {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.system-option {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
    position: relative;
}

.system-option:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.system-option.selected {
    border-color: #2a5298;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
}

.system-option.selected::after {
    content: '✓';
    position: absolute;
    top: 15px;
    right: 15px;
    width: 25px;
    height: 25px;
    background-color: #2a5298;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.system-header {
    padding: 25px 20px;
    color: white;
    display: flex;
    align-items: center;
}

.system-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px;
}

.system-info h3 {
    font-size: 20px;
    margin-bottom: 5px;
    font-weight: 600;
}

.system-info p {
    font-size: 14px;
    opacity: 0.9;
}

.system-content {
    padding: 20px;
}

.system-features {
    list-style: none;
    margin-bottom: 20px;
}

.system-features li {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 14px;
}

.system-features li i {
    color: #2a5298;
    margin-right: 8px;
    font-size: 12px;
}

.system-details {
    background-color: #f9fbfd;
    border-radius: 8px;
    padding: 15px;
    margin-top: 15px;
    display: none;
}

.system-option.selected .system-details {
    display: block;
}

.system-details h4 {
    font-size: 14px;
    color: #1e3c72;
    margin-bottom: 8px;
}

.system-details p {
    font-size: 13px;
    color: #666;
    line-height: 1.5;
}

/* Cores para diferentes tipos de sistema */
.metal-system .system-header {
    background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
}

.construction-system .system-header {
    background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);
}

.retail-system .system-header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.logistics-system .system-header {
    background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
}

/* Configuração do sistema */
.config-options {
    display: none;
    background-color: #f9fbfd;
    border-radius: 12px;
    padding: 30px;
    margin-top: 30px;
    border: 1px solid #e0e6ef;
}

.config-options.active {
    display: block;
    animation: fadeIn 0.5s;
}

.config-header {
    margin-bottom: 25px;
}

.config-header h3 {
    color: #1e3c72;
    font-size: 22px;
    margin-bottom: 10px;
}

.config-header p {
    color: #666;
}

.config-form {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #444;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: 1.5px solid #ddd;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #2a5298;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
}

.checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 10px;
}

.checkbox-item {
    display: flex;
    align-items: center;
}

.checkbox-item input {
    margin-right: 8px;
}

/* Ações */
.wizard-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #e0e6ef;
}

.action-btn {
    padding: 12px 30px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.back-btn {
    background-color: #f5f7fa;
    color: #666;
    border: 1px solid #ddd;
}

.next-btn {
    background-color: #2a5298;
    color: white;
}

.confirm-btn {
    background-color: #11998e;
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.back-btn:hover {
    background-color: #e4edf5;
}

.next-btn:hover {
    background-color: #3a62a8;
}

.confirm-btn:hover {
    background-color: #0d8a7e;
}

.action-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Notificação */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #11998e;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    z-index: 1001;
    display: none;
}

.notification i {
    margin-right: 10px;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1002;
    display: none;
}

.modal {
    background: white;
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
}

.modal-header {
    padding: 25px 30px;
    border-bottom: 1px solid #e0e6ef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    color: #1e3c72;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    padding: 20px 30px;
    border-top: 1px solid #e0e6ef;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

/* Estilos responsivos */
@media (max-width: 768px) {
    .system-selection {
        grid-template-columns: 1fr;
    }
    
    .wizard-container {
        padding: 25px 20px;
    }
    
    .wizard-steps::before {
        left: 30px;
        right: 30px;
    }
    
    .config-form {
        grid-template-columns: 1fr;
    }
    
    .wizard-actions {
        flex-direction: column;
        gap: 15px;
    }
    
    .action-btn {
        width: 100%;
        justify-content: center;
    }
    
    .modal {
        width: 95%;
        margin: 10px;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>
    <!-- Cabeçalho -->
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-building"></i>
                <h1>BizManager Pro</h1>
            </div>
            
            <div class="user-info">
                <div class="user-icon">
                    <?php
                    // Mostrar primeira letra do nome do usuário
                    $nomeUsuario = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'A';
                    echo strtoupper(substr($nomeUsuario, 0, 1));
                    ?>
                </div>
                <div>
                    <div style="font-weight: 600;">
                        <?php echo isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'Administrador'; ?>
                    </div>
                    <div style="font-size: 13px; color: #666;">
                        <?php echo isset($_SESSION['usuario_email']) ? $_SESSION['usuario_email'] : 'admin@sistema.pt'; ?>
                    </div>
                </div>
                <button class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </div>
        </div>
        
        <!-- Assistente de configuração -->
        <div class="wizard-container">
            <div class="wizard-header">
                <h2>Configurar Novo Sistema</h2>
                <p>Escolha o tipo de sistema de stock que melhor se adapta ao seu negócio. Cada sistema tem funcionalidades específicas para diferentes setores.</p>
            </div>
            
            <!-- Passos do assistente -->
            <div class="wizard-steps">
                <div class="step active" id="step1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Escolher Sistema</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Configurar</div>
                </div>
                <div class="step" id="step3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Confirmar</div>
                </div>
            </div>
            
            <!-- PASSO 1: Escolher tipo de sistema -->
            <div id="step1-content">
                <div class="system-selection">
                    <!-- Sistema para Metal -->
                    <div class="system-option metal-system" data-system="metal">
                        <div class="system-header">
                            <div class="system-icon">
                                <i class="fas fa-industry"></i>
                            </div>
                            <div class="system-info">
                                <h3>Sistema para Metal</h3>
                                <p>Indústria Metalúrgica</p>
                            </div>
                        </div>
                        
                        <div class="system-content">
                            <ul class="system-features">
                                <li><i class="fas fa-check"></i> Gestão de metais e ligas</li>
                                <li><i class="fas fa-check"></i> Controlo de lotes e seriais</li>
                                <li><i class="fas fa-check"></i> Rastreabilidade de materiais</li>
                                <li><i class="fas fa-check"></i> Relatórios de qualidade</li>
                            </ul>
                            
                            <div class="system-details">
                                <h4>Ideal para:</h4>
                                <p>Fundições, siderurgias, metalomecânicas, empresas de transformação de metais.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sistema para Construção -->
                    <div class="system-option construction-system" data-system="construction">
                        <div class="system-header">
                            <div class="system-icon">
                                <i class="fas fa-hard-hat"></i>
                            </div>
                            <div class="system-info">
                                <h3>Sistema para Construção</h3>
                                <p>Construção Civil e Obras</p>
                            </div>
                        </div>
                        
                        <div class="system-content">
                            <ul class="system-features">
                                <li><i class="fas fa-check"></i> Gestão por obra/ projeto</li>
                                <li><i class="fas fa-check"></i> Controlo de equipamentos</li>
                                <li><i class="fas fa-check"></i> Consumo por fases</li>
                                <li><i class="fas fa-check"></i> Pedidos a fornecedores</li>
                            </ul>
                            
                            <div class="system-details">
                                <h4>Ideal para:</h4>
                                <p>Construtoras, empreiteiras, empresas de remodelação, gestão de projetos.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sistema para Retalho -->
                    <div class="system-option retail-system" data-system="retail">
                        <div class="system-header">
                            <div class="system-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="system-info">
                                <h3>Sistema para Retalho</h3>
                                <p>Comércio e Distribuição</p>
                            </div>
                        </div>
                        
                        <div class="system-content">
                            <ul class="system-features">
                                <li><i class="fas fa-check"></i> Gestão multicanal</li>
                                <li><i class="fas fa-check"></i> Reposição automática</li>
                                <li><i class="fas fa-check"></i> Controlo de expirações</li>
                                <li><i class="fas fa-check"></i> Análise de vendas</li>
                            </ul>
                            
                            <div class="system-details">
                                <h4>Ideal para:</h4>
                                <p>Lojas, supermercados, distribuidores, e-commerce, franchising.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sistema para Logística -->
                    <div class="system-option logistics-system" data-system="logistics">
                        <div class="system-header">
                            <div class="system-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="system-info">
                                <h3>Sistema para Logística</h3>
                                <p>Armazenagem e Distribuição</p>
                            </div>
                        </div>
                        
                        <div class="system-content">
                            <ul class="system-features">
                                <li><i class="fas fa-check"></i> Gestão por lotes FIFO/LIFO</li>
                                <li><i class="fas fa-check"></i> Rastreio de localizações</li>
                                <li><i class="fas fa-check"></i> Otimização de armazenagem</li>
                                <li><i class="fas fa-check"></i> Integração com transportadoras</li>
                            </ul>
                            
                            <div class="system-details">
                                <h4>Ideal para:</h4>
                                <p>Armazéns, centros de distribuição, operadores logísticos, transporte.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PASSO 2: Configurar o sistema escolhido -->
            <form id="configForm" action="salvar-config.php" method="POST">
                <div class="config-options" id="step2-content">
                    <div class="config-header">
                        <h3 id="configTitle">Configurar Sistema</h3>
                        <p id="configDescription">Personalize as opções do sistema escolhido</p>
                    </div>
                    
                    <div class="config-form">
                        <input type="hidden" id="sistema_tipo" name="sistema_tipo" value="">
                        
                        <div class="form-group">
                            <label for="companyName">Nome da Empresa *</label>
                            <input type="text" id="companyName" name="empresa_nome" placeholder="Ex: Metalurgia Lda" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="companySector">Setor de Atividade *</label>
                            <input type="text" id="companySector" name="empresa_setor" placeholder="Ex: Indústria Metalúrgica" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="companySize">Dimensão da Empresa *</label>
                            <select id="companySize" name="empresa_dimensao" required>
                                <option value="">Selecione...</option>
                                <option value="micro">Microempresa (até 10 funcionários)</option>
                                <option value="pequena">Pequena (11-50 funcionários)</option>
                                <option value="media">Média (51-250 funcionários)</option>
                                <option value="grande">Grande (mais de 250 funcionários)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="warehouseCount">Número de Armazéns *</label>
                            <input type="number" id="warehouseCount" name="armazens_qtd" min="1" max="50" value="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Módulos Adicionais</label>
                            <div class="checkbox-group" id="modulesContainer">
                                <!-- Os módulos serão preenchidos dinamicamente via JavaScript -->
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="reportFrequency">Frequência de Relatórios *</label>
                            <select id="reportFrequency" name="relatorios_frequencia" required>
                                <option value="diaria">Diária</option>
                                <option value="semanal" selected>Semanal</option>
                                <option value="mensal">Mensal</option>
                                <option value="trimestral">Trimestral</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="empresa_email">Email de Contacto</label>
                            <input type="email" id="empresa_email" name="empresa_email" placeholder="contacto@empresa.pt">
                        </div>
                        
                        <div class="form-group">
                            <label for="empresa_telefone">Telefone</label>
                            <input type="tel" id="empresa_telefone" name="empresa_telefone" placeholder="+351 123 456 789">
                        </div>
                    </div>
                </div>
                
                <!-- Ações -->
                <div class="wizard-actions">
                    <button type="button" class="action-btn back-btn" id="backBtn" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                    
                    <button type="button" class="action-btn next-btn" id="nextBtn" disabled>
                        Continuar <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <button type="submit" class="action-btn confirm-btn" id="confirmBtn" style="display: none;">
                        <i class="fas fa-save"></i> Salvar Configuração
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Notificação -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationText">Sistema configurado com sucesso!</span>
    </div>

    <!-- Resumo Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-check-circle"></i> Configuração Completa</h3>
                <button class="modal-close" id="modalClose">&times;</button>
            </div>
            <div class="modal-body">
                <div id="resumoConfiguracao"></div>
            </div>
            <div class="modal-footer">
                <button class="action-btn back-btn" id="modalVoltar">
                    <i class="fas fa-edit"></i> Corrigir
                </button>
                <button class="action-btn next-btn" id="modalConfirmar">
                    <i class="fas fa-check"></i> Confirmar e Salvar
                </button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>