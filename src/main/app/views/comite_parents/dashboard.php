<?php
/**
 * Dashboard Comité des Parents - Version Standalone
 * Design moderne pour la gestion parentale
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Mme. Marie Kalala',
    'role' => 'comite_parents',
    'email' => 'm.kalala@parents.fr',
    'id_utilisateur' => 9,
    'poste' => 'Présidente du Comité',
    'classe_enfant' => 'Terminale S',
    'telephone' => '+243 82 34 56 789'
];

// Classes de base intégrées
class Component {
    protected $options;
    
    public function __construct(array $options = []) {
        $this->options = $options;
    }
    

    public function render(): string {
        return '';
    }
}

class AuthMiddleware {
    public static function requireRole($roles) {
        return true;
    }
    
    public static function getUser() {
        global $user;
        return $user;
    }
}

class DashboardContentFactory {
    public static function getComiteParentsContent() {
        return [
            'stats_config' => [
                'membres_actifs' => [
                    'label' => 'Membres actifs',
                    'icon' => 'fas fa-users',
                    'color' => 'blue'
                ],
                'reunions_ce_mois' => [
                    'label' => 'Réunions ce mois',
                    'icon' => 'fas fa-calendar-check',
                    'color' => 'green'
                ],
                'projets_en_cours' => [
                    'label' => 'Projets en cours',
                    'icon' => 'fas fa-project-diagram',
                    'color' => 'purple'
                ],
                'fonds_collectes' => [
                    'label' => 'Fonds collectés (30j)',
                    'icon' => 'fas fa-coins',
                    'color' => 'yellow'
                ],
                'messages_parents' => [
                    'label' => 'Messages parents',
                    'icon' => 'fas fa-envelope',
                    'color' => 'orange'
                ],
                'evenements_prevus' => [
                    'label' => 'Événements à venir',
                    'icon' => 'fas fa-calendar-day',
                    'color' => 'red'
                ]
            ],
            'meetings_data' => [
                [
                    'title' => 'Réunion mensuelle du comité',
                    'date' => '2024-01-20',
                    'time' => '18:00 - 20:00',
                    'location' => 'Salle des professeurs',
                    'type' => 'mensuel',
                    'participants' => '12/15',
                    'status' => 'confirmée'
                ],
                [
                    'title' => 'Assemblée générale annuelle',
                    'date' => '2024-01-25',
                    'time' => '15:00 - 17:00',
                    'location' => 'Amphithéâtre principal',
                    'type' => 'general',
                    'participants' => '45/60',
                    'status' => 'planifiée'
                ],
                [
                    'title' => 'Réunion commission budget',
                    'date' => '2024-02-02',
                    'time' => '17:00 - 19:00',
                    'location' => 'Salle B201',
                    'type' => 'budget',
                    'participants' => '8/10',
                    'status' => 'planifiée'
                ],
                [
                    'title' => 'Réunion projets éducatifs',
                    'date' => '2024-02-10',
                    'time' => '16:00 - 18:00',
                    'location' => 'Salle des parents',
                    'type' => 'projet',
                    'participants' => '6/8',
                    'status' => 'à confirmer'
                ]
            ],
            'projects_data' => [
                [
                    'name' => 'Rénovation bibliothèque',
                    'progress' => 75,
                    'budget' => '500.000 FC',
                    'deadline' => '15/03/2024',
                    'status' => 'en_cours',
                    'responsible' => 'M. Mbayo'
                ],
                [
                    'name' => 'Équipement informatique',
                    'progress' => 45,
                    'budget' => '1.200.000 FC',
                    'deadline' => '20/04/2024',
                    'status' => 'en_cours',
                    'responsible' => 'Mme. Kanku'
                ],
                [
                    'name' => 'Amélioration cantine',
                    'progress' => 90,
                    'budget' => '800.000 FC',
                    'deadline' => '28/02/2024',
                    'status' => 'en_cours',
                    'responsible' => 'M. Tshibanda'
                ],
                [
                    'name' => 'Terrain de sport',
                    'progress' => 20,
                    'budget' => '2.000.000 FC',
                    'deadline' => '30/06/2024',
                    'status' => 'planification',
                    'responsible' => 'M. Mukendi'
                ]
            ],
            'communications_data' => [
                [
                    'type' => 'Message parent',
                    'sender' => 'Jean Mukendi',
                    'subject' => 'Demande information frais scolaires',
                    'date' => 'Aujourd\'hui, 09:15',
                    'priority' => 'normal',
                    'status' => 'non_lu'
                ],
                [
                    'type' => 'Annonce officielle',
                    'sender' => 'Direction École',
                    'subject' => 'Nouvelles procédures d\'inscription 2024',
                    'date' => 'Hier, 14:30',
                    'priority' => 'high',
                    'status' => 'lu'
                ],
                [
                    'type' => 'Rappel paiement',
                    'sender' => 'Secrétariat',
                    'subject' => 'Paiement cotisations - Dernier rappel',
                    'date' => 'Hier, 11:45',
                    'priority' => 'medium',
                    'status' => 'lu'
                ],
                [
                    'type' => 'Invitation réunion',
                    'sender' => 'Comité des Parents',
                    'subject' => 'Réunion exceptionnelle - Sécurité scolaire',
                    'date' => '12/01/2024',
                    'priority' => 'high',
                    'status' => 'lu'
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Nouvelle réunion',
                    'icon' => 'fas fa-plus-circle',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Nouveau projet',
                    'icon' => 'fas fa-project-diagram',
                    'color' => 'green',
                    'link' => '#'
                ],
                [
                    'title' => 'Gestion cotisations',
                    'icon' => 'fas fa-coins',
                    'color' => 'yellow',
                    'link' => '#'
                ],
                [
                    'title' => 'Nouvelle annonce',
                    'icon' => 'fas fa-bullhorn',
                    'color' => 'purple',
                    'link' => '#'
                ]
            ]
        ];
    }
}

class SimpleFooter {
    public function render(): string {
        return '
        <footer class="bg-white border-t border-gray-200 py-6 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-hands-helping text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 Comité des Parents</p>
                            <p class="text-xs text-gray-500">Collaboration École-Famille v3.2</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-phone mr-1"></i> Contact
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-file-contract mr-1"></i> Statuts
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-question-circle mr-1"></i> FAQ
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Comité des Parents - Version Standalone Améliorée
 */
class ComiteParentsDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getComiteParentsContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comité des Parents - Dashboard</title>
            
            <!-- Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                'primary': {
                                    50: '#eff6ff',
                                    100: '#dbeafe',
                                    500: '#3b82f6',
                                    600: '#2563eb',
                                    700: '#1d4ed8',
                                },
                                'community': {
                                    50: '#f0f9ff',
                                    100: '#e0f2fe',
                                    500: '#0ea5e9',
                                    600: '#0284c7',
                                    700: '#0369a1',
                                }
                            },
                            animation: {
                                'fade-in-up': 'fadeInUp 0.6s ease-out',
                                'fade-in': 'fadeIn 0.8s ease-out',
                                'slide-in-right': 'slideInRight 0.5s ease-out',
                                'pulse-subtle': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                            }
                        }
                    }
                }
            </script>
            
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            
            <!-- Google Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                .heading {
                    font-family: 'Poppins', sans-serif;
                    font-weight: 600;
                }
                
                body {
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    min-height: 100vh;
                    color: #000000;
                    font-size: 14px;
                }
                
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                
                @keyframes slideInRight {
                    from {
                        opacity: 0;
                        transform: translateX(-20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }
                
                .glass-card {
                    background: rgba(255, 255, 255, 0.95);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.3);
                }
                
                .hover-lift {
                    transition: all 0.3s ease;
                }
                
                .hover-lift:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }
                
                .gradient-text {
                    background: linear-gradient(135deg, #2563eb 0%, #0d9488 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #1e3a8a 0%, #0f766e 100%);
                }
                
                .stat-card {
                    position: relative;
                    overflow: hidden;
                }
                
                .stat-card::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 100px;
                    height: 100px;
                    background: linear-gradient(135deg, currentColor 0%, transparent 70%);
                    opacity: 0.1;
                    border-radius: 0 0 0 100px;
                }
                
                .meeting-card {
                    transition: all 0.3s ease;
                }
                
                .meeting-card:hover {
                    transform: scale(1.02);
                }
                
                .progress-bar {
                    transition: width 1s ease-in-out;
                }
                
                .project-highlight {
                    border-left: 4px solid #10b981;
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-green-500 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-hands-helping text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Comité des Parents</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['poste']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600">Enfant: <?php echo htmlspecialchars($this->user['classe_enfant']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Community Button -->
                            <button class="hidden md:flex px-4 py-2 bg-gradient-to-r from-blue-500 to-green-500 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-opacity items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>Communauté</span>
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-3 h-3 bg-orange-500 rounded-full"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Représentante parentale</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">Tél: <?php echo htmlspecialchars($this->user['telephone']); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-tie mr-3 text-blue-600"></i>
                                        Mon Profil Parent
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-child mr-3 text-green-600"></i>
                                        Fiche de mon enfant
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-file-alt mr-3 text-orange-600"></i>
                                        Mes contributions
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Déconnexion
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex min-h-[calc(100vh-74px)]">
                <!-- Sidebar -->
                <aside class="sidebar w-64 text-black  hidden md:block fixed top-[74px] left-0 h-[calc(100vh-74px)] z-40 overflow-y-auto">
                    <div class="p-6 bg-white">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-green-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Collaboration</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-users', 'label' => 'Réunions', 'badge' => '4'],
                                ['icon' => 'fas fa-project-diagram', 'label' => 'Projets', 'badge' => '4'],
                                ['icon' => 'fas fa-dollar-sign', 'label' => 'Finances', 'badge' => '12'],
                                ['icon' => 'fas fa-user-friends', 'label' => 'Membres', 'badge' => '15'],
                                ['icon' => 'fas fa-comments', 'label' => 'Communication', 'badge' => '8'],
                                ['icon' => 'fas fa-calendar-day', 'label' => 'Événements', 'badge' => '3'],
                                ['icon' => 'fas fa-chart-bar', 'label' => 'Rapports', 'badge' => ''],
                                ['icon' => 'fas fa-cog', 'label' => 'Paramètres', 'badge' => '']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-black/10 shadow-inner' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3 text-black"></i>
                                <span class="flex-1 text-black"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Progress -->
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-2">Participation communautaire</p>
                                <div class="w-full bg-black/20 rounded-full h-2 mb-2">
                                    <div class="bg-green-400 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <p class="text-xs text-black/60">Très bon engagement</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-600 to-green-500 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-64">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 heading mb-2">
                                    Collaboration <span class="gradient-text">École-Famille</span>
                                </h1>
                                <p class="text-gray-600">
                                    <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1];
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-clock text-green-600 mr-1"></i>
                                    <span class="time-display font-medium"><?php echo date('H:i'); ?></span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>Engagement: 85%</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-green-500 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-handshake mr-2"></i>
                                    Proposer idée
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'membres_actifs' => '15',
                            'reunions_ce_mois' => '4',
                            'projets_en_cours' => '4',
                            'fonds_collectes' => '2.450.000 FC',
                            'messages_parents' => '8',
                            'evenements_prevus' => '3'
                        ];
                        
                        if (isset($content['stats_config'])) {
                            foreach($content['stats_config'] as $key => $stat): 
                                $value = $statsValues[$key] ?? '0';
                        ?>
                        <div class="stat-card bg-white rounded-xl shadow-md border border-gray-200 p-5 hover-lift animate-fade-in-up" style="animation-delay: <?php echo array_search($key, array_keys($content['stats_config'])) * 0.1; ?>s">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1"><?php echo $stat['label']; ?></p>
                                    <p class="text-2xl font-bold text-gray-900 heading"><?php echo $value; ?></p>
                                </div>
                                <div class="p-3 rounded-xl bg-gradient-to-br from-<?php echo $stat['color']; ?>-500 to-<?php echo $stat['color']; ?>-600 shadow-md">
                                    <i class="<?php echo $stat['icon']; ?> text-white text-lg"></i>
                                </div>
                            </div>
                            <?php if(in_array($key, ['fonds_collectes', 'projets_en_cours'])): ?>
                            <div class="mt-4 pt-3 border-t border-<?php echo $stat['color']; ?>-100">
                                <p class="text-xs font-medium text-<?php echo $stat['color']; ?>-700 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <?php echo rand(5, 20); ?>% vs mois dernier
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php 
                            endforeach;
                        } else {
                            echo '<div class="col-span-6 p-4 text-center text-gray-500">Indicateurs non disponibles</div>';
                        }
                        ?>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Réunions à venir -->
                        <div class="lg:col-span-2">
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                            Réunions à Venir
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Prochaines rencontres du comité</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                        Calendrier complet
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php 
                                    if (isset($content['meetings_data']) && is_array($content['meetings_data'])) {
                                        foreach($content['meetings_data'] as $index => $meeting): 
                                            $isToday = ($meeting['date'] === date('Y-m-d'));
                                    ?>
                                    <div class="meeting-card flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition-all animate-slide-in-right <?php echo $isToday ? 'bg-blue-50' : 'bg-white'; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 <?php echo $isToday ? 'bg-blue-100' : 'bg-gray-100'; ?>">
                                                <span class="text-lg font-bold text-gray-900"><?php echo date('d', strtotime($meeting['date'])); ?></span>
                                                <span class="text-xs text-gray-600"><?php echo date('M', strtotime($meeting['date'])); ?></span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($meeting['title']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-clock mr-1.5 text-gray-400"></i>
                                                        <?php echo $meeting['time']; ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($meeting['location']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-sm font-medium text-gray-900"><?php echo $meeting['participants']; ?> participants</span>
                                            <span class="mt-1 px-3 py-1 bg-<?php echo match($meeting['status']) {
                                                'confirmée' => 'green',
                                                'planifiée' => 'blue',
                                                default => 'yellow'
                                            }; ?>-100 text-<?php echo match($meeting['status']) {
                                                'confirmée' => 'green',
                                                'planifiée' => 'blue',
                                                default => 'yellow'
                                            }; ?>-800 text-xs font-medium rounded-full">
                                                <?php echo $meeting['status']; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune réunion planifiée</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Projets en cours -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-project-diagram text-purple-600 mr-2"></i>
                                        Projets Communautaires
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center">
                                        Détails
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['projects_data']) && is_array($content['projects_data'])) {
                                        foreach($content['projects_data'] as $index => $project): 
                                            $progressColor = $project['progress'] >= 75 ? 'green' : 
                                                            ($project['progress'] >= 50 ? 'yellow' : 'red');
                                    ?>
                                    <div class="p-4 rounded-lg border-l-4 border-<?php echo $progressColor; ?>-500 bg-gradient-to-r from-gray-50 to-white animate-slide-in-right <?php echo $project['progress'] >= 75 ? 'project-highlight' : ''; ?>" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($project['name']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1">Responsable: <?php echo htmlspecialchars($project['responsible']); ?></p>
                                            </div>
                                            <span class="text-lg font-bold text-<?php echo $progressColor; ?>-700"><?php echo $project['progress']; ?>%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                            <div class="progress-bar bg-gradient-to-r from-<?php echo $progressColor; ?>-500 to-<?php echo $progressColor; ?>-600 h-2 rounded-full" style="width: <?php echo $project['progress']; ?>%"></div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span>Budget: <?php echo $project['budget']; ?></span>
                                            <span>Échéance: <?php echo $project['deadline']; ?></span>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun projet en cours</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Communications récentes -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-comments text-orange-600 mr-2"></i>
                                    Communications Récentes
                                </h3>
                                <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-800 flex items-center">
                                    Boîte de réception
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php 
                                if (isset($content['communications_data']) && is_array($content['communications_data'])) {
                                    foreach($content['communications_data'] as $comm): 
                                        $priorityColor = match($comm['priority']) {
                                            'high' => 'red',
                                            'medium' => 'orange',
                                            default => 'green'
                                        };
                                ?>
                                <div class="flex items-start p-4 rounded-lg border-l-4 border-<?php echo $priorityColor; ?>-500 bg-gradient-to-r from-gray-50 to-white hover:border-<?php echo $priorityColor; ?>-600 transition-colors">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 <?php echo $comm['status'] === 'non_lu' ? 'bg-orange-100' : 'bg-gray-100'; ?> rounded-full flex items-center justify-center">
                                            <i class="fas fa-<?php echo match($comm['type']) { 
                                                'Message parent' => 'envelope', 
                                                'Annonce officielle' => 'bullhorn',
                                                'Rappel paiement' => 'bell',
                                                default => 'calendar-alt' 
                                            }; ?> text-<?php echo $priorityColor; ?>-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($comm['type']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($comm['subject']); ?></p>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <?php if($comm['status'] === 'non_lu'): ?>
                                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full mb-1">
                                                    Nouveau
                                                </span>
                                                <?php endif; ?>
                                                <p class="text-xs text-gray-400"><?php echo $comm['date']; ?></p>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-2">De: <?php echo htmlspecialchars($comm['sender']); ?></p>
                                    </div>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucune communication récente</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Actions rapides -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-bolt text-purple-600 mr-2"></i>
                                    Actions Collaboratives
                                </h3>
                                <span class="text-xs text-gray-500">Participation active</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php 
                                if (isset($content['quick_actions']) && is_array($content['quick_actions'])) {
                                    foreach($content['quick_actions'] as $action): 
                                ?>
                                <a href="<?php echo $action['link'] ?? '#'; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color'] ?? 'blue'; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color'] ?? 'blue'; ?>-500 to-<?php echo $action['color'] ?? 'blue'; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
                                        <i class="<?php echo $action['icon'] ?? 'fas fa-question'; ?> text-white text-xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 text-center group-hover:text-<?php echo $action['color'] ?? 'blue'; ?>-700">
                                        <?php echo htmlspecialchars($action['title'] ?? 'Action'); ?>
                                    </span>
                                </a>
                                <?php 
                                    endforeach;
                                } else {
                                    $defaultActions = [
                                        ['title' => 'Nouvelle réunion', 'icon' => 'fas fa-plus-circle', 'color' => 'blue', 'link' => '#'],
                                        ['title' => 'Nouveau projet', 'icon' => 'fas fa-project-diagram', 'color' => 'green', 'link' => '#'],
                                        ['title' => 'Gestion cotisations', 'icon' => 'fas fa-coins', 'color' => 'yellow', 'link' => '#'],
                                        ['title' => 'Nouvelle annonce', 'icon' => 'fas fa-bullhorn', 'color' => 'purple', 'link' => '#'],
                                    ];
                                    
                                    foreach($defaultActions as $action):
                                ?>
                                <a href="<?php echo $action['link']; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color']; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color']; ?>-500 to-<?php echo $action['color']; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
                                        <i class="<?php echo $action['icon']; ?> text-white text-xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 text-center group-hover:text-<?php echo $action['color']; ?>-700">
                                        <?php echo htmlspecialchars($action['title']); ?>
                                    </span>
                                </a>
                                <?php 
                                    endforeach;
                                }
                                ?>
                            </div>
                            
                            <!-- Community Poll -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="p-4 bg-gradient-to-r from-blue-50 to-green-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-poll text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">Sondage communautaire</p>
                                            <p class="text-xs text-gray-600">Priorités pour le trimestre</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 mt-3">
                                        <button class="px-3 py-2 bg-white text-blue-700 text-xs rounded border border-blue-300 hover:bg-blue-50 transition-colors">
                                            Sécurité scolaire
                                        </button>
                                        <button class="px-3 py-2 bg-gradient-to-r from-blue-500 to-green-500 text-white text-xs rounded hover:opacity-90 transition-opacity">
                                            Équipement sportif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <!-- Footer -->
            <?php 
            $footer = new SimpleFooter();
            echo $footer->render();
            ?>

            <script>
                // Toggle user menu
                function toggleUserMenu() {
                    const menu = document.getElementById('userMenu');
                    menu.classList.toggle('hidden');
                }
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    const menu = document.getElementById('userMenu');
                    const button = event.target.closest('button[onclick="toggleUserMenu()"]');
                    
                    if (!button && menu && !menu.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
                
                // Mobile menu toggle
                const mobileMenuToggle = document.getElementById('mobileMenuToggle');
                const sidebar = document.querySelector('aside');
                
                if (mobileMenuToggle && sidebar) {
                    mobileMenuToggle.addEventListener('click', () => {
                        sidebar.classList.toggle('hidden');
                        sidebar.classList.toggle('fixed');
                        sidebar.classList.toggle('inset-0');
                        sidebar.classList.toggle('z-50');
                    });
                }
                
                // Community button
                const communityBtn = document.querySelector('[class*="Communauté"]');
                if (communityBtn) {
                    communityBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        alert('🤝 Espace Communauté\n\nConnectez-vous avec d\'autres parents et échangez des idées.');
                    });
                }
                
                // Poll buttons
                document.querySelectorAll('button:contains("Sécurité scolaire"), button:contains("Équipement sportif")').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const choice = this.textContent.trim();
                        alert(`🗳️ Merci pour votre vote!\n\nVous avez choisi: ${choice}\n\nLes résultats seront publiés dans 48h.`);
                    });
                });
                
                // Animate progress bars on load
                document.addEventListener('DOMContentLoaded', function() {
                    const bars = document.querySelectorAll('.progress-bar');
                    bars.forEach(bar => {
                        const originalWidth = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = originalWidth;
                        }, 300);
                    });
                });
                
                // Mark communications as read
                document.querySelectorAll('.bg-orange-100').forEach(comm => {
                    comm.addEventListener('click', function() {
                        if (this.querySelector('.text-orange-800')) {
                            this.classList.remove('bg-orange-100');
                            this.classList.add('bg-gray-100');
                            const badge = this.querySelector('.text-orange-800');
                            if (badge) badge.remove();
                        }
                    });
                });
                
                // Live time update
                function updateTime() {
                    const now = new Date();
                    const timeElement = document.querySelector('.time-display');
                    if (timeElement) {
                        const timeString = now.toLocaleTimeString('fr-FR', { 
                            hour: '2-digit', 
                            minute: '2-digit',
                            hour12: false 
                        });
                        timeElement.textContent = timeString;
                    }
                }
                
                // Update every minute
                setInterval(updateTime, 60000);
                
                // Initial update
                updateTime();
                
                // Idea proposal button
                const ideaBtn = document.querySelector('[class*="Proposer idée"]');
                if (ideaBtn) {
                    ideaBtn.addEventListener('click', () => {
                        const idea = prompt('💡 Proposez une idée pour améliorer l\'école:\n\n(Votre suggestion sera soumise au comité)');
                        if (idea && idea.trim()) {
                            alert('✅ Idée soumise avec succès!\n\nMerci pour votre contribution à la communauté.');
                        }
                    });
                }
                
                // Meeting hover effects
                document.querySelectorAll('.meeting-card').forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.boxShadow = '0 8px 15px -3px rgba(0, 0, 0, 0.1)';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.boxShadow = '';
                    });
                });
                
                // Highlight today's meetings
                function highlightTodayMeetings() {
                    const today = new Date();
                    const todayStr = today.toISOString().split('T')[0];
                    
                    document.querySelectorAll('.bg-blue-50').forEach(el => {
                        el.classList.remove('bg-blue-50');
                        el.classList.add('bg-white');
                    });
                    
                    document.querySelectorAll('[class*="bg-white"]').forEach(el => {
                                        const dateElement = el.querySelector('span.text-lg');
                                        if (dateElement) {
                                            const day = parseInt(dateElement.textContent);
                                            const month = today.getMonth() + 1;
                                            const monthStr = month < 10 ? '0' + month : month;
                                            const dayStr = day < 10 ? '0' + day : day;
                                            const elementDate = `${today.getFullYear()}-${monthStr}-${dayStr}`;
                                            
                                            if (elementDate === todayStr) {
                                                el.classList.add('bg-blue-50');
                                                el.classList.remove('bg-white');
                                            }
                                        }
                                    });
                                }
                
                // Initial highlight
                highlightTodayMeetings();
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new ComiteParentsDashboardStandalone();
echo $dashboard->render();
?>