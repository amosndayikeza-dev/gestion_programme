<?php
/**
 * Dashboard Administrateur - Version Standalone Corrigée
 * Utilise DashboardContent mais sans dépendances
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Administrateur',
    'role' => 'administrateur',
    'email' => 'admin@ecole.com',
    'id_utilisateur' => 1
];

// Inclure les composants nécessaires
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../components/DashboardContent.php';

// Simuler AuthMiddleware
if (!class_exists('AuthMiddleware')) {
    class AuthMiddleware {
        public static function requireRole($roles) {
            return true;
        }
        
        public static function getUser() {
            global $user;
            return $user;
        }
    }
}

/**
 * Dashboard Administrateur - Version Standalone Corrigée
 */
class AdminDashboardStandaloneFixed extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
        parent::__construct($options);
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getAdminContent();
        
        $header = new Header([
            'user' => $this->user,
            'title' => 'Espace Administrateur',
            'logoColor' => 'blue'
        ]);
        
        $sidebar = new Sidebar([
            'user' => $this->user,
            'menuItems' => [
                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'active' => true],
                ['icon' => 'fas fa-graduation-cap', 'label' => 'Élèves'],
                ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Enseignants'],
                ['icon' => 'fas fa-school', 'label' => 'Classes'],
                ['icon' => 'fas fa-dollar-sign', 'label' => 'Finances'],
                ['icon' => 'fas fa-cog', 'label' => 'Paramètres']
            ],
            'logoColor' => 'blue'
        ]);
        
        $footer = new SimpleFooter();
        
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Administrateur - Gestion Programme</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                .sidebar-transition {
                    transition: margin-left 0.3s ease;
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-slide-in {
                    animation: slideIn 0.5s ease forwards;
                }
            </style>
        </head>
        <body class="bg-gray-50">
            ' . $header->render() . '
            
            <div class="flex">
                ' . $sidebar->render() . '
                
                <main class="flex-1 sidebar-transition" id="mainContent">
                    <div class="p-6">
                        <!-- Page Header -->
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Administrateur</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Voici un aperçu de votre système.</p>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards($content['stats_config']) . '
                        </div>
                        
                        <!-- Activités Récentes et Alertes -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- Activités Récentes -->
                            ' . $this->renderRecentActivities($content['recent_activities']) . '
                            
                            <!-- Alertes -->
                            ' . $this->renderAlerts($content['alerts']) . '
                        </div>
                        
                        <!-- Actions Rapides -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Actions Rapides</h3>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                ' . $this->renderQuickActions($content['quick_actions']) . '
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
            ' . $footer->render() . '
            
            <script>
                function toggleSidebar() {
                    const sidebar = document.querySelector(\'aside\');
                    const mainContent = document.getElementById(\'mainContent\');
                    
                    sidebar.classList.toggle(\'w-16\');
                    sidebar.classList.toggle(\'w-64\');
                    
                    if (sidebar.classList.contains(\'w-16\')) {
                        mainContent.style.marginLeft = \'4rem\';
                    } else {
                        mainContent.style.marginLeft = \'16rem\';
                    }
                }
                
                function toggleUserMenu() {
                    const menu = document.getElementById(\'userMenu\');
                    menu.classList.toggle(\'hidden\');
                }
                
                document.addEventListener(\'DOMContentLoaded\', function() {
                    const cards = document.querySelectorAll(\'.animate-slide-in\');
                    cards.forEach((card, index) => {
                        card.style.animationDelay = `${index * 0.1}s`;
                    });
                });
            </script>
        </body>
        </html>';
    }
    
    private function renderStatsCards($statsConfig): string {
        $html = '';
        foreach ($statsConfig as $key => $stat) {
            $html .= '
            <div class="animate-slide-in">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-' . $stat['color'] . '-500 rounded-lg p-3">
                            <i class="' . $stat['icon'] . ' text-white text-xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">' . $stat['label'] . '</dt>
                                <dd class="text-3xl font-bold text-gray-900">' . $this->getStatValue($key) . '</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>';
        }
        return $html;
    }
    
    private function renderRecentActivities($activities): string {
        $html = '
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Activités Récentes</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
            </div>
            <div class="space-y-4">';
        
        foreach ($activities as $activity) {
            $html .= '
                <div class="flex items-center p-4 hover:bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">' . htmlspecialchars($activity['title']) . '</p>
                        <p class="text-sm text-gray-500">' . htmlspecialchars($activity['description']) . '</p>
                    </div>
                </div>';
        }
        
        $html .= '
            </div>
        </div>';
        
        return $html;
    }
    
    private function renderAlerts($alerts): string {
        $html = '
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Alertes</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir tout</a>
            </div>
            <div class="space-y-4">';
        
        foreach ($alerts as $alert) {
            $severityColor = $alert['severity'] === 'high' ? 'red' : 
                           ($alert['severity'] === 'medium' ? 'yellow' : 'blue';
            
            $html .= '
                <div class="flex items-center p-4 bg-' . $severityColor . '-50 rounded-lg border border-' . $severityColor . '-200">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-' . $severityColor . '-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-' . $severityColor . '-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">' . htmlspecialchars($alert['title']) . '</p>
                        <p class="text-sm text-gray-500">' . htmlspecialchars($alert['description']) . '</p>
                    </div>
                </div>';
        }
        
        $html .= '
            </div>
        </div>';
        
        return $html;
    }
    
    private function renderQuickActions($actions): string {
        $html = '
        <div class="grid grid-cols-2 gap-4">';
        
        foreach ($actions as $action) {
            $html .= '
                <a href="' . $action['link'] . '" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div class="w-10 h-10 bg-' . $action['color'] . '-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="' . $action['icon'] . ' text-' . $action['color'] . '-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-900">' . htmlspecialchars($action['title']) . '</span>
                </a>';
        }
        
        $html .= '
            </div>';
        
        return $html;
    }
    
    private function getStatValue($key): string {
        $values = [
            'total_eleves' => '245',
            'total_enseignants' => '32',
            'total_classes' => '12',
            'total_cours' => '68',
            'paiements_en_attente' => '8',
            'discipline_cases' => '3'
        ];
        
        return $values[$key] ?? '0';
    }
}

// Rendu du dashboard
$dashboard = new AdminDashboardStandaloneFixed();
echo $dashboard->render();
?>
