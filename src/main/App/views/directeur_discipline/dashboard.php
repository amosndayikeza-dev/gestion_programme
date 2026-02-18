<?php
/**
 * Dashboard Directeur de Discipline - Version Standalone
 * Design moderne pour la gestion disciplinaire
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'M. Augustin Mbayo',
    'role' => 'directeur_discipline',
    'email' => 'a.mbayo@ecole.fr',
    'id_utilisateur' => 7,
    'titre' => 'Directeur de Discipline',
    'annee_experience' => 12,
    'telephone' => '+243 81 23 45 678'
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
    public static function getDirecteurDisciplineContent() {
        return [
            'stats_config' => [
                'cas_en_attente' => [
                    'label' => 'Cas en attente',
                    'icon' => 'fas fa-clock',
                    'color' => 'orange'
                ],
                'cas_traites' => [
                    'label' => 'Cas traités (30j)',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'green'
                ],
                'retards_ce_mois' => [
                    'label' => 'Retards ce mois',
                    'icon' => 'fas fa-hourglass-half',
                    'color' => 'yellow'
                ],
                'absences_ce_mois' => [
                    'label' => 'Absences ce mois',
                    'icon' => 'fas fa-calendar-times',
                    'color' => 'red'
                ],
                'sanctions_appliquees' => [
                    'label' => 'Sanctions appliquées',
                    'icon' => 'fas fa-gavel',
                    'color' => 'purple'
                ],
                'cas_urgents' => [
                    'label' => 'Cas urgents',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'red'
                ]
            ],
            'urgent_cases' => [
                [
                    'student' => 'François Mbuyu',
                    'type' => 'Violence',
                    'description' => 'Agression verbale contre un camarade',
                    'date' => 'Aujourd\'hui, 10:30',
                    'priority' => 'high',
                    'teacher' => 'M. Lumbu',
                    'classe' => 'Terminale S'
                ],
                [
                    'student' => 'Grace Nkulu',
                    'type' => 'Triche',
                    'description' => 'Copie lors de l\'examen final',
                    'date' => 'Hier, 14:15',
                    'priority' => 'high',
                    'teacher' => 'Mme. Kanku',
                    'classe' => 'Première ES'
                ],
                [
                    'student' => 'David Kabasele',
                    'type' => 'Substance',
                    'description' => 'Introduction d\'objet prohibé',
                    'date' => 'Hier, 09:45',
                    'priority' => 'high',
                    'teacher' => 'M. Tshibanda',
                    'classe' => 'Seconde'
                ]
            ],
            'recent_cases' => [
                [
                    'student' => 'Jean Mukendi',
                    'type' => 'Retard',
                    'description' => 'Retard de 15 minutes en cours de maths',
                    'date' => '15/01/2024',
                    'status' => 'en_attente',
                    'teacher' => 'M. Dupont',
                    'severity' => 'low'
                ],
                [
                    'student' => 'Marie Kalonji',
                    'type' => 'Absence',
                    'description' => 'Absence non justifiée - cours de français',
                    'date' => '14/01/2024',
                    'status' => 'en_attente',
                    'teacher' => 'M. Bernard',
                    'severity' => 'medium'
                ],
                [
                    'student' => 'Pierre Kabeya',
                    'type' => 'Indiscipline',
                    'description' => 'Bavardage répété en classe',
                    'date' => '13/01/2024',
                    'status' => 'traite',
                    'teacher' => 'Mme. Martin',
                    'severity' => 'low'
                ],
                [
                    'student' => 'Sophie Tshibanda',
                    'type' => 'Triche',
                    'description' => 'Tentative de triche lors de l\'examen',
                    'date' => '12/01/2024',
                    'status' => 'en_attente',
                    'teacher' => 'M. Petit',
                    'severity' => 'high'
                ]
            ],
            'sanctions_data' => [
                [
                    'type' => 'Avertissement verbal',
                    'count' => 15,
                    'percentage' => 45,
                    'color' => 'blue'
                ],
                [
                    'type' => 'Avertissement écrit',
                    'count' => 10,
                    'percentage' => 30,
                    'color' => 'yellow'
                ],
                [
                    'type' => 'Exclusion temporaire',
                    'count' => 5,
                    'percentage' => 15,
                    'color' => 'orange'
                ],
                [
                    'type' => 'Tâches d\'intérêt général',
                    'count' => 3,
                    'percentage' => 10,
                    'color' => 'red'
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Nouveau cas',
                    'icon' => 'fas fa-plus-circle',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Rapport mensuel',
                    'icon' => 'fas fa-chart-bar',
                    'color' => 'green',
                    'link' => '#'
                ],
                [
                    'title' => 'Convocations',
                    'icon' => 'fas fa-envelope-open-text',
                    'color' => 'purple',
                    'link' => '#'
                ],
                [
                    'title' => 'Fiches élèves',
                    'icon' => 'fas fa-id-card',
                    'color' => 'yellow',
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
                        <div class="w-8 h-8 bg-gradient-to-br from-red-600 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-gavel text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 Commission de Discipline</p>
                            <p class="text-xs text-gray-500">Système de Gestion Disciplinaire v3.5</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-book mr-1"></i> Règlement
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-phone mr-1"></i> Urgence
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-shield-alt mr-1"></i> Confidentialité
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Directeur de Discipline - Version Standalone Améliorée
 */
class DirecteurDisciplineDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getDirecteurDisciplineContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Direction de Discipline - Dashboard</title>
            
            <!-- Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                'primary': {
                                    50: '#fef2f2',
                                    100: '#fee2e2',
                                    500: '#ef4444',
                                    600: '#dc2626',
                                    700: '#b91c1c',
                                },
                                'discipline': {
                                    50: '#fff7ed',
                                    100: '#ffedd5',
                                    500: '#f97316',
                                    600: '#ea580c',
                                    700: '#c2410c',
                                }
                            },
                            animation: {
                                'fade-in-up': 'fadeInUp 0.6s ease-out',
                                'fade-in': 'fadeIn 0.8s ease-out',
                                'slide-in-right': 'slideInRight 0.5s ease-out',
                                'pulse-urgent': 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                .heading {
                    font-family: 'Merriweather', serif;
                    font-weight: 700;
                }
                
                body {
                    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    min-height: 100vh;
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
                
                @keyframes blink {
                    0%, 100% { opacity: 1; }
                    50% { opacity: 0.5; }
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
                    background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #b91c1c 0%, #7f1d1d 100%);
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
                
                .urgent-case {
                    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
                    border-left: 4px solid #ef4444;
                    animation: pulse-urgent 1.5s infinite;
                }
                
                .case-low { border-left: 4px solid #10b981; }
                .case-medium { border-left: 4px solid #f59e0b; }
                .case-high { border-left: 4px solid #ef4444; }
                
                .sanction-bar {
                    transition: width 1s ease-in-out;
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-orange-500 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-gavel text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Direction de Discipline</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['titre']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['annee_experience']); ?> ans d'expérience</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Emergency Alert -->
                            <button class="relative px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-opacity flex items-center">
                                <i class="fas fa-siren mr-2"></i>
                                <span>ALERTE</span>
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full animate-pulse-urgent"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Direction de Discipline</p>
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
                                        <i class="fas fa-user-tie mr-3 text-red-600"></i>
                                        Mon Profil Professionnel
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-key mr-3 text-blue-600"></i>
                                        Sécurité & Accès
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-folder-open mr-3 text-orange-600"></i>
                                        Archives disciplinaires
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
                <aside class="sidebar w-64 text-white hidden md:block fixed top-[74px] left-0 h-[calc(100vh-74px)] z-40 overflow-y-auto">
                    <div class="p-6 bg-white text-black">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-orange-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Directeur Discipline</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-exclamation-triangle', 'label' => 'Cas en attente', 'badge' => '8'],
                                ['icon' => 'fas fa-gavel', 'label' => 'Sanctions', 'badge' => '15'],
                                ['icon' => 'fas fa-users', 'label' => 'Élèves suivis', 'badge' => '12'],
                                ['icon' => 'fas fa-chart-bar', 'label' => 'Statistiques', 'badge' => ''],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'badge' => '3'],
                                ['icon' => 'fas fa-comments', 'label' => 'Convocations', 'badge' => '5'],
                                ['icon' => 'fas fa-archive', 'label' => 'Archives', 'badge' => ''],
                                ['icon' => 'fas fa-book', 'label' => 'Règlement', 'badge' => '']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-white/10 shadow-inner' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3"></i>
                                <span class="flex-1"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Stats -->
                        <div class="mt-2 pt-2 border-t border-white/10">
                            <div class="px-2 py-2 bg-white/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-2">Sévérité ce mois</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <p class="text-xs text-black/60">Moyenne: 2.8/5</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-red-600 to-orange-500 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-64">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 heading mb-2">
                                    Tribunal <span class="gradient-text">Disciplinaire</span>
                                </h1>
                                <p class="text-gray-600">
                                    <i class="fas fa-calendar-day text-red-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1];
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-clock text-orange-600 mr-1"></i>
                                    <span class="time-display font-medium"><?php echo date('H:i'); ?></span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-red-50 text-red-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <span>3 cas urgents</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Nouveau dossier
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Urgent Cases Alert -->
                    <?php if(isset($content['urgent_cases']) && !empty($content['urgent_cases'])): ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <?php foreach($content['urgent_cases'] as $index => $case): ?>
                        <div class="urgent-case rounded-lg p-4 border border-red-300 animate-fade-in-up" style="animation-delay: <?php echo $index * 0.1; ?>s">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-red-800"><?php echo htmlspecialchars($case['type']); ?> - URGENT</h4>
                                    <p class="text-red-700 text-sm mt-1 font-medium"><?php echo htmlspecialchars($case['student']); ?></p>
                                    <p class="text-red-600 text-xs mt-1"><?php echo htmlspecialchars($case['classe']); ?> • <?php echo htmlspecialchars($case['teacher']); ?></p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-red-600"><?php echo $case['date']; ?></span>
                                        <button onclick="handleUrgentCase('<?php echo htmlspecialchars($case['student']); ?>')" 
                                                class="px-3 py-1 bg-gradient-to-r from-red-600 to-orange-500 text-white text-xs rounded hover:opacity-90 transition-opacity">
                                            Traiter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'cas_en_attente' => '8',
                            'cas_traites' => '15',
                            'retards_ce_mois' => '23',
                            'absences_ce_mois' => '17',
                            'sanctions_appliquees' => '12',
                            'cas_urgents' => '3'
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
                            <?php if(in_array($key, ['cas_en_attente', 'cas_urgents'])): ?>
                            <div class="mt-4 pt-3 border-t border-red-100">
                                <p class="text-xs font-medium text-red-700 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Action requise
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
                        <!-- Cas récents -->
                        <div class="lg:col-span-2">
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-folder-open text-blue-600 mr-2"></i>
                                            Dossiers Récents
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Derniers cas disciplinaires</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                        Tous les dossiers
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php 
                                    if (isset($content['recent_cases']) && is_array($content['recent_cases'])) {
                                        foreach($content['recent_cases'] as $index => $case): 
                                            $severityClass = 'case-' . $case['severity'];
                                            $statusBadge = $case['status'] === 'en_attente' ? 
                                                '<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">En attente</span>' : 
                                                '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Traité</span>';
                                    ?>
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-<?php echo $case['severity'] === 'high' ? 'red' : ($case['severity'] === 'medium' ? 'orange' : 'green'); ?>-300 transition-all animate-slide-in-right <?php echo $severityClass; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 <?php echo $case['severity'] === 'high' ? 'bg-red-100' : ($case['severity'] === 'medium' ? 'bg-yellow-100' : 'bg-green-100'); ?>">
                                                <i class="fas fa-<?php echo match($case['type']) {
                                                    'Retard' => 'hourglass-half',
                                                    'Absence' => 'calendar-times',
                                                    'Violence' => 'fist-raised',
                                                    'Triche' => 'copy',
                                                    default => 'exclamation-circle'
                                                }; ?> text-<?php echo $case['severity'] === 'high' ? 'red' : ($case['severity'] === 'medium' ? 'yellow' : 'green'); ?>-600"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($case['student']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-tag mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($case['type']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-user-tie mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($case['teacher']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <div class="mb-2"><?php echo $statusBadge; ?></div>
                                            <div class="text-xs text-gray-500"><?php echo $case['date']; ?></div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun dossier disponible</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sanctions répartition -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
                                        Sanctions appliquées
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center">
                                        Statistiques
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['sanctions_data']) && is_array($content['sanctions_data'])) {
                                        foreach($content['sanctions_data'] as $index => $sanction): 
                                    ?>
                                    <div class="animate-slide-in-right" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($sanction['type']); ?></span>
                                            <span class="text-sm font-bold text-gray-900"><?php echo $sanction['count']; ?> (<?php echo $sanction['percentage']; ?>%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="sanction-bar bg-gradient-to-r from-<?php echo $sanction['color']; ?>-500 to-<?php echo $sanction['color']; ?>-600 h-2.5 rounded-full" style="width: <?php echo $sanction['percentage']; ?>%"></div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune donnée de sanctions</div>';
                                    }
                                    ?>
                                </div>
                                
                                <!-- Summary -->
                                <div class="mt-6 pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                                            <div class="text-lg font-bold text-blue-700">85%</div>
                                            <div class="text-xs text-blue-600">Dossiers traités</div>
                                        </div>
                                        <div class="text-center p-3 bg-green-50 rounded-lg">
                                            <div class="text-lg font-bold text-green-700">92%</div>
                                            <div class="text-xs text-green-600">Parents informés</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Actions rapides -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-bolt text-orange-600 mr-2"></i>
                                    Actions Rapides
                                </h3>
                                <span class="text-xs text-gray-500">Accès direct</span>
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
                                        ['title' => 'Nouveau cas', 'icon' => 'fas fa-plus-circle', 'color' => 'blue', 'link' => '#'],
                                        ['title' => 'Rapport mensuel', 'icon' => 'fas fa-chart-bar', 'color' => 'green', 'link' => '#'],
                                        ['title' => 'Convocations', 'icon' => 'fas fa-envelope-open-text', 'color' => 'purple', 'link' => '#'],
                                        ['title' => 'Fiches élèves', 'icon' => 'fas fa-id-card', 'color' => 'yellow', 'link' => '#'],
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
                            
                            <!-- Sanction Levels -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="p-4 bg-gradient-to-r from-red-50 to-orange-50 rounded-lg border border-red-200">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-scale-balanced text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">Niveaux de sévérité</p>
                                            <p class="text-xs text-gray-600">Critères d'évaluation</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 mt-3">
                                        <button class="px-3 py-2 bg-green-100 text-green-800 text-xs rounded border border-green-300 hover:bg-green-200 transition-colors">
                                            Niveau 1
                                        </button>
                                        <button class="px-3 py-2 bg-yellow-100 text-yellow-800 text-xs rounded border border-yellow-300 hover:bg-yellow-200 transition-colors">
                                            Niveau 2
                                        </button>
                                        <button class="px-3 py-2 bg-red-100 text-red-800 text-xs rounded border border-red-300 hover:bg-red-200 transition-colors">
                                            Niveau 3
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Message d'information -->
                        <div class="glass-card rounded-xl shadow-md p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-info-circle text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">Aujourd'hui</h3>
                                    <p class="text-sm text-gray-600">Agenda des audiences</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Audience parents - Mbuyu</h4>
                                            <p class="text-sm text-gray-600 mt-1">Cas: Violence entre élèves</p>
                                        </div>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            14h00 - Salle 101
                                        </span>
                                    </div>
                                    <button class="mt-3 w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm rounded-lg hover:opacity-90 transition-opacity">
                                        <i class="fas fa-calendar-check mr-2"></i>Préparer le dossier
                                    </button>
                                </div>
                                
                                <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Réunion commission</h4>
                                            <p class="text-sm text-gray-600 mt-1">Bilan trimestriel discipline</p>
                                        </div>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                            16h30 - Bureau
                                        </span>
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
                
                // Handle urgent cases
                function handleUrgentCase(studentName) {
                    if (confirm(`🚨 TRAITEMENT URGENT\n\nVoulez-vous traiter le dossier de ${studentName} maintenant?`)) {
                        alert(`Dossier ${studentName} ouvert pour traitement.`);
                        // Ici: Code pour ouvrir le dossier
                    }
                }
                
                // Emergency alert button
                const emergencyBtn = document.querySelector('[class*="ALERTE"]');
                if (emergencyBtn) {
                    emergencyBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const code = prompt('🚨 CODE D\'ALERTE DISCIPLINAIRE\n\nEntrez le code d\'urgence:');
                        if (code === 'RED2024') {
                            alert('🔴 ALERTE GÉNÉRALE ACTIVÉE\nToutes les unités prévenues.');
                        } else if (code) {
                            alert('❌ Code incorrect. Action annulée.');
                        }
                    });
                }
                
                // Sanction levels buttons
                document.querySelectorAll('button:contains("Niveau")').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const level = this.textContent.trim();
                        alert(`Niveau de sévérité: ${level}\n\nCritères appliqués pour l'évaluation disciplinaire.`);
                    });
                });
                
                // Animate sanction bars on load
                document.addEventListener('DOMContentLoaded', function() {
                    const bars = document.querySelectorAll('.sanction-bar');
                    bars.forEach(bar => {
                        const originalWidth = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = originalWidth;
                        }, 300);
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
                
                // New case button
                const newCaseBtn = document.querySelector('[class*="Nouveau dossier"]');
                if (newCaseBtn) {
                    newCaseBtn.addEventListener('click', () => {
                        alert('📁 Ouverture d\'un nouveau dossier disciplinaire\n\nFormulaire de signalement ouvert.');
                    });
                }
                
                // Case severity tooltips
                document.querySelectorAll('.case-low, .case-medium, .case-high').forEach(caseEl => {
                    caseEl.addEventListener('mouseenter', function() {
                        const severity = this.className.includes('high') ? 'Haute' : 
                                        this.className.includes('medium') ? 'Moyenne' : 'Basse';
                        this.setAttribute('title', `Sévérité: ${severity}`);
                    });
                });
                
                // Update urgent cases animation
                const urgentCases = document.querySelectorAll('.urgent-case');
                urgentCases.forEach(caseEl => {
                    setInterval(() => {
                        caseEl.style.animation = 'none';
                        setTimeout(() => {
                            caseEl.style.animation = 'pulse-urgent 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                        }, 10);
                    }, 3000);
                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new DirecteurDisciplineDashboardStandalone();
echo $dashboard->render();
?>