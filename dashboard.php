<?php
session_start();

// Verificar se o sistema foi configurado
if (!isset($_SESSION['sistema_configurado']) || $_SESSION['sistema_configurado'] !== true) {
    header('Location: index.php');
    exit();
}

$config = $_SESSION['config_sistema'] ?? [];

// Nomes dos sistemas
$nomesSistemas = [
    'metal' => 'Sistema para Metal',
    'construction' => 'Sistema para Construção',
    'retail' => 'Sistema para Retalho',
    'logistics' => 'Sistema para Logística'
];

$dimensoes = [
    'micro' => 'Microempresa (até 10 funcionários)',
    'pequena' => 'Pequena (11-50 funcionários)',
    'media' => 'Média (51-250 funcionários)',
    'grande' => 'Grande (mais de 250 funcionários)'
];
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($config['empresa_nome']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .metal .stat-icon { background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%); }
        .construction .stat-icon { background: linear-gradient(135deg, #f46b45 0%, #eea849 100%); }
        .retail .stat-icon { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .logistics .stat-icon { background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%); }
        
        .config-details {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.05);
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .detail-label {
            font-weight: 600;
            color: #1e3c72;
            min-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-building"></i>
                <h1><?php echo htmlspecialchars($config['empresa_nome']); ?></h1>
            </div>
            
            <div class="user-info">
                <div class="user-icon">
                    <?php echo strtoupper(substr($_SESSION['usuario_nome'] ?? 'A', 0, 1)); ?>
                </div>
                <div>
                    <div style="font-weight: 600;"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Administrador'); ?></div>
                    <div style="font-size: 13px; color: #666;">Dashboard Principal</div>
                </div>
                <button class="logout-btn" onclick="window.location.href='index.php?action=edit'">
                    <i class="fas fa-cog"></i> Alterar Config
                </button>
                <button class="logout-btn" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </div>
        </div>
        
        <div class="dashboard-header">
            <h2>Bem-vindo ao seu Sistema de Gestão</h2>
            <p><?php echo $nomesSistemas[$config['sistema_tipo']] ?? 'Sistema Personalizado'; ?></p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card <?php echo $config['sistema_tipo']; ?>">
                <div class="stat-icon">
                    <?php 
                    $icones = [
                        'metal' => 'fas fa-industry',
                        'construction' => 'fas fa-hard-hat',
                        'retail' => 'fas fa-shopping-cart',
                        'logistics' => 'fas fa-truck'
                    ];
                    echo '<i class="' . ($icones[$config['sistema_tipo']] ?? 'fas fa-cogs') . '"></i>';
                    ?>
                </div>
                <div>
                    <h3><?php echo $nomesSistemas[$config['sistema_tipo']] ?? 'Sistema Personalizado'; ?></h3>
                    <p>Sistema ativo</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div>
                    <h3><?php echo $config['armazens_qtd']; ?> Armazém(ns)</h3>
                    <p>Em operação</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f46b45 0%, #eea849 100%);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3>Relatórios <?php echo ucfirst($config['relatorios_frequencia']); ?></h3>
                    <p>Próximo: <?php echo date('d/m/Y', strtotime('+1 week')); ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <div>
                    <h3><?php echo count($config['modulos_selecionados'] ?? []); ?> Módulos</h3>
                    <p>Ativos</p>
                </div>
            </div>
        </div>
        
        <div class="config-details">
            <h3 style="margin-bottom: 25px; color: #1e3c72;">Detalhes da Configuração</h3>
            
            <div class="detail-item">
                <div class="detail-label">Empresa:</div>
                <div><?php echo htmlspecialchars($config['empresa_nome']); ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Setor:</div>
                <div><?php echo htmlspecialchars($config['empresa_setor']); ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Dimensão:</div>
                <div><?php echo $dimensoes[$config['empresa_dimensao']] ?? 'Não especificado'; ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Tipo de Sistema:</div>
                <div><?php echo $nomesSistemas[$config['sistema_tipo']] ?? 'Não especificado'; ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Data de Configuração:</div>
                <div><?php echo date('d/m/Y H:i', strtotime($config['data_configuracao'])); ?></div>
            </div>
            
            <?php if (!empty($config['modulos_selecionados'])): ?>
            <div class="detail-item">
                <div class="detail-label">Módulos Ativos:</div>
                <div>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <?php foreach($config['modulos_selecionados'] as $modulo): ?>
                            <li style="margin-bottom: 5px;">
                                <i class="fas fa-check-circle" style="color: #11998e;"></i>
                                <?php echo htmlspecialchars($modulo); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($config['empresa_email'])): ?>
            <div class="detail-item">
                <div class="detail-label">Contacto:</div>
                <div>
                    <?php echo htmlspecialchars($config['empresa_email']); ?>
                    <?php if (!empty($config['empresa_telefone'])): ?>
                    <br><?php echo htmlspecialchars($config['empresa_telefone']); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 40px; padding: 20px; color: #666;">
            <p>Sistema configurado em <?php echo date('d/m/Y', strtotime($config['data_configuracao'])); ?></p>
            <button onclick="window.location.href='index.php?action=edit'" class="action-btn back-btn">
                <i class="fas fa-edit"></i> Alterar Configuração
            </button>
        </div>
    </div>
    
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            if (confirm('Tem a certeza que deseja terminar sessão?')) {
                window.location.href = 'logout.php';
            }
        });
    </script>
</body>
</html>