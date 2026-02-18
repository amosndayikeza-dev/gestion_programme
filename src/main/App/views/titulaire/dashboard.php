<?php
/**
 * Dashboard Chef de Classe - Version Standalone
 * Design moderne et complet pour le chef de classe
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Jean-Pierre Ntumba',
    'role' => 'chef_classe',
    'email' => 'jp.ntumba@ecole.fr',
    'id_utilisateur' => 42,
    'matricule' => 'CHF-2023-042',
    'experience' => '8 ans',
    'specialite' => 'Mathématiques'
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
    public static function getChefClasseContent() {
        return [
            'stats_config' => [
                'total_classes' => [
                    'label' => 'Classes assignées',
                    'icon' => 'fas fa-school',
                    'color' => 'blue',
                    'trend' => 'stable'
                ],
                'total_eleves' => [
                    'label' => 'Élèves sous responsabilité',
                    'icon' => 'fas fa-graduation-cap',
                    'color' => 'green',
                    'trend' => 'up'
                ],
                'absences_ce_jour' => [
                    'label' => 'Absences aujourd\'hui',
                    'icon' => 'fas fa-calendar-times',
                    'color' => 'red',
                    'trend' => 'down'
                ],
                'notes_a_valider' => [
                    'label' => 'Notes à valider',
                    'icon' => 'fas fa-edit',
                    'color' => 'yellow',
                    'trend' => 'up'
                ],
                'messages_parents' => [
                    'label' => 'Messages parents',
                    'icon' => 'fas fa-envelope',
                    'color' => 'purple',
                    'trend' => 'stable'
                ],
                'reunions_prevues' => [
                    'label' => 'Réunions cette semaine',
                    'icon' => 'fas fa-users',
                    'color' => 'orange',
                    'trend' => 'up'
                ]
            ],
            'classes_data' => [
                [
                    'name' => '6ème Scientifique A',
                    'students' => 32,
                    'level' => 'Secondaire',
                    'room' => 'Salle A101',
                    'moyenne_classe' => 14.2,
                    'taux_reussite' => 92
                ],
                [
                    'name' => '5ème Scientifique B',
                    'students' => 28,
                    'level' => 'Secondaire',
                    'room' => 'Salle A102',
                    'moyenne_classe' => 13.8,
                    'taux_reussite' => 88
                ],
                [
                    'name' => 'Terminale C',
                    'students' => 35,
                    'level' => 'Secondaire Supérieur',
                    'room' => 'Salle B201',
                    'moyenne_classe' => 15.1,
                    'taux_reussite' => 95
                ],
                [
                    'name' => '4ème Littéraire',
                    'students' => 25,
                    'level' => 'Secondaire',
                    'room' => 'Salle A103',
                    'moyenne_classe' => 12.9,
                    'taux_reussite' => 85
                ]
            ],
            'activities_data' => [
                [
                    'type' => 'Note saisie',
                    'description' => 'Validation notes Mathématiques',
                    'class' => '6ème Scientifique A',
                    'student' => 'Marie Kalonji',
                    'time' => 'Il y a 2 heures',
                    'priority' => 'high'
                ],
                [
                    'type' => 'Absence signalée',
                    'description' => 'Justification à vérifier',
                    'class' => '5ème Scientifique B',
                    'student' => 'Jean Mukendi',
                    'time' => 'Il y a 3 heures',
                    'priority' => 'medium'
                ],
                [
                    'type' => 'Message parent',
                    'description' => 'Demande de rendez-vous urgent',
                    'class' => 'Terminale C',
                    'student' => 'Paul Kabeya',
                    'time' => 'Il y a 5 heures',
                    'priority' => 'high'
                ],
                [
                    'type' => 'Réunion planifiée',
                    'description' => 'Conseil de classe trimestriel',
                    'class' => '6ème Scientifique A',
                    'student' => 'Toute la classe',
                    'time' => 'Il y a 1 jour',
                    'priority' => 'low'
                ],
                [
                    'type' => 'Alerte discipline',
                    'description' => 'Incident en cours de récréation',
                    'class' => '4ème Littéraire',
                    'student' => 'Lucie Mpongo',
                    'time' => 'Il y a 2 jours',
                    'priority' => 'high'
                ]
            ],
            'events_data' => [
                [
                    'title' => 'Conseil de classe',
                    'class' => '6ème Scientifique A',
                    'date' => 'Aujourd\'hui, 14:00',
                    'type' => 'meeting',
                    'location' => 'Salle des professeurs'
                ],
                [
                    'title' => 'Réunion parents-professeurs',
                    'class' => '5ème Scientifique B',
                    'date' => '22/01/2024, 16:30',
                    'type' => 'meeting',
                    'location' => 'Amphithéâtre B'
                ],
                [
                    'title' => 'Examen final',
                    'class' => 'Terminale C',
                    'date' => '25/01/2024, 08:00',
                    'type' => 'exam',
                    'location' => 'Salle d\'examen'
                ],
                [
                    'title' => 'Sortie pédagogique',
                    'class' => '4ème Littéraire',
                    'date' => '28/01/2024, 09:00',
                    'type' => 'event',
                    'location' => 'Musée National'
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
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user-tie text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 École Excellence</p>
                            <p class="text-xs text-gray-500">Espace Chef de Classe v2.5</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-question-circle mr-1"></i> Guide Chef de Classe
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-file-alt mr-1"></i> Rapports
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-comments mr-1"></i> Support
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Chef de Classe - Version Standalone Améliorée
 */
class ChefClasseDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getChefClasseContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Chef de Classe - Dashboard</title>
            
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
                                'chef-classe': {
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
                                'bounce-subtle': 'bounce 2s infinite',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                .heading {
                    font-family: 'Source Sans Pro', sans-serif;
                }
                
                body {
                    background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
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
                    background: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                    color: #000000;
                    border-right: 1px solid rgba(0, 0, 0, 0.1);
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
                
                .activity-high {
                    border-left: 4px solid #ef4444;
                    animation: pulse-subtle 2s infinite;
                }
                
                .activity-medium {
                    border-left: 4px solid #f59e0b;
                }
                
                .activity-low {
                    border-left: 4px solid #10b981;
                }
                
                .event-meeting {
                    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
                }
                
                .event-exam {
                    background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
                }
                
                .event-general {
                    background: linear-gradient(135deg, #d1fae5 0%, #ecfdf5 100%);
                }
                
                .class-card {
                    transition: all 0.3s ease;
                }
                
                .class-card:hover {
                    transform: scale(1.02);
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-user-tie text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Espace Tutilaire de Classe</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['specialite']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['experience']); ?> d'expérience</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Quick Access -->
                            <div class="hidden md:flex items-center space-x-2">
                                <a href="#" class="px-3 py-1 text-sm bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-chart-line mr-1"></i> Statistiques
                                </a>
                                <a href="#" class="px-3 py-1 text-sm bg-indigo-50 text-indigo-700 rounded-full hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-file-alt mr-1"></i> Rapports
                                </a>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center animate-bounce-subtle">3</span>
                                </button>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Chef de Classe</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">Matricule: <?php echo htmlspecialchars($this->user['matricule']); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-tie mr-3 text-blue-600"></i>
                                        Mon Profil Chef de Classe
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-school mr-3 text-indigo-600"></i>
                                        Mes Classes
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-chart-bar mr-3 text-green-600"></i>
                                        Statistiques
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-3 text-gray-600"></i>
                                        Paramètres
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
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bars text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Navigation</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-school', 'label' => 'Mes Classes', 'badge' => '4'],
                                ['icon' => 'fas fa-users', 'label' => 'Élèves', 'badge' => '120'],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Évaluations', 'badge' => '15'],
                                ['icon' => 'fas fa-comments', 'label' => 'Communication', 'badge' => '8'],
                                ['icon' => 'fas fa-exclamation-triangle', 'label' => 'Discipline', 'badge' => '3'],
                                ['icon' => 'fas fa-calendar-alt', 'label' => 'Planning', 'badge' => ''],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'badge' => '5'],
                                ['icon' => 'fas fa-bullhorn', 'label' => 'Annonces', 'badge' => '2'],
                                ['icon' => 'fas fa-handshake', 'label' => 'Relations parents', 'badge' => '6'],
                                ['icon' => 'fas fa-chart-bar', 'label' => 'Statistiques avancées', 'badge' => '']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-black/10 shadow-inner' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3 text-black"></i>
                                <span class="flex-1 text-black"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Summary -->
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-2">Responsabilités</p>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Classes gérées:</span>
                                        <span class="font-bold text-blue-600">4</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Élèves totaux:</span>
                                        <span class="font-bold text-green-600">120</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Actions en attente:</span>
                                        <span class="font-bold text-red-600">8</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full shadow-lg flex items-center justify-center">
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
                                    <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1];
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-clock text-indigo-600 mr-1"></i>
                                    <span class="time-display font-medium"><?php echo date('H:i'); ?></span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-user-tie mr-2"></i>
                                    <span>Chef de Classe Certifié</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Nouvelle action
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'total_classes' => '4',
                            'total_eleves' => '120',
                            'absences_ce_jour' => '8',
                            'notes_a_valider' => '15',
                            'messages_parents' => '6',
                            'reunions_prevues' => '3'
                        ];
                        
                        if (isset($content['stats_config'])) {
                            foreach($content['stats_config'] as $key => $stat): 
                                $value = $statsValues[$key] ?? '0';
                                $trend = $stat['trend'] ?? 'stable';
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
                            <div class="mt-4 pt-3 border-t border-<?php echo $stat['color']; ?>-100">
                                <p class="text-xs font-medium text-<?php echo match($trend) { 'up' => 'green', 'down' => 'red', default => 'gray' }; ?>-700 flex items-center">
                                    <i class="fas fa-arrow-<?php echo $trend === 'up' ? 'up' : ($trend === 'down' ? 'down' : 'right'); ?> mr-1"></i>
                                    <?php echo match($trend) { 
                                        'up' => '+5% vs hier', 
                                        'down' => '-2% vs hier', 
                                        default => 'Stable' 
                                    }; ?>
                                </p>
                            </div>
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
                        <!-- Mes Classes -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-school text-blue-600 mr-2"></i>
                                            Mes Classes
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Gestion et supervision</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                        Voir toutes
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['classes_data']) && is_array($content['classes_data'])) {
                                        foreach($content['classes_data'] as $index => $classe): 
                                            $successColor = $classe['taux_reussite'] >= 90 ? 'green' : ($classe['taux_reussite'] >= 80 ? 'blue' : 'yellow');
                                    ?>
                                    <div class="class-card flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition-all animate-slide-in-right" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 bg-blue-100">
                                                <i class="fas fa-chalkboard-teacher text-blue-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($classe['name']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-users mr-1.5 text-gray-400"></i>
                                                        <?php echo $classe['students']; ?> élèves
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($classe['room']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center justify-end mb-1">
                                                <span class="text-lg font-bold text-<?php echo $successColor; ?>-700 mr-2"><?php echo $classe['moyenne_classe']; ?>/20</span>
                                                <span class="px-2 py-1 bg-<?php echo $successColor; ?>-100 text-<?php echo $successColor; ?>-800 text-xs font-medium rounded-full">
                                                    <?php echo $classe['taux_reussite']; ?>% réussite
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500"><?php echo htmlspecialchars($classe['level']); ?></div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune classe assignée</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Événements à venir -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>
                                            Événements à Venir
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Planning de la semaine</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                        Ajouter
                                        <i class="fas fa-plus ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['events_data']) && is_array($content['events_data'])) {
                                        foreach($content['events_data'] as $index => $event): 
                                            $eventType = $event['type'];
                                            $eventClass = 'event-' . $eventType;
                                            $icon = $eventType === 'meeting' ? 'fas fa-users' : 
                                                   ($eventType === 'exam' ? 'fas fa-clipboard-check' : 'fas fa-calendar-day');
                                    ?>
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-indigo-300 transition-all animate-slide-in-right <?php echo $eventClass; ?>" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4 <?php echo $eventType === 'meeting' ? 'bg-blue-100' : ($eventType === 'exam' ? 'bg-red-100' : 'bg-green-100'); ?>">
                                                <i class="<?php echo $icon; ?> <?php echo $eventType === 'meeting' ? 'text-blue-600' : ($eventType === 'exam' ? 'text-red-600' : 'text-green-600'); ?>"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($event['title']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-school mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($event['class']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($event['location']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900"><?php echo $event['date']; ?></div>
                                            <div class="mt-1 flex space-x-2">
                                                <button class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-lg hover:bg-blue-200 transition-colors">
                                                    <i class="fas fa-eye mr-1"></i>Voir
                                                </button>
                                                <button class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-edit mr-1"></i>Modifier
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun événement prévu</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activités Récentes et Actions Rapides -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Activités Récentes -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-history text-purple-600 mr-2"></i>
                                        Activités Récentes
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Suivi des actions</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center">
                                    Voir journal
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-3">
                                <?php 
                                if (isset($content['activities_data']) && is_array($content['activities_data'])) {
                                    foreach($content['activities_data'] as $index => $activity): 
                                        $priority = $activity['priority'];
                                        $priorityClass = 'activity-' . $priority;
                                        $priorityIcon = $priority === 'high' ? 'fas fa-exclamation-circle text-red-500' : 
                                                       ($priority === 'medium' ? 'fas fa-exclamation-triangle text-yellow-500' : 'fas fa-info-circle text-green-500');
                                ?>
                                <div class="flex items-center p-4 rounded-lg border border-gray-200 hover:border-purple-300 transition-all animate-slide-in-right <?php echo $priorityClass; ?>" style="animation-delay: <?php echo $index * 0.05; ?>s">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 bg-<?php echo $priority === 'high' ? 'red' : ($priority === 'medium' ? 'yellow' : 'green'); ?>-100">
                                        <i class="<?php echo $priorityIcon; ?>"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold text-gray-900 truncate"><?php echo htmlspecialchars($activity['type']); ?></h4>
                                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0"><?php echo $activity['time']; ?></span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate"><?php echo htmlspecialchars($activity['description']); ?></p>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span class="flex items-center mr-3">
                                                <i class="fas fa-school mr-1"></i>
                                                <?php echo htmlspecialchars($activity['class']); ?>
                                            </span>
                                            <span class="flex items-center">
                                                <i class="fas fa-user-graduate mr-1"></i>
                                                <?php echo htmlspecialchars($activity['student']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="ml-2 px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-lg hover:bg-gray-200 transition-colors flex-shrink-0">
                                        Traiter
                                    </button>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucune activité récente</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Actions Rapides -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-bolt text-orange-600 mr-2"></i>
                                        Actions Rapides
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Gestion immédiate</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php foreach([
                                    ['icon' => 'fas fa-edit', 'label' => 'Valider notes', 'color' => 'blue', 'action' => 'validateNotes'],
                                    ['icon' => 'fas fa-users', 'label' => 'Planifier réunion', 'color' => 'indigo', 'action' => 'planMeeting'],
                                    ['icon' => 'fas fa-calendar-times', 'label' => 'Gérer absences', 'color' => 'red', 'action' => 'manageAbsences'],
                                    ['icon' => 'fas fa-file-alt', 'label' => 'Rapport classe', 'color' => 'green', 'action' => 'generateReport'],
                                    ['icon' => 'fas fa-comments', 'label' => 'Contacter parent', 'color' => 'purple', 'action' => 'contactParent'],
                                    ['icon' => 'fas fa-chart-line', 'label' => 'Statistiques', 'color' => 'yellow', 'action' => 'showStats'],
                                    ['icon' => 'fas fa-bullhorn', 'label' => 'Annonce classe', 'color' => 'pink', 'action' => 'createAnnouncement'],
                                    ['icon' => 'fas fa-exclamation', 'label' => 'Alerte discipline', 'color' => 'orange', 'action' => 'disciplineAlert']
                                ] as $index => $action): ?>
                                <button onclick="<?php echo $action['action']; ?>()" class="p-4 bg-<?php echo $action['color']; ?>-50 hover:bg-<?php echo $action['color']; ?>-100 rounded-xl text-center transition-all duration-300 hover-lift animate-fade-in-up" style="animation-delay: <?php echo $index * 0.05; ?>s">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-lg flex items-center justify-center bg-<?php echo $action['color']; ?>-100">
                                        <i class="<?php echo $action['icon']; ?> text-<?php echo $action['color']; ?>-600 text-xl"></i>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800"><?php echo $action['label']; ?></p>
                                </button>
                                <?php endforeach; ?>
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
                
                // Action functions
                function validateNotes() {
                    alert('📊 Validation des notes\n\nOuverture de l\'interface de validation des notes saisies par les professeurs.');
                }
                
                function planMeeting() {
                    alert('📅 Planifier une réunion\n\nCréation d\'une nouvelle réunion avec les professeurs ou les parents.');
                }
                
                function manageAbsences() {
                    alert('⏰ Gérer les absences\n\nConsulter et valider les justificatifs d\'absence des élèves.');
                }
                
                function generateReport() {
                    alert('📋 Générer un rapport\n\nCréation du rapport trimestriel de la classe.');
                }
                
                function contactParent() {
                    alert('📞 Contacter un parent\n\nEnvoyer un message à un parent d\'élève.');
                }
                
                function showStats() {
                    alert('📈 Statistiques de classe\n\nVisualisation des statistiques détaillées de performance.');
                }
                
                function createAnnouncement() {
                    alert('📢 Créer une annonce\n\nPublier une annonce pour les élèves et parents de la classe.');
                }
                
                function disciplineAlert() {
                    alert('⚠️ Alerte discipline\n\nSignaler un incident disciplinaire.');
                }
                
                // Class card hover effect
                document.querySelectorAll('.class-card').forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
                    });
                    card.addEventListener('mouseleave', function() {
                        this.style.boxShadow = '';
                    });
                });
                
                // Update urgent activities
                function updateUrgentActivities() {
                    const urgentItems = document.querySelectorAll('.activity-high');
                    urgentItems.forEach(item => {
                        item.style.animation = 'none';
                        setTimeout(() => {
                            item.style.animation = 'pulse-subtle 2s infinite';
                        }, 10);
                    });
                }
                
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
                
                // Update urgent activities every 5 seconds
                setInterval(updateUrgentActivities, 5000);
                
                // Initial updates
                updateTime();
                updateUrgentActivities();
                
                // New action button
                const newActionBtn = document.querySelector('[class*="Nouvelle action"]');
                if (newActionBtn) {
                    newActionBtn.addEventListener('click', () => {
                        const actions = [
                            '📝 Créer une fiche de suivi',
                            '📊 Analyser les résultats',
                            '👥 Programmer un conseil',
                            '📧 Envoyer un rapport'
                        ];
                        const action = actions[Math.floor(Math.random() * actions.length)];
                        alert('➕ Nouvelle action\n\n' + action);
                    });
                }
                
                // Tooltips for success rates
                document.querySelectorAll('[class*="bg-green-100"], [class*="bg-blue-100"], [class*="bg-yellow-100"]').forEach(badge => {
                    badge.addEventListener('mouseenter', function() {
                        const rate = parseInt(this.textContent);
                        let message = '';
                        if (rate >= 90) message = 'Excellente performance!';
                        else if (rate >= 80) message = 'Bonne performance';
                        else message = 'Performance à améliorer';
                        
                        this.setAttribute('title', `${message} (${rate}% de réussite)`);
                    });
                });
                
                // Notification animation
                const notificationBadge = document.querySelector('.animate-bounce-subtle');
                if (notificationBadge) {
                    setInterval(() => {
                        notificationBadge.style.animation = 'none';
                        setTimeout(() => {
                            notificationBadge.style.animation = 'bounce-subtle 2s infinite';
                        }, 10);
                    }, 10000);
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new ChefClasseDashboardStandalone();
echo $dashboard->render();
?>