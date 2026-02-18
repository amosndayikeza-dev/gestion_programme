<?php
/**
 * Page de connexion simple
 * Ne dépend d'aucune classe externe
 */

session_start();

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    
    // Rediriger selon le rôle
    $dashboardRoutes = [
        'administrateur' => 'dashboard_admin.php',
        'enseignant' => 'dashboard_enseignant.php',
        'eleve' => 'dashboard_eleve.php',
        'directeur_discipline' => 'dashboard_directeur_discipline.php',
        'chef_classe' => 'dashboard_chef_classe.php',
        'prefet' => 'dashboard_prefet.php',
        'comite_parents' => 'dashboard_comite_parents.php',
        'tuteur' => 'dashboard_tuteur.php'
    ];
    
    $redirectUrl = $dashboardRoutes[$user['role']] ?? 'dashboard_admin.php';
    header("Location: $redirectUrl");
    exit();
}

// Gérer la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Utilisateurs de test
    $users = [
        'admin@ecole.com' => ['password' => 'admin123', 'role' => 'administrateur', 'nom' => 'Administrateur'],
        'enseignant@ecole.com' => ['password' => 'enseignant123', 'role' => 'enseignant', 'nom' => 'Enseignant'],
        'eleve@ecole.com' => ['password' => 'eleve123', 'role' => 'eleve', 'nom' => 'Élève'],
        'directeur@ecole.com' => ['password' => 'directeur123', 'role' => 'directeur_discipline', 'nom' => 'Directeur Discipline'],
        'chef@ecole.com' => ['password' => 'chef123', 'role' => 'chef_classe', 'nom' => 'Chef de Classe'],
        'prefet@ecole.com' => ['password' => 'prefet123', 'role' => 'prefet', 'nom' => 'Préfet'],
        'comite@ecole.com' => ['password' => 'comite123', 'role' => 'comite_parents', 'nom' => 'Comité Parents'],
        'tuteur@ecole.com' => ['password' => 'tuteur123', 'role' => 'tuteur', 'nom' => 'Tuteur']
    ];
    
    if (isset($users[$email]) && $users[$email]['password'] === $password) {
        $_SESSION['user'] = [
            'email' => $email,
            'role' => $users[$email]['role'],
            'nom' => $users[$email]['nom'],
            'id_utilisateur' => array_search($email, array_keys($users)) + 1
        ];
        
        // Rediriger vers le dashboard approprié
        $dashboardRoutes = [
            'administrateur' => 'dashboard_admin.php',
            'enseignant' => 'dashboard_enseignant.php',
            'eleve' => 'dashboard_eleve.php',
            'directeur_discipline' => 'dashboard_directeur_discipline.php',
            'chef_classe' => 'dashboard_chef_classe.php',
            'prefet' => 'dashboard_prefet.php',
            'comite_parents' => 'dashboard_comite_parents.php',
            'tuteur' => 'dashboard_tuteur.php'
        ];
        
        $redirectUrl = $dashboardRoutes[$users[$email]['role']] ?? 'dashboard_admin.php';
        header("Location: $redirectUrl");
        exit();
    } else {
        $error = 'Email ou mot de passe incorrect';
    }
}

$error = $error ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion Programme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }
        .shape-1 {
            width: 80px;
            height: 80px;
            background: #3b82f6;
            top: 20%;
            left: 10%;
            animation: float 10s ease-in-out infinite;
        }
        .shape-2 {
            width: 120px;
            height: 120px;
            background: #2563eb;
            top: 60%;
            right: 10%;
            animation: float 15s ease-in-out infinite;
        }
        .shape-3 {
            width: 60px;
            height: 60px;
            background: #1e40af;
            bottom: 20%;
            left: 20%;
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        .input-group {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Formes flottantes -->
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <!-- Container principal -->
    <div class="relative z-10 w-full max-w-md px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-lg mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Gestion Scolaire</h1>
            <p class="text-gray-300">Lycée CIREZI - Bukavu</p>
        </div>
        
        <!-- Formulaire de connexion -->
        <div class="glass-effect rounded-2xl shadow-2xl p-8">
            <!-- Messages -->
            <?php if ($error): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span><?php echo htmlspecialchars($success); ?></span>
                </div>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" class="space-y-6">
                <!-- Email -->
                <div class="input-group">
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Adresse email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder=" "
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                    </div>
                </div>
                
                <!-- Mot de passe -->
                <div class="input-group">
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder=" "
                               class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                               required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </span>
                    </div>
                </div>
                
                <!-- Options -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-300">Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-sm text-blue-300 hover:text-blue-500">Mot de passe oublié?</a>
                </div>
                
                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Se connecter
                    </button>
                </div>
            </form>
            
            <!-- Comptes de démo -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Comptes de démo</span>
                    </div>
                </div>
                
                <div class="mt-4 space-y-2">
                    <button onclick="quickLogin('admin@ecole.com', 'admin123')" class="w-full flex justify-center py-2 px-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Admin: admin@ecole.com
                    </button>
                    <button onclick="quickLogin('enseignant@ecole.com', 'enseignant123')" class="w-full flex justify-center py-2 px-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Enseignant: enseignant@ecole.com
                    </button>
                    <button onclick="quickLogin('eleve@ecole.com', 'eleve123')" class="w-full flex justify-center py-2 px-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Élève: eleve@ecole.com
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>
