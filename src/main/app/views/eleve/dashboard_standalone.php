<?php
/**
 * Dashboard Élève - Version Standalone
 * Design moderne et complet pour l'élève
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Lucas Martin',
    'role' => 'eleve',
    'email' => 'l.martin@ecole.fr',
    'id_utilisateur' => 103,
    'classe' => 'Terminale S',
    'annee' => '2023-2024',
    'moyenne_generale' => 15.2
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
    public static function getEleveContent() {
        return [
            'stats_config' => [
                'moyenne_generale' => [
                    'label' => 'Moyenne générale',
                    'icon' => 'fas fa-chart-line',
                    'color' => 'blue'
                ],
                'total_notes' => [
                    'label' => 'Notes ce trimestre',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'green'
                ],
                'devoirs_a_faire' => [
                    'label' => 'Devoirs à faire',
                    'icon' => 'fas fa-tasks',
                    'color' => 'orange'
                ],
                'absences' => [
                    'label' => 'Absences',
                    'icon' => 'fas fa-clock',
                    'color' => 'red'
                ],
                'retards' => [
                    'label' => 'Retards',
                    'icon' => 'fas fa-running',
                    'color' => 'yellow'
                ],
                'messages_non_lus' => [
                    'label' => 'Messages non lus',
                    'icon' => 'fas fa-envelope',
                    'color' => 'purple'
                ]
            ],
            'recent_notes' => [
                [
                    'subject' => 'Mathématiques',
                    'grade' => 16.5,
                    'coefficient' => 4,
                    'date' => '15/01/2024',
                    'teacher' => 'M. Dupont'
                ],
                [
                    'subject' => 'Physique-Chimie',
                    'grade' => 14.0,
                    'coefficient' => 3,
                    'date' => '14/01/2024',
                    'teacher' => 'Mme. Laurent'
                ],
                [
                    'subject' => 'Philosophie',
                    'grade' => 12.5,
                    'coefficient' => 2,
                    'date' => '12/01/2024',
                    'teacher' => 'M. Bernard'
                ],
                [
                    'subject' => 'Anglais',
                    'grade' => 17.0,
                    'coefficient' => 2,
                    'date' => '10/01/2024',
                    'teacher' => 'Mme. Johnson'
                ]
            ],
            'assignments_data' => [
                [
                    'title' => 'DM Algèbre linéaire',
                    'subject' => 'Mathématiques',
                    'due_date' => 'Demain, 08:30',
                    'urgency' => 'urgent',
                    'status' => 'à faire'
                ],
                [
                    'title' => 'Exposé énergies renouvelables',
                    'subject' => 'Physique',
                    'due_date' => '22/01/2024',
                    'urgency' => 'normal',
                    'status' => 'en cours'
                ],
                [
                    'title' => 'Dissertation philosophique',
                    'subject' => 'Philosophie',
                    'due_date' => '25/01/2024',
                    'urgency' => 'normal',
                    'status' => 'à faire'
                ],
                [
                    'title' => 'Article scientifique',
                    'subject' => 'SVT',
                    'due_date' => '30/01/2024',
                    'urgency' => 'low',
                    'status' => 'planifié'
                ]
            ],
            'schedule_data' => [
                [
                    'subject' => 'Mathématiques',
                    'time' => '08:30 - 10:00',
                    'room' => 'Salle 201',
                    'teacher' => 'M. Dupont'
                ],
                [
                    'subject' => 'Physique-Chimie',
                    'time' => '10:30 - 12:00',
                    'room' => 'Labo 3',
                    'teacher' => 'Mme. Laurent'
                ],
                [
                    'subject' => 'Pause déjeuner',
                    'time' => '12:00 - 13:30',
                    'room' => 'Cafétéria',
                    'teacher' => ''
                ],
                [
                    'subject' => 'Philosophie',
                    'time' => '13:30 - 15:00',
                    'room' => 'Salle 105',
                    'teacher' => 'M. Bernard'
                ],
                [
                    'subject' => 'Anglais',
                    'time' => '15:15 - 16:45',
                    'room' => 'Salle 203',
                    'teacher' => 'Mme. Johnson'
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
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 École Excellence</p>
                            <p class="text-xs text-gray-500">Espace Élève v2.3</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-question-circle mr-1"></i> Aide
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-download mr-1"></i> Ressources
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-calendar mr-1"></i> Agenda
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Élève - Version Standalone Améliorée
 */
class EleveDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getEleveContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mon Espace Élève - Dashboard</title>
            
            <!-- Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                'primary': {
                                    50: '#f5f3ff',
                                    100: '#ede9fe',
                                    500: '#8b5cf6',
                                    600: '#7c3aed',
                                    700: '#6d28d9',
                                },
                                'student': {
                                    50: '#eef2ff',
                                    100: '#e0e7ff',
                                    500: '#6366f1',
                                    600: '#4f46e5',
                                    700: '#4338ca',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                .heading {
                    font-family: 'Nunito', sans-serif;
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
                
                @keyframes bounce-subtle {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-5px); }
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
                    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
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
                
                .sidebar .bg-white/5 {
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
                
                .grade-card {
                    transition: all 0.3s ease;
                }
                
                .grade-card:hover {
                    transform: scale(1.02);
                }
                
                .assignment-urgent {
                    border-left: 4px solid #ef4444;
                    animation: pulse-subtle 2s infinite;
                }
                
                .current-class {
                    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-500 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Mon Espace Élève</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['classe']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['annee']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Quick Access -->
                            <div class="hidden md:flex items-center space-x-2">
                                <a href="#" class="px-3 py-1 text-sm bg-purple-50 text-purple-700 rounded-full hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-tasks mr-1"></i> Devoirs
                                </a>
                                <a href="#" class="px-3 py-1 text-sm bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-chart-line mr-1"></i> Notes
                                </a>
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-blue-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Élève - <?php echo htmlspecialchars($this->user['classe']); ?></p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">N° élève: <?php echo str_pad($this->user['id_utilisateur'], 4, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-graduate mr-3 text-purple-600"></i>
                                        Mon Profil Élève
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-lock mr-3 text-blue-600"></i>
                                        Sécurité & Mot de passe
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-3 text-gray-600"></i>
                                        Préférences
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
                <aside class="sidebar w-64 text-black hidden md:block fixed top-[74px] left-0 h-[calc(100vh-74px)] z-40">
                    <div class="p-6 h-full overflow-y-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-blue-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-book-open text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Navigation</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Mes Notes', 'badge' => '4'],
                                ['icon' => 'fas fa-tasks', 'label' => 'Devoirs', 'badge' => '5'],
                                ['icon' => 'fas fa-calendar-alt', 'label' => 'Emploi du temps', 'badge' => ''],
                                ['icon' => 'fas fa-envelope', 'label' => 'Messages', 'badge' => '3'],
                                ['icon' => 'fas fa-file', 'label' => 'Fiche de cotation', 'badge' => '3'],
                                ['icon' => 'fas fa-file-lines', 'label' => 'Bulletins', 'badge' => '3'],
                                ['icon' => 'fas fa-clock', 'label' => 'Absences/Retards', 'badge' => '2'],
                                ['icon' => 'fas fa-book', 'label' => 'Cours & Ressources', 'badge' => ''],
                                ['icon' => 'fas fa-users', 'label' => 'Mes Classes', 'badge' => ''],
                                ['icon' => 'fas fa-award', 'label' => 'Badges & Récompenses', 'badge' => '2']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-black/10 shadow-inner' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3 text-black"></i>
                                <span class="flex-1 text-black"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Progress -->
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-2">Progression trimestrielle</p>
                                <div class="w-full bg-black/20 rounded-full h-2 mb-2">
                                    <div class="bg-green-400 h-2 rounded-full" style="width: 75%"></div>
                                </div>
                                <p class="text-xs text-black/60">Moyenne: <?php echo htmlspecialchars($this->user['moyenne_generale']); ?>/20</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-purple-500 to-blue-500 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-[230px]">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 heading mb-2">
                                    Bonjour <span class="gradient-text"><?php echo htmlspecialchars(explode(' ', $this->user['nom'])[0]); ?>!</span>
                                </h1>
                                <p class="text-gray-600">
                                    <i class="fas fa-calendar-day text-purple-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1];
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-clock text-blue-600 mr-1"></i>
                                    <span class="time-display font-medium"><?php echo date('H:i'); ?></span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-purple-50 text-purple-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>Moyenne: <?php echo htmlspecialchars($this->user['moyenne_generale']); ?>/20</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Nouveau devoir
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'moyenne_generale' => $this->user['moyenne_generale'],
                            'total_notes' => '18',
                            'devoirs_a_faire' => '5',
                            'absences' => '2',
                            'retards' => '7',
                            'messages_non_lus' => '3'
                        ];
                        
                        if (isset($content['stats_config'])) {
                            foreach($content['stats_config'] as $key => $stat): 
                                $value = $statsValues[$key] ?? '0';
                                $trend = rand(0, 1) ? 'up' : 'down';
                        ?>
                        <div class="stat-card bg-white rounded-xl shadow-md border border-gray-200 p-5 hover-lift animate-fade-in-up" style="animation-delay: <?php echo array_search($key, array_keys($content['stats_config'])) * 0.1; ?>s">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1"><?php echo $stat['label']; ?></p>
                                    <p class="text-2xl font-bold text-gray-900 heading"><?php echo $value; ?><?php echo $key === 'moyenne_generale' ? '/20' : ''; ?></p>
                                </div>
                                <div class="p-3 rounded-xl bg-gradient-to-br from-<?php echo $stat['color']; ?>-500 to-<?php echo $stat['color']; ?>-600 shadow-md">
                                    <i class="<?php echo $stat['icon']; ?> text-white text-lg"></i>
                                </div>
                            </div>
                            <?php if($key === 'moyenne_generale'): ?>
                            <div class="mt-4 pt-3 border-t border-<?php echo $stat['color']; ?>-100">
                                <p class="text-xs font-medium text-<?php echo $trend === 'up' ? 'green' : 'red'; ?>-700 flex items-center">
                                    <i class="fas fa-arrow-<?php echo $trend; ?> mr-1"></i>
                                    <?php echo $trend === 'up' ? '+0.5' : '-0.2'; ?> vs dernier trimestre
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php 
                            endforeach;
                        } else {
                            echo '<div class="col-span-6 p-4 text-center text-gray-500">Statistiques non disponibles</div>';
                        }
                        ?>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Notes Récentes -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-star text-yellow-600 mr-2"></i>
                                            Mes Notes Récentes
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Trimestre 2 - 2023/2024</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-yellow-600 hover:text-yellow-800 flex items-center">
                                        Relevé complet
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php 
                                    if (isset($content['recent_notes']) && is_array($content['recent_notes'])) {
                                        foreach($content['recent_notes'] as $index => $note): 
                                            $grade = $note['grade'];
                                            $gradeColor = $grade >= 16 ? 'green' : ($grade >= 10 ? 'blue' : 'red');
                                            $icon = $grade >= 16 ? 'fa-trophy' : ($grade >= 10 ? 'fa-check-circle' : 'fa-exclamation-circle');
                                    ?>
                                    <div class="grade-card flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-<?php echo $gradeColor; ?>-300 transition-all animate-slide-in-right" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 bg-<?php echo $gradeColor; ?>-100">
                                                <i class="fas <?php echo $icon; ?> text-<?php echo $gradeColor; ?>-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($note['subject']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-user-graduate mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($note['teacher']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-weight mr-1.5 text-gray-400"></i>
                                                        Coef. <?php echo $note['coefficient']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-<?php echo $gradeColor; ?>-700"><?php echo $grade; ?>/20</div>
                                            <div class="text-xs text-gray-500"><?php echo $note['date']; ?></div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune note disponible</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Devoirs à faire -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-tasks text-orange-600 mr-2"></i>
                                            Devoirs à Rendre
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Priorité & Échéances</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-800 flex items-center">
                                        Planning
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['assignments_data']) && is_array($content['assignments_data'])) {
                                        foreach($content['assignments_data'] as $index => $assignment): 
                                            $urgencyColor = match($assignment['urgency']) {
                                                'urgent' => 'red',
                                                'normal' => 'blue',
                                                default => 'gray'
                                            };
                                    ?>
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-<?php echo $urgencyColor; ?>-300 transition-all animate-slide-in-right <?php echo $assignment['urgency'] === 'urgent' ? 'assignment-urgent' : ''; ?>" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 bg-<?php echo $urgencyColor; ?>-100">
                                                <i class="fas fa-<?php echo match($assignment['subject']) {
                                                    'Mathématiques' => 'calculator',
                                                    'Physique' => 'atom',
                                                    'Philosophie' => 'brain',
                                                    'SVT' => 'dna',
                                                    default => 'book'
                                                }; ?> text-<?php echo $urgencyColor; ?>-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($assignment['title']); ?></h4>
                                                    <?php if($assignment['urgency'] === 'urgent'): ?>
                                                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full animate-pulse-subtle">
                                                        <i class="fas fa-exclamation mr-1"></i>URGENT
                                                    </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-book mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($assignment['subject']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-clock mr-1.5 text-<?php echo $urgencyColor; ?>-500"></i>
                                                        <?php echo $assignment['due_date']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                <?php echo $assignment['status']; ?>
                                            </span>
                                            <button class="px-3 py-1 bg-gradient-to-r from-purple-500 to-blue-500 text-white text-xs rounded-lg hover:opacity-90 transition-opacity">
                                                <i class="fas fa-edit mr-1"></i>Faire
                                            </button>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun devoir à faire</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emploi du Temps -->
                    <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                                    Emploi du Temps
                                </h3>
                                <p class="text-sm text-gray-600 mt-1"><?php echo $jours[date('w')]; ?> <?php echo date('d'); ?> <?php echo $mois[date('n')-1]; ?></p>
                            </div>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                Semaine complète
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                        <div class="space-y-3">
                            <?php 
                            if (isset($content['schedule_data']) && is_array($content['schedule_data'])) {
                                $currentTime = date('H:i');
                                foreach($content['schedule_data'] as $index => $slot): 
                                    $slotStart = explode(' - ', $slot['time'])[0];
                                    $isCurrent = ($currentTime >= $slotStart && $currentTime <= explode(' - ', $slot['time'])[1]);
                            ?>
                            <div class="flex items-center p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition-all animate-slide-in-right <?php echo $isCurrent ? 'current-class' : 'bg-white'; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 <?php echo $isCurrent ? 'bg-blue-100' : 'bg-gray-100'; ?>">
                                    <span class="text-lg font-bold text-gray-900"><?php echo substr($slot['time'], 0, 5); ?></span>
                                    <span class="text-xs text-gray-600"><?php echo substr($slot['time'], 8, 5); ?></span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($slot['subject']); ?></h4>
                                    <div class="flex items-center text-sm text-gray-600 mt-1">
                                        <span class="flex items-center mr-4">
                                            <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                            <?php echo htmlspecialchars($slot['room']); ?>
                                        </span>
                                        <?php if(!empty($slot['teacher'])): ?>
                                        <span class="flex items-center">
                                            <i class="fas fa-chalkboard-teacher mr-1.5 text-gray-400"></i>
                                            <?php echo htmlspecialchars($slot['teacher']); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <?php if($isCurrent): ?>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full flex items-center">
                                        <i class="fas fa-play mr-1"></i>
                                        En cours
                                    </span>
                                    <?php elseif(strpos($slot['time'], '12:00') === 0): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        <i class="fas fa-utensils mr-1"></i>Pause
                                    </span>
                                    <?php elseif(strtotime($slotStart) > strtotime($currentTime)): ?>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                        À venir
                                    </span>
                                    <?php else: ?>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                        Terminé
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                            } else {
                                echo '<div class="text-center py-8 text-gray-500">Emploi du temps non disponible</div>';
                            }
                            ?>
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
                
                // Highlight current class in schedule
                function highlightCurrentClass() {
                    const now = new Date();
                    const currentTime = now.getHours() * 60 + now.getMinutes();
                    
                    document.querySelectorAll('.current-class').forEach(el => {
                        el.classList.remove('current-class');
                        el.classList.add('bg-white');
                    });
                    
                    document.querySelectorAll('[class*="bg-white"]').forEach(el => {
                                        const timeText = el.querySelector('span.text-lg')?.textContent;
                                        const timeRange = el.querySelector('span.text-xs')?.textContent;
                                        
                                        if (timeText && timeRange) {
                                            const startTime = timeText;
                                            const endTime = timeRange;
                                            
                                            const startMinutes = parseInt(startTime.split(':')[0]) * 60 + parseInt(startTime.split(':')[1]);
                                            const endMinutes = parseInt(endTime.split(':')[0]) * 60 + parseInt(endTime.split(':')[1]);
                                            
                                            if (currentTime >= startMinutes && currentTime <= endMinutes) {
                                                el.classList.add('current-class');
                                                el.classList.remove('bg-white');
                                            }
                                        }
                                    });
                                }
                
                // Update urgent assignments
                function updateUrgentAssignments() {
                    const urgentBadges = document.querySelectorAll('.animate-pulse-subtle');
                    urgentBadges.forEach(badge => {
                        badge.style.animation = 'none';
                        setTimeout(() => {
                            badge.style.animation = 'pulse-subtle 3s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                        }, 10);
                    });
                }
                
                // Grade hover effect
                document.querySelectorAll('.grade-card').forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.boxShadow = '';
                    });
                });
                
                // Assignment completion
                document.querySelectorAll('button:has(.fa-edit)').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const assignmentTitle = this.closest('[class*="flex items-center"]').querySelector('h4').textContent;
                        if (confirm(`Commencer le devoir: ${assignmentTitle} ?`)) {
                            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>En cours...';
                            this.classList.remove('from-purple-500', 'to-blue-500');
                            this.classList.add('from-green-500', 'to-green-600');
                            
                            setTimeout(() => {
                                alert('✅ Devoir ouvert dans l\'éditeur!');
                                this.innerHTML = '<i class="fas fa-check mr-1"></i>Terminer';
                            }, 1000);
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
                    
                    // Update current class highlighting
                    highlightCurrentClass();
                }
                
                // Update every minute
                setInterval(updateTime, 60000);
                
                // Update urgent assignments every 5 seconds
                setInterval(updateUrgentAssignments, 5000);
                
                // Initial updates
                updateTime();
                highlightCurrentClass();
                
                // New assignment button
                const newAssignmentBtn = document.querySelector('[class*="Nouveau devoir"]');
                if (newAssignmentBtn) {
                    newAssignmentBtn.addEventListener('click', () => {
                        alert('📝 Création d\'un nouveau devoir\n\nCette fonctionnalité vous permet d\'ajouter vos propres tâches personnelles.');
                    });
                }
                
                // Tooltips for grades
                document.querySelectorAll('[class*="text-green-700"], [class*="text-blue-700"], [class*="text-red-700"]').forEach(grade => {
                    grade.addEventListener('mouseenter', function() {
                                        const score = parseFloat(this.textContent);
                                        let message = '';
                                        if (score >= 16) message = 'Excellent!';
                                        else if (score >= 14) message = 'Très bien';
                                        else if (score >= 12) message = 'Assez bien';
                                        else if (score >= 10) message = 'Passable';
                                        else message = 'À améliorer';
                                        
                                        this.setAttribute('title', `${message} (${score}/20)`);
                                    });
                                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new EleveDashboardStandalone();
echo $dashboard->render();
?>