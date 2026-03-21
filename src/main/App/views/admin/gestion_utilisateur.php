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
            
            <!-- Bootstrap 5 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            
            <!-- Remixicon -->
            <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
            
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            
            <!-- Google Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

            <script src="./Ajout_utilisateur/ajout_utilisateur.js" defer></script>

            <?php
            $jsVersion = filemtime('script.js'); // Récupère la date de dernière modification du fichier
            ?>
            <script src="script.js?v=<?php echo $jsVersion; ?>" defer></script>

            <link href="style.css" rel="stylesheet">
            


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
                                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full focus:outline-none">
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
                                </button    >
                                
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
                <aside id="sidebar" class="sidebar fixed top-[74px] left-0 h-[calc(100vh-74px)] w-64 z-40 transform transition-transform duration-300 ease-in-out">
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

                <!-- MAIN CONTENT -->
                <main class="mainContent flex-1 p-4 md:p-6 lg:p-8 px-12 animate-fade-in mt-[74px] ml-0 transition-all duration-300">

                    <style>
                        * {
                            font-family: 'Inter', sans-serif;
                        }
                        body {
                            background: #fff;
                        }
                        .sidebar {
                            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                            color: #000000;
                            border-right: 1px solid rgba(0, 0, 0, 0.1);
                        }

                        /* Animation douce */
                        @keyframes fadeInUp {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        .animate-fadeInUp {
                            animation: fadeInUp 0.3s ease-out forwards;
                        }
                        .hover-lift {
                            transition: transform 0.2s ease, box-shadow 0.2s ease;
                        }
                        .hover-lift:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
                        }
                        .stat-card {
                            transition: all 0.2s;
                        }
                        .filter-chip {
                            transition: all 0.2s;
                            cursor: pointer;
                        }
                        .filter-chip.active {
                            background: #3b82f6;
                            color: white;
                        }
                        .filter-chip.active:hover {
                            background: #2563eb;
                        }
                        /* Personnalisation des scrollbars */
                        ::-webkit-scrollbar {
                            width: 6px;
                            height: 6px;
                        }
                        ::-webkit-scrollbar-track {
                            background: #e2e8f0;
                            border-radius: 10px;
                        }
                        ::-webkit-scrollbar-thumb {
                            background: #94a3b8;
                            border-radius: 10px;
                        }
                        /* Modal overlay */
                        .modal-overlay {
                            background: rgba(0,0,0,0.5);
                            backdrop-filter: blur(4px);
                        }
                        /* Pour les badges de rôle */
                        .badge-role {
                            padding: 0.2rem 0.7rem;
                            border-radius: 999px;
                            font-size: 0.75rem;
                            font-weight: 500;
                            background: #eef2ff;
                            color: #1e40af;
                        }
                        .btn-action {
                            background: transparent;
                            border: none;
                            cursor: pointer;
                            padding: 0.25rem 0.5rem;
                            border-radius: 0.375rem;
                            transition: all 0.2s;
                        }
                        .btn-action:hover {
                            background: #f1f5f9;
                        }
                        .btn-danger {
                            color: #ef4444;
                        }
                        .btn-danger:hover {
                            background: #fee2e2;
                        }
                        
                    </style>



                    <div class="max-w-7xl mx-auto ps-3">
                        <!-- En-tête principal -->
                        <div class="flex flex-col mt-2 sm:flex-row sm:items-center justify-between gap-4 mb-8">
                            <div>
                                <h2 class="text-2xl md:text-3xl fs-2 font-bold text-gray-750 flex items-center gap-2">
                                    <i class="fas fa-users text-blue-600"></i>
                                    utilisateurs
                                </h>
                                <p class="text-gray-500 text-sm mt-1">
                                    <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                                    Année scolaire 2025-2026
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <button id="exportBtn" class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-100 transition flex items-center gap-2 text-sm font-medium">
                                    <i class="fas fa-download"></i> Exporter CSV
                                </button>
                                <button id="openAddModalBtn" class="px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 text-sm font-semibold">
                                    <i class="fas fa-plus"></i> Nouvel utilisateur
                                </button>
                            </div>
                        </div>

                        <!-- Cartes statistiques -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 mb-2">
                            
                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Total utilisateurs</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statTotal">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-blue-500  rounded-3">
                                        <i class="fas fa-users text-white text-xl"></i>
                                    </div>
                                </div>
                            
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover-lift">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Étudiants</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statStudents">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-green-600  rounded-3">
                                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover-lift">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Enseignants</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statTeachers">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-purple-600  rounded-3">
                                        <i class="fas fa-chalkboard-user text-white text-xl"></i>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover-lift">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Parents / Tuteurs</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statParents">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-orange-600  rounded-3">
                                        <i class="fas fa-user-friends text-white text-xl"></i>
                                    </div>
                                </div>  
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover-lift">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Enseignants</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statTeachers">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-purple-600  rounded-3">
                                        <i class="fas fa-chalkboard-user text-white text-xl"></i>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover-lift">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Parents / Tuteurs</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statParents">0</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-orange-600  rounded-3">
                                        <i class="fas fa-user-friends text-white text-xl"></i>
                                    </div>
                                </div>  
                            </div>
                        </div>

                        <div class="relative w-full">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" placeholder="Rechercher nom ou email..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100">
                        </div>

                        <!-- Filtres et recherche -->
                        <div class="bg-white rounded-xl  p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex flex-wrap gap-2" id="roleFiltersContainer">
                                <button data-role="all" class="filter-chip px-2 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 active">Tous <span id="filterTotal">0</span></button>
                                <button data-role="etudiant" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Étudiants <span id="filterStudents">0</span></button>
                                <button data-role="enseignant" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Enseignants <span id="filterTeachers">0</span></button>
                                <button data-role="parent" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Parents <span id="filterParents">0</span></button>
                                <button data-role="admin" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Admin <span id="filterAdmin">0</span></button>
                                <button data-role="prefet" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Préfets <span id="filterPrefets">0</span></button>
                                <button data-role="inspecteur" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Inspecteurs <span id="filterInspecteurs">0</span></button>
                                <button data-role="tuteur" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Tuteurs <span id="filterTuteurs">0</span></button>
                                <button data-role="titulaire" class="filter-chip px-3 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Titulaires <span id="filterTitulaires">0</span></button>
                            </div>
                            
                        </div>

                        

                        <!-- Tableau des utilisateurs -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Infos supplémentaires</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody" class="bg-white divide-y divide-gray-100">
                                        <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Chargement des utilisateurs...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 flex justify-between items-center text-sm text-gray-500 border-t">
                                <span>Total : <span id="footerTotal">0</span> utilisateur(s)</span>
                                <span class="text-xs"><i class="fas fa-sync-alt mr-1"></i> Dernière mise à jour : <span id="lastUpdate">--:--</span></span>
                            </div>
                        </div>
                        
                    </div>

                    <!-- MODAL AJOUT / MODIFICATION -->

                    <div id="userModal" class="fixed inset-0 flex items-center justify-center z-50 modal-overlay hidden transition-all">
                        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform transition-all scale-95 opacity-0" id="modalContent">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-bold text-gray-800" id="modalTitle">Ajouter un utilisateur</h3>
                                    <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                                </div>
                                <form id="userForm">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                                        <select id="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            <option value="etudiant">Étudiant</option>
                                            <option value="enseignant">Enseignant</option>
                                            <option value="parent">Parent</option>
                                            <option value="admin">Administrateur</option>
                                            <option value="prefet">Préfet</option>
                                            <option value="inspecteur">Inspecteur</option>
                                            <option value="tuteur">Tuteur</option>
                                            <option value="titulaire">Titulaire</option>
                                        </select>
                                    </div>
                                    
                                    <input type="hidden" id="editId" value="">
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                                        <input type="text" id="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                        <input type="email" id="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    

                                    <div id="dynamicFields" class="mb-4"></div>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" id="cancelModalBtn" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Annuler</button>
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>

                    <!--script pour ouvrir le sidebar-->

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
                    

                    <script>
                        // ==================== DATA ====================
                        const STORAGE_KEY = 'school_user_management';
                        let users = [];
                        let currentFilter = 'all';
                        let searchTerm = '';

                        // Données de démonstration
                        const defaultUsers = [
                            { id: 1, name: 'Kouassi Yao', email: 'yao.kouassi@eleve.fr', role: 'etudiant', extra: { classe: 'CM2', moyenne: '16.8' } },
                            { id: 2, name: 'Pr. Aya N\'Guessan', email: 'aya.nguessan@ecole.fr', role: 'enseignant', extra: { matiere: 'Physique', anciennete: '15 ans' } },
                            { id: 3, name: 'Konan Jean', email: 'jean.konan@parent.fr', role: 'parent', extra: { enfants: 3, association: 'APE' } },
                            { id: 4, name: 'Dr. François Kouadio', email: 'francois.kouadio@ecole.fr', role: 'titulaire', extra: { fonction: 'Doyen', departement: 'Droit' } },
                            { id: 5, name: 'Michel Yao', email: 'michel.yao@ecole.fr', role: 'prefet', extra: { secteur: 'Discipline', eleves: 1200 } },
                            { id: 6, name: 'Dr. Adama Koné', email: 'a.kone@inspection.fr', role: 'inspecteur', extra: { zone: 'Nord' } },
                            { id: 7, name: 'Mme Fatou Diallo', email: 'fatou.diallo@ecole.fr', role: 'admin', extra: { service: 'Direction' } }
                        ];

                        // ==================== UTILITAIRES ====================
                        function saveToLocalStorage() {
                            localStorage.setItem(STORAGE_KEY, JSON.stringify(users));
                        }

                        function loadUsers() {
                            const stored = localStorage.getItem(STORAGE_KEY);
                            if (stored) {
                                users = JSON.parse(stored);
                            } else {
                                users = defaultUsers;
                                saveToLocalStorage();
                            }
                            updateStats();
                            renderTable();
                            updateLastUpdate();
                        }

                        function updateLastUpdate() {
                            const now = new Date();
                            document.getElementById('lastUpdate').innerText = now.toLocaleTimeString();
                        }

                        function updateStats() {
                            const total = users.length;
                            const students = users.filter(u => u.role === 'etudiant').length;
                            const teachers = users.filter(u => u.role === 'enseignant').length;
                            const parents = users.filter(u => u.role === 'parent').length;
                            const admin = users.filter(u => u.role === 'admin').length;
                            const prefets = users.filter(u => u.role === 'prefet').length;
                            const inspecteurs = users.filter(u => u.role === 'inspecteur').length;
                            const tuteurs = users.filter(u => u.role === 'tuteur').length;
                            const titulaires = users.filter(u => u.role === 'titulaire').length;

                            document.getElementById('statTotal').innerText = total;
                            document.getElementById('statStudents').innerText = students;
                            document.getElementById('statTeachers').innerText = teachers;
                            document.getElementById('statParents').innerText = parents;

                            document.getElementById('filterTotal').innerText = total;
                            document.getElementById('filterStudents').innerText = students;
                            document.getElementById('filterTeachers').innerText = teachers;
                            document.getElementById('filterParents').innerText = parents;
                            document.getElementById('filterAdmin').innerText = admin;
                            document.getElementById('filterPrefets').innerText = prefets;
                            document.getElementById('filterInspecteurs').innerText = inspecteurs;
                            document.getElementById('filterTuteurs').innerText = tuteurs;
                            document.getElementById('filterTitulaires').innerText = titulaires;

                            document.getElementById('footerTotal').innerText = total;
                        }

                        // Champs dynamiques selon rôle
                        function renderDynamicFields(role, extra = {}) {
                            let html = '';
                            if (role === 'etudiant') {
                                html = `
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                                            <input type="text" id="studentClass" value="${extra.classe || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Moyenne</label>
                                            <input type="text" id="studentAverage" value="${extra.moyenne || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>
                                    </div>
                                `;
                            } else if (role === 'enseignant') {
                                html = `
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Matière(s)</label>
                                        <input type="text" id="teacherSubject" value="${extra.matiere || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Ancienneté</label>
                                            <input type="text" id="teacherExp" value="${extra.anciennete || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>
                                    </div>
                                `;
                            } else if (role === 'parent') {
                                html = `
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'enfants</label>
                                            <input type="text" id="parentChildren" value="${extra.enfants || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Association</label>
                                            <input type="text" id="parentAssoc" value="${extra.association || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        </div>

                                    </div>
                                `;
                            } else if (role === 'admin') {
                                html = `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                                    <input type="text" id="adminService" value="${extra.service || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>`;
                            } else if (role === 'prefet') {
                                html = `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Secteur / Élèves sous responsabilité</label>
                                    <input type="text" id="prefetSecteur" value="${extra.secteur || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>`;
                            } else if (role === 'inspecteur') {
                                html = `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Zone d'inspection</label>
                                    <input type="text" id="inspecteurZone" value="${extra.zone || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>`;
                            } else if (role === 'tuteur') {
                                html = `<div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité</label>
                                
                                <input type="text" id="tuteurSpecialite" value="${extra.specialite || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>`;
                            } else if (role === 'titulaire') {
                                html = `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label>
                                    <input type="text" id="titulaireFonction" value="${extra.fonction || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                </div>`;
                            }
                            document.getElementById('dynamicFields').innerHTML = html;
                        }

                        function collectExtraData(role) {
                            let extra = {};
                            if (role === 'etudiant') {
                                extra.classe = document.getElementById('studentClass')?.value || '';
                                extra.moyenne = document.getElementById('studentAverage')?.value || '';
                            } else if (role === 'enseignant') {
                                extra.matiere = document.getElementById('teacherSubject')?.value || '';
                                extra.anciennete = document.getElementById('teacherExp')?.value || '';
                            } else if (role === 'parent') {
                                extra.enfants = document.getElementById('parentChildren')?.value || '';
                                extra.association = document.getElementById('parentAssoc')?.value || '';
                            } else if (role === 'admin') {
                                extra.service = document.getElementById('adminService')?.value || '';
                            } else if (role === 'prefet') {
                                extra.secteur = document.getElementById('prefetSecteur')?.value || '';
                            } else if (role === 'inspecteur') {
                                extra.zone = document.getElementById('inspecteurZone')?.value || '';
                            } else if (role === 'tuteur') {
                                extra.specialite = document.getElementById('tuteurSpecialite')?.value || '';
                            } else if (role === 'titulaire') {
                                extra.fonction = document.getElementById('titulaireFonction')?.value || '';
                            }
                            return extra;
                        }

                        function saveUser(event) {
                            event.preventDefault();
                            const id = document.getElementById('editId').value ? parseInt(document.getElementById('editId').value) : null;
                            const name = document.getElementById('name').value.trim();
                            const email = document.getElementById('email').value.trim();
                            const role = document.getElementById('role').value;
                            const extra = collectExtraData(role);

                            if (!name || !email) {
                                alert('Veuillez remplir le nom et l\'email.');
                                return;
                            }

                            if (id === null) {
                                const newId = Date.now();
                                users.push({ id: newId, name, email, role, extra });
                            } else {
                                const index = users.findIndex(u => u.id === id);
                                if (index !== -1) {
                                    users[index] = { ...users[index], name, email, role, extra };
                                }
                            }
                            saveToLocalStorage();
                            updateStats();
                            renderTable();
                            closeModal();
                        }

                        function deleteUser(id) {
                            if (confirm('Supprimer définitivement cet utilisateur ?')) {
                                users = users.filter(u => u.id !== id);
                                saveToLocalStorage();
                                updateStats();
                                renderTable();
                                if (document.getElementById('editId').value == id) closeModal();
                            }
                        }

                        function editUser(id) {
                            const user = users.find(u => u.id === id);
                            if (user) {
                                document.getElementById('editId').value = user.id;
                                document.getElementById('name').value = user.name;
                                document.getElementById('email').value = user.email;
                                document.getElementById('role').value = user.role;
                                renderDynamicFields(user.role, user.extra || {});
                                document.getElementById('modalTitle').innerText = 'Modifier l\'utilisateur';
                                openModal();
                            }
                        }

                        function openModal() {
                            const modal = document.getElementById('userModal');
                            const modalContent = document.getElementById('modalContent');
                            modal.classList.remove('hidden');
                            setTimeout(() => {
                                modalContent.classList.remove('scale-95', 'opacity-0');
                                modalContent.classList.add('scale-100', 'opacity-100');
                            }, 10);
                        }

                        function closeModal() {
                            const modal = document.getElementById('userModal');
                            const modalContent = document.getElementById('modalContent');
                            modalContent.classList.add('scale-95', 'opacity-0');
                            setTimeout(() => {
                                modal.classList.add('hidden');
                                document.getElementById('userForm').reset();
                                document.getElementById('editId').value = '';
                                document.getElementById('modalTitle').innerText = 'Ajouter un utilisateur';
                                renderDynamicFields('etudiant', {});
                            }, 200);
                        }

                        function renderTable() {
                            let filtered = users;
                            if (currentFilter !== 'all') {
                                filtered = filtered.filter(u => u.role === currentFilter);
                            }
                            if (searchTerm.trim() !== '') {
                                filtered = filtered.filter(u =>
                                    u.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                                    u.email.toLowerCase().includes(searchTerm.toLowerCase())
                                );
                            }

                            const tbody = document.getElementById('userTableBody');
                            if (filtered.length === 0) {
                                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Aucun utilisateur trouvé</td></tr>';
                                return;
                            }

                            let html = '';
                            filtered.forEach(user => {
                                const roleLabel = {
                                    etudiant: 'Étudiant',
                                    enseignant: 'Enseignant',
                                    parent: 'Parent',
                                    admin: 'Administrateur',
                                    prefet: 'Préfet',
                                    inspecteur: 'Inspecteur',
                                    tuteur: 'Tuteur',
                                    titulaire: 'Titulaire'
                                }[user.role] || user.role;

                                let extraInfo = '';
                                if (user.role === 'etudiant') extraInfo = `Classe: ${user.extra.classe || '—'} ${user.extra.moyenne ? `Moy: ${user.extra.moyenne}` : ''}`;
                                else if (user.role === 'enseignant') extraInfo = `Matière: ${user.extra.matiere || '—'} (${user.extra.anciennete || ''})`;
                                else if (user.role === 'parent') extraInfo = `${user.extra.enfants || '0'} enfant(s) · ${user.extra.association || ''}`;
                                else if (user.role === 'admin') extraInfo = `Service: ${user.extra.service || '—'}`;
                                else if (user.role === 'prefet') extraInfo = `${user.extra.secteur || '—'}`;
                                else if (user.role === 'inspecteur') extraInfo = `Zone: ${user.extra.zone || '—'}`;
                                else if (user.role === 'tuteur') extraInfo = `Spécialité: ${user.extra.specialite || '—'}`;
                                else if (user.role === 'titulaire') extraInfo = `Fonction: ${user.extra.fonction || '—'}`;

                                html += `
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${escapeHtml(user.name)}</td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-600">${escapeHtml(user.email)}</td>
                                        <td class="px-6 py-2 whitespace-nowrap"><span class="badge-role">${roleLabel}</span></td>
                                        <td class="px-6 py-2 text-sm text-gray-500">${escapeHtml(extraInfo) || '—'}</td>
                                        <td class="px-6 py-2 whitespace-nowrap text-right">
                                            <button onclick="editUser(${user.id})" class="btn-action text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteUser(${user.id})" class="btn-action text-red-500 hover:text-red-700"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                `;
                            });
                            tbody.innerHTML = html;
                        }

                        function escapeHtml(str) {
                            if (!str) return '';
                            return str.replace(/[&<>]/g, function(m) {
                                if (m === '&') return '&amp;';
                                if (m === '<') return '&lt;';
                                if (m === '>') return '&gt;';
                                return m;
                            });
                        }

                        function exportCSV() {
                            let csv = "Nom,Email,Rôle,Infos supplémentaires\n";
                            users.forEach(u => {
                                let extraStr = '';
                                if (u.role === 'etudiant') extraStr = `Classe: ${u.extra.classe || ''} Moy: ${u.extra.moyenne || ''}`;
                                else if (u.role === 'enseignant') extraStr = `Matière: ${u.extra.matiere || ''} Ancienneté: ${u.extra.anciennete || ''}`;
                                else if (u.role === 'parent') extraStr = `Enfants: ${u.extra.enfants || ''} Assoc: ${u.extra.association || ''}`;
                                else if (u.role === 'admin') extraStr = `Service: ${u.extra.service || ''}`;
                                else if (u.role === 'prefet') extraStr = `Secteur: ${u.extra.secteur || ''}`;
                                else if (u.role === 'inspecteur') extraStr = `Zone: ${u.extra.zone || ''}`;
                                else if (u.role === 'tuteur') extraStr = `Spécialité: ${u.extra.specialite || ''}`;
                                else if (u.role === 'titulaire') extraStr = `Fonction: ${u.extra.fonction || ''}`;
                                csv += `"${u.name}","${u.email}","${u.role}","${extraStr}"\n`;
                            });
                            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                            const link = document.createElement('a');
                            const url = URL.createObjectURL(blob);
                            link.setAttribute('href', url);
                            link.setAttribute('download', 'utilisateurs_ecole.csv');
                            link.style.display = 'none';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                            URL.revokeObjectURL(url);
                        }

                        // ==================== INITIALISATION & ÉVÉNEMENTS ====================
                        document.addEventListener('DOMContentLoaded', () => {
                            loadUsers();

                            // Filtres
                            document.querySelectorAll('#roleFiltersContainer .filter-chip').forEach(chip => {
                                chip.addEventListener('click', () => {
                                    document.querySelectorAll('#roleFiltersContainer .filter-chip').forEach(c => c.classList.remove('active', 'bg-blue-600', 'text-white'));
                                    chip.classList.add('active', 'bg-blue-600', 'text-white');
                                    currentFilter = chip.getAttribute('data-role');
                                    renderTable();
                                });
                            });

                            // Recherche
                            const searchInput = document.getElementById('searchInput');
                            searchInput.addEventListener('input', (e) => {
                                searchTerm = e.target.value;
                                renderTable();
                            });

                            // Modal
                            const openModalBtn = document.getElementById('openAddModalBtn');
                            openModalBtn.addEventListener('click', () => {
                                document.getElementById('userForm').reset();
                                document.getElementById('editId').value = '';
                                document.getElementById('modalTitle').innerText = 'Ajouter un utilisateur';
                                renderDynamicFields('etudiant', {});
                                openModal();
                            });

                            const closeModalBtns = document.querySelectorAll('#closeModalBtn, #cancelModalBtn');
                            closeModalBtns.forEach(btn => btn.addEventListener('click', closeModal));

                            document.getElementById('userForm').addEventListener('submit', saveUser);

                            // Export
                            document.getElementById('exportBtn').addEventListener('click', exportCSV);

                            // Fermeture modal en cliquant sur l'overlay
                            document.getElementById('userModal').addEventListener('click', (e) => {
                                if (e.target === document.getElementById('userModal')) closeModal();
                            });

                            // Mise à jour des champs dynamiques lors du changement de rôle dans le modal
                            document.getElementById('role').addEventListener('change', (e) => {
                                const currentExtra = {};
                                renderDynamicFields(e.target.value, currentExtra);
                            });
                        });

                        // Exposer les fonctions globales pour les boutons du tableau
                        window.editUser = editUser;
                        window.deleteUser = deleteUser;
                    </script>


                



            


            </div>

            <!-- Footer -->
            <?php 
            $footer = new SimpleFooter();
            echo $footer->render();
            ?>



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