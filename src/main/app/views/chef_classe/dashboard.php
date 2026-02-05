<?php
require_once __DIR__ . '/../components/Component.php';
require_once __DIR__ . '/../components/Header.php';
require_once __DIR__ . '/../components/Sidebar.php';
require_once __DIR__ . '/../components/Card.php';
require_once __DIR__ . '/../components/Footer.php';
require_once __DIR__ . '/../auth/logout.php';

/**
 * Dashboard Chef de Classe
 * Thème: Bleu et Blanc
 */
class ChefClasseDashboard extends Component {
    private $user;
    private $stats = [];
    private $myClasses = [];
    private $recentActivities = [];
    private $upcomingEvents = [];
    
    public function __construct(array $options = []) {
        // Vérification de l'authentification
        AuthMiddleware::requireRole(['chef_classe']);
        
        $this->user = AuthMiddleware::getUser();
        $this->loadDashboardData();
        
        parent::__construct($options);
    }
    
    private function loadDashboardData(): void {
        // Statistiques du chef de classe
        $this->stats = [
            'total_classes' => $this->getStat('SELECT COUNT(*) FROM classe WHERE id_chef_classe = ?', [$this->user['id_utilisateur']]),
            'total_eleves' => $this->getStat('SELECT COUNT(*) FROM eleve e JOIN classe c ON e.id_classe_actuelle = c.id_classe WHERE c.id_chef_classe = ?', [$this->user['id_utilisateur']]),
            'absences_ce_jour' => $this->getStat('SELECT COUNT(*) FROM absence a JOIN eleve e ON a.id_eleve = e.id_eleve JOIN classe c ON e.id_classe_actuelle = c.id_classe WHERE c.id_chef_classe = ? AND a.date_absence = CURDATE()', [$this->user['id_utilisateur']]),
            'notes_a_valider' => $this->getStat('SELECT COUNT(*) FROM note n JOIN eleve e ON n.id_eleve = e.id_eleve JOIN classe c ON e.id_classe_actuelle = c.id_classe WHERE c.id_chef_classe = ? AND n.statut = "en_attente"', [$this->user['id_utilisateur']]),
            'messages_parents' => $this->getStat('SELECT COUNT(*) FROM message m JOIN eleve e ON m.id_eleve_concerne = e.id_eleve JOIN classe c ON e.id_classe_actuelle = c.id_classe WHERE c.id_chef_classe = ? AND m.statut = "non_lu"', [$this->user['id_utilisateur']]),
            'reunions_prevues' => $this->getStat('SELECT COUNT(*) FROM reunion WHERE id_chef_classe = ? AND date_reunion >= CURDATE() AND date_reunion <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)', [$this->user['id_utilisateur']])
        ];
        
        // Classes du chef de classe
        $this->myClasses = [
            ['name' => '6ème Scientifique', 'students' => 28, 'level' => 'Secondaire', 'room' => 'A101'],
            ['name' => '5ème Scientifique', 'students' => 25, 'level' => 'Secondaire', 'room' => 'A102']
        ];
        
        // Activités récentes
        $this->recentActivities = [
            ['type' => 'Note saisie', 'description' => 'Mathématiques - 6ème Scientifique', 'student' => 'Jean Mukendi', 'time' => 'Il y a 2 heures'],
            ['type' => 'Absence signalée', 'description' => 'Français - 5ème Scientifique', 'student' => 'Marie Kalonji', 'time' => 'Il y a 3 heures'],
            ['type' => 'Message parent', 'description' => 'Demande de rendez-vous', 'student' => 'Pierre Kabeya', 'time' => 'Il y a 5 heures'],
            ['type' => 'Réunion planifiée', 'description' => 'Conseil de classe', 'student' => '6ème Scientifique', 'time' => 'Il y a 1 jour']
        ];
        
        // Événements à venir
        $this->upcomingEvents = [
            ['title' => 'Conseil de classe', 'class' => '6ème Scientifique', 'date' => '2024-01-20', 'type' => 'meeting'],
            ['title' => 'Réunion parents-professeurs', 'class' => '5ème Scientifique', 'date' => '2024-01-22', 'type' => 'meeting'],
            ['title' => 'Examen final', 'class' => '6ème Scientifique', 'date' => '2024-01-25', 'type' => 'exam'],
            ['title' => 'Sortie pédagogique', 'class' => '5ème Scientifique', 'date' => '2024-01-28', 'type' => 'event']
        ];
    }
    
    private function getStat(string $query, array $params = []): int {
        // Simulation de données - à remplacer avec vraie BDD
        return rand(0, 30);
    }
    
    public function render(): string {
        return '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Chef de Classe - Gestion Programme</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                .sidebar-transition {
                    transition: margin-left 0.3s ease;
                }
                .activity-item {
                    transition: all 0.3s ease;
                }
                .activity-item:hover {
                    transform: translateX(5px);
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-slide-in {
                    animation: slideIn 0.5s ease forwards;
                }
                .event-meeting { border-left: 4px solid #3b82f6; }
                .event-exam { border-left: 4px solid #ef4444; }
                .event-general { border-left: 4px solid #10b981; }
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
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard Chef de Classe</h1>
                            <p class="text-gray-600 mt-2">Bienvenue, ' . htmlspecialchars($this->user['nom']) . '! Gestion de vos classes.</p>
                        </div>
                        
                        <!-- Statistiques -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
                            ' . $this->renderStatsCards() . '
                        </div>
                        
                        <!-- Mes classes et Événements -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                            <!-- Mes classes -->
                            <div class="lg:col-span-2">
                                ' . $this->renderMyClasses() . '
                            </div>
                            
                            <!-- Événements à venir -->
                            <div>
                                ' . $this->renderUpcomingEvents() . '
                            </div>
                        </div>
                        
                        <!-- Activités récentes et Actions rapides -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Activités récentes -->
                            ' . $this->renderRecentActivities() . '
                            
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
                ['label' => 'Dashboard', 'url' => '/chef_classe/dashboard', 'icon' => 'fas fa-tachometer-alt'],
                ['label' => 'Mes Classes', 'url' => '/chef_classe/classes', 'icon' => 'fas fa-school'],
                ['label' => 'Élèves', 'url' => '/chef_classe/eleves', 'icon' => 'fas fa-graduation-cap'],
                ['label' => 'Notes', 'url' => '/chef_classe/notes', 'icon' => 'fas fa-chart-line'],
                ['label' => 'Communication', 'url' => '/chef_classe/communication', 'icon' => 'fas fa-comments']
            ]
        ]);
        
        return $header->render();
    }
    
    private function renderSidebar(): string {
        $sidebar = new Sidebar([
            'user' => $this->user,
            'collapsed' => false
        ]);
        
        $sidebar->addMenuItem('Dashboard', '/chef_classe/dashboard', 'fas fa-tachometer-alt')
                ->addMenuItem('Mes Classes', '/chef_classe/classes', 'fas fa-school', [
                    ['label' => 'Liste des classes', 'url' => '/chef_classe/classes/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Effectifs', 'url' => '/chef_classe/classes/effectifs', 'icon' => 'fas fa-users'],
                    ['label' => 'Emploi du temps', 'url' => '/chef_classe/classes/emploi', 'icon' => 'fas fa-calendar-alt']
                ])
                ->addMenuItem('Élèves', '/chef_classe/eleves', 'fas fa-graduation-cap', [
                    ['label' => 'Liste des élèves', 'url' => '/chef_classe/eleves/liste', 'icon' => 'fas fa-list'],
                    ['label' => 'Fiches individuelles', 'url' => '/chef_classe/eleves/fiches', 'icon' => 'fas fa-id-card'],
                    ['label' => 'Suivi scolaire', 'url' => '/chef_classe/eleves/suivi', 'icon' => 'fas fa-chart-line'],
                    ['label' => 'Absences', 'url' => '/chef_classe/eleves/absences', 'icon' => 'fas fa-calendar-times']
                ])
                ->addMenuItem('Évaluations', '/chef_classe/evaluations', 'fas fa-clipboard-check', [
                    ['label' => 'Notes à valider', 'url' => '/chef_classe/evaluations/notes', 'icon' => 'fas fa-edit'],
                    ['label' => 'Bulletins', 'url' => '/chef_classe/evaluations/bulletins', 'icon' => 'fas fa-file-invoice'],
                    ['label' => 'Statistiques', 'url' => '/chef_classe/evaluations/stats', 'icon' => 'fas fa-chart-pie']
                ])
                ->addMenuItem('Communication', '/chef_classe/communication', 'fas fa-comments', [
                    ['label' => 'Messages parents', 'url' => '/chef_classe/communication/parents', 'icon' => 'fas fa-user-friends'],
                    ['label' => 'Annonces classe', 'url' => '/chef_classe/communication/annonces', 'icon' => 'fas fa-bullhorn'],
                    ['label' => 'Réunions', 'url' => '/chef_classe/communication/reunions', 'icon' => 'fas fa-users']
                ])
                ->addMenuItem('Discipline', '/chef_classe/discipline', 'fas fa-exclamation-triangle', [
                    ['label' => 'Cas disciplinaires', 'url' => '/chef_classe/discipline/cas', 'icon' => 'fas fa-exclamation-circle'],
                    ['label' => 'Rapports', 'url' => '/chef_classe/discipline/rapports', 'icon' => 'fas fa-file-alt']
                ])
                ->addMenuItem('Rapports', '/chef_classe/rapports', 'fas fa-chart-bar', [
                    ['label' => 'Rapport de classe', 'url' => '/chef_classe/rapports/classe', 'icon' => 'fas fa-file-alt'],
                    ['label' => 'Statistiques générales', 'url' => '/chef_classe/rapports/stats', 'icon' => 'fas fa-chart-line'],
                    ['label' => 'Export', 'url' => '/chef_classe/rapports/export', 'icon' => 'fas fa-download']
                ])
                ->addMenuItem('Paramètres', '/chef_classe/parametres', 'fas fa-cog', [
                    ['label' => 'Profil', 'url' => '/chef_classe/parametres/profil', 'icon' => 'fas fa-user'],
                    ['label' => 'Préférences', 'url' => '/chef_classe/parametres/preferences', 'icon' => 'fas fa-sliders-h']
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
    
    private function renderStatsCards(): string {
        $cards = '';
        
        $statsConfig = [
            'total_classes' => ['label' => 'Classes', 'icon' => 'fas fa-school', 'color' => 'blue'],
            'total_eleves' => ['label' => 'Élèves', 'icon' => 'fas fa-graduation-cap', 'color' => 'green'],
            'absences_ce_jour' => ['label' => 'Absences aujourd\'hui', 'icon' => 'fas fa-calendar-times', 'color' => 'red'],
            'notes_a_valider' => ['label' => 'Notes à valider', 'icon' => 'fas fa-edit', 'color' => 'yellow'],
            'messages_parents' => ['label' => 'Messages parents', 'icon' => 'fas fa-envelope', 'color' => 'purple'],
            'reunions_prevues' => ['label' => 'Réunions', 'icon' => 'fas fa-users', 'color' => 'orange']
        ];
        
        foreach ($statsConfig as $key => $config) {
            $card = new StatsCard(
                $config['label'],
                $this->stats[$key],
                [
                    'icon' => $config['icon'],
                    'color' => $config['color'],
                    'change' => '+3%',
                    'changeType' => 'positive'
                ]
            );
            
            $cards .= '<div class="animate-slide-in">' . $card->render() . '</div>';
        }
        
        return $cards;
    }
    
    private function renderMyClasses(): string {
        $card = new ListCard('Mes classes', [
            'headerActions' => [
                ['label' => 'Voir détails', 'url' => '/chef_classe/classes/liste', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->myClasses as $class) {
            $card->addItem(
                $class['name'],
                $class['students'] . ' élèves - ' . $class['level'] . ' - Salle ' . $class['room'],
                '#',
                [
                    ['icon' => 'fas fa-users', 'title' => 'Voir les élèves'],
                    ['icon' => 'fas fa-chart-line', 'title' => 'Statistiques'],
                    ['icon' => 'fas fa-envelope', 'title' => 'Contacter la classe'],
                    ['icon' => 'fas fa-calendar-alt', 'title' => 'Emploi du temps']
                ]
            );
        }
        
        return $card->render();
    }
    
    private function renderUpcomingEvents(): string {
        $card = new ListCard('Événements à venir', [
            'headerActions' => [
                ['label' => 'Voir tout', 'url' => '/chef_classe/communication/reunions', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->upcomingEvents as $event) {
            $eventClass = 'event-' . $event['type'];
            $icon = $event['type'] === 'meeting' ? 'fas fa-users' : 
                   ($event['type'] === 'exam' ? 'fas fa-clipboard-check' : 'fas fa-calendar-day');
            
            $card->addItem(
                $event['title'],
                $event['class'] . ' - ' . $event['date'],
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir détails'],
                    ['icon' => 'fas fa-edit', 'title' => 'Modifier']
                ],
                ['class' => $eventClass]
            );
        }
        
        return $card->render();
    }
    
    private function renderRecentActivities(): string {
        $card = new ListCard('Activités récentes', [
            'headerActions' => [
                ['label' => 'Voir tout', 'url' => '/chef_classe/activites', 'icon' => 'fas fa-arrow-right']
            ]
        ]);
        
        foreach ($this->recentActivities as $activity) {
            $card->addItem(
                $activity['type'],
                $activity['description'] . ' - ' . $activity['student'] . ' - ' . $activity['time'],
                '#',
                [
                    ['icon' => 'fas fa-eye', 'title' => 'Voir détails'],
                    ['icon' => 'fas fa-share', 'title' => 'Partager']
                ]
            );
        }
        
        return $card->render();
    }
    
    private function renderQuickActions(): string {
        $card = new Card('Actions rapides');
        
        $actions = '
        <div class="grid grid-cols-2 gap-3">
            <button onclick="window.location.href=\'/chef_classe/evaluations/notes\'" 
                    class="p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-center transition-colors">
                <i class="fas fa-edit text-blue-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Valider notes</p>
            </button>
            <button onclick="window.location.href=\'/chef_classe/communication/reunions\'" 
                    class="p-4 bg-green-50 hover:bg-green-100 rounded-lg text-center transition-colors">
                <i class="fas fa-users text-green-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Planifier réunion</p>
            </button>
            <button onclick="window.location.href=\'/chef_classe/eleves/absences\'" 
                    class="p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg text-center transition-colors">
                <i class="fas fa-calendar-times text-yellow-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Gérer absences</p>
            </button>
            <button onclick="window.location.href=\'/chef_classe/rapports/classe\'" 
                    class="p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-center transition-colors">
                <i class="fas fa-file-alt text-purple-600 text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Rapport classe</p>
            </button>
        </div>';
        
        $card->addChild($actions);
        return $card->render();
    }
}

// Vérification de l'authentification
AuthMiddleware::requireRole(['chef_classe']);

// Rendu du dashboard
$dashboard = new ChefClasseDashboard();
echo $dashboard->render();
