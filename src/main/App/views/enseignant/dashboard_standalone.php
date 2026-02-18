<?php
/**
 * Dashboard Enseignant - Version Standalone
 * Design amélioré avec corrections et meilleure UI
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Dr. Sophie Martin',
    'role' => 'enseignant',
    'email' => 's.martin@ecole.fr',
    'id_utilisateur' => 2,
    'matiere' => 'Mathématiques'
];

// Inclure les composants nécessaires (chemins adaptés)
$basePath = __DIR__;
require_once $basePath . '/../components/Component.php';
require_once $basePath . '/../components/Header.php';
require_once $basePath . '/../components/Sidebar.php';
require_once $basePath . '/../components/Card.php';
require_once $basePath . '/../components/Footer.php';
require_once $basePath . '/../components/DashboardContent.php';

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

// Simuler DashboardContentFactory si nécessaire
if (!class_exists('DashboardContentFactory')) {
    class DashboardContentFactory {
        public static function getEnseignantContent() {
            return [
                'stats_config' => [
                    'total_classes' => [
                        'label' => 'Classes',
                        'icon' => 'fas fa-chalkboard-teacher',
                        'color' => 'indigo'
                    ],
                    'total_eleves' => [
                        'label' => 'Élèves',
                        'icon' => 'fas fa-user-graduate',
                        'color' => 'blue'
                    ],
                    'total_cours' => [
                        'label' => 'Cours cette semaine',
                        'icon' => 'fas fa-book-open',
                        'color' => 'green'
                    ],
                    'notes_a_saisir' => [
                        'label' => 'Notes à saisir',
                        'icon' => 'fas fa-clipboard-check',
                        'color' => 'yellow'
                    ],
                    'devoirs_a_corriger' => [
                        'label' => 'Devoirs à corriger',
                        'icon' => 'fas fa-tasks',
                        'color' => 'orange'
                    ],
                    'messages_non_lus' => [
                        'label' => 'Messages non lus',
                        'icon' => 'fas fa-envelope',
                        'color' => 'purple'
                    ]
                ],
                'classes_data' => [
                    [
                        'name' => 'Terminale S1',
                        'subject' => 'Mathématiques',
                        'students' => '32'
                    ],
                    [
                        'name' => 'Première S2',
                        'subject' => 'Mathématiques',
                        'students' => '28'
                    ],
                    [
                        'name' => 'Seconde 3',
                        'subject' => 'Mathématiques',
                        'students' => '35'
                    ],
                    [
                        'name' => 'Terminale ES',
                        'subject' => 'Spécialité Maths',
                        'students' => '24'
                    ]
                ],
                'schedule_data' => [
                    [
                        'subject' => 'Mathématiques - Terminale S1',
                        'time' => '08:30 - 10:00',
                        'room' => 'Salle 201'
                    ],
                    [
                        'subject' => 'Mathématiques - Première S2',
                        'time' => '10:30 - 12:00',
                        'room' => 'Salle 203'
                    ],
                    [
                        'subject' => 'Réunion pédagogique',
                        'time' => '14:00 - 15:30',
                        'room' => 'Salle des profs'
                    ],
                    [
                        'subject' => 'Mathématiques - Seconde 3',
                        'time' => '15:45 - 17:15',
                        'room' => 'Salle 205'
                    ]
                ],
                'recent_notes' => [
                    [
                        'subject' => 'Contrôle Algèbre',
                        'student' => 'Jean Dupont',
                        'date' => '15 Nov 2023',
                        'grade' => 17.5
                    ],
                    [
                        'subject' => 'Devoir Géométrie',
                        'student' => 'Marie Curie',
                        'date' => '14 Nov 2023',
                        'grade' => 19.0
                    ],
                    [
                        'subject' => 'Interro Statistiques',
                        'student' => 'Paul Durand',
                        'date' => '13 Nov 2023',
                        'grade' => 12.0
                    ],
                    [
                        'subject' => 'Contrôle Algèbre',
                        'student' => 'Julie Martin',
                        'date' => '12 Nov 2023',
                        'grade' => 15.5
                    ]
                ],
                'quick_actions' => [
                    [
                        'title' => 'Ajouter une note',
                        'icon' => 'fas fa-plus-circle',
                        'color' => 'green',
                        'link' => '#'
                    ],
                    [
                        'title' => 'Créer un devoir',
                        'icon' => 'fas fa-edit',
                        'color' => 'blue',
                        'link' => '#'
                    ],
                    [
                        'title' => 'Planning',
                        'icon' => 'fas fa-calendar-alt',
                        'color' => 'purple',
                        'link' => '#'
                    ],
                    [
                        'title' => 'Ressources',
                        'icon' => 'fas fa-folder-open',
                        'color' => 'yellow',
                        'link' => '#'
                    ]
                ]
            ];
        }
    }
}

// Simpler SimpleFooter si non existant
if (!class_exists('SimpleFooter')) {
    class SimpleFooter extends Component {
        public function render(): string {
            return '
            <footer class="bg-white border-t border-gray-200 py-6">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-gray-600 mb-4 md:mb-0">
                            © 2023 École Excellence - Système de Gestion Pédagogique
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-green-600">
                                <i class="fas fa-question-circle"></i> Aide
                            </a>
                            <a href="#" class="text-gray-500 hover:text-green-600">
                                <i class="fas fa-cog"></i> Paramètres
                            </a>
                            <a href="#" class="text-gray-500 hover:text-green-600">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </footer>';
        }
    }
}

/**
 * Dashboard Enseignant - Version Standalone Améliorée
 */
class EnseignantDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
        parent::__construct($options);
    }
    
    public function render(): string {
        $content = [
            'stats_config' => [
                'total_classes' => [
                    'label' => 'Classes',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'color' => 'indigo'
                ],
                'total_eleves' => [
                    'label' => 'Élèves',
                    'icon' => 'fas fa-user-graduate',
                    'color' => 'blue'
                ],
                'total_cours' => [
                    'label' => 'Cours cette semaine',
                    'icon' => 'fas fa-book-open',
                    'color' => 'green'
                ],
                'notes_a_saisir' => [
                    'label' => 'Notes à saisir',
                    'icon' => 'fas fa-clipboard-check',
                    'color' => 'yellow'
                ],
                'devoirs_a_corriger' => [
                    'label' => 'Devoirs à corriger',
                    'icon' => 'fas fa-tasks',
                    'color' => 'orange'
                ],
                'messages_non_lus' => [
                    'label' => 'Messages non lus',
                    'icon' => 'fas fa-envelope',
                    'color' => 'purple'
                ]
            ],
            'classes_data' => [
                [
                    'name' => 'Terminale S1',
                    'subject' => 'Mathématiques',
                    'students' => '32'
                ],
                [
                    'name' => 'Première S2',
                    'subject' => 'Mathématiques',
                    'students' => '28'
                ],
                [
                    'name' => 'Seconde 3',
                    'subject' => 'Mathématiques',
                    'students' => '35'
                ],
                [
                    'name' => 'Terminale ES',
                    'subject' => 'Spécialité Maths',
                    'students' => '24'
                ]
            ],
            'schedule_data' => [
                [
                    'subject' => 'Mathématiques - Terminale S1',
                    'time' => '08:30 - 10:00',
                    'room' => 'Salle 201'
                ],
                [
                    'subject' => 'Mathématiques - Première S2',
                    'time' => '10:30 - 12:00',
                    'room' => 'Salle 203'
                ],
                [
                    'subject' => 'Réunion pédagogique',
                    'time' => '14:00 - 15:30',
                    'room' => 'Salle des profs'
                ],
                [
                    'subject' => 'Mathématiques - Seconde 3',
                    'time' => '15:45 - 17:15',
                    'room' => 'Salle 205'
                ]
            ],
            'recent_notes' => [
                [
                    'subject' => 'Contrôle Algèbre',
                    'student' => 'Jean Dupont',
                    'date' => '15 Nov 2023',
                    'grade' => 17.5
                ],
                [
                    'subject' => 'Devoir Géométrie',
                    'student' => 'Marie Curie',
                    'date' => '14 Nov 2023',
                    'grade' => 19.0
                ],
                [
                    'subject' => 'Interro Statistiques',
                    'student' => 'Paul Durand',
                    'date' => '13 Nov 2023',
                    'grade' => 12.0
                ],
                [
                    'subject' => 'Contrôle Algèbre',
                    'student' => 'Julie Martin',
                    'date' => '12 Nov 2023',
                    'grade' => 15.5
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Ajouter une note',
                    'icon' => 'fas fa-plus-circle',
                    'color' => 'green',
                    'link' => '#'
                ],
                [
                    'title' => 'Créer un devoir',
                    'icon' => 'fas fa-edit',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Planning',
                    'icon' => 'fas fa-calendar-alt',
                    'color' => 'purple',
                    'link' => '#'
                ],
                [
                    'title' => 'Ressources',
                    'icon' => 'fas fa-folder-open',
                    'color' => 'yellow',
                    'link' => '#'
                ]
            ]
        ];
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Enseignant - Dashboard</title>
            
            <!-- Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                'primary': {
                                    50: '#f0f9ff',
                                    100: '#e0f2fe',
                                    500: '#0ea5e9',
                                    600: '#0284c7',
                                    700: '#0369a1',
                                },
                                'success': {
                                    50: '#f0fdf4',
                                    100: '#dcfce7',
                                    500: '#22c55e',
                                    600: '#16a34a',
                                    700: '#15803d',
                                }
                            },
                            animation: {
                                'fade-in-up': 'fadeInUp 0.6s ease-out',
                                'fade-in': 'fadeIn 0.8s ease-out',
                                'slide-in-right': 'slideInRight 0.5s ease-out',
                                'pulse-gentle': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
                    font-family: 'Inter', 'Poppins', sans-serif;
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
                    background: rgba(255, 255, 255, 0.9);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }
                
                .hover-lift {
                    transition: all 0.3s ease;
                }
                
                .hover-lift:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }
                
                .gradient-text {
                    background: linear-gradient(135deg, #0ea5e9 0%, #22c55e 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                    color: #000000;
                }
                
                .sidebar .text-white {
                    color: #000000 !important;
                }
                
                .sidebar .bg-white/5{ 
                    background: rgba(0, 0, 0, 0.05);
                }
                
                .sidebar .bg-white/10 {
                    background: rgba(0, 0, 0, 0.1);
                }
                
                .sidebar .bg-white/20 {
                    background: rgba(0, 0, 0, 0.2);
                }
                
                .sidebar .border-white/10 {
                    border-color: rgba(0, 0, 0, 0.1);
                }
                
                .sidebar .text-white/80 {
                    color: rgba(0, 0, 0, 0.8) !important;
                }
                
                .sidebar .text-white/60 {
                    color: rgba(0, 0, 0, 0.6) !important;
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
                
                .grade-badge {
                    font-variant-numeric: tabular-nums;
                }
                
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-chalkboard-teacher text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">Espace Enseignant</h1>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['matiere']); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-semibold">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden md:block">
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Mon Profil
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i> Paramètres
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex pt-[73px]"> <!-- Ajusté pour le header fixe -->
                <!-- Sidebar -->
                <aside class="sidebar w-64 text-black hidden md:block fixed top-[74px] left-0 h-[calc(100vh-74px)] z-40 overflow-y-auto">
                    <div class="p-6 h-full overflow-y-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-green-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Navigation</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'active' => true],
                                ['icon' => 'fas fa-school', 'label' => 'Mes Classes', 'active' => false],
                                ['icon' => 'fas fa-clipboard-list', 'label' => 'Notes', 'active' => false],
                                ['icon' => 'fas fa-tasks', 'label' => 'Devoirs', 'active' => false],
                                ['icon' => 'fas fa-file', 'label' => 'Interrogation', 'active' => false],
                                ['icon' => 'fas fa-comments', 'label' => 'Messages', 'badge' => '3', 'active' => false],
                                ['icon' => 'fas fa-calendar-alt', 'label' => 'Emploi du temps', 'active' => false],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Analyses', 'active' => false],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Ressources', 'active' => false]
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo $item['active'] ? 'bg-black/10 border-l-4 border-blue-500' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3 text-sm text-black"></i>
                                <span class="flex-1 text-sm text-black"><?php echo $item['label']; ?></span>
                                <?php if(isset($item['badge'])): ?>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Footer -->
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm text-black/80">Prochain conseil</p>
                                <p class="font-medium text-sm text-black">Lundi 20 Nov, 14h</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-500 to-green-500 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 ml-64 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px]">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    Bonjour, <span class="gradient-text"><?php echo htmlspecialchars(explode(' ', $this->user['nom'])[0]); ?>!</span>
                                </h1>
                                <p class="text-gray-600">
                                    <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1] . ' ' . date('Y');
                                    ?>
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-2"></i>
                                    <?php echo date('H:i'); ?>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-green-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                                    <i class="fas fa-plus mr-2"></i>Nouveau cours
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'total_classes' => '4',
                            'total_eleves' => '119',
                            'total_cours' => '12',
                            'notes_a_saisir' => '8',
                            'devoirs_a_corriger' => '5',
                            'messages_non_lus' => '3'
                        ];
                        
                        foreach($content['stats_config'] as $key => $stat): 
                            $value = $statsValues[$key] ?? '0';
                        ?>
                        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover-lift animate-fade-in-up" style="animation-delay: <?php echo array_search($key, array_keys($content['stats_config'])) * 0.1; ?>s">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1"><?php echo $stat['label']; ?></p>
                                    <p class="text-2xl font-bold text-gray-900"><?php echo $value; ?></p>
                                </div>
                                <div class="p-3 rounded-lg bg-gradient-to-br from-<?php echo $stat['color']; ?>-500 to-<?php echo $stat['color']; ?>-600">
                                    <i class="<?php echo $stat['icon']; ?> text-white text-lg"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-arrow-<?php echo rand(0,1) ? 'up text-green-500' : 'down text-red-500'; ?> mr-1"></i>
                                    <?php echo rand(1, 20); ?>% vs semaine dernière
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Classes -->
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-chalkboard-teacher text-blue-500 mr-2"></i>
                                    Mes Classes
                                </h3>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                    Tout voir
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php foreach($content['classes_data'] as $index => $class): ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-lg border border-gray-100 hover:border-blue-200 transition-colors animate-slide-in-right" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-users text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($class['name']); ?></h4>
                                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($class['subject']); ?></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-gray-900"><?php echo $class['students']; ?></div>
                                        <div class="text-xs text-gray-500">élèves</div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Schedule -->
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                    Aujourd'hui
                                </h3>
                                <a href="#" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                                    Semaine
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php foreach($content['schedule_data'] as $index => $slot): ?>
                                <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:border-green-200 transition-all animate-slide-in-right" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-100 to-green-50 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas <?php echo $slot['subject'] === 'Réunion pédagogique' ? 'fas fa-users' : 'fa-book'; ?> text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($slot['subject']); ?></h4>
                                        <div class="flex items-center text-sm text-gray-600 mt-1">
                                            <span class="flex items-center mr-4">
                                                <i class="fas fa-clock mr-1.5"></i>
                                                <?php echo $slot['time']; ?>
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-door-open mr-1.5"></i>
                                                <?php echo htmlspecialchars($slot['room']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="<?php echo strpos($slot['time'], '08:30') !== false ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'; ?> text-xs font-medium px-3 py-1 rounded-full">
                                        <?php echo strpos($slot['time'], '08:30') !== false ? 'En cours' : 'À venir'; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Recent Grades -->
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                                    Dernières Notes
                                </h3>
                                <a href="#" class="text-sm font-medium text-yellow-600 hover:text-yellow-800 flex items-center">
                                    Saisir des notes
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php foreach($content['recent_notes'] as $note): 
                                    $grade = $note['grade'];
                                    if($grade >= 16) {
                                        $color = 'from-green-500 to-emerald-600';
                                        $icon = 'fas fa-trophy';
                                    } elseif($grade >= 10) {
                                        $color = 'from-blue-500 to-cyan-600';
                                        $icon = 'fas fa-check-circle';
                                    } else {
                                        $color = 'from-orange-500 to-red-600';
                                        $icon = 'fas fa-exclamation-circle';
                                    }
                                ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-lg border border-gray-100 hover:border-yellow-200 transition-colors">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br <?php echo $color; ?> rounded-lg flex items-center justify-center mr-4">
                                            <i class="<?php echo $icon; ?> text-white"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($note['subject']); ?></h4>
                                            <p class="text-sm text-gray-600">
                                                <?php echo htmlspecialchars($note['student']); ?> • <?php echo htmlspecialchars($note['date']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="grade-badge inline-block px-3 py-1.5 bg-gradient-to-r <?php echo $color; ?> text-white font-bold rounded-full text-sm">
                                            <?php echo number_format($grade, 1); ?>/20
                                        </span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-bolt text-purple-500 mr-2"></i>
                                    Actions Rapides
                                </h3>
                                <span class="text-xs text-gray-500">Cliquez pour agir</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php foreach($content['quick_actions'] as $action): ?>
                                <a href="<?php echo $action['link']; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 hover:border-<?php echo $action['color']; ?>-300 hover:shadow-md transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color']; ?>-500 to-<?php echo $action['color']; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <i class="<?php echo $action['icon']; ?> text-white text-xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 text-center group-hover:text-<?php echo $action['color']; ?>-700">
                                        <?php echo htmlspecialchars($action['title']); ?>
                                    </span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                                        <div class="text-2xl font-bold text-blue-700">18</div>
                                        <div class="text-xs text-blue-600">Cours ce mois</div>
                                    </div>
                                    <div class="text-center p-3 bg-green-50 rounded-lg">
                                        <div class="text-2xl font-bold text-green-700">94%</div>
                                        <div class="text-xs text-green-600">Taux de présence</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-6 mt-8 ml-64">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">© 2023 École Excellence</p>
                                <p class="text-xs text-gray-500">Système de Gestion Pédagogique v2.1</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-shield-alt mr-1"></i> Sécurité
                            </a>
                            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-question-circle mr-1"></i> Support
                            </a>
                            <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                                <i class="fas fa-file-contract mr-1"></i> Mentions légales
                            </a>
                        </div>
                    </div>
                </div>
            </footer>

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
                    
                    if (!button && !menu.contains(event.target)) {
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
                
                // Animate elements on scroll
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, observerOptions);
                
                // Observe animated elements
                document.querySelectorAll('.animate-fade-in-up').forEach(el => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(el);
                });
                
                // Live time update
                function updateTime() {
                    const now = new Date();
                    const timeElement = document.querySelector('.time-display');
                    if (timeElement) {
                        timeElement.textContent = now.toLocaleTimeString('fr-FR', { 
                            hour: '2-digit', 
                            minute: '2-digit' 
                        });
                    }
                }
                
                // Update time every minute
                setInterval(updateTime, 60000);
                
                // Initial time display
                const timeDisplay = document.querySelector('.time-display');
                if (timeDisplay) {
                    const now = new Date();
                    timeDisplay.textContent = now.toLocaleTimeString('fr-FR', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new EnseignantDashboardStandalone();
echo $dashboard->render();
?>