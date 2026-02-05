<?php
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../auth/logout.php';

/**
 * Dashboard Comité des Parents
 * Thème: Bleu et Blanc
 */
class ComiteParentsDashboard extends Component {
    private $user;
    private $stats = [];
    private $meetings = [];
    private $projects = [];
    private $communications = [];
    
    public function __construct(array $options = []) {
        // Vérification de l'authentification
        AuthMiddleware::requireRole(['comite_parents']);
        
        $this->user = AuthMiddleware::getUser();
        $this->loadDashboardData();
        
        parent::__construct($options);
    }
    
    private function loadDashboardData(): void {
        // Statistiques du comité des parents
        $this->stats = [
            'membres_actifs' => $this->getStat('SELECT COUNT(*) FROM comite_parents WHERE statut = "actif"'),
            'reunions_ce_mois' => $this->getStat('SELECT COUNT(*) FROM reunion_comite WHERE MONTH(date_reunion) = MONTH(NOW()) AND YEAR(date_reunion) = YEAR(NOW())'),
            'projets_en_cours' => $this->getStat('SELECT COUNT(*) FROM projet_comite WHERE statut = "en_cours"'),
            'fonds_collectes' => $this->getStat('SELECT SUM(montant) FROM cotisation WHERE date_cotisation >= DATE_SUB(NOW(), INTERVAL 30 DAY)'),
            'messages_parents' => $this->getStat('SELECT COUNT(*) FROM message_parent WHERE statut = "non_lu" AND date_message >= DATE_SUB(NOW(), INTERVAL 7 DAY)'),
            'evenements_prevus' => $this->getStat('SELECT COUNT(*) FROM evenement_ecole WHERE date_evenement >= CURDATE() AND date_eveniment <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)')
        ];
        
        // Réunions à venir
        $this->meetings = [
            ['title' => 'Réunion mensuelle du comité', 'date' => '2024-01-20', 'time' => '18:00', 'location' => 'Salle des professeurs', 'type' => 'mensuel'],
            ['title' => 'Assemblée générale', 'date' => '2024-01-25', 'time' => '15:00', 'location' => 'Amphithéâtre', 'type' => 'general'],
            ['title' => 'Réunion budget', 'date' => '2024-02-02', 'time' => '17:00', 'location' => 'Salle B201', 'type' => 'budget'],
            ['title' => 'Réunion projets', 'date' => '2024-02-10', 'time' => '16:00', 'location' => 'Salle des parents', 'type' => 'projet']
        ];
        
        // Projets en cours
        $this->projects = [
            ['name' => 'Rénovation bibliothèque', 'progress' => 75, 'budget' => '500.000 FC', 'deadline' => '2024-03-15', 'status' => 'en_cours'],
            ['name' => 'Équipement informatique', 'progress' => 45, 'budget' => '1.200.000 FC', 'deadline' => '2024-04-20', 'status' => 'en_cours'],
            ['name' => 'Cantine scolaire', 'progress' => 90, 'budget' => '800.000 FC', 'deadline' => '2024-02-28', 'status' => 'en_cours'],
            ['name' => 'Terrain de sport', 'progress' => 20, 'budget' => '2.000.000 FC', 'deadline' => '2024-06-30', 'status' => 'planification']
        ];
        
        // Communications récentes
        $this->communications = [
            ['type' => 'Message parent', 'sender' => 'Jean Mukendi', 'subject' => 'Demande information frais scolaires', 'date' => '2024-01-15', 'priority' => 'normal'],
            ['type' => 'Annonce', 'sender' => 'Direction', 'subject' => 'Nouvelles procédures inscription', 'date' => '2024-01-14', 'priority' => 'high'],
            ['type' => 'Rappel', 'sender' => 'Secrétariat', 'subject' => 'Paiement cotisations', 'date' => '2024-01-13', 'priority' => 'medium'],
            ['type' => 'Invitation', 'sender' => 'Comité', 'subject' => 'Réunion exceptionnelle', 'date' => '2024-01-12', 'priority' => 'high']
        ];
    }
    
    private function getStat(string $query, array $params = []): int {
        // Simulation de données - à remplacer avec vraie BDD
        return rand(0, 100);
    }
    
    public function render(): string {
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Comité des Parents - Gestion Programme</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                .sidebar-transition {
                    transition: margin-left 0.3s ease;
                }
                .meeting-item {
                    transition: all 0.3s ease;
                }
                .meeting-item:hover {
                    transform: translateY(-2px);
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-slide-in {
                    animation: slideIn 0.5s ease forwards;
                }
                .priority-high { border-left: 4px solid #ef4444; }
                .priority-medium { border-left: 4px solid #f59e0b; }
                .priority-normal { border-left: 4px solid #10b981; }
                .progress-bar {
                    transition: width 0.3s ease;
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
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Comité des Parents</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Espace de gestion du comité.</p>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards() . '
                        </div>
                        
                        <!-- Réunions et Projets -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                            <!-- Réunions à venir -->
                            <div class="lg:col-span-2">
                                ' . $this->renderUpcomingMeetings() . '
                            </div>
                            
                            <!-- Projets en cours -->
                            <div>
                                ' . $this->renderCurrentProjects() . '
                            </div>
                        </div>
                        
                        <!-- Communications et Actions rapides -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Communications récentes -->
                            ' . $this->renderRecentCommunications() . '
                            
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
                ['label' => 'Dashboard', 'url' => '/comite_parents/dashboard', 'icon' => 'fas fa-tachometer-alt'],
                ['label' => 'Réunions', 'url' => '/comite_parents/reunions', 'icon' => 'fas fa-users'],
                ['label' => 'Projets', 'url' => '/comite_parents/projets', 'icon' => 'fas fa-project-diagram'],
                ['label' => 'Finances', 'url' => '/comite_parents/finances', 'icon' => 'fas fa-dollar-sign'],
                ['label' => 'Communication', 'url' => '/comite_parents/communication', 'icon' => 'fas fa-comments']
            ]
        ]);
        
        return $header->render();
    }
    
    private function renderSidebar(): string {
        $sidebar = new Sidebar([
            'user' => $this->user,
            'collapsed' => false
        ]);
        
        $sidebar->addMenuItem('Dashboard', '/comite_parents/dashboard', 'fas fa-tachometer-alt')
                ->addMenuItem('Réunions', '/comite_parents/reunions', 'fas fa-users', [
                    ['label' => 'Calendrier', 'url' => '/comite_parents/reunions/calendrier', 'icon' => 'fas fa-calendar-alt'],
                    ['label' => 'Procès-verbaux', 'url' => '/comite_parents/reunions/pv', 'icon' => 'fas fa-file-alt'],
                    ['label' => 'Convocations', 'url' => '/comite_parents/reunions/convocations', 'icon' => 'fas fa-envelope-open-text']
                ])
                ->addMenuItem('Projets', '/comite_parents/projets', 'fas fa-project-diagram', [
                    ['label' => 'Projets en cours', 'url' => '/comite_parents/projets/encours', 'icon' => 'fas fa-spinner'],
                    ['label' => 'Nouveau projet', 'url' => '/comite_parents/projets/nouveau', 'icon' => 'fas fa-plus'],
                    ['label' => 'Archives', 'url' => '/comite_parents/projets/archives', 'icon' => 'fas fa-archive']
                ])
                ->addMenuItem('Finances', '/comite_parents/finances', 'fas fa-dollar-sign', [
                    ['label' => 'Cotisations', 'url' => '/comite_parents/finances/cotisations', 'icon' => 'fas fa-coins'],
                    ['label' => 'Budget', 'url' => '/comite_parents/finances/budget', 'icon' => 'fas fa-calculator'],
                    ['label' => 'Rapports financiers', 'url' => '/comite_parents/finances/rapports', 'icon' => 'fas fa-chart-line'],
                    ['label' => 'Dépenses', 'url' => '/comite_parents/finances/depenses', 'icon' => 'fas fa-receipt']
                ])
                ->addMenuItem('Membres', '/comite_parents/membres', 'fas fa-user-friends', [
                    ['label' => 'Liste des membres', 'url' => '/comite_parents/membres/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Adhésions', 'url' => '/comite_parents/membres/adhesions', 'icon' => 'fas fa-user-plus'],
                    ['label' => 'Rôles', 'url' => '/comite_parents/membres/roles', 'icon' => 'fas fa-user-tag']
                ])
                ->addMenuItem('Communication', '/comite_parents/communication', 'fas fa-comments', [
                    ['label' => 'Messages', 'url' => '/comite_parents/communication/messages', 'icon' => 'fas fa-envelope'],
                    ['label' => 'Annonces', 'url' => '/comite_parents/communication/annonces', 'icon' => 'fas fa-bullhorn'],
                    ['label' => 'Newsletter', 'url' => '/comite_parents/communication/newsletter', 'icon' => 'fas fa-newspaper']
                ])
                ->addMenuItem('Événements', '/comite_parents/evenements', 'fas fa-calendar-day', [
                    ['label' => 'Calendrier', 'url' => '/comite_parents/evenements/calendrier', 'icon' => 'fas fa-calendar'],
                    ['label' => 'Organisation', 'url' => '/comite_parents/evenements/organisation', 'icon' => 'fas fa-tasks'],
                    ['label' => 'Bénévoles', 'url' => '/comite_parents/evenements/benevoles', 'icon' => 'fas fa-hands-helping']
                ])
                ->addMenuItem('Paramètres', '/comite_parents/parametres', 'fas fa-cog', [
                    ['label' => 'Profil', 'url' => '/comite_parents/parametres/profil', 'icon' => 'fas fa-user'],
                    ['label' => 'Préférences', 'url' => '/comite_parents/parametres/preferences', 'icon' => 'fas fa-sliders-h']
                ]);
        
        return $sidebar->render();
    }
    
    private function renderFooter(): string {
        $footer = new Footer([
            'links' => [
                ['label' => 'Aide', 'url' => '/help'],
                ['label' => 'Documentation', 'url' => '/docs'],
                ['label' => 'Contact', 'url' => '/contact']
            ]
        ]);
        
        return $footer->render();
    }
    
    private function renderStatsCards(): string {
        $cards = '';
        
        $statsConfig = [
            'membres_actifs' => ['label' => 'Membres actifs', 'icon' => 'fas fa-users', 'color' => 'blue'],
            'reunions_ce_mois' => ['label' => 'Réunions ce mois', 'icon' => 'fas fa-calendar-check', 'color' => 'green'],
            'projets_en_cours' => ['label' => 'Projets en cours', 'icon' => 'fas fa-project-diagram', 'color' => 'purple'],
            'fonds_collectes' => ['label' => 'Fonds collectés', 'icon' => 'fas fa-coins', 'color' => 'yellow'],
            'messages_parents' => ['label' => 'Messages parents', 'icon' => 'fas fa-envelope', 'color' => 'orange'],
            'evenements_prevus' => ['label' => 'Événements', 'icon' => 'fas fa-calendar-day', 'color' => 'red']
        ];
        
        foreach ($statsConfig as $key => $config) {
            $value = $this->stats[$key];
            
            if ($key === 'fonds_collectes') {
                $value = number_format($value, 0, '.', ' ') . ' FC';
            }
            
            $card = new StatsCard(
                $config['label'],
                $value,
                [
                    'icon' => $config['icon'],
                    'color' => $config['color'],
                    'change' => '+5%',
                    'changeType' => 'positive'
                ]
            );
            
            $cards .= '<div class="animate-slide-in">' . $card->render() . '</div>';
        }
        
        return $cards;
    }
    
    private function renderUpcomingMeetings(): string {
        $card = new ListCard('Réunions à venir', [
            'headerActions' => [
                ['label' => 'Voir calendrier', 'url' => '/comite_parents/reunions/calendrier', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->meetings as $meeting) {
            $typeIcon = $meeting['type'] === 'mensuel' ? 'fas fa-calendar-alt' : 
                       ($meeting['type'] === 'general' ? 'fas fa-users' : 
                       ($meeting['type'] === 'budget' ? 'fas fa-calculator' : 'fas fa-project-diagram'));
            
            $card->addItem(
                $meeting['title'],
                $meeting['date'] . ' à ' . $meeting['time'] . ' - ' . $meeting['location'],
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir détails'],
                    ['icon' => 'fas fa-edit', 'title' => 'Modifier'],
                    ['icon' => 'fas fa-share', 'title' => 'Partager']
                ]
            );
        }
        
        return $card->render();
    }
    
    private function renderCurrentProjects(): string {
        $card = new Card('Projets en cours', [
            'headerActions' => [
                ['label' => 'Voir tous', 'url' => '/comite_parents/projets/encours', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        $projects = '<div class="space-y-4">';
        foreach ($this->projects as $project) {
            $progressColor = $project['progress'] >= 75 ? 'bg-green-500' : 
                            ($project['progress'] >= 50 ? 'bg-yellow-500' : 'bg-red-500');
            
            $projects .= '
            <div class="p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold text-gray-800">' . htmlspecialchars($project['name']) . '</h4>
                    <span class="text-sm text-gray-500">' . $project['progress'] . '%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="' . $progressColor . ' h-2 rounded-full progress-bar" style="width: ' . $project['progress'] . '%"></div>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <span>Budget: ' . htmlspecialchars($project['budget']) . '</span>
                    <span>Échéance: ' . $project['deadline'] . '</span>
                </div>
            </div>';
        }
        $projects .= '</div>';
        
        $card->addChild($projects);
        return $card->render();
    }
    
    private function renderRecentCommunications(): string {
        $card = new ListCard('Communications récentes', [
            'headerActions' => [
                ['label' => 'Voir toutes', 'url' => '/comite_parents/communication/messages', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->communications as $comm) {
            $priorityClass = 'priority-' . $comm['priority'];
            $typeIcon = $comm['type'] === 'Message parent' ? 'fas fa-envelope' : 
                       ($comm['type'] === 'Annonce' ? 'fas fa-bullhorn' : 
                       ($comm['type'] === 'Rappel' ? 'fas fa-bell' : 'fas fa-calendar-alt'));
            
            $card->addItem(
                $comm['type'] . ' - ' . $comm['sender'],
                $comm['subject'] . ' - ' . $comm['date'],
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir'],
                    ['icon' => 'fas fa-reply', 'title' => 'Répondre'],
                    ['icon' => 'fas fa-archive', 'title' => 'Archiver']
                ],
                ['class' => $priorityClass]
            );
        }
        
        return $card->render();
    }
    
    private function renderQuickActions(): string {
        $card = new Card('Actions rapides');
        
        $actions = '
        <div class="grid grid-cols-2 gap-3">
            <button onclick="window.location.href=\'/comite_parents/reunions/nouvelle\'" 
                    class="p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-center transition-colors">
                <i class="fas fa-plus-circle text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Nouvelle réunion</p>
            </button>
            <button onclick="window.location.href=\'/comite_parents/projets/nouveau\'" 
                    class="p-4 bg-green-50 hover:bg-green-100 rounded-lg text-center transition-colors">
                <i class="fas fa-project-diagram text-green-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Nouveau projet</p>
            </button>
            <button onclick="window.location.href=\'/comite_parents/finances/cotisations\'" 
                    class="p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-center transition-colors">
                <i class="fas fa-coins text-yellow-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Cotisations</p>
            </button>
            <button onclick="window.location.href=\'/comite_parents/communication/annonces\'" 
                    class="p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-center transition-colors">
                <i class="fas fa-bullhorn text-purple-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Nouvelle annonce</p>
            </button>
        </div>';
        
        $card->addChild($actions);
        return $card->render();
    }
}

// Vérification de l'authentification
AuthMiddleware::requireRole(['comite_parents']);

// Rendu du dashboard
$dashboard = new ComiteParentsDashboard();
echo $dashboard->render();
