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
    
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <!-- Google Font (Inter) -->
            <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
            <!-- Chart.js pour graphiques réalistes -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

            
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

                .progress-sm {
                    display:flex;
                    align-items:center;
                    height:8px;
                    }
                                    
                .progress-bar {
                    height: 100%;
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


                /* =======================
                    styles pour le  main 
                =============================*/

                .table-finance th { 
                    background: #f8fafd;
                    color: #1e3a6f;
                    font-weight: 600;
                }
                .btn-primary { background: #1e3a6f; border-color: #1e3a6f; }
                .btn-primary:hover { background: #143157; border-color: #143157; }

                .nav-tabs .nav-link.active { 
                    background: #1e3a6f; 
                    color: white;
                    border-radius: 50px;
                }
                .nav-tabs .nav-link { 
                    color: #1e3a6f; 
                    border-radius: 50px;
                    padding: 0.5rem 1.5rem;
                    margin-right: 0.5rem;
                }

            </style>
        </head>
        
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white  border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">

                            <button class="mobileMenuToggle p-2 mr-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            
                            <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 md:hidden"></div>
                            
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>

                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading hidden lg:block">Administration Système</h1>
                                <div class="flex items-center mt-1 hidden lg:block">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['fonction']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600 "><?php echo htmlspecialchars($this->user['experience']); ?> d'expérience</span>
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
                <aside id="sidebar" class="sidebar fixed top-[74px] left-0 h-[calc(100vh-74px)] w-64 z-40 transform transition-transform duration-300 ease-in-out -translate-x-full">
                    <div class="p-6 h-full overflow-y-auto">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-bars text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Navigation Admin</h2>
                        </div>
                        
                        <nav class="space-y-2">

  
                        
                           <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'url'=>'dashboard_standalone_fixed.php','badge' => ''],
                                ['icon' => 'fas fa-users', 'label' => 'Gestion Utilisateurs','url'=>'gestion_utilisateur.php', 'badge' => '3'],
                                ['icon' => 'fas fa-graduation-cap', 'label' => 'Élèves', 'url'=>'gestion_etudiant.php', 'badge' => '245'],
                                ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Enseignants', 'url'=>'gestion_enseignant.php', 'badge' => '32'],
                                ['icon' => 'fas fa-school', 'label' => 'Classes', 'url'=>'gestion_classe.php', 'badge' => '12'],
                                ['icon' => 'fas fa-dollar-sign', 'label' => 'Finances', 'url'=>'finances.php', 'badge' => '8'],
                                ['icon' => 'fas fa-chart-line', 'label' => 'Statistiques', 'url'=>'dashboard_standalone_fixed.php', 'badge' => ''],
                                ['icon' => 'fas fa-cog', 'label' => 'Paramètres', 'url'=>'dashboard_standalone_fixed.php', 'badge' => ''],
                                ['icon' => 'fas fa-server', 'label' => 'Serveur', 'url'=>'dashboard_standalone_fixed.php', 'badge' => ''],
                                ['icon' => 'fas fa-lock', 'label' => 'Sécurité', 'url'=>'dashboard_standalone_fixed.php', 'badge' => '2'],
                                ['icon' => 'fas fa-database', 'label' => 'Base de données', 'url'=>'dashboard_standalone_fixed.php', 'badge' => ''],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'url'=>'dashboard_standalone_fixed.php', 'badge' => '5']
                            ] 
                            as $item): ?>


                            <a href="<?php echo $item['url'] ?? '#'; ?>"   class="flex items-center px-4 py-3 rounded-lg hover:bg-black/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-black/10 shadow-inner' : ''; ?>">

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
                <main class="mainContent flex-1 md:p-6 lg:p-1 animate-fade-in mt-[90px] ml-0 transition-all duration-300">

                    <div class="container-fluid px-4">

                        <!-- En-tête avec date et actions -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                            
                            

                            <div>
                                <h3 class="fs-3" style="color:#0a2647;"> Finance & Analytics</h3>
                                <p class="text-secondary">
                                    <i class="bi bi-calendar3 me-2"></i>2025-2026 · Dernière mise à jour : 15 Mars 2025
                                </p>
                            </div>


                            <div class="input-group border" style="width:250px;">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-0" placeholder="Rechercher...">
                            </div>
                            
                            <div class="d-flex gap-2 mt-2">
                                <button class="btn btn-outline-primary"><i class="bi bi-file-pdf me-2"></i>Exporter PDF</button>
                                <button class="btn btn-outline-primary"><i class="bi bi-file-excel me-2"></i>Excel</button>
                                <button class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Nouveau budget</button>
                            </div>
                        </div>

                        <!-- SECTION 1: INDICATEURS PRINCIPAUX (6 cards) -->

                        <div class="grid grid-cols-7 gap-2 mb-2">
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">Promotions</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">47</p>
                                    </div>
                                    
                                </div>
                                
                                <span class="text-sm text-blue-700">dont 8 accréditées</span>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">budget total</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">800000</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">depense</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">400000</p>
                                    </div>
                                   
                                </div>
                                <span class="text-sm text-green-700">50% du total</span>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">Programme</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">36</p>
                                    </div>
                                   
                                </div>
                                <span class="text-sm text-red-500">8 alerte</span>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">Restant</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">40000</p>
                                    </div>
                                   
                                </div>
                                <span class="text-sm text-purple-700">20%</span>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">Depassement</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">0Fbu</p>
                                    </div>
                                    
                                </div>
                                <span class="text-sm text-red-700">0% vs prevu</span>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm text-uppercase">Taux execution</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">78.4%</p>
                                    </div>
                                   
                                </div>
                                <span class="text-sm text-green-900">objectif 75%</span>
                            </div>
                        </div>

                        <!-- SECTION 2: GRAPHIQUES (2 colonnes) -->

                        <div class="row g-4 mb-5 ">
                            <div class="col-lg-7">
                                <div class="card p-4 border-0 rounded-4 shadow">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="fw-semibold"><i class="bi bi-graph-up me-2"></i>
                                            Évolution budgétaire mensuelle
                                        </h4>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary active">2025</button>
                                            <button class="btn btn-outline-secondary">2024</button>
                                            <button class="btn btn-outline-secondary">3 ans</button>
                                        </div>
                                    </div>
                                    
                                    <canvas id="budgetChart" class="" style="height:280px; width:100%; "></canvas>
                                    
                                    <div class="row mt-4 text-center">
                                        <div class="col-4"><span class="badge bg-primary">Budget prévisionnel</span></div>
                                        <div class="col-4"><span class="badge bg-success">Réalisé</span></div>
                                        <div class="col-4"><span class="badge bg-warning">Écart</span></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 h-100 ">
                                <div class="card p-4 h-100 bg-[E8FFD7] border-0">
                                    <h4 class="fw-semibold mb-3">
                                        <i class="bi bi-pie-chart me-2"></i>Répartition par faculté
                                    </h4>

                                
                                    <div class=" d-flex justify-content-center"style="height: 220px;">
                                        <canvas id="facultyChart" style="width: 100px; height: 100px;" ></canvas>
                                    </div>
                                        
                                    <div class="row mt-4 g-2">
                                        <div class="col-6 d-flex gap-1 flex-column">
                                            <div class="d-flex align-items-center gap-2  justify-content-start">
                                                <span style="width: 12px; height: 12px; background: #1e4a6b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Informatique</span>
                                                <span class="">280000</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2  justify-content-start">
                                                <span style="width: 12px; height: 12px; background: #1f7a5c; border-radius: 4px;"></span>
                                                <span class="text-secondary">Gestion</span>
                                                <span class="">60000</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #9e6300; border-radius: 4px;"></span>
                                                <span class="text-secondary">Droit</span>
                                                <span class="">43000</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2">
                                                <span style="width: 12px; height: 12px; background: #b45f4b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Médecine</span>
                                                <span class="">138000</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #4a637b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Sciences</span>
                                                <span class="">26300</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #8a7f8c; border-radius: 4px;"></span>
                                                <span class="text-secondary">Total</span>
                                                <span class="">800000</span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <!-- SECTION 3: TABLEAU COMPLET DES PROGRAMMES (20+ lignes) -->
                        <div class="card p-4 ">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                <h4 class="fw-semibold"><i class="bi bi-table me-2"></i>Suivi détaillé des 36 programmes</h4>
                                <div>
                                    <ul class="nav nav-tabs border-0" id="programTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">Tous</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" id="actif-tab" data-bs-toggle="tab" data-bs-target="#actif" type="button">Actifs</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" id="critique-tab" data-bs-toggle="tab" data-bs-target="#critique" type="button">Critiques</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" id="termine-tab" data-bs-toggle="tab" data-bs-target="#termine" type="button">Terminés</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="all">
                                    <div class="table-responsive" style="max-height:500px; overflow-y:auto;">
                                        <table class="table table-hover table-finance align-middle">
                                            <thead class="sticky-top bg-white">
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Programme</th>
                                                    <th>Faculté</th>
                                                    <th>Budget total</th><th>Dépensé</th>
                                                    <th>Disponible</th>
                                                    <th>% utilisé</th>
                                                    <th>Statut</th>
                                                    <th>Responsable</th>
                                                    <th>Échéance</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="programmesTableBody">
                                                <!-- généré par JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="actif">Tableau des actifs (même structure, mais filtré)</div>
                                <div class="tab-pane fade" id="critique">Programmes en critique</div>
                                <div class="tab-pane fade" id="termine">Programmes terminés</div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <span class="text-secondary"><i class="bi bi-info-circle me-1"></i> 36 programmes au total, 8 nécessitent attention</span>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-download"></i> Export CSV</button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Imprimer</button>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: TRANSACTIONS RÉCENTES + PRÉVISIONS -->
                        <div class="row g-4  ms-0  ">

                            <div class="col-lg-7 ">
                                <div class="card p-4 h-100 bg-info ">
                                    <div class="d-flex justify-content-between ">
                                        <h4 class="fw-semibold">
                                            <i class="bi bi-arrow-left-right me-2"></i>
                                            Flux de trésorerie
                                        </h4>

                                        <select class="form-select w-auto">
                                            <option>Mars 2025</option>
                                            <option>Février 2025</option>
                                        </select>
                                    </div>
                                    <canvas id="cashflowChart" style="height:200px;"></canvas>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="card p-4 h-100">
                                    <h4 class="fw-semibold mb-3">
                                        <i class="bi bi-clock-history me-2"></i>
                                        30 dernières transactions
                                    </h4>

                                    <div style="max-height:280px; overflow-y:auto;" id="transactionsList">
                                        <!-- Généré par JS -->
                                    </div>

                                    <button class="btn btn-link text-decoration-none mt-2">Voir tout l'historique →</button>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 5: BUDGETS PAR CATÉGORIE ET ALERTES -->

                        <div class="row g-4 bg-light">
                            <div class="col-lg-6 h-100">
                                <div class="card p-4 gap-2">
                                    <h4 class="fw-semibold mb-3"><i class="bi bi-tags me-2"></i>Dépenses par catégorie</h4>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Salaires enseignants</span> 
                                            <span class="fw-semibold">1420500 (42%)</span></div>
                                        <div class="progress progress-sm ">
                                            <div class="progress-bar bg-primary " style="width:42%"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between"><span>Bourses étudiantes</span> <span class="fw-semibold">890200 (26%)</span></div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width:26%"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between"><span>Équipement & matériel</span> <span class="fw-semibold">510000 (15%)</span></div>
                                        <div class="progress progress-sm"><div class="progress-bar bg-warning" style="width:15%"></div></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between"><span>Recherche</span> <span class="fw-semibold">324500 (10%)</span></div>
                                        <div class="progress progress-sm"><div class="progress-bar bg-info" style="width:10%"></div></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between"><span>Frais administratifs</span> <span class="fw-semibold">240000 (7%)</span></div>
                                        <div class="progress progress-sm"><div class="progress-bar bg-secondary" style="width:7%"></div></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card p-3 pb-0">

                                    <h4 class="fw-semibold mb-3">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Alertes & recommandations
                                    </h4>

                                    <div class="list-group border-0">
                                        <div class="list-group-item d-flex gap-3 border-0">
                                            <i class="bi bi-exclamation-circle-fill text-danger fs-4"></i>
                                            <div><span class="fw-semibold">MBA Management</span> - 92% du budget utilisé, reste 3 mois</div>
                                        </div>
                                        <div class="list-group-item d-flex gap-3 border-0">
                                            <i class="bi bi-exclamation-circle-fill text-warning fs-4"></i>
                                            <div><span class="fw-semibold">Master Finance</span> - Dépassement prévu de 45,000</div>
                                        </div>
                                        <div class="list-group-item d-flex gap-3 border-0">
                                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                            <div><span class="fw-semibold">Licence Informatique</span> - Budget sous-contrôle</div>
                                        </div>
                                        <div class="list-group-item d-flex gap-3 border-0">
                                            <i class="bi bi-info-circle-fill text-info fs-4"></i>
                                            <div><span class="fw-semibold">Doctorat Physique</span> - Nouvelle allocation disponible</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mt-0">Prévisions S2</h5>
                                    <p>Estimation dépenses restantes: <span class="fw-bold">2.1M</span> sur budget total 4.2M</p>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 6: TABLEAUX COMPARATIFS -->
                        <div class="row g-1">
                            <div class="col-12">
                                <div class="card p-4">
                                    <h4 class="fw-semibold mb-3"><i class="bi bi-bar-chart-line me-2"></i>Comparatif facultés (réel vs prévisionnel)</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr><th>Faculté</th><th>Budget initial</th><th>Révisé</th><th>Dépensé</th><th>Restant</th><th>Prévision fin d'année</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Gestion</td>
                                                    <td>2100000</td>
                                                    <td>2250000</td>
                                                    <td>1445000</td>
                                                    <td>805000</td>
                                                    <td>2180000</td>
                                                </tr>

                                                <tr>
                                                    <td>Informatique</td>
                                                    <td>1600000</td>
                                                    <td>1720000</td>
                                                    <td>890000</td>
                                                    <td>830000</td>
                                                    <td>1650000</td>
                                                </tr>

                                                <tr>
                                                    <td>Droit</td>
                                                    <td>1400000</td>
                                                    <td>1480000</td>
                                                    <td>1210000</td>
                                                    <td>270000</td>
                                                    <td>1520000</td>
                                                </tr>

                                                <tr>
                                                    <td>Médecine</td>
                                                    <td>1100000</td>
                                                    <td>1250000</td>
                                                    <td>980000</td>
                                                    <td>270000</td>
                                                    <td>1300000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </main>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const button = document.querySelector('.mobileMenuToggle');
                    const sidebar = document.getElementById('sidebar');
                    const main = document.querySelector('.mainContent');  // ou getElementsByClassName

                    if (button && sidebar && main) {
                        // Fonction qui initialise l'état selon la largeur de l'écran
                        function setInitialState() {
                            if (window.innerWidth >= 768) {
                                // Bureau : sidebar visible, contenu décalé
                                sidebar.classList.remove('-translate-x-full');
                                main.classList.add('ml-[230px]');
                            } else {
                                // Mobile : sidebar cachée, contenu sans marge
                                sidebar.classList.add('-translate-x-full');
                                main.classList.remove('ml-[230px]');
                            }
                        }

                        setInitialState();  // Applique l'état initial

                        // Toggle au clic sur le bouton
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            sidebar.classList.toggle('-translate-x-full');
                            // Sur bureau, on décale le main en même temps
                            if (window.innerWidth >= 768) {
                                main.classList.toggle('ml-[230px]');
                            }
                        });

                        // Clic à l'extérieur sur mobile : ferme le sidebar
                        document.addEventListener('click', function(e) {
                            if (window.innerWidth < 768) {
                                if (!sidebar.contains(e.target) && !button.contains(e.target)) {
                                    sidebar.classList.add('-translate-x-full');
                                }
                            }
                        });

                        // Adaptation si la fenêtre est redimensionnée
                        window.addEventListener('resize', function() {
                            setInitialState();
                        });
                    }
                });
            </script>

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



                    
        <script>
        (function() {
            // ===================== DONNÉES MASSIVES =====================
            // 36 programmes réalistes
            const programmes = [
                { code: "LIC-101", nom: "Licence Informatique", fac: "Sciences", budget: 540000, depense: 312000, resp: "Dr. Martin", echeance: "2025-06-30", statut: "actif" },
                { code: "LIC-102", nom: "Licence Mathématiques", fac: "Sciences", budget: 480000, depense: 291000, resp: "Dr. Bernard", echeance: "2025-06-30", statut: "actif" },
                { code: "LIC-103", nom: "Licence Physique", fac: "Sciences", budget: 510000, depense: 402000, resp: "Dr. Dubois", echeance: "2025-06-30", statut: "critique" },
                { code: "MAS-201", nom: "Master Cybersécurité", fac: "Sciences", budget: 620000, depense: 421000, resp: "Dr. Leroy", echeance: "2025-08-31", statut: "actif" },
                { code: "MAS-202", nom: "Master Data Science", fac: "Sciences", budget: 680000, depense: 544000, resp: "Dr. Moreau", echeance: "2025-08-31", statut: "critique" },
                { code: "MAS-203", nom: "Master Intelligence Artificielle", fac: "Sciences", budget: 750000, depense: 398000, resp: "Dr. Petit", echeance: "2025-08-31", statut: "actif" },
                { code: "DOC-301", nom: "Doctorat Informatique", fac: "Sciences", budget: 320000, depense: 189000, resp: "Pr. Rousseau", echeance: "2026-09-30", statut: "actif" },
                { code: "DOC-302", nom: "Doctorat Physique Quantique", fac: "Sciences", budget: 410000, depense: 378000, resp: "Pr. Laurent", echeance: "2025-12-31", statut: "critique" },
                { code: "LIC-104", nom: "Licence Psychologie", fac: "Lettres", budget: 380000, depense: 244000, resp: "Dr. Faure", echeance: "2025-06-30", statut: "actif" },
                { code: "LIC-105", nom: "Licence Sociologie", fac: "Lettres", budget: 350000, depense: 301000, resp: "Dr. Mercier", echeance: "2025-06-30", statut: "critique" },
                { code: "LIC-106", nom: "Licence Philosophie", fac: "Lettres", budget: 290000, depense: 167000, resp: "Dr. Girard", echeance: "2025-06-30", statut: "actif" },
                { code: "MAS-204", nom: "Master Psychologie Clinique", fac: "Lettres", budget: 420000, depense: 311000, resp: "Dr. Roux", echeance: "2025-08-31", statut: "actif" },
                { code: "MAS-205", nom: "Master Sociologie", fac: "Lettres", budget: 390000, depense: 356000, resp: "Dr. Lambert", echeance: "2025-08-31", statut: "critique" },
                { code: "DOC-303", nom: "Doctorat Philosophie", fac: "Lettres", budget: 210000, depense: 98000, resp: "Pr. Bonnet", echeance: "2026-09-30", statut: "actif" },
                { code: "LIC-107", nom: "Licence Droit", fac: "Droit", budget: 410000, depense: 312000, resp: "Dr. Andre", echeance: "2025-06-30", statut: "actif" },
                { code: "LIC-108", nom: "Licence Administration", fac: "Droit", budget: 360000, depense: 301000, resp: "Dr. Michel", echeance: "2025-06-30", statut: "critique" },
                { code: "MAS-206", nom: "Master Droit des Affaires", fac: "Droit", budget: 520000, depense: 498000, resp: "Dr. Garcia", echeance: "2025-08-31", statut: "critique" },
                { code: "MAS-207", nom: "Master Droit Public", fac: "Droit", budget: 480000, depense: 312000, resp: "Dr. Rodriguez", echeance: "2025-08-31", statut: "actif" },
                { code: "DOC-304", nom: "Doctorat Droit", fac: "Droit", budget: 280000, depense: 187000, resp: "Pr. Lopez", echeance: "2026-09-30", statut: "actif" },
                { code: "MED-401", nom: "Médecine (PCEM2)", fac: "Médecine", budget: 890000, depense: 721000, resp: "Dr. Fournier", echeance: "2025-05-31", statut: "critique" },
                { code: "MED-402", nom: "Pharmacie", fac: "Médecine", budget: 560000, depense: 389000, resp: "Dr. Girard", echeance: "2025-06-30", statut: "actif" },
                { code: "MED-403", nom: "Odontologie", fac: "Médecine", budget: 410000, depense: 287000, resp: "Dr. Riviere", echeance: "2025-06-30", statut: "actif" },
                { code: "MED-404", nom: "Maïeutique", fac: "Médecine", budget: 380000, depense: 291000, resp: "Dr. Marchal", echeance: "2025-07-31", statut: "actif" },
                { code: "MAS-208", nom: "Master Santé Publique", fac: "Médecine", budget: 440000, depense: 401000, resp: "Dr. Legrand", echeance: "2025-08-31", statut: "critique" },
                { code: "ECO-501", nom: "Licence Économie", fac: "Droit", budget: 370000, depense: 248000, resp: "Dr. Blanc", echeance: "2025-06-30", statut: "actif" },
                { code: "ECO-502", nom: "Licence Gestion", fac: "Droit", budget: 390000, depense: 315000, resp: "Dr. Chevalier", echeance: "2025-06-30", statut: "actif" },
                { code: "MAS-209", nom: "Master Finance", fac: "Droit", budget: 610000, depense: 543000, resp: "Dr. Robin", echeance: "2025-08-31", statut: "critique" },
                { code: "MAS-210", nom: "Master Marketing", fac: "Droit", budget: 550000, depense: 378000, resp: "Dr. Morel", echeance: "2025-08-31", statut: "actif" },
                { code: "MAS-211", nom: "Master RH", fac: "Droit", budget: 520000, depense: 455000, resp: "Dr. Perrot", echeance: "2025-08-31", statut: "critique" },
                { code: "DOC-305", nom: "Doctorat Économie", fac: "Droit", budget: 290000, depense: 167000, resp: "Pr. Gauthier", echeance: "2026-09-30", statut: "actif" },
                { code: "ART-601", nom: "Licence Arts", fac: "Lettres", budget: 280000, depense: 194000, resp: "Dr. Meunier", echeance: "2025-06-30", statut: "actif" },
                { code: "ART-602", nom: "Master Création Numérique", fac: "Lettres", budget: 330000, depense: 289000, resp: "Dr. Caron", echeance: "2025-08-31", statut: "actif" },
                { code: "STAPS-701", nom: "STAPS Licence", fac: "Sciences", budget: 450000, depense: 312000, resp: "Dr. Colin", echeance: "2025-06-30", statut: "actif" },
                { code: "STAPS-702", nom: "STAPS Master", fac: "Sciences", budget: 380000, depense: 298000, resp: "Dr. Fernandes", echeance: "2025-08-31", statut: "actif" },
                { code: "IUT-801", nom: "BUT Informatique", fac: "Sciences", budget: 520000, depense: 345000, resp: "Dr. Muller", echeance: "2025-05-31", statut: "actif" },
                { code: "IUT-802", nom: "BUT GEA", fac: "Droit", budget: 410000, depense: 356000, resp: "Dr. Dupuy", echeance: "2025-05-31", statut: "critique" },
            ];

            // 30 transactions mock
            const transactions = [
                { programme: "MBA Management", montant: 15000, date: "2025-03-15", desc: "Intervenant extérieur", type: "dépense" },
                { programme: "Master Finance", montant: 8200, date: "2025-03-14", desc: "Workshop Bloomberg", type: "dépense" },
                { programme: "Licence Informatique", montant: 23000, date: "2025-03-14", desc: "Équipement labo", type: "dépense" },
                { programme: "Doctorat Physique", montant: 6700, date: "2025-03-13", desc: "Mission conférence", type: "dépense" },
                { programme: "Master Cybersécurité", montant: 5200, date: "2025-03-12", desc: "Licences logicielles", type: "dépense" },
                { programme: "Licence Droit", montant: 3800, date: "2025-03-11", desc: "Sortie pédagogique", type: "dépense" },
                { programme: "Master Data Science", montant: 12500, date: "2025-03-10", desc: "Serveurs calcul", type: "dépense" },
                { programme: "Médecine", montant: 18500, date: "2025-03-09", desc: "Matériel simulation", type: "dépense" },
                { programme: "Budget central", montant: 50000, date: "2025-03-08", desc: "Allocation recherche", type: "recette" },
                { programme: "MBA Management", montant: 7500, date: "2025-03-07", desc: "Formation continue", type: "dépense" },
                { programme: "Licence Psychologie", montant: 2100, date: "2025-03-06", desc: "Fournitures", type: "dépense" },
                { programme: "Master Droit", montant: 4300, date: "2025-03-05", desc: "Conférences", type: "dépense" },
                { programme: "Doctorat Informatique", montant: 3600, date: "2025-03-04", desc: "Inscription conférence", type: "dépense" },
                { programme: "Budget régional", montant: 75000, date: "2025-03-03", desc: "Subvention", type: "recette" },
                { programme: "Master Marketing", montant: 5800, date: "2025-03-02", desc: "Étude de cas", type: "dépense" },
                { programme: "Licence Sociologie", montant: 1900, date: "2025-03-01", desc: "Enquête terrain", type: "dépense" },
                { programme: "Master RH", montant: 4200, date: "2025-02-28", desc: "Séminaire", type: "dépense" },
                { programme: "BUT Informatique", montant: 8900, date: "2025-02-27", desc: "Matériel TP", type: "dépense" },
                { programme: "STAPS Master", montant: 3300, date: "2025-02-26", desc: "Équipement sportif", type: "dépense" },
                { programme: "Licence Arts", montant: 1700, date: "2025-02-25", desc: "Matériel création", type: "dépense" },
                { programme: "Master Création", montant: 4600, date: "2025-02-24", desc: "Studio", type: "dépense" },
                { programme: "Pharmacie", montant: 7800, date: "2025-02-23", desc: "Réactifs", type: "dépense" },
                { programme: "Odontologie", montant: 6200, date: "2025-02-22", desc: "Matériel clinique", type: "dépense" },
                { programme: "Maïeutique", montant: 2800, date: "2025-02-21", desc: "Formation", type: "dépense" },
                { programme: "Master Santé", montant: 5100, date: "2025-02-20", desc: "Enquête", type: "dépense" },
                { programme: "Ministère", montant: 120000, date: "2025-02-19", desc: "Dotation annuelle", type: "recette" },
                { programme: "Licence Math", montant: 2200, date: "2025-02-18", desc: "Bibliothèque", type: "dépense" },
                { programme: "Master IA", montant: 13500, date: "2025-02-17", desc: "GPU", type: "dépense" },
                { programme: "Doctorat Droit", montant: 1900, date: "2025-02-16", desc: "Documentation", type: "dépense" },
                { programme: "BUT GEA", montant: 3400, date: "2025-02-15", desc: "Projet tutoré", type: "dépense" },
            ];

            // Remplir tableau des programmes
            const tbody = document.getElementById('programmesTableBody');
            if (tbody) {
                programmes.forEach(p => {
                    const disponible = p.budget - p.depense;
                    const pourcent = ((p.depense / p.budget) * 100).toFixed(1);
                    let badge = '';
                    if (p.statut === 'critique') badge = '<span class="badge bg-danger">Critique</span>';
                    else if (p.statut === 'actif') badge = '<span class="badge bg-success">Actif</span>';
                    else badge = '<span class="badge bg-secondary">Terminé</span>';

                    const row = `<tr>
                        <td><span class="fw-semibold">${p.code}</span></td>
                        <td>${p.nom}</td>
                        <td>${p.fac}</td>
                        <td>$${p.budget.toLocaleString()}</td>
                        <td>$${p.depense.toLocaleString()}</td>
                        <td class="${disponible < 50000 ? 'text-danger fw-bold' : ''}">$${disponible.toLocaleString()}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="me-2">${pourcent}%</span>
                                <div class="progress flex-grow-1" style="height:5px;">
                                    <div class="progress-bar ${p.statut === 'critique' ? 'bg-danger' : 'bg-success'}" style="width:${pourcent}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>${badge}</td>
                        <td>${p.resp}</td>
                        <td>${p.echeance}</td>
                        <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button></td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            }

            // Remplir transactions récentes
            const transDiv = document.getElementById('transactionsList');
            if (transDiv) {
                transactions.slice(0, 15).forEach(t => {
                    const signe = t.type === 'recette' ? 'text-success' : 'text-danger';
                    const icon = t.type === 'recette' ? 'bi-arrow-down' : 'bi-arrow-up';
                    transDiv.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <span class="fw-semibold">${t.programme}</span><br>
                                <small class="text-secondary">${t.date} · ${t.desc}</small>
                            </div>
                            <span class="${signe} fw-bold"><i class="bi ${icon} me-1"></i> $${t.montant.toLocaleString()}</span>
                        </div>
                    `;
                });
            }

            // ========== GRAPHIQUES ==========

    // Chart budget evolution
   /* const ctx1 = document.getElementById('budgetChart')?.getContext('2d');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [
                    { label: 'Prévisionnel', data: [320, 350, 380, 410, 430, 460, 490, 520, 550, 580], borderColor: '#1e3a6f', tension: 0.3 },
                    { label: 'Réalisé', data: [310, 340, 390, 400, 420, 450, 480, 510, 0, 0], borderColor: '#28a745', tension: 0.3 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }*/
   


    // Pie chart facultés


            document.addEventListener('DOMContentLoaded', function() {
                                    // Graphique répartition
                                    new Chart(document.getElementById('facultyChart'), {
                                        type: 'pie',
                                        data: {
                                            labels: ['Informatique', 'Gestion', 'Droit', 'Médecine', 'Sciences'],
                                            datasets: [{
                                                data: [280000, 2600000, 430000, 138000, 263000],
                                                backgroundColor: ['#1e4a6b', '#1f7a5c', '#9e6300', '#b45f4b', '#4a637b'],
                                                borderWidth: 1, 
                                            }]
                                        },  
                                        options: {
                                            cutout: '65%',
                                            responsive: true,
                                            maintainAspectRatio: true,
                                            plugins: {
                                                legend: { display: false },
                                                tooltip: {backgroundColor: 'rgba(255,255,255,0.8)',  titleColor: 'navy',  bodyColor: 'red',  borderColor: 'red', borderWidth: 1 }
                                            }
                                        }
                                    });

                                });



            // Cashflow chart
            const ctx3 = document.getElementById('cashflowChart')?.getContext('2d');
            if (ctx3) {
                new Chart(ctx3, {
                    type: 'bar',
                    data: {
                        labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4', 'Sem 5', 'Sem 6'],
                        datasets: [
                            { label: 'Entrées', data: [120, 85, 95, 110, 105, 130], backgroundColor: '#28a745' },
                            { label: 'Sorties', data: [90, 95, 105, 100, 115, 95], backgroundColor: '#dc3545' }
                        ]
                    }
                });

                
            }
        })();
        </script>


        <!-- Gestion des onglets pour les tableaux filtrés (simplifié) -->
        <script>
            document.querySelectorAll('#programTab button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const target = e.target.id.split('-')[0]; // all, actif, critique, termine
                    const tbody = document.getElementById('programmesTableBody');
                    // Simulation de filtrage (à compléter avec vraies données)
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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