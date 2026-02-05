<?php
/**
 * Dashboard Élève - Version Standalone
 * Utilise DashboardContent mais sans dépendances
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Élève',
    'role' => 'eleve',
    'email' => 'eleve@ecole.com',
    'id_utilisateur' => 3
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
            // Toujours autoriser en mode standalone
            return true;
        }
        
        public static function getUser() {
            global $user;
            return $user;
        }
    }
}

/**
 * Dashboard Élève - Version Standalone
 */
class EleveDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
        parent::__construct($options);
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getEleveContent();
        
        $header = new Header([
            'user' => $this->user,
            'title' => 'Espace Élève',
            'logoColor' => 'purple'
        ]);
        
        $sidebar = new Sidebar([
            'user' => $this->user,
            'menuItems' => [
                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'active' => true],
                ['icon' => 'fas fa-chart-line', 'label' => 'Mes Notes'],
                ['icon' => 'fas fa-tasks', 'label' => 'Devoirs'],
                ['icon' => 'fas fa-calendar-alt', 'label' => 'Emploi du temps'],
                ['icon' => 'fas fa-envelope', 'label' => 'Messages'],
                ['icon' => 'fas fa-clock', 'label' => 'Absences']
            ],
            'logoColor' => 'purple'
        ]);
        
        $footer = new SimpleFooter();
        
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Élève - Gestion Programme</title>
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
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Élève</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Voici votre espace personnel.</p>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards($content['stats_config']) . '
                        </div>
                        
                        <!-- Notes Récentes et Devoirs -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            <!-- Notes Récentes -->
                            ' . $this->renderRecentNotes($content['recent_notes']) . '
                            
                            <!-- Devoirs à faire -->
                            ' . $this->renderAssignments($content['assignments_data']) . '
                        </div>
                        
                        <!-- Emploi du Temps -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Emploi du temps d\'aujourd\'hui</h3>
                                <a href="#" class="text-sm text-purple-600 hover:text-purple-800">Voir semaine</a>
                            </div>
                            <div class="space-y-4">
                                ' . $this->renderSchedule($content['schedule_data']) . '
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
                <div class="bg-white rounded-xl shadow-lg p-6 border border-purple-100">
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
    
    private function renderRecentNotes($notes): string {
        $html = '
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Notes Récentes</h3>
                <a href="#" class="text-sm text-purple-600 hover:text-purple-800">Voir tout</a>
            </div>
            <div class="space-y-4">';
        
        foreach ($notes as $note) {
            $gradeColor = $note['grade'] >= 10 ? 'green' : 'red';
            
            $html .= '
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div>
                        <p class="font-medium text-gray-900">' . htmlspecialchars($note['subject']) . '</p>
                        <p class="text-sm text-gray-500">Coef: ' . $note['coefficient'] . ' | ' . htmlspecialchars($note['date']) . '</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-' . $gradeColor . '-600">' . $note['grade'] . '/20</p>
                    </div>
                </div>';
        }
        
        $html .= '
            </div>
        </div>';
        
        return $html;
    }
    
    private function renderAssignments($assignments): string {
        $html = '
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Devoirs à faire</h3>
                <a href="#" class="text-sm text-purple-600 hover:text-purple-800">Voir tout</a>
            </div>
            <div class="space-y-4">';
        
        foreach ($assignments as $assignment) {
            $urgencyColor = $assignment['urgency'] === 'urgent' ? 'red' : 'blue';
            
            $html .= '
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <p class="font-medium text-gray-900">' . htmlspecialchars($assignment['title']) . '</p>';
                            if ($assignment['urgency'] === 'urgent') {
                                $html .= '<span class="ml-2 px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Urgent</span>';
                            }
                            $html .= '
                        </div>
                        <p class="text-sm text-gray-500">' . htmlspecialchars($assignment['subject']) . ' | Limite: ' . $assignment['due_date'] . '</p>
                    </div>
                    <button class="ml-4 px-3 py-1 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">
                        Faire
                    </button>
                </div>';
        }
        
        $html .= '
            </div>
        </div>';
        
        return $html;
    }
    
    private function renderSchedule($scheduleData): string {
        $html = '';
        
        foreach ($scheduleData as $slot) {
            $html .= '
                <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-book text-purple-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">' . htmlspecialchars($slot['subject']) . '</p>
                        <p class="text-sm text-gray-500">' . $slot['time'] . ' | ' . htmlspecialchars($slot['room']) . '</p>
                    </div>
                </div>';
        }
        
        return $html;
    }
    
    private function getStatValue($key): string {
        $values = [
            'moyenne_generale' => '14.2',
            'total_notes' => '18',
            'devoirs_a_faire' => '5',
            'absences' => '2',
            'retards' => '7',
            'messages_non_lus' => '3'
        ];
        
        return $values[$key] ?? '0';
    }
}

// Rendu du dashboard
$dashboard = new EleveDashboardStandalone();
echo $dashboard->render();
?>
