<?php
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../components/DashboardContent.php';
require_once __DIR__ . '/../auth/logout.php';

/**
 * Dashboard Administrateur - Version Simplifiée avec Contenu Séparé
 * Thème: Bleu et Blanc
 */
class AdminDashboardSimple extends Component {
    private $user;
    private $content;
    
    public function __construct(array $options = []) {
        // Vérification de l'authentification
        AuthMiddleware::requireRole(['administrateur']);
        
        $this->user = AuthMiddleware::getUser();
        $this->content = DashboardContentFactory::getAdminContent();
        $this->loadDashboardData();
        
        parent::__construct($options);
    }
    
    private function loadDashboardData(): void {
        // Simulation de données - à remplacer avec vraie BDD
        $this->stats = [
            'total_eleves' => rand(100, 500),
            'total_enseignants' => rand(20, 50),
            'total_classes' => rand(10, 30),
            'total_cours' => rand(50, 150),
            'paiements_en_attente' => rand(5, 20),
            'discipline_cases' => rand(0, 10)
        ];
    }
    
    public function render(): string {
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
            <!-- Header -->
            ' . $this->renderHeader() . '
            
            <div class="flex">
                <!-- Sidebar -->
                ' . $this->renderSidebar() . '
                
                <!-- Main Content -->
                <main class="flex-1 sidebar-transition" id="mainContent">
                    <div class="p-6">
                        <!-- Page Header -->
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Administrateur</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Voici un aperçu de votre système.</p>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . DashboardContent::renderStatsCards($this->stats, $this->content['stats_config']) . '
                        </div>
                        
                        <!-- Activités récentes -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                            ' . DashboardContent::renderListCard('Activités récentes', $this->content['recent_activities'], [
                                'headerActions' => [
                                    ['label' => 'Voir tout', 'url' => '/admin/activites', 'icon' => 'fas fa-arrow-right']
                                ]
                            ]) . '
                            
                            ' . $this->renderQuickActionsCard() . '
                        </div>
                        
                        <!-- Tableau des classes -->
                        ' . $this->renderClassesTable() . '
                    </div>
                </main>
            </div>
            
            <!-- Footer -->
            ' . $this->renderFooter() . '
            
            <!-- Scripts -->
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
                
                function toggleMobileMenu() {
                    const menu = document.getElementById(\'mobileMenu\');
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
    
    private function renderHeader(): string {
        $header = new Header('Gestion Programme', [
            'user' => $this->user,
            'navigation' => [
                ['label' => 'Dashboard', 'url' => '/admin/dashboard', 'icon' => 'fas fa-tachometer-alt'],
                ['label' => 'Élèves', 'url' => '/admin/eleves', 'icon' => 'fas fa-graduation-cap'],
                ['label' => 'Enseignants', 'url' => '/admin/enseignants', 'icon' => 'fas fa-chalkboard-teacher'],
                ['label' => 'Classes', 'url' => '/admin/classes', 'icon' => 'fas fa-school']
            ]
        ]);
        
        return $header->render();
    }
    
    private function renderSidebar(): string {
        $sidebar = new Sidebar([
            'user' => $this->user,
            'collapsed' => false
        ]);
        
        $sidebar->addMenuItem('Dashboard', '/admin/dashboard', 'fas fa-tachometer-alt')
                ->addMenuItem('Gestion des Élèves', '/admin/eleves', 'fas fa-graduation-cap')
                ->addMenuItem('Gestion Enseignants', '/admin/enseignants', 'fas fa-chalkboard-teacher')
                ->addMenuItem('Classes & Cours', '/admin/classes', 'fas fa-school')
                ->addMenuItem('Finances', '/admin/finances', 'fas fa-dollar-sign')
                ->addMenuItem('Paramètres', '/admin/parametres', 'fas fa-cog');
        
        return $sidebar->render();
    }
    
    private function renderFooter(): string {
        $footer = new Footer([
            'links' => [
                ['label' => 'Aide', 'url' => '/help'],
                ['label' => 'Documentation', 'url' => '/docs'],
                ['label' => 'Support', 'url' => '/support']
            ]
        ]);
        
        return $footer->render();
    }
    
    private function renderQuickActionsCard(): string {
        $actions = [
            ['label' => 'Nouvel élève', 'url' => '/admin/eleves/creer', 'icon' => 'fas fa-user-plus', 'bg_color' => 'bg-blue-50', 'hover_color' => 'hover:bg-blue-100', 'text_color' => 'text-blue-600'],
            ['label' => 'Nouvelle classe', 'url' => '/admin/classes/creer', 'icon' => 'fas fa-plus', 'bg_color' => 'bg-green-50', 'hover_color' => 'hover:bg-green-100', 'text_color' => 'text-green-600'],
            ['label' => 'Rapport', 'url' => '/admin/rapports', 'icon' => 'fas fa-chart-bar', 'bg_color' => 'bg-purple-50', 'hover_color' => 'hover:bg-purple-100', 'text_color' => 'text-purple-600'],
            ['label' => 'Paramètres', 'url' => '/admin/parametres', 'icon' => 'fas fa-cog', 'bg_color' => 'bg-yellow-50', 'hover_color' => 'hover:bg-yellow-100', 'text_color' => 'text-yellow-600']
        ];
        
        return DashboardContent::renderQuickActions($actions);
    }
    
    private function renderClassesTable(): string {
        $headers = ['Nom', 'Niveau', 'Effectif', 'Professeur Principal'];
        $rows = [
            ['6ème Scientifique', '6ème', '28', 'M. Dupont'],
            ['5ème Scientifique', '5ème', '25', 'Mme. Martin'],
            ['4ème Littéraire', '4ème', '30', 'M. Bernard'],
            ['3ème Commerciale', '3ème', '27', 'Mme. Petit']
        ];
        
        return DashboardContent::renderTable($headers, $rows, [
            'title' => 'Liste des classes',
            'headerActions' => [
                ['label' => 'Voir tout', 'url' => '/admin/classes', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
    }
}

// Vérification de l'authentification
AuthMiddleware::requireRole(['administrateur']);

// Rendu du dashboard
$dashboard = new AdminDashboardSimple();
echo $dashboard->render();
