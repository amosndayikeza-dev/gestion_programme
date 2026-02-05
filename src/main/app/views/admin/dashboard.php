<?php
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../auth/logout.php';

/**
 * Dashboard Administrateur
 * Thème: Bleu et Blanc
 */
class AdminDashboard extends Component {
    private $user;
    private $stats = [];
    private $recentActivities = [];
    private $alerts = [];
    
    public function __construct(array $options = []) {
        // Vérification de l'authentification
        AuthMiddleware::requireRole(['administrateur']);
        
        $this->user = AuthMiddleware::getUser();
        $this->loadDashboardData();
        
        parent::__construct($options);
    }
    
    private function loadDashboardData(): void {
        // Statistiques
        $this->stats = [
            'total_eleves' => $this->getStat('SELECT COUNT(*) FROM eleve WHERE statut = "actif"'),
            'total_enseignants' => $this->getStat('SELECT COUNT(*) FROM enseignant'),
            'total_classes' => $this->getStat('SELECT COUNT(*) FROM classe'),
            'total_cours' => $this->getStat('SELECT COUNT(*) FROM cours'),
            'paiements_en_attente' => $this->getStat('SELECT COUNT(*) FROM paiement WHERE statut = "en_attente"'),
            'discipline_cases' => $this->getStat('SELECT COUNT(*) FROM discipline WHERE statut = "en_attente"')
        ];
        
        // Activités récentes
        $this->recentActivities = [
            ['title' => 'Nouvel élève inscrit', 'description' => 'Jean Mukendi - 6ème Scientifique', 'time' => 'Il y a 2 heures', 'icon' => 'fas fa-user-plus', 'color' => 'green'],
            ['title' => 'Paiement reçu', 'description' => 'Scolarité - Marie Kalonji', 'time' => 'Il y a 3 heures', 'icon' => 'fas fa-dollar-sign', 'color' => 'blue'],
            ['title' => 'Nouveau cours créé', 'description' => 'Mathématiques - 5ème', 'time' => 'Il y a 5 heures', 'icon' => 'fas fa-book', 'color' => 'purple'],
            ['title' => 'Cas de discipline', 'description' => 'Retard - Pierre Kabeya', 'time' => 'Il y a 6 heures', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'yellow']
        ];
        
        // Alertes
        $this->alerts = [
            ['type' => 'warning', 'message' => '3 paiements en retard', 'count' => 3],
            ['type' => 'info', 'message' => 'Nouvelle mise à jour disponible', 'count' => 1],
            ['type' => 'error', 'message' => '2 cas de discipline en attente', 'count' => 2]
        ];
    }
    
    private function getStat(string $query): int {
        // Simulation de données - à remplacer avec vraie BDD
        return rand(10, 100);
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
                .chart-container {
                    position: relative;
                    height: 300px;
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
                        
                        <!-- Alertes -->
                        ' . $this->renderAlerts() . '
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards() . '
                        </div>
                        
                        <!-- Graphiques et Activités -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                            <!-- Graphique des statistiques -->
                            <div class="lg:col-span-2">
                                ' . $this->renderChartCard() . '
                            </div>
                            
                            <!-- Activités récentes -->
                            <div>
                                ' . $this->renderRecentActivities() . '
                            </div>
                        </div>
                        
                        <!-- Tableaux de bord -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Élèves récents -->
                            ' . $this->renderRecentStudents() . '
                            
                            <!-- Paiements récents -->
                            ' . $this->renderRecentPayments() . '
                        </div>
                    </div>
                </main>
            </div>
            
            <!-- Footer -->
            ' . $this->renderFooter() . '
            
            <!-- Scripts -->
            <script>
                // Toggle Sidebar
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
                
                // Toggle User Menu
                function toggleUserMenu() {
                    const menu = document.getElementById(\'userMenu\');
                    menu.classList.toggle(\'hidden\');
                }
                
                // Toggle Mobile Menu
                function toggleMobileMenu() {
                    const menu = document.getElementById(\'mobileMenu\');
                    menu.classList.toggle(\'hidden\');
                }
                
                // Simuler des données pour les graphiques
                document.addEventListener(\'DOMContentLoaded\', function() {
                    // Animation des cartes
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
                ['label' => 'Classes', 'url' => '/admin/classes', 'icon' => 'fas fa-school'],
                ['label' => 'Cours', 'url' => '/admin/cours', 'icon' => 'fas fa-book'],
                ['label' => 'Paiements', 'url' => '/admin/paiements', 'icon' => 'fas fa-dollar-sign'],
                ['label' => 'Rapports', 'url' => '/admin/rapports', 'icon' => 'fas fa-chart-bar']
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
                ->addMenuItem('Gestion des Élèves', '/admin/eleves', 'fas fa-graduation-cap', [
                    ['label' => 'Liste des élèves', 'url' => '/admin/eleves/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Inscriptions', 'url' => '/admin/eleves/inscriptions', 'icon' => 'fas fa-user-plus'],
                    ['label' => 'Bulletins', 'url' => '/admin/eleves/bulletins', 'icon' => 'fas fa-file-alt']
                ])
                ->addMenuItem('Gestion Enseignants', '/admin/enseignants', 'fas fa-chalkboard-teacher', [
                    ['label' => 'Liste des enseignants', 'url' => '/admin/enseignants/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Affectations', 'url' => '/admin/enseignants/affectations', 'icon' => 'fas fa-calendar-alt']
                ])
                ->addMenuItem('Classes & Cours', '/admin/classes', 'fas fa-school', [
                    ['label' => 'Classes', 'url' => '/admin/classes', 'icon' => 'fas fa-door-open'],
                    ['label' => 'Cours', 'url' => '/admin/cours', 'icon' => 'fas fa-book'],
                    ['label' => 'Emplois du temps', 'url' => '/admin/emplois', 'icon' => 'fas fa-clock']
                ])
                ->addMenuItem('Finances', '/admin/finances', 'fas fa-dollar-sign', [
                    ['label' => 'Paiements', 'url' => '/admin/paiements', 'icon' => 'fas fa-money-bill-wave'],
                    ['label' => 'Frais scolaires', 'url' => '/admin/frais', 'icon' => 'fas fa-receipt'],
                    ['label' => 'Rapports financiers', 'url' => '/admin/rapports/financiers', 'icon' => 'fas fa-chart-line']
                ])
                ->addMenuItem('Discipline', '/admin/discipline', 'fas fa-exclamation-triangle')
                ->addMenuItem('Bibliothèque', '/admin/bibliotheque', 'fas fa-book-open')
                ->addMenuItem('Paramètres', '/admin/parametres', 'fas fa-cog', [
                    ['label' => 'Utilisateurs', 'url' => '/admin/parametres/utilisateurs', 'icon' => 'fas fa-users'],
                    ['label' => 'Système', 'url' => '/admin/parametres/systeme', 'icon' => 'fas fa-server'],
                    ['label' => 'Sauvegardes', 'url' => '/admin/parametres/sauvegardes', 'icon' => 'fas fa-database']
                ]);
        
        return $sidebar->render();
    }
    
    private function renderFooter(): string {
        $footer = new Footer([
            'links' => [
                ['label' => 'Aide', 'url' => '/help'],
                ['label' => 'Documentation', 'url' => '/docs'],
                ['label' => 'Support', 'url' => '/support']
            ],
            'socialLinks' => [
                ['platform' => 'Facebook', 'url' => '#', 'icon' => 'fab fa-facebook-f'],
                ['platform' => 'Twitter', 'url' => '#', 'icon' => 'fab fa-twitter'],
                ['platform' => 'LinkedIn', 'url' => '#', 'icon' => 'fab fa-linkedin-in']
            ]
        ]);
        
        return $footer->render();
    }
    
    private function renderAlerts(): string {
        if (empty($this->alerts)) {
            return '';
        }
        
        $alerts = '<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">';
        
        foreach ($this->alerts as $alert) {
            $colorClasses = [
                'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                'info' => 'bg-blue-50 border-blue-200 text-blue-800',
                'error' => 'bg-red-50 border-red-200 text-red-800'
            ];
            
            $iconClasses = [
                'warning' => 'fas fa-exclamation-triangle text-yellow-500',
                'info' => 'fas fa-info-circle text-blue-500',
                'error' => 'fas fa-times-circle text-red-500'
            ];
            
            $class = $colorClasses[$alert['type']] ?? $colorClasses['info'];
            $icon = $iconClasses[$alert['type']] ?? $iconClasses['info'];
            
            $alerts .= '
            <div class="flex items-center p-4 rounded-lg border ' . $class . ' animate-slide-in">
                <i class="' . $icon . ' mr-3"></i>
                <div class="flex-1">
                    <p class="font-medium">' . htmlspecialchars($alert['message']) . '</p>
                    <p class="text-sm opacity-75">' . $alert['count'] . ' élément(s)</p>
                </div>
                <button class="ml-4 hover:opacity-75">
                    <i class="fas fa-times"></i>
                </button>
            </div>';
        }
        
        $alerts .= '</div>';
        return $alerts;
    }
    
    private function renderStatsCards(): string {
        $cards = '';
        
        $statsConfig = [
            'total_eleves' => ['label' => 'Élèves', 'icon' => 'fas fa-graduation-cap', 'color' => 'blue'],
            'total_enseignants' => ['label' => 'Enseignants', 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'green'],
            'total_classes' => ['label' => 'Classes', 'icon' => 'fas fa-school', 'color' => 'purple'],
            'total_cours' => ['label' => 'Cours', 'icon' => 'fas fa-book', 'color' => 'yellow'],
            'paiements_en_attente' => ['label' => 'Paiements en attente', 'icon' => 'fas fa-clock', 'color' => 'orange'],
            'discipline_cases' => ['label' => 'Cas discipline', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red']
        ];
        
        foreach ($statsConfig as $key => $config) {
            $card = new StatsCard(
                $config['label'],
                $this->stats[$key],
                [
                    'icon' => $config['icon'],
                    'color' => $config['color'],
                    'change' => '+12%',
                    'changeType' => 'positive'
                ]
            );
            
            $cards .= '<div class="animate-slide-in">' . $card->render() . '</div>';
        }
        
        return $cards;
    }
    
    private function renderChartCard(): string {
        return '
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Statistiques générales</h3>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-blue-500">
                    <option>Cette semaine</option>
                    <option>Ce mois</option>
                    <option>Cette année</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="statsChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-600">85%</p>
                    <p class="text-sm text-gray-500">Taux de réussite</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">92%</p>
                    <p class="text-sm text-gray-500">Présence</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-purple-600">78%</p>
                    <p class="text-sm text-gray-500">Satisfaction</p>
                </div>
            </div>
        </div>';
    }
    
    private function renderRecentActivities(): string {
        $card = new ListCard('Activités récentes', [
            'emptyMessage' => 'Aucune activité récente'
        ]);
        
        foreach ($this->recentActivities as $activity) {
            $card->addItem($activity['title'], $activity['description'], '#', [
                ['icon' => $activity['icon'], 'title' => 'Voir les détails']
            ]);
        }
        
        return $card->render();
    }
    
    private function renderRecentStudents(): string {
        $card = new ListCard('Nouveaux élèves', [
            'headerActions' => [
                ['label' => 'Voir tout', 'url' => '/admin/eleves', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        $students = [
            ['name' => 'Jean Mukendi', 'class' => '6ème Scientifique', 'date' => '2024-01-15'],
            ['name' => 'Marie Kalonji', 'class' => '5ème Scientifique', 'date' => '2024-01-14'],
            ['name' => 'Pierre Kabeya', 'class' => '4ème Littéraire', 'date' => '2024-01-13']
        ];
        
        foreach ($students as $student) {
            $card->addItem($student['name'], $student['class'] . ' - Inscrit le ' . $student['date'], '#', [
                ['icon' => 'fas fa-eye', 'title' => 'Voir le profil'],
                ['icon' => 'fas fa-edit', 'title' => 'Modifier']
            ]);
        }
        
        return $card->render();
    }
    
    private function renderRecentPayments(): string {
        $card = new ListCard('Paiements récents', [
            'headerActions' => [
                ['label' => 'Voir tout', 'url' => '/admin/paiements', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        $payments = [
            ['student' => 'Jean Mukendi', 'amount' => '50.000 FC', 'type' => 'Inscription', 'status' => 'Complété'],
            ['student' => 'Marie Kalonji', 'amount' => '80.000 FC', 'type' => 'Scolarité', 'status' => 'En attente'],
            ['student' => 'Pierre Kabeya', 'amount' => '30.000 FC', 'type' => 'Cantine', 'status' => 'Complété']
        ];
        
        foreach ($payments as $payment) {
            $statusColor = $payment['status'] === 'Complété' ? 'text-green-600' : 'text-yellow-600';
            $card->addItem(
                $payment['student'], 
                $payment['type'] . ' - ' . $payment['amount'] . ' - <span class="' . $statusColor . '">' . $payment['status'] . '</span>',
                '#',
                [
                    ['icon' => 'fas fa-receipt', 'title' => 'Voir le reçu'],
                    ['icon' => 'fas fa-download', 'title' => 'Télécharger']
                ]
            );
        }
        
        return $card->render();
    }
}

// Vérification de l'authentification
AuthMiddleware::requireRole(['administrateur']);

// Rendu du dashboard
$dashboard = new AdminDashboard();
echo $dashboard->render();
