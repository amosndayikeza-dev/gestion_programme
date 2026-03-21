
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion étudiants · Bootstrap</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="configu ration.css">
    
</head>

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
            <link rel="stylesheet" href="configuration.css">
            
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

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

               
                <!-- Main Content -->
                <main class="mainContent flex-1 p-4 md:p-6 lg:p-8 px-12 animate-fade-in mt-[74px] ml-0 transition-all duration-300">
                    <div class="container-fluid px-0">
                        <!-- En-tête de section -->
                        <div class="d-flex gap-3 flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                            <div>
                                <h2 class="h2 fw-900 text-dark mb-1">
                                    <i class="fas fa-user-graduate me-2 text-blue-500"></i>
                                    Gestion des étudiants
                                </h2>
                                    
                                <p class="text-secondary-emphasis mb-0">
                                    <i class="fas fa-database me-1"></i> 543 inscrits · Mise à jour 10:24
                                </p>
                            </div>

                            <div class="mt-3 mt-md-0 d-flex gap-2">
                                <span class="badge bg-light text-dark p-3 border rounded-4 shadow-sm">
                                    <i class="fas fa-calendar-alt me-2 text-primary" style="color: #1e4a6b;"></i>
                                    2025-2026
                                </span>
                                <button class="px-2 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 text-sm font-semibold">
                                    <i class="fas fa-plus me-2"></i>Nouvel étudiant
                                </button>
                            </div>
                            
                        </div>

                        <!-- Cartes statistiques (row) -->
                        <div class="grid grid-cols-6 gap-2">

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card ">
                                <div class="flex justify-between items-start">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="text-muted small text-uppercase mb-1">Étudiants actifs</p>
                                            <h3 class="fw-bold mb-0">543</h3>
                                        </div>
                                        
                                        <div class="py-2.5 px-2.5 bg-blue-500  rounded-3">
                                            <i class="fas fa-users text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Dossiers incomplets</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">47</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-orange-500  rounded-3">
                                        <i class="fas fa-clock fs-3 text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Nouveaux 2025</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">324</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-green-700  rounded-3">
                                        <i class="fas fa-file-signature fs-3 text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>



                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card ">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Taux de présence</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">80%</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-purple-500  rounded-3">
                                        <i class="fas fa-chart-line fs-3 text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            
                             <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card ">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-gray-500 text-sm">Taux de présence</p>
                                        <p class="text-2xl font-bold text-gray-800 mt-1">80%</p>
                                    </div>
                                    <div class="py-2.5 px-2.5 bg-purple-500  rounded-3">
                                        <i class="fas fa-chart-line fs-3 text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 border border-gray-100 hover-lift stat-card">
                                <div class="flex justify-between items-start">
                                    <div class="card-body d-flex align-items-center">
                                        <div>
                                            <p class="text-muted small text-uppercase mb-1">Étudiants actifs</p>
                                            <h3 class="fw-bold mb-0">543</h3>
                                        </div>
                                        
                                        <div class="py-2.5 px-2.5 bg-blue-500  rounded-3">
                                            <i class="fas fa-users text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>

                        <!-- Barre d'outils (recherche, filtres) -->
                        <div class="card border-0  p-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-lg-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-end-0 h-100"><i class="fas fa-search text-muted py-1"></i></span>
                                        <input type="text" class="border border-start-0 focus:outline focus:outline-1 focus:outline-gray-300 ps-0 w-75 py-1" placeholder="Rechercher par nom, matricule ou email...">
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                                        <select class="form-select w-auto">
                                            <option>Tous programmes</option>
                                            <option>Informatique</option>
                                            <option>Gestion</option>
                                            <option>Droit</option>
                                        </select>
                                        <select class="form-select w-auto">
                                            <option>Tous statuts</option>
                                            <option>Actif</option>
                                            <option>En attente</option>
                                            <option>Inactif</option>
                                        </select>
                                        <button class="btn btn-outline-secondary"><i class="fas fa-sliders-h me-2"></i>Filtres</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                        .table-custom th {
                           color: #263B6A;      /* text-muted = gris Bootstrap */
                            font-size: 0.8rem;  /* small = 14px si base 16px */
                            text-transform: uppercase;
                        }

                        .table-custom td{
                            color:#0D1A63;
                        }

                        </style>

                        <!-- Tableau des étudiants -->
                        <div class="card border-1 shadow-sm rounded-4 overflow-hidden mb-5">
                            <div>
                                <table class="table-custom table table-hover align-middle mb-0">
                                    <thead >
                                        <tr class="text-orange-500">
                                            <th class="ps-4 text-orange-500">Photo</th>
                                            <th>Étudiant</th>
                                            <th>Matricule</th>
                                            <th>Faculté</th>
                                            <th>Année</th>
                                            <th>Progression</th>
                                            <th>Statut</th>
                                            <th class="pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-10 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-circle fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">Emma Chen</div>
                                                <div class="small text-muted">emma.chen@universite.fr</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">IA-2025-042</span>
                                            </td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td style="min-width: 120px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-75 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small">78%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Actif</span></td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-envelope"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-10 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-circle fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">Emma Chen</div>
                                                <div class="small text-muted">emma.chen@universite.fr</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">IA-2025-042</span>
                                            </td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td style="min-width: 120px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-75 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small">78%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Actif</span></td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-envelope"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-10 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-circle fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">Emma Chen</div>
                                                <div class="small text-muted">emma.chen@universite.fr</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">IA-2025-042</span>
                                            </td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td style="min-width: 120px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-75 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small">78%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Actif</span></td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-envelope"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-10 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-circle fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">Emma Chen</div>
                                                <div class="small text-muted">emma.chen@universite.fr</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">IA-2025-042</span>
                                            </td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td style="min-width: 120px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-75 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small">78%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Actif</span></td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-envelope"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-10 p-2" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-user-circle fs-3 text-secondary"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">Emma Chen</div>
                                                <div class="small text-muted">emma.chen@universite.fr</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">IA-2025-042</span>
                                            </td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td style="min-width: 120px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="progress w-75 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="small">78%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Actif</span></td>
                                            <td class="pe-4">
                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-eye"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-edit"></i></a>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="far fa-envelope"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center py-3">
                                <span class="small text-muted">Affichage 1 à 7 sur 543 résultats</span>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item disabled"><a class="page-link border-0" href="#">Précédent</a></li>
                                        <li class="page-item active"><a class="page-link border-0 bg-primary" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">Suivant</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Graphiques (deux colonnes) -->
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-chart-pie me-2" style="color: #1e4a6b;"></i>Répartition par programme</h5>
                                        <canvas id="programChart" style="max-height: 200px;"></canvas>
                                        <div class="row mt-4 small">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center mb-2"><span class="badge me-2" style="background: #1e4a6b; width: 12px; height: 12px;"></span>Informatique <span class="ms-auto fw-bold">850</span></div>
                                                <div class="d-flex align-items-center mb-2"><span class="badge me-2" style="background: #1f7a5c; width: 12px; height: 12px;"></span>Gestion <span class="ms-auto fw-bold">620</span></div>
                                                <div class="d-flex align-items-center"><span class="badge me-2" style="background: #9e6300; width: 12px; height: 12px;"></span>Droit <span class="ms-auto fw-bold">430</span></div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center mb-2"><span class="badge me-2" style="background: #b45f4b; width: 12px; height: 12px;"></span>Médecine <span class="ms-auto fw-bold">380</span></div>
                                                <div class="d-flex align-items-center mb-2"><span class="badge me-2" style="background: #4a637b; width: 12px; height: 12px;"></span>Sciences <span class="ms-auto fw-bold">263</span></div>
                                                <div class="d-flex align-items-center fw-bold border-top pt-1 mt-1"><span class="me-auto">Total</span>2 543</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm rounded-4 h-100">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-chart-line me-2" style="color: #1e4a6b;"></i>Évolution des inscriptions</h5>
                                        <canvas id="evolutionChart" style="max-height: 200px;"></canvas>
                                        <div class="d-flex justify-content-between mt-4 small fw-bold">
                                            <span>Sept: 1 240</span>
                                            <span>Jan: 2 100</span>
                                            <span>Juin: 2 543</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'actions rapides -->
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2"><i class="fas fa-download me-2"></i>Exporter .CSV</button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2"><i class="fas fa-print me-2"></i>Imprimer</button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2"><i class="fas fa-bell me-2"></i>Alertes absences</button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2"><i class="fas fa-file-pdf me-2"></i>Rapport</button>
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
                                            main.classList.add('ml-[250px]');
                                        } else {
                                            // Mobile : sidebar cachée, contenu sans marge
                                            sidebar.classList.add('-translate-x-full');
                                            main.classList.remove('ml-[250px]');
                                        }
                                    }

                                    setInitialState();  // Applique l'état initial

                                    // Toggle au clic sur le bouton
                                    button.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        sidebar.classList.toggle('-translate-x-full');
                                        // Sur bureau, on décale le main en même temps
                                        if (window.innerWidth >= 768) {
                                            main.classList.toggle('ml-[250px]');
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