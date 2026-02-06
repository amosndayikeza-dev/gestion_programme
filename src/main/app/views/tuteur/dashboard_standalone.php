<?php
/**
 * Dashboard Tuteur - Version Standalone
 * Design moderne avec toutes les classes intégrées
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Sophie Durand',
    'role' => 'tuteur',
    'email' => 's.durand@famille.fr',
    'id_utilisateur' => 8,
    'telephone' => '+33 6 12 34 56 78'
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
    public static function getTuteurContent() {
        return [
            'stats_config' => [
                'eleves_suivis' => [
                    'label' => 'Élèves suivis',
                    'icon' => 'fas fa-user-graduate',
                    'color' => 'teal'
                ],
                'paiements_en_retard' => [
                    'label' => 'Paiements en retard',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'orange'
                ],
                'messages_non_lus' => [
                    'label' => 'Messages non lus',
                    'icon' => 'fas fa-envelope',
                    'color' => 'blue'
                ],
                'reunions_prevues' => [
                    'label' => 'Réunions prévues',
                    'icon' => 'fas fa-users',
                    'color' => 'purple'
                ],
                'bulletins_disponibles' => [
                    'label' => 'Bulletins disponibles',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'green'
                ],
                'absences_recentes' => [
                    'label' => 'Absences récentes',
                    'icon' => 'fas fa-clock',
                    'color' => 'red'
                ]
            ],
            'students_data' => [
                [
                    'name' => 'Lucas Durand',
                    'class' => 'Terminale S',
                    'average' => '15.2/20',
                    'status' => 'Bon niveau',
                    'avatar' => 'LD'
                ],
                [
                    'name' => 'Emma Durand',
                    'class' => 'Première ES',
                    'average' => '13.8/20',
                    'status' => 'À surveiller',
                    'avatar' => 'ED'
                ],
                [
                    'name' => 'Thomas Martin (neveu)',
                    'class' => 'Seconde',
                    'average' => '11.5/20',
                    'status' => 'Soutien nécessaire',
                    'avatar' => 'TM'
                ]
            ],
            'payments_data' => [
                [
                    'student' => 'Lucas Durand',
                    'type' => 'Frais de scolarité - Octobre',
                    'amount' => 125000,
                    'due_date' => '15/10/2023'
                ],
                [
                    'student' => 'Emma Durand',
                    'type' => 'Activités périscolaires',
                    'amount' => 35000,
                    'due_date' => '20/10/2023'
                ]
            ],
            'communications_data' => [
                [
                    'sender' => 'Prof. Mathématiques',
                    'subject' => 'Progrès notable en algèbre',
                    'date' => 'Aujourd\'hui, 10:30',
                    'type' => 'note',
                    'priority' => 'low'
                ],
                [
                    'sender' => 'Conseil de classe',
                    'subject' => 'Convocation réunion trimestrielle',
                    'date' => 'Hier, 14:15',
                    'type' => 'reunion',
                    'priority' => 'high'
                ],
                [
                    'sender' => 'Infirmerie',
                    'subject' => 'Absence de votre enfant',
                    'date' => '12/10/2023',
                    'type' => 'absence',
                    'priority' => 'medium'
                ],
                [
                    'sender' => 'Administration',
                    'subject' => 'Facture du 2ème trimestre',
                    'date' => '10/10/2023',
                    'type' => 'payment',
                    'priority' => 'medium'
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Payer en ligne',
                    'icon' => 'fas fa-credit-card',
                    'color' => 'teal',
                    'link' => '#'
                ],
                [
                    'title' => 'Consulter bulletins',
                    'icon' => 'fas fa-file-invoice',
                    'color' => 'green',
                    'link' => '#'
                ],
                [
                    'title' => 'Prendre rendez-vous',
                    'icon' => 'fas fa-calendar-plus',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Contacter l\'école',
                    'icon' => 'fas fa-headset',
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
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-school text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2023 École Excellence</p>
                            <p class="text-xs text-gray-500">Espace Tuteur v2.1</p>
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
                            <i class="fas fa-file-contract mr-1"></i> Mentions
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Tuteur - Version Standalone Améliorée
 */
class TuteurDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getTuteurContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Tuteur - Dashboard</title>
            
            <!-- Tailwind CSS -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                'primary': {
                                    50: '#f0fdfa',
                                    100: '#ccfbf1',
                                    500: '#14b8a6',
                                    600: '#0d9488',
                                    700: '#0f766e',
                                },
                                'warning': {
                                    50: '#fffbeb',
                                    100: '#fef3c7',
                                    500: '#f59e0b',
                                    600: '#d97706',
                                    700: '#b45309',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
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
                    background: linear-gradient(135deg, #14b8a6 0%, #0ea5e9 100%);
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
                
                .payment-card {
                    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
                    border: 2px solid #fbbf24;
                }
                
                /* Taille de police pour les badges et lments spcifiques */
                .grade-badge {
                    font-size: 1.1rem; /* Augmenter la taille des badges */
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user-tie text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">Espace Tuteur</h1>
                                <p class="text-sm text-gray-600">Suivi familial et administratif</p>
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
                                    <div class="w-10 h-10 bg-gradient-to-br from-teal-400 to-blue-400 rounded-full flex items-center justify-center text-white font-semibold">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden md:block">
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Tuteur familial</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                    </div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i> Mon Profil
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i> Paramètres
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-shield-alt mr-2"></i> Sécurité
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

            <div class="flex min-h-[calc(100vh-73px)]">
                <!-- Sidebar -->
                <aside class="sidebar w-64 text-black hidden md:block fixed top-[74px] left-0 h-[calc(100vh-74px)] z-40 overflow-y-auto">
                    <div class="p-6 h-full overflow-y-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-blue-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-family"></i>
                            </div>
                            <h2 class="text-lg font-semibold">Navigation Tuteur</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'active' => true],
                                ['icon' => 'fas fa-graduation-cap', 'label' => 'Mes Élèves', 'badge' => '3'],
                                ['icon' => 'fas fa-dollar-sign', 'label' => 'Paiements', 'badge' => '2'],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Bulletins', 'badge' => '2'],
                                ['icon' => 'fas fa-comments', 'label' => 'Messages', 'badge' => '4'],
                                ['icon' => 'fas fa-users', 'label' => 'Réunions', 'badge' => '1'],
                                ['icon' => 'fas fa-calendar-alt', 'label' => 'Calendrier'],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Suivi scolaire']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-black/10 border-l-4 border-blue-500' : ''; ?>">
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
                                <p class="text-sm text-black/80 mb-1">Prochaine réunion</p>
                                <p class="font-medium text-black">Lundi 23 Oct, 16h</p>
                                <p class="text-xs text-black/60 mt-1">Avec Prof. Principal</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-teal-500 to-blue-500 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 ml-64 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px]">
                    <!-- Welcome Header -->
                    <div class="mb-8 mt-28">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                                    Bonjour, <span class="gradient-text"><?php echo htmlspecialchars(explode(' ', $this->user['nom'])[0]); ?>!</span>
                                </h1>
                                <p class="text-gray-600 text-lg">
                                    <i class="fas fa-calendar-day text-teal-500 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1] . ' ' . date('Y');
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-user-graduate text-blue-500 mr-1"></i>
                                    3 élèves suivis
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="px-4 py-2 bg-teal-50 text-teal-700 rounded-full text-sm font-medium">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span class="time-display"><?php echo date('H:i'); ?></span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-lg hover:opacity-90 transition-opacity">
                                    <i class="fas fa-bell mr-2"></i>Alertes
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'eleves_suivis' => '3',
                            'paiements_en_retard' => '2',
                            'messages_non_lus' => '4',
                            'reunions_prevues' => '1',
                            'bulletins_disponibles' => '2',
                            'absences_recentes' => '3'
                        ];
                        
                        if (isset($content['stats_config'])) {
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
                            <?php if($key === 'paiements_en_retard' && $value > 0): ?>
                            <div class="mt-4 pt-3 border-t border-red-100">
                                <p class="text-xs text-red-600 font-medium">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Action requise
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
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Mes élèves -->
                        <div class="lg:col-span-2">
                            <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="fas fa-graduation-cap text-teal-500 mr-2"></i>
                                        Mes Élèves
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-teal-600 hover:text-teal-800 flex items-center">
                                        Profils détaillés
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['students_data']) && is_array($content['students_data'])) {
                                        foreach($content['students_data'] as $index => $student): 
                                            $statusColor = match(true) {
                                                strpos($student['status'], 'Bon') !== false => 'green',
                                                strpos($student['status'], 'À surveiller') !== false => 'yellow',
                                                default => 'red'
                                            };
                                    ?>
                                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:border-teal-200 transition-colors animate-slide-in-right" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-gradient-to-br from-teal-100 to-blue-100 rounded-full flex items-center justify-center mr-4 font-semibold text-teal-700">
                                                <?php echo $student['avatar']; ?>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($student['name']); ?></h4>
                                                <div class="flex items-center mt-1">
                                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($student['class']); ?></span>
                                                    <span class="mx-2 text-gray-300">•</span>
                                                    <span class="text-xs px-2 py-1 bg-<?php echo $statusColor; ?>-100 text-<?php echo $statusColor; ?>-800 rounded-full font-medium">
                                                        <?php echo $student['status']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-gray-900"><?php echo $student['average']; ?></div>
                                            <div class="text-xs text-gray-500">Moyenne générale</div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun élève enregistré</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Paiements urgents -->
                        <div>
                            <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
                                        Paiements urgents
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-800 flex items-center">
                                        Payer tous
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['payments_data']) && is_array($content['payments_data'])) {
                                        foreach($content['payments_data'] as $index => $payment): 
                                    ?>
                                    <div class="payment-card rounded-lg p-4 border-2 border-orange-300 animate-slide-in-right" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($payment['student']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($payment['type']); ?></p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-medium bg-orange-500 text-white rounded-full animate-pulse-gentle">
                                                <i class="fas fa-clock mr-1"></i>Urgent
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div>
                                                <p class="text-lg font-bold text-gray-900"><?php echo number_format($payment['amount'], 0, ',', ' '); ?> FC</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">Échéance</p>
                                                <p class="text-sm font-medium text-red-600"><?php echo $payment['due_date']; ?></p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <button class="px-3 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm rounded-lg hover:opacity-90 transition-opacity">
                                                <i class="fas fa-credit-card mr-1"></i>Payer
                                            </button>
                                            <button class="px-3 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-file-invoice mr-1"></i>Facture
                                            </button>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun paiement en attente</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Communications récentes -->
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-comments text-blue-500 mr-2"></i>
                                    Communications récentes
                                </h3>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                    Toutes les communications
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
                                <div class="flex items-start p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-100 hover:border-blue-200 transition-colors">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-<?php echo match($comm['type']) { 
                                                'note' => 'chart-line', 
                                                'reunion' => 'users', 
                                                'absence' => 'clock',
                                                'payment' => 'file-invoice-dollar',
                                                default => 'comment-dots' 
                                            }; ?> text-blue-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900"><?php echo htmlspecialchars($comm['sender']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($comm['subject']); ?></p>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <span class="text-xs px-2 py-1 bg-<?php echo $priorityColor; ?>-100 text-<?php echo $priorityColor; ?>-800 rounded-full font-medium mb-1">
                                                    <?php echo ucfirst($comm['priority']); ?>
                                                </span>
                                                <p class="text-xs text-gray-400"><?php echo $comm['date']; ?></p>
                                            </div>
                                        </div>
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
                        <div class="glass-card rounded-xl shadow-sm p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <i class="fas fa-bolt text-purple-500 mr-2"></i>
                                    Actions rapides
                                </h3>
                                <span class="text-xs text-gray-500">Accès direct</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php 
                                if (isset($content['quick_actions']) && is_array($content['quick_actions'])) {
                                    foreach($content['quick_actions'] as $action): 
                                ?>
                                <a href="<?php echo $action['link'] ?? '#'; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 hover:border-<?php echo $action['color'] ?? 'teal'; ?>-300 hover:shadow-md transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color'] ?? 'teal'; ?>-500 to-<?php echo $action['color'] ?? 'teal'; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                        <i class="<?php echo $action['icon'] ?? 'fas fa-question'; ?> text-white text-xl"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 text-center group-hover:text-<?php echo $action['color'] ?? 'teal'; ?>-700">
                                        <?php echo htmlspecialchars($action['title'] ?? 'Action'); ?>
                                    </span>
                                </a>
                                <?php 
                                    endforeach;
                                } else {
                                    $defaultActions = [
                                        ['title' => 'Payer en ligne', 'icon' => 'fas fa-credit-card', 'color' => 'teal', 'link' => '#'],
                                        ['title' => 'Consulter bulletins', 'icon' => 'fas fa-file-invoice', 'color' => 'green', 'link' => '#'],
                                        ['title' => 'Prendre rendez-vous', 'icon' => 'fas fa-calendar-plus', 'color' => 'blue', 'link' => '#'],
                                        ['title' => 'Contacter l\'école', 'icon' => 'fas fa-headset', 'color' => 'purple', 'link' => '#'],
                                    ];
                                    
                                    foreach($defaultActions as $action):
                                ?>
                                <a href="<?php echo $action['link']; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-200 hover:border-<?php echo $action['color']; ?>-300 hover:shadow-md transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color']; ?>-500 to-<?php echo $action['color']; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
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
                            
                            <!-- Information -->
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <div class="p-4 bg-gradient-to-r from-blue-50 to-teal-50 rounded-lg border border-blue-100">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-teal-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-info-circle text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Prochaine réunion parents-professeurs</p>
                                            <p class="text-xs text-gray-600">Lundi 23 octobre, 16h - Salle polyvalente</p>
                                        </div>
                                    </div>
                                    <button class="mt-3 w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-teal-500 text-white text-sm rounded-lg hover:opacity-90 transition-opacity">
                                        <i class="fas fa-calendar-check mr-2"></i>Confirmer ma présence
                                    </button>
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
                
                // Payment animation
                const paymentCards = document.querySelectorAll('.payment-card');
                paymentCards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        card.style.transform = 'scale(1.02)';
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'scale(1)';
                    });
                });
                
                // Alert badge animation
                const alertBadge = document.querySelector('.animate-pulse-gentle');
                if (alertBadge) {
                    setInterval(() => {
                        alertBadge.style.animation = 'none';
                        setTimeout(() => {
                            alertBadge.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
                        }, 10);
                    }, 2000);
                }
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new TuteurDashboardStandalone();
echo $dashboard->render();
?>