<?php
/**
 * Dashboard Administrateur - Version Standalone Complète
 * Design moderne et complet pour l'administrateur
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Dr. Samuel Mbongo',
    'role' => 'administrateur',
    'email' => 'directeur@ecole.fr',
    'id_utilisateur' => 1,
    'matricule' => 'ADM-2023-001',
    'fonction' => 'Directeur Administratif',
    'experience' => '12 ans'
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
    public static function getAdminContent() {
        return [
            'stats_config' => [
                'total_eleves' => [
                    'label' => 'Élèves inscrits',
                    'icon' => 'fas fa-graduation-cap',
                    'color' => 'blue',
                    'trend' => 'up'
                ],
                'total_enseignants' => [
                    'label' => 'Enseignants',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'color' => 'green',
                    'trend' => 'stable'
                ],
                'total_classes' => [
                    'label' => 'Classes actives',
                    'icon' => 'fas fa-school',
                    'color' => 'purple',
                    'trend' => 'up'
                ],
                'total_cours' => [
                    'label' => 'Cours programmés',
                    'icon' => 'fas fa-book-open',
                    'color' => 'orange',
                    'trend' => 'up'
                ],
                'paiements_en_attente' => [
                    'label' => 'Paiements en attente',
                    'icon' => 'fas fa-dollar-sign',
                    'color' => 'red',
                    'trend' => 'down'
                ],
                'discipline_cases' => [
                    'label' => 'Cas disciplinaires',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'yellow',
                    'trend' => 'down'
                ]
            ],
            'activities_data' => [
                [
                    'type' => 'Inscription',
                    'description' => 'Nouvel élève inscrit',
                    'user' => 'Kevin Mbala',
                    'class' => 'Terminale S',
                    'time' => 'Il y a 10 minutes',
                    'priority' => 'normal'
                ],
                [
                    'type' => 'Paiement',
                    'description' => 'Frais trimestriels payés',
                    'user' => 'Sarah Nkosi',
                    'class' => '1ère Littéraire',
                    'time' => 'Il y a 30 minutes',
                    'priority' => 'low'
                ],
                [
                    'type' => 'Absence',
                    'description' => 'Absence non justifiée',
                    'user' => 'Professeur Dupont',
                    'class' => 'Mathématiques',
                    'time' => 'Il y a 2 heures',
                    'priority' => 'high'
                ],
                [
                    'type' => 'Rapport',
                    'description' => 'Rapport trimestriel généré',
                    'user' => 'Système',
                    'class' => 'Toutes classes',
                    'time' => 'Il y a 4 heures',
                    'priority' => 'normal'
                ],
                [
                    'type' => 'Maintenance',
                    'description' => 'Sauvegarde système effectuée',
                    'user' => 'Système',
                    'class' => 'Base de données',
                    'time' => 'Il y a 6 heures',
                    'priority' => 'low'
                ]
            ],
            'alerts_data' => [
                [
                    'title' => 'Serveur surchargé',
                    'description' => 'Utilisation CPU à 95%',
                    'severity' => 'high',
                    'time' => 'Il y a 15 minutes',
                    'action' => 'redémarrer'
                ],
                [
                    'title' => 'Licence expirée',
                    'description' => 'Licence logiciel expire dans 7 jours',
                    'severity' => 'medium',
                    'time' => 'Il y a 2 jours',
                    'action' => 'renouveler'
                ],
                [
                    'title' => 'Sauvegarde échouée',
                    'description' => 'Échec sauvegarde nocturne',
                    'severity' => 'high',
                    'time' => 'Hier, 03:00',
                    'action' => 'vérifier'
                ],
                [
                    'title' => 'Mise à jour disponible',
                    'description' => 'Nouvelle version v2.5.0',
                    'severity' => 'low',
                    'time' => 'Il y a 3 jours',
                    'action' => 'installer'
                ]
            ],
            'system_data' => [
                'cpu_usage' => 65,
                'memory_usage' => 72,
                'storage_usage' => 58,
                'uptime' => '45 jours',
                'last_backup' => 'Hier, 02:00',
                'active_sessions' => 142
            ],
            'quick_actions' => [
                [
                    'icon' => 'fas fa-user-plus',
                    'label' => 'Nouvel utilisateur',
                    'color' => 'blue',
                    'action' => 'addUser'
                ],
                [
                    'icon' => 'fas fa-file-invoice-dollar',
                    'label' => 'Générer facture',
                    'color' => 'green',
                    'action' => 'generateInvoice'
                ],
                [
                    'icon' => 'fas fa-chart-bar',
                    'label' => 'Rapport statistique',
                    'color' => 'purple',
                    'action' => 'generateReport'
                ],
                [
                    'icon' => 'fas fa-cog',
                    'label' => 'Paramètres système',
                    'color' => 'orange',
                    'action' => 'systemSettings'
                ],
                [
                    'icon' => 'fas fa-database',
                    'label' => 'Sauvegarde',
                    'color' => 'red',
                    'action' => 'backupSystem'
                ],
                [
                    'icon' => 'fas fa-shield-alt',
                    'label' => 'Sécurité',
                    'color' => 'yellow',
                    'action' => 'securityCheck'
                ],
                [
                    'icon' => 'fas fa-bell',
                    'label' => 'Notifications',
                    'color' => 'pink',
                    'action' => 'manageNotifications'
                ],
                [
                    'icon' => 'fas fa-tools',
                    'label' => 'Maintenance',
                    'color' => 'indigo',
                    'action' => 'systemMaintenance'
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
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 École Excellence</p>
                            <p class="text-xs text-gray-500">Admin Panel v3.2.1 • Sécurité renforcée</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-server mr-1"></i> Serveur
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-lock mr-1"></i> Sécurité
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-chart-line mr-1"></i> Monitoring
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Administrateur - Version Standalone Améliorée
 */
class AdminDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getAdminContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Administration - Dashboard Système</title>
            
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
                                'admin': {
                                    50: '#f8fafc',
                                    100: '#f1f5f9',
                                    500: '#64748b',
                                    600: '#475569',
                                    700: '#334155',
                                }
                            },
                            animation: {
                                'fade-in-up': 'fadeInUp 0.6s ease-out',
                                'fade-in': 'fadeIn 0.8s ease-out',
                                'slide-in-right': 'slideInRight 0.5s ease-out',
                                'pulse-subtle': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                                'spin-slow': 'spin 3s linear infinite',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                .heading {
                    font-family: 'Inter', sans-serif;
                    font-weight: 700;
                }
                
                .mono {
                    font-family: 'Roboto Mono', monospace;
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
                    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
                
                .alert-high {
                    border-left: 4px solid #ef4444;
                    animation: pulse-subtle 2s infinite;
                }
                
                .alert-medium {
                    border-left: 4px solid #f59e0b;
                }
                
                .alert-low {
                    border-left: 4px solid #10b981;
                }
                
                .progress-bar {
                    height: 8px;
                    border-radius: 4px;
                    overflow: hidden;
                    background: #e5e7eb;
                }
                
                .progress-fill {
                    height: 100%;
                    border-radius: 4px;
                    transition: width 1s ease-in-out;
                }
                
                .server-status {
                    position: relative;
                }
                
                .server-status::before {
                    content: '';
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    background: #10b981;
                    animation: blink 2s infinite;
                }
                
                .server-critical::before {
                    background: #ef4444;
                    animation: blink 1s infinite;
                }
            </style>
        </head>
        
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Administration Système</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['fonction']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['experience']); ?> d'expérience</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- System Status -->
                            <div class="hidden md:flex items-center space-x-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium">
                                <i class="fas fa-server"></i>
                                <span>Système: <span class="font-bold">Opérationnel</span></span>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                                </button>
                            </div>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Administrateur Système</p>
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
                                        <i class="fas fa-user-shield mr-3 text-blue-600"></i>
                                        Mon Profil Admin
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-3 text-indigo-600"></i>
                                        Paramètres Système
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-history mr-3 text-gray-600"></i>
                                        Journal d'activité
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Déconnexion Admin
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
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bars text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Navigation Admin</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-users', 'label' => 'Gestion Utilisateurs', 'badge' => '3'],
                                ['icon' => 'fas fa-graduation-cap', 'label' => 'Élèves', 'badge' => '245'],
                                ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Enseignants', 'badge' => '32'],
                                ['icon' => 'fas fa-school', 'label' => 'Classes', 'badge' => '12'],
                                ['icon' => 'fas fa-dollar-sign', 'label' => 'Finances', 'badge' => '8'],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Statistiques', 'badge' => ''],
                                ['icon' => 'fas fa-cog', 'label' => 'Paramètres', 'badge' => ''],
                                ['icon' => 'fas fa-server', 'label' => 'Serveur', 'badge' => ''],
                                ['icon' => 'fas fa-lock', 'label' => 'Sécurité', 'badge' => '2'],
                                ['icon' => 'fas fa-database', 'label' => 'Base de données', 'badge' => ''],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'badge' => '5']
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
                        
                        <!-- System Info -->
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-3">État du système</p>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Sessions actives:</span>
                                        <span class="font-bold text-blue-600">142</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Uptime:</span>
                                        <span class="font-bold text-green-600">45 jours</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Dernière sauvegarde:</span>
                                        <span class="font-bold text-gray-600">Hier, 02:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-full shadow-lg flex items-center justify-center">
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
                                    <i class="fas fa-clock text-blue-600 mr-1"></i>
                                    <span class="time-display font-medium mono"><?php echo date('H:i:s'); ?></span>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-server text-green-600 mr-1"></i>
                                    <span class="font-medium text-green-700">Système opérationnel</span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    <span>Niveau de sécurité: Élevé</span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Action rapide
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'total_eleves' => '245',
                            'total_enseignants' => '32',
                            'total_classes' => '12',
                            'total_cours' => '68',
                            'paiements_en_attente' => '8',
                            'discipline_cases' => '3'
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
                                        'up' => '+12% ce mois', 
                                        'down' => '-5% ce mois', 
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

                    <!-- System Monitoring -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Server Status -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-server text-blue-600 mr-2"></i>
                                        État du Serveur
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Monitoring en temps réel</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    En ligne
                                </span>
                            </div>
                            <div class="space-y-4">
                                <?php 
                                $systemData = $content['system_data'] ?? [];
                                ?>
                                <!-- CPU Usage -->
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium text-gray-700">CPU</span>
                                        <span class="font-bold <?php echo $systemData['cpu_usage'] > 80 ? 'text-red-600' : 'text-green-600'; ?>">
                                            <?php echo $systemData['cpu_usage'] ?? 0; ?>%
                                        </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill bg-<?php echo $systemData['cpu_usage'] > 80 ? 'red' : 'blue'; ?>-500" 
                                             style="width: <?php echo $systemData['cpu_usage'] ?? 0; ?>%"></div>
                                    </div>
                                </div>
                                
                                <!-- Memory Usage -->
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium text-gray-700">Mémoire</span>
                                        <span class="font-bold <?php echo $systemData['memory_usage'] > 80 ? 'text-yellow-600' : 'text-green-600'; ?>">
                                            <?php echo $systemData['memory_usage'] ?? 0; ?>%
                                        </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill bg-<?php echo $systemData['memory_usage'] > 80 ? 'yellow' : 'green'; ?>-500" 
                                             style="width: <?php echo $systemData['memory_usage'] ?? 0; ?>%"></div>
                                    </div>
                                </div>
                                
                                <!-- Storage Usage -->
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium text-gray-700">Stockage</span>
                                        <span class="font-bold <?php echo $systemData['storage_usage'] > 80 ? 'text-yellow-600' : 'text-green-600'; ?>">
                                            <?php echo $systemData['storage_usage'] ?? 0; ?>%
                                        </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill bg-<?php echo $systemData['storage_usage'] > 80 ? 'yellow' : 'purple'; ?>-500" 
                                             style="width: <?php echo $systemData['storage_usage'] ?? 0; ?>%"></div>
                                    </div>
                                </div>
                                
                                <!-- System Info -->
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500 mb-1">Uptime</p>
                                            <p class="font-medium"><?php echo $systemData['uptime'] ?? 'N/A'; ?></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 mb-1">Sessions actives</p>
                                            <p class="font-medium"><?php echo $systemData['active_sessions'] ?? '0'; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activités Récentes -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-history text-purple-600 mr-2"></i>
                                        Activités Récentes
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Journal système</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-800 flex items-center">
                                    Voir tout
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-3">
                                <?php 
                                if (isset($content['activities_data']) && is_array($content['activities_data'])) {
                                    foreach($content['activities_data'] as $index => $activity): 
                                        $priority = $activity['priority'];
                                        $priorityIcon = $priority === 'high' ? 'fa-exclamation-circle text-red-500' : 
                                                       ($priority === 'medium' ? 'fa-exclamation-triangle text-yellow-500' : 'fa-info-circle text-green-500');
                                ?>
                                <div class="flex items-center p-3 rounded-lg border border-gray-200 hover:border-gray-300 transition-all animate-slide-in-right" style="animation-delay: <?php echo $index * 0.05; ?>s">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-gray-100">
                                        <i class="fas <?php echo $priorityIcon; ?>"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold text-gray-900 truncate"><?php echo htmlspecialchars($activity['type']); ?></h4>
                                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0"><?php echo $activity['time']; ?></span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate"><?php echo htmlspecialchars($activity['description']); ?></p>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span class="flex items-center mr-3">
                                                <i class="fas fa-user mr-1"></i>
                                                <?php echo htmlspecialchars($activity['user']); ?>
                                            </span>
                                            <?php if(!empty($activity['class'])): ?>
                                            <span class="flex items-center">
                                                <i class="fas fa-school mr-1"></i>
                                                <?php echo htmlspecialchars($activity['class']); ?>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucune activité récente</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Alertes Système -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                        Alertes Système
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">Attention requise</p>
                                </div>
                                <a href="#" class="text-sm font-medium text-red-600 hover:text-red-800 flex items-center">
                                    Résoudre tout
                                    <i class="fas fa-wrench ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php 
                                if (isset($content['alerts_data']) && is_array($content['alerts_data'])) {
                                    foreach($content['alerts_data'] as $index => $alert): 
                                        $severity = $alert['severity'];
                                        $severityClass = 'alert-' . $severity;
                                        $severityColor = $severity === 'high' ? 'red' : 
                                                        ($severity === 'medium' ? 'yellow' : 'green');
                                ?>
                                <div class="flex items-center p-4 rounded-lg border border-<?php echo $severityColor; ?>-200 bg-<?php echo $severityColor; ?>-50 hover:border-<?php echo $severityColor; ?>-300 transition-all animate-slide-in-right <?php echo $severityClass; ?>" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-<?php echo $severityColor; ?>-100">
                                        <i class="fas fa-exclamation-triangle text-<?php echo $severityColor; ?>-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($alert['title']); ?></h4>
                                            <span class="text-xs text-gray-500 ml-2 flex-shrink-0"><?php echo $alert['time']; ?></span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($alert['description']); ?></p>
                                    </div>
                                    <button onclick="resolveAlert('<?php echo $alert['action']; ?>')" class="ml-2 px-3 py-1 bg-<?php echo $severityColor; ?>-100 text-<?php echo $severityColor; ?>-800 text-xs font-medium rounded-lg hover:bg-<?php echo $severityColor; ?>-200 transition-colors flex-shrink-0">
                                        <?php echo ucfirst($alert['action']); ?>
                                    </button>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucune alerte système</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Rapides -->
                    <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-bolt text-blue-600 mr-2"></i>
                                    Actions Rapides Administratives
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Gestion système immédiate</p>
                            </div>
                            <button onclick="showAllActions()" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                Voir toutes
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                            <?php 
                            if (isset($content['quick_actions'])) {
                                foreach($content['quick_actions'] as $index => $action): 
                            ?>
                            <button onclick="<?php echo $action['action']; ?>()" class="p-4 bg-<?php echo $action['color']; ?>-50 hover:bg-<?php echo $action['color']; ?>-100 rounded-xl text-center transition-all duration-300 hover-lift animate-fade-in-up" style="animation-delay: <?php echo $index * 0.05; ?>s">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-lg flex items-center justify-center bg-<?php echo $action['color']; ?>-100">
                                    <i class="<?php echo $action['icon']; ?> text-<?php echo $action['color']; ?>-600 text-xl"></i>
                                </div>
                                <p class="text-xs font-medium text-gray-800 leading-tight"><?php echo $action['label']; ?></p>
                            </button>
                            <?php 
                                endforeach;
                            } else {
                                echo '<div class="col-span-8 text-center py-8 text-gray-500">Aucune action disponible</div>';
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
                
                // Alert functions
                function resolveAlert(action) {
                    const actions = {
                        'redémarrer': '🔧 Redémarrage du service en cours...',
                        'renouveler': '📄 Ouverture du portail de licence...',
                        'vérifier': '🔍 Vérification des paramètres...',
                        'installer': '⬇️ Téléchargement de la mise à jour...'
                    };
                    
                    const message = actions[action] || `Action "${action}" exécutée`;
                    alert('⚙️ Résolution d\'alerte\n\n' + message);
                }
                
                // Quick action functions
                function addUser() {
                    alert('👤 Ajouter un utilisateur\n\nOuverture du formulaire de création d\'utilisateur.');
                }
                
                function generateInvoice() {
                    alert('🧾 Générer une facture\n\nSélectionnez le type de facture à générer.');
                }
                
                function generateReport() {
                    alert('📊 Générer un rapport\n\nCréation d\'un rapport statistique détaillé.');
                }
                
                function systemSettings() {
                    alert('⚙️ Paramètres système\n\nAccès aux paramètres avancés du système.');
                }
                
                function backupSystem() {
                    alert('💾 Sauvegarde système\n\nLancement de la sauvegarde complète.');
                }
                
                function securityCheck() {
                    alert('🛡️ Vérification sécurité\n\nAnalyse de sécurité en cours...');
                }
                
                function manageNotifications() {
                    alert('🔔 Gestion notifications\n\nConfiguration des préférences de notification.');
                }
                
                function systemMaintenance() {
                    alert('🔧 Maintenance système\n\nAccès aux outils de maintenance.');
                }
                
                function showAllActions() {
                    alert('📋 Toutes les actions\n\nListe complète des actions administratives disponibles.');
                }
                
                // Progress bar animation
                document.querySelectorAll('.progress-fill').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 300);
                });
                
                // Live time update
                function updateTime() {
                    const now = new Date();
                    const timeElement = document.querySelector('.time-display');
                    if (timeElement) {
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        const seconds = now.getSeconds().toString().padStart(2, '0');
                        timeElement.textContent = `${hours}:${minutes}:${seconds}`;
                    }
                }
                
                // Update every second
                setInterval(updateTime, 1000);
                
                // Initial update
                updateTime();
                
                // System status simulation
                function updateSystemStatus() {
                    const statusBadge = document.querySelector('[class*="Système:"]');
                    if (statusBadge && Math.random() > 0.9) {
                        statusBadge.innerHTML = '<i class="fas fa-server"></i><span>Système: <span class="font-bold text-yellow-600">Attention</span></span>';
                        statusBadge.classList.remove('bg-green-50', 'text-green-700');
                        statusBadge.classList.add('bg-yellow-50', 'text-yellow-700');
                    }
                }
                
                // Update status randomly
                setInterval(updateSystemStatus, 30000);
                
                // Quick action button
                const quickActionBtn = document.querySelector('[class*="Action rapide"]');
                if (quickActionBtn) {
                    quickActionBtn.addEventListener('click', () => {
                        const actions = [
                            '🚀 Optimisation système',
                            '📊 Génération rapport automatique',
                            '🔒 Vérification sécurité',
                            '🔄 Synchronisation données'
                        ];
                        const action = actions[Math.floor(Math.random() * actions.length)];
                        alert('⚡ Action rapide\n\n' + action);
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
$dashboard = new AdminDashboardStandalone();
echo $dashboard->render();
?>