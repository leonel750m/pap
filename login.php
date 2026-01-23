<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestão Empresarial</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        }
        
        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-left h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .login-left p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features {
            margin-top: 30px;
        }
        
        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .feature i {
            font-size: 20px;
            margin-right: 15px;
            color: #64b5f6;
        }
        
        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
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
        
        .login-form h3 {
            font-size: 24px;
            margin-bottom: 8px;
            color: #333;
        }
        
        .login-form p {
            color: #666;
            margin-bottom: 30px;
            font-size: 15px;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }
        
        .input-with-icon input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .input-with-icon input:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .remember {
            display: flex;
            align-items: center;
        }
        
        .remember input {
            margin-right: 8px;
        }
        
        .forgot-link {
            color: #2a5298;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .login-btn:hover {
            background: linear-gradient(to right, #2a5298, #3a62a8);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.2);
        }
        
        .test-login {
            background-color: #f0f7ff;
            border: 1px dashed #2a5298;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .test-login p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        
        .test-credentials {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }
        
        .test-credentials div {
            background-color: #e4edf5;
            padding: 8px 12px;
            border-radius: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 13px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        
        .register-link a {
            color: #2a5298;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 950px) {
            .login-container {
                width: 95%;
                height: auto;
                margin: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }
            
            .login-left, .login-right {
                padding: 40px 30px;
            }
        }
        
        /* Estilos para o loading */
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .login-btn.loading .loading-spinner {
            display: inline-block;
        }
        
        .login-btn.loading span {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Página de Login -->
    <div class="login-container" id="loginPage">
        <div class="login-left">
            <h2>Sistema de Gestão Empresarial</h2>
            <p>Uma solução completa para administrar a sua empresa, controlar inventário e otimizar processos operacionais.</p>
            
            <div class="features">
                <div class="feature">
                    <i class="fas fa-boxes"></i>
                    <div>
                        <h4>Gestão de Stock</h4>
                        <p>Controle o seu inventário em tempo real</p>
                    </div>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-line"></i>
                    <div>
                        <h4>Relatórios Detalhados</h4>
                        <p>Analise o desempenho da sua empresa</p>
                    </div>
                </div>
                <div class="feature">
                    <i class="fas fa-cogs"></i>
                    <div>
                        <h4>Configuração Flexível</h4>
                        <p>Personalize de acordo com as necessidades do seu negócio</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="login-right">
            <div class="logo">
                <i class="fas fa-building"></i>
                <h1>BizManager Pro</h1>
            </div>
            
            <div class="login-form">
                <h3>Iniciar Sessão</h3>
                <p>Introduza as suas credenciais para aceder ao sistema</p>
                
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" placeholder="seu.email@empresa.pt" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Palavra-passe</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" placeholder="Introduza a sua palavra-passe" required>
                        </div>
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="remember">
                            <input type="checkbox" id="remember">
                            <label for="remember">Lembrar-me</label>
                        </div>
                        <a href="#" class="forgot-link" id="forgotLink">Esqueceu a palavra-passe?</a>
                    </div>
                    
                    <button type="submit" class="login-btn" id="loginButton">
                        <div class="loading-spinner"></div>
                        <span><i class="fas fa-sign-in-alt"></i> Iniciar Sessão</span>
                    </button>
                    
                    <div class="register-link">
                        Não tem conta? <a href="#" id="registerLink">Criar nova empresa</a>
                    </div>
                </form>
                
                <div class="test-login">
                    <p><i class="fas fa-info-circle"></i> <strong>Credenciais de Teste:</strong></p>
                    <div class="test-credentials">
                        <div>Utilizador: admin@teste.pt</div>
                        <div>Palavra-passe: teste123</div>
                    </div>
                </div>
                
                <div class="footer">
                    <p>© 2023 BizManager Pro. Versão de demonstração.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const registerLink = document.getElementById('registerLink');
            const forgotLink = document.getElementById('forgotLink');
            
            // Credenciais de teste
            const testEmail = "admin@teste.pt";
            const testPassword = "teste123";
            
            // Manipular o envio do formulário de login
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                // Mostrar loading no botão
                loginButton.classList.add('loading');
                
                // Simular um pequeno delay para o processo de login
                setTimeout(() => {
                    // Verificar credenciais (versão de teste - aceita qualquer credencial ou as de teste)
                    if ((email === testEmail && password === testPassword) || 
                        (email.includes("@") && password.length >= 4)) {
                        
                        // Login bem-sucedido - redirecionar para a página de seleção de empresa
                        redirectToCompanySelection(email);
                    } else {
                        // Credenciais inválidas
                        alert("Credenciais inválidas. Utilize as credenciais de teste ou qualquer e-mail válido com palavra-passe de pelo menos 4 caracteres.");
                        loginButton.classList.remove('loading');
                    }
                }, 800);
            });
            
            // Função para redirecionar para a página de seleção de empresa
            function redirectToCompanySelection(email) {
                // Aqui você pode salvar o email do utilizador se necessário
                localStorage.setItem('userEmail', email);
                localStorage.setItem('userName', 'Administrador');
                
                // Mostrar mensagem de sucesso
                showNotification("Login bem-sucedido! A redirecionar...");
                
                // Redirecionar após 1 segundo para ver a notificação
                setTimeout(() => {
                    // REDIRECIONAR PARA O ARQUIVO selecao-empresa.html
                    window.location.href = "selecao-empresa.html";
                }, 1200);
            }
            
            // Link para criar nova empresa
            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                showNotification("Funcionalidade de criação de nova empresa em desenvolvimento.");
            });
            
            // Link para recuperar palavra-passe
            forgotLink.addEventListener('click', function(e) {
                e.preventDefault();
                const email = document.getElementById('email').value || 'seu.email@exemplo.pt';
                showNotification(`Instruções de recuperação enviadas para ${email}`);
            });
            
            // Função para mostrar notificação
            function showNotification(message) {
                // Criar elemento de notificação
                const notification = document.createElement('div');
                notification.style.cssText = `
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
                    z-index: 1000;
                    animation: fadeIn 0.3s;
                `;
                notification.innerHTML = `
                    <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
                    <span>${message}</span>
                `;
                document.body.appendChild(notification);
                
                // Remover após 3 segundos
                setTimeout(() => {
                    notification.style.animation = 'fadeOut 0.3s';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
                
                // Adicionar estilos de animação se não existirem
                if (!document.getElementById('notificationStyles')) {
                    const style = document.createElement('style');
                    style.id = 'notificationStyles';
                    style.textContent = `
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        @keyframes fadeOut {
                            from { opacity: 1; transform: translateY(0); }
                            to { opacity: 0; transform: translateY(-10px); }
                        }
                    `;
                    document.head.appendChild(style);
                }
            }
            
            // Preencher automaticamente as credenciais de teste para facilitar
            document.getElementById('email').value = testEmail;
            document.getElementById('password').value = testPassword;
            
            // Adicionar animação de entrada
            document.body.style.animation = 'fadeIn 0.5s';
            
            // Adicionar a animação de fadeIn se não existir
            if (!document.getElementById('fadeInAnimation')) {
                const style = document.createElement('style');
                style.id = 'fadeInAnimation';
                style.textContent = `
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                `;
                document.head.appendChild(style);
            }
        });
    </script>
</body>
</html>