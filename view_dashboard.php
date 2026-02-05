<?php
/**
 * Visualiseur de dashboards - Mode démo
 * Permet de voir les dashboards sans authentification
 */

// Récupérer le dashboard demandé
$dashboard = $_GET['dashboard'] ?? 'admin';

// Mapper les dashboards
$dashboardFiles = [
    'admin' => 'src/main/app/views/admin/dashboard.php',
    'enseignant' => 'src/main/app/views/enseignant/dashboard.php',
    'eleve' => 'src/main/app/views/eleve/dashboard.php',
    'directeur_discipline' => 'src/main/app/views/directeur_discipline/dashboard.php',
    'chef_classe' => 'src/main/app/views/chef_classe/dashboard.php',
    'prefet' => 'src/main/app/views/prefet/dashboard.php',
    'comite_parents' => 'src/main/app/views/comite_parents/dashboard.php',
    'tuteur' => 'src/main/app/views/tuteur/dashboard.php'
];

// Vérifier si le dashboard existe
if (!isset($dashboardFiles[$dashboard])) {
    echo "<h1>Dashboard non trouvé</h1>";
    echo "<p>Le dashboard demandé n'existe pas.</p>";
    echo "<a href='login.php'>Retour à la connexion</a>";
    exit();
}

$dashboardFile = $dashboardFiles[$dashboard];

if (!file_exists($dashboardFile)) {
    echo "<h1>Fichier de dashboard non trouvé</h1>";
    echo "<p>Le fichier $dashboardFile n'existe pas.</p>";
    echo "<a href='login.php'>Retour à la connexion</a>";
    exit();
}

// Créer un utilisateur de démo
$demoUser = [
    'nom' => ucfirst($dashboard),
    'role' => $dashboard,
    'email' => $dashboard . '@ecole.com'
];

// Simuler les classes nécessaires pour éviter les erreurs
if (!class_exists('AuthMiddleware')) {
    class AuthMiddleware {
        public static function requireRole($roles) {
            // Toujours autoriser en mode démo
            return true;
        }
        
        public static function getUser() {
            global $demoUser;
            return $demoUser;
        }
    }
}

if (!class_exists('Component')) {
    class Component {
        protected $options;
        
        public function __construct($options = []) {
            $this->options = $options;
        }
    }
}

if (!class_exists('Theme')) {
    class Theme {
        public static function getButtonClasses($variant = 'primary') {
            $classes = [
                'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
                'secondary' => 'bg-gray-600 text-white hover:bg-gray-700',
                'success' => 'bg-green-600 text-white hover:bg-green-700',
                'danger' => 'bg-red-600 text-white hover:bg-red-700',
                'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50'
            ];
            return $classes[$variant] ?? $classes['primary'];
        }
    }
}

// Créer une page wrapper
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard <?php echo ucfirst($dashboard); ?> - Mode Démo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .demo-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .dashboard-container {
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Bannière de démo -->
    <div class="demo-banner">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-2">🎭 Mode Démo</h1>
            <p class="text-sm opacity-90">
                Visualisation du dashboard <?php echo ucfirst($dashboard); ?> sans authentification
            </p>
            <div class="mt-4 space-x-4">
                <a href="login.php" class="inline-block bg-white text-purple-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100">
                    <i class="fas fa-sign-in-alt mr-2"></i>Connexion réelle
                </a>
                <a href="view_dashboard.php?dashboard=<?php echo $dashboard; ?>" class="inline-block bg-purple-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-purple-600">
                    <i class="fas fa-sync mr-2"></i>Actualiser
                </a>
            </div>
        </div>
    </div>
    
    <!-- Contenu du dashboard -->
    <div class="dashboard-container">
        <?php
        // Inclure les composants nécessaires
        require_once __DIR__ . '/src/main/app/views/components/Component.php';
        require_once __DIR__ . '/src/main/app/views/components/Header.php';
        require_once __DIR__ . '/src/main/app/views/components/Sidebar.php';
        require_once __DIR__ . '/src/main/app/views/components/Card.php';
        require_once __DIR__ . '/src/main/app/views/components/Footer.php';
        require_once __DIR__ . '/src/main/app/views/auth/logout.php';
        
        // Charger le dashboard
        include $dashboardFile;
        ?>
    </div>
    
    <!-- Menu de navigation flottant -->
    <div class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 z-50">
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Autres dashboards</h3>
        <div class="space-y-2">
            <?php foreach ($dashboardFiles as $key => $file): ?>
            <?php if ($key !== $dashboard): ?>
            <a href="view_dashboard.php?dashboard=<?php echo $key; ?>" class="block text-sm text-gray-600 hover:text-gray-800">
                <i class="fas fa-tachometer-alt mr-2"></i><?php echo ucfirst($key); ?>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
            <hr class="my-2 border-gray-200">
            <a href="login.php" class="block text-sm text-purple-600 hover:text-purple-800">
                <i class="fas fa-sign-in-alt mr-2"></i>Connexion réelle
            </a>
        </div>
    </div>
</body>
</html>
