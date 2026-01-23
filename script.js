document.addEventListener('DOMContentLoaded', function() {
    // Elementos DOM
    const logoutBtn = document.getElementById('logoutBtn');
    const systemOptions = document.querySelectorAll('.system-option');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const step1Content = document.getElementById('step1-content');
    const step2Content = document.getElementById('step2-content');
    const backBtn = document.getElementById('backBtn');
    const nextBtn = document.getElementById('nextBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const configForm = document.getElementById('configForm');
    const configTitle = document.getElementById('configTitle');
    const configDescription = document.getElementById('configDescription');
    const sistemaTipoInput = document.getElementById('sistema_tipo');
    const notification = document.getElementById('notification');
    const notificationText = document.getElementById('notificationText');
    const modulesContainer = document.getElementById('modulesContainer');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalClose = document.getElementById('modalClose');
    const modalVoltar = document.getElementById('modalVoltar');
    const modalConfirmar = document.getElementById('modalConfirmar');
    const resumoConfiguracao = document.getElementById('resumoConfiguracao');
    
    // Variáveis de estado
    let currentStep = 1;
    let selectedSystem = null;
    
    // Módulos disponíveis por tipo de sistema
    const systemModules = {
        metal: [
            { id: 'metal_quality', name: 'Controlo de Qualidade', default: true },
            { id: 'metal_trace', name: 'Rastreabilidade Total', default: true },
            { id: 'metal_cert', name: 'Certificados de Material', default: false },
            { id: 'metal_scrap', name: 'Gestão de Sucata', default: false },
            { id: 'metal_heat', name: 'Tratamentos Térmicos', default: false }
        ],
        construction: [
            { id: 'cons_projects', name: 'Gestão de Projetos', default: true },
            { id: 'cons_equipment', name: 'Gestão de Equipamentos', default: true },
            { id: 'cons_safety', name: 'Segurança no Trabalho', default: false },
            { id: 'cons_subcontract', name: 'Subcontratação', default: false },
            { id: 'cons_budget', name: 'Controlo Orçamental', default: false }
        ],
        retail: [
            { id: 'retail_multichannel', name: 'Vendas Multicanal', default: true },
            { id: 'retail_pricing', name: 'Gestão de Preços', default: true },
            { id: 'retail_promotions', name: 'Campanhas Promocionais', default: false },
            { id: 'retail_loyalty', name: 'Programa de Fidelização', default: false },
            { id: 'retail_ecommerce', name: 'Integração E-commerce', default: false }
        ],
        logistics: [
            { id: 'logi_tracking', name: 'Rastreio em Tempo Real', default: true },
            { id: 'logi_optimization', name: 'Otimização de Rotas', default: true },
            { id: 'logi_temperature', name: 'Controlo de Temperatura', default: false },
            { id: 'logi_fleet', name: 'Gestão de Frota', default: false },
            { id: 'logi_customs', name: 'Desalfandegamento', default: false }
        ]
    };
    
    // Nomes dos sistemas
    const systemNames = {
        metal: 'Sistema para Metal',
        construction: 'Sistema para Construção',
        retail: 'Sistema para Retalho',
        logistics: 'Sistema para Logística'
    };
    
    // Descrições dos sistemas
    const systemDescriptions = {
        metal: 'Configure o sistema de gestão para indústria metalúrgica',
        construction: 'Configure o sistema de gestão para construção civil',
        retail: 'Configure o sistema de gestão para retalho e distribuição',
        logistics: 'Configure o sistema de gestão para logística e armazenagem'
    };
    
    // Inicializar
    init();
    
    function init() {
        // Logout
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                if (confirm('Tem a certeza que deseja terminar sessão?')) {
                    window.location.href = 'logout.php';
                }
            });
        }
        
        // Selecionar sistema
        systemOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remover seleção anterior
                systemOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Selecionar este sistema
                this.classList.add('selected');
                selectedSystem = this.getAttribute('data-system');
                sistemaTipoInput.value = selectedSystem;
                
                // Ativar botão "Continuar"
                nextBtn.disabled = false;
                
                // Pré-preencher alguns campos com base no sistema
                const sectorInput = document.getElementById('companySector');
                if (selectedSystem === 'metal') sectorInput.value = 'Indústria Metalúrgica';
                else if (selectedSystem === 'construction') sectorInput.value = 'Construção Civil';
                else if (selectedSystem === 'retail') sectorInput.value = 'Comércio Retalhista';
                else if (selectedSystem === 'logistics') sectorInput.value = 'Logística e Distribuição';
            });
        });
        
        // Botão "Continuar"
        nextBtn.addEventListener('click', function() {
            if (currentStep === 1) {
                // Validar que um sistema foi selecionado
                if (!selectedSystem) {
                    showNotification('Por favor, selecione um tipo de sistema');
                    return;
                }
                
                // Avançar para o passo 2
                goToStep(2);
                
                // Atualizar título e descrição da configuração
                configTitle.textContent = `Configurar ${systemNames[selectedSystem]}`;
                configDescription.textContent = systemDescriptions[selectedSystem];
                
                // Carregar módulos específicos do sistema
                loadSystemModules(selectedSystem);
                
            } else if (currentStep === 2) {
                // Validar configuração
                if (!validateConfiguration()) {
                    showNotification('Por favor, preencha todos os campos obrigatórios');
                    return;
                }
                
                // Mostrar resumo e modal de confirmação
                showResumoConfiguracao();
            }
        });
        
        // Botão "Voltar"
        backBtn.addEventListener('click', function() {
            if (currentStep === 2) {
                goToStep(1);
            }
        });
        
        // Modal actions
        if (modalClose) {
            modalClose.addEventListener('click', function() {
                modalOverlay.style.display = 'none';
            });
        }
        
        if (modalVoltar) {
            modalVoltar.addEventListener('click', function() {
                modalOverlay.style.display = 'none';
                goToStep(2);
            });
        }
        
        if (modalConfirmar) {
            modalConfirmar.addEventListener('click', function() {
                // Enviar formulário
                configForm.submit();
            });
        }
        
        // Fechar modal ao clicar fora
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });
        
        // Pré-selecionar o primeiro sistema para facilitar
        setTimeout(() => {
            if (systemOptions.length > 0 && !selectedSystem) {
                systemOptions[0].click();
            }
        }, 500);
    }
    
    // Função para navegar entre passos
    function goToStep(step) {
        // Atualizar passo atual
        currentStep = step;
        
        // Atualizar indicadores de passo
        [step1, step2, step3].forEach((s, index) => {
            const stepNum = index + 1;
            if (stepNum < step) {
                s.classList.remove('active');
                s.classList.add('completed');
            } else if (stepNum === step) {
                s.classList.add('active');
                s.classList.remove('completed');
            } else {
                s.classList.remove('active', 'completed');
            }
        });
        
        // Mostrar/ocultar conteúdos
        step1Content.style.display = (step === 1) ? 'block' : 'none';
        step2Content.style.display = (step === 2) ? 'block' : 'none';
        if (step === 2) step2Content.classList.add('active');
        
        // Mostrar/ocultar botões
        backBtn.style.display = (step > 1) ? 'flex' : 'none';
        nextBtn.style.display = (step < 3) ? 'flex' : 'none';
        confirmBtn.style.display = (step === 3) ? 'flex' : 'none';
        
        // Atualizar estado do botão "Continuar"
        if (step === 1) {
            nextBtn.disabled = !selectedSystem;
        }
    }
    
    // Carregar módulos do sistema
    function loadSystemModules(systemType) {
        modulesContainer.innerHTML = '';
        
        if (systemModules[systemType]) {
            systemModules[systemType].forEach(module => {
                const checkboxId = `module_${module.id}`;
                const checkbox = document.createElement('div');
                checkbox.className = 'checkbox-item';
                checkbox.innerHTML = `
                    <input type="checkbox" id="${checkboxId}" name="modulos[]" value="${module.name}" ${module.default ? 'checked' : ''}>
                    <label for="${checkboxId}">${module.name}</label>
                `;
                modulesContainer.appendChild(checkbox);
            });
        }
    }
    
    // Validar configuração
    function validateConfiguration() {
        const requiredFields = [
            'companyName',
            'companySector',
            'companySize',
            'warehouseCount',
            'reportFrequency'
        ];
        
        for (const fieldId of requiredFields) {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.focus();
                return false;
            }
        }
        
        return true;
    }
    
    // Mostrar resumo da configuração
    function showResumoConfiguracao() {
        // Coletar dados do formulário
        const dados = {
            tipo: systemNames[selectedSystem] || 'Não especificado',
            empresa: document.getElementById('companyName').value,
            setor: document.getElementById('companySector').value,
            dimensao: document.getElementById('companySize').selectedOptions[0].text,
            armazens: document.getElementById('warehouseCount').value,
            relatorios: document.getElementById('reportFrequency').selectedOptions[0].text,
            email: document.getElementById('empresa_email').value,
            telefone: document.getElementById('empresa_telefone').value
        };
        
        // Coletar módulos selecionados
        const modulosSelecionados = [];
        const moduleCheckboxes = modulesContainer.querySelectorAll('input[type="checkbox"]:checked');
        moduleCheckboxes.forEach(checkbox => {
            modulosSelecionados.push(checkbox.value);
        });
        
        // Gerar HTML do resumo
        let html = `
            <div style="display: grid; gap: 15px;">
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Tipo de Sistema:</div>
                    <div><strong>${dados.tipo}</strong></div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Empresa:</div>
                    <div>${dados.empresa}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Setor:</div>
                    <div>${dados.setor}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Dimensão:</div>
                    <div>${dados.dimensao}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Armazéns:</div>
                    <div>${dados.armazens}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Relatórios:</div>
                    <div>${dados.relatorios}</div>
                </div>
        `;
        
        if (modulosSelecionados.length > 0) {
            html += `
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Módulos:</div>
                    <div>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            ${modulosSelecionados.map(mod => `<li style="margin-bottom: 5px;"><i class="fas fa-check-circle" style="color: #11998e;"></i> ${mod}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            `;
        }
        
        if (dados.email) {
            html += `
                <div class="detail-item">
                    <div class="detail-label" style="min-width: 180px;">Contacto:</div>
                    <div>
                        ${dados.email}
                        ${dados.telefone ? `<br>${dados.telefone}` : ''}
                    </div>
                </div>
            `;
        }
        
        html += `</div>`;
        
        resumoConfiguracao.innerHTML = html;
        modalOverlay.style.display = 'flex';
    }
    
    // Mostrar notificação
    function showNotification(message) {
        notificationText.textContent = message;
        notification.style.display = 'flex';
        notification.style.animation = 'fadeIn 0.3s';
        
        setTimeout(() => {
            notification.style.animation = '';
            notification.style.display = 'none';
        }, 3000);
    }
});