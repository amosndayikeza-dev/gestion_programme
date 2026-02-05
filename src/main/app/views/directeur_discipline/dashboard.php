<?php
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../auth/logout.php';

/**
 * Dashboard Directeur de Discipline
 * Thème: Bleu et Blanc
 */
class DirecteurDisciplineDashboard extends Component {
    private $user;
    private $stats = [];
    private $recentCases = [];
    private $urgentCases = [];
    private $sanctions = [];
    
    public function __construct(array $options = []) {
        // Vérification de l'authentification
        AuthMiddleware::requireRole(['directeur_discipline']);
        
        $this->user = AuthMiddleware::getUser();
        $this->loadDashboardData();
        
        parent::__construct($options);
    }
    
    private function loadDashboardData(): void {
        // Statistiques discipline
        $this->stats = [
            'cas_en_attente' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE statut = "en_attente"'),
            'cas_traites' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE statut = "traite" AND date_rapport >= DATE_SUB(NOW(), INTERVAL 30 DAY)'),
            'retards_ce_mois' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE type_infraction = "retard" AND MONTH(date_infraction) = MONTH(NOW()) AND YEAR(date_infraction) = YEAR(NOW())'),
            'absences_ce_mois' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE type_infraction = "absence" AND MONTH(date_infraction) = MONTH(NOW()) AND YEAR(date_infraction) = YEAR(NOW())'),
            'sanctions_appliquees' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE sanction IS NOT NULL AND date_rapport >= DATE_SUB(NOW(), INTERVAL 30 DAY)'),
            'cas_urgents' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE type_infraction IN ("violence", "triche") AND statut = "en_attente"')
        ];
        
        // Cas récents
        $this->recentCases = [
            ['student' => 'Jean Mukendi', 'type' => 'Retard', 'description' => 'Retard de 15 minutes en cours de maths', 'date' => '2024-01-15', 'status' => 'en_attente', 'teacher' => 'M. Dupont'],
            ['student' => 'Marie Kalonji', 'type' => 'Absence', 'description' => 'Absence non justifiée - cours de français', 'date' => '2024-01-14', 'status' => 'en_attente', 'teacher' => 'M. Bernard'],
            ['student' => 'Pierre Kabeya', 'type' => 'Indiscipline', 'description' => 'Bavardage répété en classe', 'date' => '2024-01-13', 'status' => 'traite', 'teacher' => 'Mme. Martin'],
            ['student' => 'Sophie Tshibanda', 'type' => 'Triche', 'description' => 'Tentative de triche lors de l\'examen', 'date' => '2024-01-12', 'status' => 'en_attente', 'teacher' => 'M. Petit']
        ];
        
        // Cas urgents
        $this->urgentCases = [
            ['student' => 'François Mbuyu', 'type' => 'Violence', 'description' => 'Agression verbale contre un camarade', 'date' => '2024-01-15', 'priority' => 'high', 'teacher' => 'M. Lumbu'],
            ['student' => 'Grace Nkulu', 'type' => 'Triche', 'description' => 'Copie lors de l\'examen final', 'date' => '2024-01-14', 'priority' => 'high', 'teacher' => 'Mme. Kanku']
        ];
        
        // Types de sanctions
        $this->sanctions = [
            ['type' => 'Avertissement verbal', 'count' => 15, 'percentage' => 45],
            ['type' => 'Avertissement écrit', 'count' => 10, 'percentage' => 30],
            ['type' => 'Exclusion temporaire', 'count' => 5, 'percentage' => 15],
            ['type' => 'Tâches d\'intérêt général', 'count' => 3, 'percentage' => 10]
        ];
    }
    
    private function getStat(string $query, array $params = []): int {
        // Simulation de données - à remplacer avec vraie BDD
        return rand(0, 50);
    }
    
    public function render(): string {
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Directeur de Discipline - Gestion Programme</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                .sidebar-transition {
                    transition: margin-left 0.3s ease;
                }
                .case-item {
                    transition: all 0.3s ease;
                }
                .case-item:hover {
                    transform: translateY(-2px);
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-slide-in {
                    animation: slideIn 0.5s ease forwards;
                }
                .status-en_attente { border-left: 4px solid #f59e0b; }
                .status-traite { border-left: 4px solid #10b981; }
                .priority-high { border-left: 4px solid #ef4444; }
                .priority-medium { border-left: 4px solid #f59e0b; }
                .priority-low { border-left: 4px solid #10b981; }
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
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Directeur de Discipline</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Gestion des cas disciplinaires.</p>
                        </div>
                        
                        <!-- Alertes cas urgents -->
                        ' . $this->renderUrgentAlerts() . '
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards() . '
                        </div>
                        
                        <!-- Cas urgents et Statistiques -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                            <!-- Cas urgents -->
                            <div class="lg:col-span-2">
                                ' . $this->renderUrgentCases() . '
                            </div>
                            
                            <!-- Répartition des sanctions -->
                            <div>
                                ' . $this->renderSanctionsChart() . '
                            </div>
                        </div>
                        
                        <!-- Cas récents et Actions -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Cas récents -->
                            ' . $this->renderRecentCases() . '
                            
                            <!-- Actions rapides -->
                            ' . $this->renderQuickActions() . '
                        </div>
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
                ['label' => 'Dashboard', 'url' => '/directeur_discipline/dashboard', 'icon' => 'fas fa-tachometer-alt'],
                ['label' => 'Cas disciplinaires', 'url' => '/directeur_discipline/cas', 'icon' => 'fas fa-exclamation-triangle'],
                ['label' => 'Sanctions', 'url' => '/directeur_discipline/sanctions', 'icon' => 'fas fa-gavel'],
                ['label' => 'Rapports', 'url' => '/directeur_discipline/rapports', 'icon' => 'fas fa-chart-bar']
            ]
        ]);
        
        return $header->render();
    }
    
    private function renderSidebar(): string {
        $sidebar = new Sidebar([
            'user' => $this->user,
            'collapsed' => false
        ]);
        
        $sidebar->addMenuItem('Dashboard', '/directeur_discipline/dashboard', 'fas fa-tachometer-alt')
                ->addMenuItem('Cas Disciplinaires', '/directeur_discipline/cas', 'fas fa-exclamation-triangle', [
                    ['label' => 'Nouveau cas', 'url' => '/directeur_discipline/cas/nouveau', 'icon' => 'fas fa-plus'],
                    ['label' => 'Cas en attente', 'url' => '/directeur_discipline/cas/en_attente', 'icon' => 'fas fa-clock'],
                    ['label' => 'Cas traités', 'url' => '/directeur_discipline/cas/traites', 'icon' => 'fas fa-check-circle'],
                    ['label' => 'Archives', 'url' => '/directeur_discipline/cas/archives', 'icon' => 'fas fa-archive']
                ])
                ->addMenuItem('Sanctions', '/directeur_discipline/sanctions', 'fas fa-gavel', [
                    ['label' => 'Types de sanctions', 'url' => '/directeur_discipline/sanctions/types', 'icon' => 'fas fa-list'],
                    ['label' => 'Sanctions appliquées', 'url' => '/directeur_discipline/sanctions/appliquees', 'icon' => 'fas fa-check'],
                    ['label' => 'Suivi des sanctions', 'url' => '/directeur_discipline/sanctions/suivi', 'icon' => 'fas fa-eye']
                ])
                ->addMenuItem('Élèves Suivis', '/directeur_discipline/eleves', 'fas fa-users', [
                    ['label' => 'Liste des élèves', 'url' => '/directeur_discipline/eleves/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Fiches individuelles', 'url' => '/directeur_discipline/eleves/fiches', 'icon' => 'fas fa-id-card'],
                    ['label' => 'Statistiques élèves', 'url' => '/directeur_discipline/eleves/stats', 'icon' => 'fas fa-chart-line']
                ])
                ->addMenuItem('Rapports', '/directeur_discipline/rapports', 'fas fa-chart-bar', [
                    ['label' => 'Rapport mensuel', 'url' => '/directeur_discipline/rapports/mensuel', 'icon' => 'fas fa-calendar-alt'],
                    ['label' => 'Statistiques', 'url' => '/directeur_discipline/rapports/statistiques', 'icon' => 'fas fa-chart-pie'],
                    ['label' => 'Export', 'url' => '/directeur_discipline/rapports/export', 'icon' => 'fas fa-download']
                ])
                ->addMenuItem('Communication', '/directeur_discipline/communication', 'fas fa-comments', [
                    ['label' => 'Messages parents', 'url' => '/directeur_discipline/communication/parents', 'icon' => 'fas fa-user-friends'],
                    ['label' => 'Convocations', 'url' => '/directeur_discipline/communication/convocations', 'icon' => 'fas fa-envelope-open-text']
                ])
                ->addMenuItem('Paramètres', '/directeur_discipline/parametres', 'fas fa-cog', [
                    ['label' => 'Règles discipline', 'url' => '/directeur_discipline/parametres/regles', 'icon' => 'fas fa-book'],
                    ['label' => 'Profil', 'url' => '/directeur_discipline/parametres/profil', 'icon' => 'fas fa-user']
                ]);
        
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
    
    private function renderUrgentAlerts(): string {
        if (empty($this->urgentCases)) {
            return '';
        }
        
        $alerts = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">';
        
        foreach ($this->urgentCases as $case) {
            $alerts .= '
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 animate-slide-in">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-800">Cas urgent - ' . htmlspecialchars($case['type']) . '</h4>
                        <p class="text-red-700 text-sm mt-1">' . htmlspecialchars($case['student']) . ' - ' . htmlspecialchars($case['description']) . '</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs text-red-600">' . $case['date'] . '</span>
                            <button onclick="window.location.href=\'/directeur_discipline/cas/details/' . $case['student'] . '\'" 
                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                Traiter maintenant
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        
        $alerts .= '</div>';
        return $alerts;
    }
    
    private function renderStatsCards(): string {
        $cards = '';
        
        $statsConfig = [
            'cas_en_attente' => ['label' => 'Cas en attente', 'icon' => 'fas fa-clock', 'color' => 'yellow'],
            'cas_traites' => ['label' => 'Cas traités', 'icon' => 'fas fa-check-circle', 'color' => 'green'],
            'retards_ce_mois' => ['label' => 'Retards ce mois', 'icon' => 'fas fa-hourglass-half', 'color' => 'orange'],
            'absences_ce_mois' => ['label' => 'Absences ce mois', 'icon' => 'fas fa-calendar-times', 'color' => 'red'],
            'sanctions_appliquees' => ['label' => 'Sanctions appliquées', 'icon' => 'fas fa-gavel', 'color' => 'purple'],
            'cas_urgents' => ['label' => 'Cas urgents', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red']
        ];
        
        foreach ($statsConfig as $key => $config) {
            $card = new StatsCard(
                $config['label'],
                $this->stats[$key],
                [
                    'icon' => $config['icon'],
                    'color' => $config['color'],
                    'change' => '+8%',
                    'changeType' => 'positive'
                ]
            );
            
            $cards .= '<div class="animate-slide-in">' . $card->render() . '</div>';
        }
        
        return $cards;
    }
    
    private function renderUrgentCases(): string {
        $card = new ListCard('Cas urgents à traiter', [
            'headerActions' => [
                ['label' => 'Voir tous les cas', 'url' => '/directeur_discipline/cas/en_attente', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->urgentCases as $case) {
            $card->addItem(
                $case['student'] . ' - ' . $case['type'],
                $case['description'] . ' - ' . $case['date'],
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir détails'],
                    ['icon' => 'fas fa-gavel', 'title' => 'Appliquer sanction'],
                    ['icon' => 'fas fa-phone', 'title' => 'Contacter parents']
                ],
                ['class' => 'priority-high']
            );
        }
        
        return $card->render();
    }
    
    private function renderSanctionsChart(): string {
        $card = new Card('Répartition des sanctions');
        
        $chart = '<div class="space-y-3">';
        foreach ($this->sanctions as $sanction) {
            $color = $sanction['percentage'] >= 40 ? 'bg-red-500' : ($sanction['percentage'] >= 20 ? 'bg-yellow-500' : 'bg-green-500');
            
            $chart .= '
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">' . htmlspecialchars($sanction['type']) . '</span>
                    <span class="text-sm text-gray-500">' . $sanction['count'] . ' (' . $sanction['percentage'] . '%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="' . $color . ' h-2 rounded-full" style="width: ' . $sanction['percentage'] . '%"></div>
                </div>
            </div>';
        }
        $chart .= '</div>';
        
        $card->addChild($chart);
        return $card->render();
    }
    
    private function renderRecentCases(): string {
        $card = new ListCard('Cas récents', [
            'headerActions' => [
                ['label' => 'Voir tous', 'url' => '/directeur_discipline/cas', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->recentCases as $case) {
            $statusClass = 'status-' . $case['status'];
            $statusBadge = $case['status'] === 'en_attente' ? 
                '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>' : 
                '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Traité</span>';
            
            $card->addItem(
                $case['student'] . ' - ' . $case['type'],
                $case['description'] . ' - ' . $case['teacher'] . ' - ' . $case['date'] . ' ' . $statusBadge,
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir détails'],
                    ['icon' => 'fas fa-edit', 'title' => 'Modifier'],
                    ['icon' => 'fas fa-file-alt', 'title' => 'Rapport']
                ],
                ['class' => $statusClass]
            );
        }
        
        return $card->render();
    }
    
    private function renderQuickActions(): string {
        $card = new Card('Actions rapides');
        
        $actions = '
        <div class="grid grid-cols-2 gap-3">
            <button onclick="window.location.href=\'/directeur_discipline/cas/nouveau\'" 
                    class="p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-center transition-colors">
                <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Nouveau cas</p>
            </button>
            <button onclick="window.location.href=\'/directeur_discipline/rapports/mensuel\'" 
                    class="p-4 bg-green-50 hover:bg-green-100 rounded-lg text-center transition-colors">
                <i class="fas fa-chart-bar text-green-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Rapport mensuel</p>
            </button>
            <button onclick="window.location.href=\'/directeur_discipline/communication/convocations\'" 
                    class="p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-center transition-colors">
                <i class="fas fa-envelope-open-text text-purple-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Convocations</p>
            </button>
            <button onclick="window.location.href=\'/directeur_discipline/eleves/fiches\'" 
                    class="p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-center transition-colors">
                <i class="fas fa-id-card text-yellow-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Fiches élèves</p>
            </button>
        </div>';
        
        $card->addChild($actions);
        return $card->render();
    }
}

// Vérification de l'authentification
AuthMiddleware::requireRole(['directeur_discipline']);

// Rendu du dashboard
$dashboard = new DirecteurDisciplineDashboard();
echo $dashboard->render();
