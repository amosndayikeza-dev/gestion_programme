<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/routing.php';
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Footer.php';

/**
 * Page de connexion
 * Thème: Bleu et Blanc
 */
class LoginPage extends Component {
    private $error;
    private $success;
    private $redirectUrl;
    
    public function __construct(array $options = []) {
        // Vérifier si l'utilisateur est déjà connecté
        if (SessionManager::isLoggedIn()) {
            Router::redirect('/admin/dashboard');
        }
        
        $this->error = SessionManager::flash('error');
        $this->success = SessionManager::flash('success');
        $this->redirectUrl = $_GET['redirect'] ?? '/admin/dashboard';
        
        parent::__construct($options);
    }
    
    public function render(): string {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion - Gestion Scolaire</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                .gradient-bg {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }
                .glass-effect {
                    background: rgba(255, 255, 255, 0.95);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }
                .floating-shapes {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                    z-index: 0;
                }
                .shape {
                    position: absolute;
                    opacity: 0.1;
                }
                .shape-1 {
                    width: 300px;
                    height: 300px;
                    background: #3b82f6;
                    border-radius: 50%;
                    top: -150px;
                    right: -150px;
                    animation: float 6s ease-in-out infinite;
                }
                .shape-2 {
                    width: 200px;
                    height: 200px;
                    background: #2563eb;
                    border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                    bottom: -100px;
                    left: -100px;
                    animation: float 8s ease-in-out infinite reverse;
                }
                .shape-3 {
                    width: 150px;
                    height: 150px;
                    background: #1e40af;
                    border-radius: 50%;
                    top: 50%;
                    left: 10%;
                    animation: float 10s ease-in-out infinite;
                }
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotate(0deg); }
                    50% { transform: translateY(-20px) rotate(180deg); }
                }
            </style>
        </head>
        <body class="min-h-screen gradient-bg flex items-center justify-center">
            <!-- Formes flottantes -->
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            
            <!-- Container principal -->
            <div class="relative z-10 w-full max-w-md px-4">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-white mb-2">Gestion Scolaire</h1>
                </div>
                
                <!-- Formulaire de connexion -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8">
                    <!-- Messages -->
                    <?php echo $this->renderMessages(); ?>
                    
                    <form method="POST" action="/login" class="space-y-6">
                        <input type="hidden" name="action" value="login">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($this->redirectUrl); ?>">
                        
                        <!-- Email -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Adresse email"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                        
                        <!-- Mot de passe -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Mot de passe"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    onclick="togglePassword()">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="passwordIcon"></i>
                            </button>
                        </div>
                        
                        <!-- Options -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                            </label>
                            <a href="/auth/forgot-password" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                Mot de passe oublié?
                            </a>
                        </div>
                        
                        <!-- Bouton de connexion -->
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Se connecter
                        </button>
                    </form>
                    
                    <!-- Lien vers l'inscription -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Vous n'avez pas de compte? 
                            <a href="/auth/register" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                    
                    <!-- Informations supplémentaires -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="text-center text-xs text-gray-500">
                            <p class="mb-2">Accès rapide:</p>
                            <div class="flex justify-center space-x-4">
                                <button onclick="quickLogin('admin@ecole.com', 'admin123')" 
                                        class="text-blue-600 hover:text-blue-800 transition-colors">
                                    Admin
                                </button>
                                <button onclick="quickLogin('enseignant@ecole.com', 'enseignant123')" 
                                        class="text-blue-600 hover:text-blue-800 transition-colors">
                                    Enseignant
                                </button>
                                <button onclick="quickLogin('eleve@ecole.com', 'eleve123')" 
                                        class="text-blue-600 hover:text-blue-800 transition-colors">
                                    Élève
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-blue-100 text-sm">
                        &copy; <?php echo date('Y'); ?> Gestion Programme. Tous droits réservés.
                    </p>
                </div>
            </div>
            
            <!-- Scripts -->
            <script>
                function togglePassword() {
                    const passwordInput = document.getElementById('password');
                    const passwordIcon = document.getElementById('passwordIcon');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        passwordIcon.classList.remove('fa-eye');
                        passwordIcon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        passwordIcon.classList.remove('fa-eye-slash');
                        passwordIcon.classList.add('fa-eye');
                    }
                }
                
                function quickLogin(email, password) {
                    document.getElementById('email').value = email;
                    document.getElementById('password').value = password;
                    document.querySelector('form').submit();
                }
                
                // Animation des inputs
                document.querySelectorAll('input').forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });
                    
                    input.addEventListener('blur', function() {
                        if (!this.value) {
                            this.parentElement.classList.remove('focused');
                        }
                    });
                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
    
    private function renderMessages(): string {
        $messages = '';
        
        if ($this->error) {
            $messages .= '
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-medium">Erreur de connexion</p>
                    <p class="text-red-600 text-sm">' . htmlspecialchars($this->error) . '</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>';
        }
        
        if ($this->success) {
            $messages .= '
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">Succès</p>
                    <p class="text-green-600 text-sm">' . htmlspecialchars($this->success) . '</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>';
        }
        
        return $messages;
    }
}

// Rendu de la page
$page = new LoginPage([
    'error' => $_GET['error'] ?? null,
    'success' => $_GET['success'] ?? null,
    'redirect' => $_GET['redirect'] ?? '/dashboard'
]);

echo $page->render();
?>
