<?php
/**
 * Dashboard Préfet - Version Standalone
 * Design moderne avec toutes les classes intégrées
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Commandant Jean Dubois',
    'role' => 'prefet',
    'email' => 'j.dubois@ecole.fr',
    'id_utilisateur' => 5,
    'grade' => 'Préfet Principal',
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
    public static function getPrefetContent() {
        return [
            'stats_config' => [
                'surveillances_ce_jour' => [
                    'label' => 'Surveil Aujourd\'hui',
                    'icon' => 'fas fa-eye',
                    'color' => 'blue'
                ],
                'rapports_rediges' => [
                    'label' => 'Rapports rédigés (7j)',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'green'
                ],
                'incidents_signales' => [
                    'label' => 'Incidents signalés (7j)',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'red'
                ],
                'classes_assignees' => [
                    'label' => 'Classes assignées',
                    'icon' => 'fas fa-school',
                    'color' => 'purple'
                ],
                'messages_administration' => [
                    'label' => 'Messages admin',
                    'icon' => 'fas fa-envelope',
                    'color' => 'yellow'
                ],
                'prochaines_surveillances' => [
                    'label' => 'Prochaines surveil',
                    'icon' => 'fas fa-calendar-check',
                    'color' => 'orange'
                ]
            ],
            'duties_data' => [
                [
                    'time' => '08:00 - 09:00',
                    'location' => 'Portail principal',
                    'type' => 'Entrée/Sortie',
                    'class' => 'Toutes classes',
                    'status' => 'en_cours'
                ],
                [
                    'time' => '10:30 - 11:00',
                    'location' => 'Cour de récréation',
                    'type' => 'Surveillance',
                    'class' => 'Primaire',
                    'status' => 'a_venir'
                ],
                [
                    'time' => '12:00 - 13:00',
                    'location' => 'Cafétéria',
                    'type' => 'Surveillance déjeuner',
                    'class' => 'Toutes',
                    'status' => 'a_venir'
                ],
                [
                    'time' => '15:00 - 16:00',
                    'location' => 'Bâtiment administratif',
                    'type' => 'Patrouille',
                    'class' => 'Secondaire',
                    'status' => 'a_venir'
                ],
                [
                    'time' => '17:00 - 18:00',
                    'location' => 'Portail principal',
                    'type' => 'Sortie',
                    'class' => 'Toutes',
                    'status' => 'a_venir'
                ]
            ],
            'reports_data' => [
                [
                    'type' => 'Incident',
                    'description' => 'Brouille entre élèves - 6ème Scientifique',
                    'date' => 'Aujourd\'hui, 09:15',
                    'status' => 'résolu'
                ],
                [
                    'type' => 'Surveillance',
                    'description' => 'Rapport de surveillance - Déjeuner',
                    'date' => 'Hier, 13:30',
                    'status' => 'terminé'
                ],
                [
                    'type' => 'Discipline',
                    'description' => 'Retard collectif - 5ème Scientifique',
                    'date' => 'Hier, 08:45',
                    'status' => 'en cours'
                ],
                [
                    'type' => 'Sécurité',
                    'description' => 'Objet suspect signalé',
                    'date' => '12/01/2026',
                    'status' => 'résolu'
                ]
            ],
            'announcements_data' => [
                [
                    'title' => 'Réunion préfets',
                    'content' => 'Réunion hebdomadaire des préfets - Ordre du jour: sécurité et discipline',
                    'date' => 'Demain, 14h',
                    'priority' => 'high'
                ],
                [
                    'title' => 'Nouvelles procédures',
                    'content' => 'Mise à jour des procédures de sécurité - Consulter le manuel',
                    'date' => 'Aujourd\'hui',
                    'priority' => 'medium'
                ],
                [
                    'title' => 'Formation surveillance',
                    'content' => 'Atelier sur les techniques de surveillance avancée',
                    'date' => '20/01/2026',
                    'priority' => 'low'
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Nouveau rapport',
                    'icon' => 'fas fa-plus-circle',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Signaler incident',
                    'icon' => 'fas fa-exclamation-circle',
                    'color' => 'red',
                    'link' => '#'
                ],
                [
                    'title' => 'Signalement élève',
                    'icon' => 'fas fa-flag',
                    'color' => 'yellow',
                    'link' => '#'
                ],
                [
                    'title' => 'Messages',
                    'icon' => 'fas fa-envelope',
                    'color' => 'green',
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
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 École Excellence</p>
                            <p class="text-xs text-gray-500">Système Préfectoral v3.2</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-phone mr-1"></i> Urgence: 01 23 45 67 89
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-file-contract mr-1"></i> Procédures
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Préfet - Version Standalone Améliorée
 */
class PrefetDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getPrefetContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Préfet - Dashboard</title>
            
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
                                'security': {
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
                                'pulse-security': 'pulse 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                body {
                    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                    min-height: 100vh;
                    font-size: 14px; /* Taille réduite pour compacité */
                }
                
                .heading {
                    font-family: 'Rajdhani', sans-serif;
                    font-weight: 700;
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
                    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
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
                
                .duty-current {
                    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
                    border-left: 4px solid #3b82f6;
                    animation: blink 2s infinite;
                }
                
                /* Augmenter la taille du texte dans tout le dashboard */
                h1 { font-size: 2.5rem; }
                h2 { font-size: 2rem; }
                h3 { font-size: 1.5rem; }
                h4 { font-size: 1.25rem; }
                p { font-size: 1rem; }
                .text-sm { font-size: 0.875rem; }
                .text-xs { font-size: 0.75rem; }
                .text-lg { font-size: 1.125rem; }
                .text-xl { font-size: 1.25rem; }
                .text-2xl { font-size: 1.5rem; }
                .text-3xl { font-size: 1.875rem; }
                
                /* Taille de police pour les badges et éléments spécifiques */
                .grade-badge {
                    font-size: 1.1rem; /* Augmenter la taille des badges */
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-700 to-indigo-800 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Espace Préfet</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['grade']); ?></span>
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="text-xs text-green-600 ml-1">• En service</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Emergency Alert -->
                            <button class="relative px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-opacity flex items-center">
                                <i class="fas fa-siren-on mr-2"></i>
                                <span>ALERTE</span>
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full alert-badge"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Préfet Principal</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">Matricule: PREF-<?php echo str_pad($this->user['id_utilisateur'], 4, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-shield mr-3 text-blue-600"></i>
                                        Mon Profil Préfectoral
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-key mr-3 text-green-600"></i>
                                        Identifiants & Sécurité
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-walkie-talkie mr-3 text-purple-600"></i>
                                        Équipement
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Fin de service
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex min-h-[calc(100vh-74px)]">
                <!-- Sidebar -->
                <aside class="w-64 text-gray-800 bg-white hidden md:block fixed top-[73px] left-0 h-[calc(100vh-73px)] z-40">
                    <div class="p-6 h-full overflow-y-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bars"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Commandement</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-eye', 'label' => 'Surveillance', 'badge' => '4'],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'badge' => '12'],
                                ['icon' => 'fas fa-exclamation-triangle', 'label' => 'Incidents', 'badge' => '3'],
                                ['icon' => 'fas fa-graduation-cap', 'label' => 'Élèves', 'badge' => ''],
                                ['icon' => 'fas fa-comments', 'label' => 'Communication', 'badge' => '5'],
                                ['icon' => 'fas fa-shield-alt', 'label' => 'Sécurité', 'badge' => '2'],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Analytique', 'badge' => ''],
                                ['icon' => 'fas fa-cog', 'label' => 'Configuration', 'badge' => '']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-blue-50 border-l-4 border-blue-500' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3 text-sm text-gray-600"></i>
                                <span class="flex-1 text-sm text-gray-700"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Status -->
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="px-4 py-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-medium text-gray-600">Statut opérationnel</p>
                                    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                </div>
                                <p class="text-xs text-gray-500">Service: 07h00 - 19h00</p>
                                <p class="text-xs text-gray-500">Zone: Secteur Principal</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-700 to-indigo-800 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 ml-64 p-4 md:p-6 lg:p-8 animate-fade-in overflow-y-auto" style="margin-top: 73px;">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 heading mb-2">
                                    Tableau de commandement <span class="gradient-text">Préfectoral</span>
                                </h1>
                                <p class="text-gray-600 text-lg">
                                    <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1] . ' ' . date('Y');
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-clock text-green-600 mr-1"></i>
                                    <span class="time-display font-medium"><?php echo date('H:i'); ?></span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-walkie-talkie mr-2"></i>
                                    <span>Fréquence: 146.520</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-radio mr-2"></i>
                                    Rapports vocaux
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'surveillances_ce_jour' => '4',
                            'rapports_rediges' => '12',
                            'incidents_signales' => '3',
                            'classes_assignees' => '8',
                            'messages_administration' => '5',
                            'prochaines_surveillances' => '7'
                        ];
                        
                        if (isset($content['stats_config'])) {
                            foreach($content['stats_config'] as $key => $stat): 
                                $value = $statsValues[$key] ?? '0';
                        ?>
                        <div class="stat-card bg-white rounded-xl shadow-md border border-gray-200 p-3 hover-lift animate-fade-in-up h-full flex flex-col justify-between" style="animation-delay: <?php echo array_search($key, array_keys($content['stats_config'])) * 0.1; ?>s">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 pr-2">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1 leading-tight"><?php echo $stat['label']; ?></p>
                                    <p class="text-xl font-bold text-gray-900 heading"><?php echo $value; ?></p>
                                </div>
                                <div class="p-2 rounded-xl bg-gradient-to-br from-<?php echo $stat['color']; ?>-600 to-<?php echo $stat['color']; ?>-700 shadow-md flex-shrink-0 w-10 h-10 flex items-center justify-center">
                                    <i class="<?php echo $stat['icon']; ?> text-white text-sm"></i>
                                </div>
                            </div>
                            <?php if(in_array($key, ['incidents_signales', 'messages_administration'])): ?>
                            <div class="mt-4 pt-3 border-t border-gray-100">        
                                <p class="text-xs font-medium text-<?php echo $stat['color']; ?>-700 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <?php echo rand(1, 20); ?>% vs hier
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <p class="text-xs font-medium text-gray-500 flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    Mis à jour: <?php echo date('H:i'); ?>
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
                        <!-- Missions du jour -->
                        <div class="lg:col-span-2">
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                                            Missions de surveillance
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Planification du <?php echo date('d/m/Y'); ?></p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                        Planning complet
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php 
                                    if (isset($content['duties_data']) && is_array($content['duties_data'])) {
                                        foreach($content['duties_data'] as $index => $duty): 
                                            $currentTime = date('H:i');
                                            $isCurrent = ($duty['status'] === 'en_cours');
                                    ?>
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition-all animate-slide-in-right <?php echo $isCurrent ? 'duty-current' : 'bg-white'; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 <?php echo $isCurrent ? 'bg-blue-100' : 'bg-gray-100'; ?>">
                                                <span class="text-lg font-bold text-gray-900"><?php echo substr($duty['time'], 0, 2); ?></span>
                                                <span class="text-xs text-gray-600"><?php echo substr($duty['time'], 6, 2); ?></span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($duty['type']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($duty['location']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-users mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($duty['class']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <?php if($isCurrent): ?>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full flex items-center">
                                                <i class="fas fa-play mr-1"></i>
                                                En cours
                                            </span>
                                            <button class="px-3 py-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-xs rounded-lg hover:opacity-90 transition-opacity">
                                                <i class="fas fa-check mr-1"></i>Terminer
                                            </button>
                                            <?php else: ?>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                À venir
                                            </span>
                                            <button class="px-3 py-1 bg-gray-200 text-gray-700 text-xs rounded-lg hover:bg-gray-300 transition-colors">
                                                <i class="fas fa-info mr-1"></i>Détails
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune mission planifiée</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Rapports récents -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-file-alt text-green-600 mr-2"></i>
                                        Rapports récents
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                                        Archives
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['reports_data']) && is_array($content['reports_data'])) {
                                        foreach($content['reports_data'] as $index => $report): 
                                            $statusColor = match($report['status']) {
                                                'résolu' => 'green',
                                                'en cours' => 'yellow',
                                                'terminé' => 'blue',
                                                default => 'gray'
                                            };
                                    ?>
                                    <div class="p-4 rounded-lg border-l-4 border-<?php echo $statusColor; ?>-500 bg-gradient-to-r from-gray-50 to-white animate-slide-in-right" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($report['type']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($report['description']); ?></p>
                                            </div>
                                            <span class="px-2 py-1 bg-<?php echo $statusColor; ?>-100 text-<?php echo $statusColor; ?>-800 text-xs font-medium rounded-full">
                                                <?php echo $report['status']; ?>
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span><?php echo $report['date']; ?></span>
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-800">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucun rapport disponible</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Annonces importantes -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-bullhorn text-orange-600 mr-2"></i>
                                    Annonces importantes
                                </h3>
                                <a href="#" class="text-sm font-medium text-orange-600 hover:text-orange-800 flex items-center">
                                    Toutes les annonces
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php 
                                if (isset($content['announcements_data']) && is_array($content['announcements_data'])) {
                                    foreach($content['announcements_data'] as $announcement): 
                                        $priorityColor = match($announcement['priority']) {
                                            'high' => 'red',
                                            'medium' => 'orange',
                                            default => 'green'
                                        };
                                ?>
                                <div class="p-4 rounded-lg border-l-4 border-<?php echo $priorityColor; ?>-500 bg-gradient-to-r from-gray-50 to-white hover:border-<?php echo $priorityColor; ?>-600 transition-colors">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 flex items-center">
                                                <?php echo htmlspecialchars($announcement['title']); ?>
                                                <span class="ml-2 px-2 py-1 bg-<?php echo $priorityColor; ?>-100 text-<?php echo $priorityColor; ?>-800 text-xs rounded-full">
                                                    <?php echo strtoupper($announcement['priority']); ?>
                                                </span>
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($announcement['content']); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mt-4">
                                        <span class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            <?php echo $announcement['date']; ?>
                                        </span>
                                        <button class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded hover:bg-gray-200 transition-colors">
                                            <i class="fas fa-bookmark mr-1"></i>Marquer lu
                                        </button>
                                    </div>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucune annonce disponible</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Actions rapides -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-bolt text-purple-600 mr-2"></i>
                                    Actions rapides
                                </h3>
                                <span class="text-xs text-gray-500">Accès prioritaire</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php 
                                if (isset($content['quick_actions']) && is_array($content['quick_actions'])) {
                                    foreach($content['quick_actions'] as $action): 
                                ?>
                                <a href="<?php echo $action['link'] ?? '#'; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color'] ?? 'blue'; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color'] ?? 'blue'; ?>-600 to-<?php echo $action['color'] ?? 'blue'; ?>-700 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
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
                                        ['title' => 'Nouveau rapport', 'icon' => 'fas fa-plus-circle', 'color' => 'blue', 'link' => '#'],
                                        ['title' => 'Signaler incident', 'icon' => 'fas fa-exclamation-circle', 'color' => 'red', 'link' => '#'],
                                        ['title' => 'Signalement élève', 'icon' => 'fas fa-flag', 'color' => 'yellow', 'link' => '#'],
                                        ['title' => 'Messages', 'icon' => 'fas fa-envelope', 'color' => 'green', 'link' => '#'],
                                    ];
                                    
                                    foreach($defaultActions as $action):
                                ?>
                                <a href="<?php echo $action['link']; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color']; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color']; ?>-600 to-<?php echo $action['color']; ?>-700 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
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
                            
                            <!-- Emergency Protocols -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="p-4 bg-gradient-to-r from-red-50 to-orange-50 rounded-lg border border-red-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-siren-on text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">Protocoles d'urgence</p>
                                            <p class="text-xs text-gray-600">Codes: ROUGE • ORANGE • VERT</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2 mt-3">
                                        <button class="px-3 py-2 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition-colors">
                                            Code Rouge
                                        </button>
                                        <button class="px-3 py-2 bg-orange-500 text-white text-xs rounded hover:bg-orange-600 transition-colors">
                                            Code Orange
                                        </button>
                                        <button class="px-3 py-2 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                            Code Vert
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
                
                // Emergency alert
                const emergencyBtn = document.querySelector('[class*="from-red-600"]');
                if (emergencyBtn) {
                    emergencyBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (confirm('⚠️ ACTIVATION ALERTE URGENCE\n\nCette action déclenchera l\'alerte générale. Confirmer?')) {
                            alert('🚨 ALERTE ACTIVÉE - Toutes les unités prévenues');
                            // Ici: Code pour déclencher l'alerte réelle
                        }
                    });
                }
                
                // Protocol buttons
                document.querySelectorAll('[class*="Code "]').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const code = this.textContent.trim();
                        alert(`Protocole ${code} activé\n\nProcédure en cours d'exécution...`);
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
                        
                        // Check for duty times
                        const currentHour = now.getHours();
                        const currentMinute = now.getMinutes();
                        const currentTime = currentHour * 60 + currentMinute;
                        
                        document.querySelectorAll('.duty-current').forEach(el => {
                            el.classList.remove('duty-current');
                        });
                        
                        document.querySelectorAll('[class*="bg-gray-100"]').forEach(el => {
                            const timeText = el.querySelector('span.text-lg')?.textContent;
                            if (timeText) {
                                const dutyHour = parseInt(timeText);
                                if (dutyHour === currentHour) {
                                    el.classList.add('duty-current');
                                }
                            }
                        });
                    }
                }
                
                // Update time every 30 seconds
                setInterval(updateTime, 30000);
                
                // Initial update
                updateTime();
                
                // Auto-refresh reports (simulated)
                setInterval(() => {
                    const reports = document.querySelectorAll('[class*="border-green-500"], [class*="border-yellow-500"]');
                    reports.forEach(report => {
                        if (Math.random() > 0.8) {
                            const statusBadge = report.querySelector('[class*="text-green-800"], [class*="text-yellow-800"]');
                            if (statusBadge) {
                                if (statusBadge.textContent.includes('en cours')) {
                                    statusBadge.textContent = 'résolu';
                                    statusBadge.className = statusBadge.className.replace('yellow', 'green');
                                    report.className = report.className.replace('border-yellow-500', 'border-green-500');
                                }
                            }
                        }
                    });
                }, 60000);
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new PrefetDashboardStandalone();
echo $dashboard->render();
?>