<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes · Université Prestige</title>
    
    <!-- Bootstrap 5 + Icônes + Fonts premium -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<head>

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


                <style>
        /* ---------- DESIGN SYSTEM PREMIUM ---------- */
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --secondary: #0f172a;
            --accent: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.02);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.02), 0 2px 4px -2px rgb(0 0 0 / 0.02);
            --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.02), 0 4px 6px -4px rgb(0 0 0 / 0.02);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.02), 0 8px 10px -6px rgb(0 0 0 / 0.02);
            --shadow-xl: 0 25px 50px -12px rgb(0 0 0 / 0.05);
            --shadow-glow: 0 0 0 1px rgba(79, 70, 229, 0.1), 0 10px 15px -3px rgba(79, 70, 229, 0.05);
            --border-radius-sm: 12px;
            --border-radius: 20px;
            --border-radius-lg: 28px;
            --border-radius-xl: 36px;
            --border-radius-2xl: 48px;
            --border-radius-full: 9999px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(145deg, #f9fcff 0%, #f1f6fa 100%);
            color: var(--gray-900);
            padding: 2rem;
            line-height: 1.6;
        }


        /* ---------- TYPOGRAPHIE PREMIUM ---------- */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--gray-900);
        }

        .display-6 {
            font-size: 2.25rem;
            line-height: 1.2;
            font-weight: 800;
        }

        .display-7 {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .text-gradient {
            background: linear-gradient(145deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ---------- CARTES PREMIUM ---------- */
        .premium-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            transition: 0.3s;
            border-top: 4px solid #3730a3;
        }

        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(79, 70, 229, 0.2);
            background: white;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-color: rgba(79, 70, 229, 0.2);
            box-shadow: var(--shadow-glow);
        }

        /* ---------- BADGES PREMIUM ---------- */
        .badge-premium {
            padding: 0.5rem 1.25rem;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge-li cence {
            background: linear-gradient(145deg, #2563eb, #4f46e5);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .badge-master {
            background: linear-gradient(145deg, #7c3aed, #a855f7);
            color: white;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
        }

        .badge-doctorat {
            background: linear-gradient(145deg, #0f172a, #1e293b);
            color: white;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
        }

        .badge-du {
            background: linear-gradient(145deg, #b45309, #d97706);
            color: white;
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.25);
        }

        .badge-success {
            background: linear-gradient(145deg, #10b981, #059669);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(145deg, #f59e0b, #d97706);
            color: white;
        }

        /* ---------- AVATARS & ICONS ---------- */
        .avatar-premium {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
            background: linear-gradient(145deg, var(--primary), var(--accent));
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.2);
            position: relative;
            transition: all 0.2s ease;
        }

        .avatar-premium::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 20px;
            background: linear-gradient(145deg, rgba(255,255,255,0.3), rgba(255,255,255,0));
            z-index: -1;
        }

        .avatar-group {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            background: linear-gradient(145deg, var(--primary-light), var(--primary));
        }

        .icon-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 14px;
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            transition: all 0.2s ease;
        }

        .icon-premium:hover {
            background: var(--primary);
            color: white;
        }

        /* ---------- PROGRESS BAR ---------- */
        .progress-premium {
            height: 8px;
            background: var(--gray-100);
            border-radius: var(--border-radius-full);
            overflow: hidden;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
        }

        .progress-bar-premium {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: var(--border-radius-full);
            position: relative;
            overflow: hidden;
        }

        .progress-bar-premium::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* ---------- ROOM BADGE ---------- */
        .room-badge-premium {
            background: var(--gray-100);
            padding: 0.4rem 1.2rem;
            border-radius: var(--border-radius-full);
            font-size: 0.8rem;
            color: var(--gray-700);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .room-badge-premium:hover {
            background: white;
            border-color: var(--primary);
            color: var(--primary);
        }

        .room-badge-premium i {
            color: var(--primary);
        }

        /* ---------- RECHERCHE ---------- */
        .search-premium {
            background: white;
            border-radius: var(--border-radius-full);
            padding: 0.4rem 0.4rem 0.4rem 1.5rem;
            border: 1.5px solid var(--gray-200);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            backdrop-filter: blur(8px);
        }

        .search-premium:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .search-input-premium {
            border: none;
            background: transparent;
            padding: 0.75rem 0;
            font-size: 0.95rem;
            width: 100%;
        }

        .search-input-premium:focus {
            outline: none;
            box-shadow: none;
        }

        /* ---------- FILTER CHIPS ---------- */
        .filter-chip-premium {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.4rem;
            background: white;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--border-radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--gray-600);
            transition: all 0.2s ease;
            cursor: pointer;
            letter-spacing: -0.01em;
        }

        .filter-chip-premium.active {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            color: white;
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.2);
        }

        .filter-chip-premium:hover:not(.active) {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        /* ---------- PROMO CARD ---------- */
        .promo-card-premium {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 1.75rem;
            transition: all 0.3s ;
            border-left:4px solid chocolate;
        }



        .promo-card-premium:hover {
            transform: translateY(-6px);
             border-left:4px solid silver;
        }


      

        /* ---------- TIMELINE ---------- */
        .timeline-premium {
            position: relative;
            padding-left: 1.5rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.5rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid white;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -1.05rem;
            top: 1.25rem;
            width: 2px;
            height: calc(100% - 1.25rem);
            background: var(--gray-200);
        }

        .timeline-item:last-child::after {
            display: none;
        }

        /* ---------- STATS GRID ---------- */
    
        .stat-card {
          
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-glow);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        /* ---------- NAVIGATION ---------- */
        .nav-elegant {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-elegant .nav-link {
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: var(--border-radius-full);
            color: var(--gray-600);
            font-weight: 600;
            background: white;
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .nav-elegant .nav-link.active {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            color: white;
            border-color: transparent;
            box-shadow: 0 8px 16px rgba(79, 70, 229, 0.2);
        }

        .nav-elegant .nav-link:hover:not(.active) {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        /* ---------- DIVIDER ---------- */
        .divider-pre    mium {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gray-200), var(--primary-light), var(--gray-200), transparent);
            margin: 2.5rem 0;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>




                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-[230px]">

                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4  w-100">
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar-premium" style="width: 72px; height: 72px; border-radius: 24px;">
                                <i class="bi bi-building fs-2"></i>
                            </div>

                            <div class="">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <h1 class="display-6 fw-bold mb-0">
                                        <span class="text-gradient">Classes & Promotions</span>
                                    </h1>
                                    <span class="badge-premium badge-licence bg-info shadow">
                                        <i class="bi bi-stars"></i> 2025-2026
                                    </span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3">
                                    <span class="d-flex align-items-center gap-2 text-secondary">
                                        <i class="bi bi-building fs-6"></i> Faculté des Sciences
                                    </span>
                                    <span class="d-flex align-items-center gap-2 text-secondary">
                                        <i class="bi bi-mortarboard fs-6"></i> 2 456 étudiants
                                    </span>
                                    <span class="d-flex align-items-center gap-2 text-secondary">
                                        <i class="bi bi-diagram-3 fs-6"></i> 24 promotions
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-3 mt-lg-0">
                            <button class="btn btn-light rounded-5 px-4 py-2 d-flex align-items-center gap-2" style="background: white; border: 1.5px solid var(--gray-200);">
                                <i class="bi bi-calendar-check text-primary"></i>
                                <span>Année 2025-26</span>
                            </button>
                            <button class="btn rounded-5 px-3 py-3 d-flex align-items-center gap-2" style="background: linear-gradient(145deg, var(--primary), var(--primary-dark)); color: white; border: none; box-shadow: 0 8px 20px rgba(79,70,229,0.3);">
                                <i class="bi bi-plus-lg"></i>
                                <span class="fw-bold">Nouvelle classe</span>
                            </button>
                        </div>
                    </div>

                    <!-- ========== STATISTIQUES AVANCÉES ========== -->
                    <div class="stats-grid row py-2 shadow mb-3 ">
                        <div class="col-3">
                            <div class="stat-card bg-white rounded-4 p-3 d-flex align-items-center gap-2 ">
                                <div class="stat-icon" style="background: linear-gradient(145deg, rgba(79,70,229,0.1), rgba(139,92,246,0.1)); color: var(--primary);">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>

                                <div>
                                    <span class="text-secondary text-uppercase small fw-bold tracking-wide">Effectif total</span>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <h2 class="display-5 fw-bold mb-0" style="color: var(--gray-900);">2 456</h2>
                                    </div>
                                    <span class="text-secondary small">inscrits pédagogiques</span>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-3">
                            <div class="stat-card bg-white rounded-4 p-3 d-flex align-items-center gap-2  ">
                                <div class="stat-icon" style="background: linear-gradient(145deg, rgba(16,185,129,0.1), rgba(5,150,105,0.1)); color: var(--success);">
                                    <i class="bi bi-diagram-3-fill"></i>
                                </div>
                                <div>
                                    <span class="text-secondary text-uppercase small fw-bold">Promotions</span>
                                    <div class="d-flex align-items-baseline gap-3">
                                        <h2 class="display-5 fw-bold mb-0" style="color: var(--gray-900);">24</h2>
                                    
                                    </div>
                                    <span class="text-secondary small">dont 8 accréditées</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="stat-card bg-white rounded-4 p-3 d-flex align-items-center gap-2  ">
                                <div class="stat-icon" style="background: linear-gradient(145deg, rgba(245,158,11,0.1), rgba(217,119,6,0.1)); color: var(--warning);">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <span class="text-secondary text-uppercase small fw-bold">Groupes TD/TP</span>
                                    <h2 class="display-5 fw-bold mb-0" style="color: var(--gray-900);">86</h2>
                                    <span class="text-secondary small">moyenne 28 étudiants/groupe</span>
                                </div>
                            </div>
                        </div>

                    <div class="col-3">
                            <div class="stat-card bg-white rounded-4 p-3 d-flex align-items-center gap-2  ">
                                <div class="stat-icon" style="background: linear-gradient(145deg, rgba(139,92,246,0.1), rgba(124,58,237,0.1)); color: var(--accent);">
                                    <i class="bi bi-door-open-fill"></i>
                                </div>
                                <div>
                                    <span class="text-secondary text-uppercase small fw-bold">Salles dédiées</span>
                                    <h2 class="display-5 fw-bold mb-0" style="color: var(--gray-900);">42</h2>
                                    <span class="text-secondary small">sur 58 · taux 72%</span>
                                </div>
                            </div>
                    </div>
                    </div>

                    <!-- ========== BARRE D'OUTILS PREMIUM ========== -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-4 mb-5">
                        <div class="search-premium" style="width: 400px; max-width: 100%;">
                            <i class="bi bi-search text-secondary me-2"></i>
                            <input type="text" class="search-input-premium" placeholder="Rechercher une promotion, un groupe, une salle...">
                            <span class="badge bg-light text-secondary px-4 py-2 rounded-5 fw-normal">
                                <i class="bi bi-command"></i> F
                            </span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="filter-chip-premium active">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Toutes
                            </button>
                            <button class="filter-chip-premium">
                                <i class="bi bi-mortarboard me-2"></i>Licence
                            </button>
                            <button class="filter-chip-premium">
                                <i class="bi bi-book me-2"></i>Master
                            </button>

                            <button class="filter-chip-premium">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ========== ONGLETS NAVIGATION ÉLÉGANTS ========== -->

                    <ul class="nav nav-elegant mb-5 " id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab">
                                <i class="bi bi-columns-gap me-2"></i>Vue d'ensemble
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-promos-tab" data-bs-toggle="pill" data-bs-target="#pills-promos" type="button" role="tab">
                                <i class="bi bi-layers me-2"></i>Promotions
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-groups-tab" data-bs-toggle="pill" data-bs-target="#pills-groups" type="button" role="tab">
                                <i class="bi bi-people me-2"></i>Groupes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-rooms-tab" data-bs-toggle="pill" data-bs-target="#pills-rooms" type="button" role="tab">
                                <i class="bi bi-door-open me-2"></i>Salles & labos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-planning-tab" data-bs-toggle="pill" data-bs-target="#pills-planning" type="button" role="tab">
                                <i class="bi bi-calendar-week me-2"></i>Planning
                            </button>
                        </li>
                    </ul>

                    
                    <div class="tab-content" id="pills-tabContent">
                       
                        <div class="tab-pane fade show active" id="pills-all" role="tabpanel">
                            

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="fw-bold mb-1 text-danger ">
                                        <i class="bi bi-pin-fill "></i> 
                                    <span  class="text-dark"> Promotions actives </span>
                                    </h3>
                                    <p class="text-secondary small">Semestre pair 2025-2026 · 12 promotions en cours</p>
                                </div>
                                <a href="#" class="text-decoration-none fw-semibold text-primary">
                                    Voir tout <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                                </a>
                            </div>

                            <div class="row g-4 mb-3 ">
                                <!-- PROMO LICENCE 1 INFORMATIQUE -->
                                <div class="col-xl-4 col-lg-6">
                                    <div class="promo-card-premium  rounded-4 h-100 ">
                                        <div class="position-relative">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="">
                                                    <span class="badge-premium badge-licence mb-2">
                                                        <i class="bi bi-mortarboard"></i> BAC 1
                                                    </span>
                                                    <h4 class="fw-bold mb-1" style="color: var(--gray-900);">Informatique</h4>
                                                    <p class="text-secondary small mb-0">Parcours général · 128 étudiants</p>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-light rounded-4 p-2" >
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center gap-4 mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-people"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">128</span>
                                                        <span class="text-secondary small ms-1">étudiants</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="width: 32px; height: 32px; background: rgba(245,158,11,0.1); color: var(--warning);">
                                                        <i class="bi bi-diagram-2"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">6</span>
                                                        <span class="text-secondary small ms-1">groupes</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small fw-semibold text-secondary">Taux d'encadrement</span>
                                                    <span class="small fw-bold" style="color: var(--primary);">1/21</span>
                                                </div>
                                                <div class="progress-premium">
                                                    <div class="progress-bar-premium" style="width: 88%;"></div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap align-items-center justify-content-between mt-4">
                                                <div class="room-badge-premium">
                                                    <i class="bi bi-building"></i> 
                                                    <span>SALLE1</span>
                                                </div>

                                                <div class="room-badge-premium">
                                                    <i class="bi bi-person-badge"></i> 
                                                    <Span>Dr.Claude</Span>
                                                </div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-5 px-3 py-2">
                                                    92% présence
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PROMO MASTER 2 DATA SCIENCE -->
                                <div class="col-xl-4 col-lg-6">
                                    <div class="promo-card-premium  rounded-4  h-100">
                                        
                                        <div class="position-relative" style="z-index: 2;">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="badge-premium badge-master mb-2">
                                                        <i class="bi bi-book"></i> Master 2
                                                    </span>
                                                    <h4 class="fw-bold mb-1" style="color: var(--gray-900);">Data Science</h4>
                                                    <p class="text-secondary small mb-0">IA & Big Data · 48 étudiants</p>
                                                </div>
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-5 px-3 py-2">
                                                    <i class="bi bi-star-fill"></i> Flagship
                                                </span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center gap-4 mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="background: rgba(124,58,237,0.1); color: #7c3aed;">
                                                        <i class="bi bi-people"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">48</span>
                                                        <span class="text-secondary small ms-1">étudiants</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="background: rgba(124,58,237,0.1); color: #7c3aed;">
                                                        <i class="bi bi-diagram-2"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">3</span>
                                                        <span class="text-secondary small ms-1">groupes</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small fw-semibold text-secondary">Taux d'encadrement</span>
                                                    <span class="small fw-bold" style="color: #7c3aed;">1/16</span>
                                                </div>
                                                <div class="progress-premium">
                                                    <div class="progress-bar-premium" style="width: 78%; background: linear-gradient(90deg, #7c3aed, #a855f7);"></div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap align-items-center justify-content-between mt-4">
                                                <div class="room-badge-premium">
                                                    <i class="bi bi-laptop"></i> Lab 08
                                                </div>
                                                <div class="room-badge-premium">
                                                    <i class="bi bi-person-badge"></i> Pr. Bernard
                                                </div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-5 px-3 py-2">
                                                    <i class="bi bi-award"></i> Excellence
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PROMO LICENCE 3 GÉNIE CIVIL -->
                                
                                <div class="col-xl-4 col-lg-6">
                                    <div class="promo-card-premium  rounded-4  h-100">
                                        <div class="position-relative" style="z-index: 2;">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="badge-premium badge-licence mb-2">
                                                        <i class="bi bi-mortarboard"></i> BAC 3
                                                    </span>
                                                    <h4 class="fw-bold mb-1" style="color: var(--gray-900);">Génie civil</h4>
                                                    <p class="text-secondary small mb-0">BTP · 96 étudiants</p>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center gap-4 mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-people"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">96</span>
                                                        <span class="text-secondary small ms-1">étudiants</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="icon-premium" style="width: 32px; height: 32px; background: rgba(245,158,11,0.1); color: var(--warning);">
                                                        <i class="bi bi-diagram-2"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold fs-5">4</span>
                                                        <span class="text-secondary small ms-1">groupes</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small fw-semibold text-secondary">Taux d'encadrement</span>
                                                    <span class="small fw-bold" style="color: var(--primary);">1/24</span>
                                                </div>
                                                <div class="progress-premium">
                                                    <div class="progress-bar-premium" style="width: 85%;"></div>
                                                </div>
                                            </div>

                                            
                                            <div class="d-flex flex-wrap align-items-center justify-content-between mt-4">
                                                <div class="room-badge-premium">
                                                    <i class="bi bi-laptop"></i> SALLE 2
                                                </div>
                                                <div class="room-badge-premium">
                                                    <i class="bi bi-person-badge"></i> Pr. Bosco
                                                </div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-5 px-3 py-2">
                                                    <i class="bi bi-award"></i> Excellence
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- SECTION 2 : GROUPES AVEC ENSEIGNANTS -->

                            <div class="d-flex justify-content-between align-items-center mb-4 ">
                                <div>
                                    <h3 class="fw-bold mb-1 fs-4"><i class="bi bi-people text-warning"></i> TD/TP/EXAMEN</h3>
                                    <p class="text-secondary small">Affectations enseignants et salles</p>
                                </div>
                                <a href="#" class="text-decoration-none fw-semibold" style="color: var(--primary);">
                                    Gérer les affectations <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                                </a>
                            </div>

                            <div class="row g-4 mb-5  ">
                                <!-- Groupe TD 1A -->
                                <div class="col-lg-3 ">
                                    <div class="glass-card p-4 d-flex flex-wrap gap-3 h-100">
                                        <div class="avatar-group" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">
                                            L1-A
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="fw-semibold mb-1">Groupe TD 1A</h5>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <span class="badge-licence px-3 py-2" style="font-size: 0.7rem;">Licence 1 Info</span>
                                                        <span class="text-secondary small"><i class="bi bi-people"></i> 28 étudiants</span>
                                                    </div>
                                                </div>
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-5 px-3 py-2">
                                                    <i class="bi bi-check-circle"></i> Actif
                                                </span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="room-badge-premium"><i class="bi bi-door-open"></i> Salle A105</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> J. Dupont (TD)</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> M. Martin (TP)</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar3 text-secondary"></i>
                                                    <span class="small text-secondary">Lundi 10h-12h · Jeudi 14h-16h</span>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Groupe M2 Data Science -->
                                <div class="col-lg-3 ">
                                    <div class="glass-card p-4 d-flex flex-wrap gap-3 h-100">
                                        <div class="avatar-group" style="background: linear-gradient(145deg, #8b5cf6, #7c3aed);">
                                            M1
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="fw-semibold mb-1">Groupe Data Science</h5>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <span class="badge-master px-3 py-2" style="font-size: 0.7rem;">Master 2</span>
                                                        <span class="text-secondary small"><i class="bi bi-people"></i> 16 étudiants</span>
                                                    </div>
                                                </div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-5 px-3 py-2">
                                                    <i class="bi bi-flask"></i> Labo
                                                </span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="room-badge-premium"><i class="bi bi-laptop"></i> Labo 208</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> Pr. Bernard</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> Dr. Petit</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar3 text-secondary"></i>
                                                    <span class="small text-secondary">Mardi 14h-17h · Vendredi 9h-12h</span>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Groupe GC3B -->
                                <div class="col-lg-3">
                                    <div class="glass-card p-4 d-flex flex-wrap gap-3 h-100">
                                        <div class="avatar-group" style="background: linear-gradient(145deg, #10b981, #059669);">
                                            BAC1
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="fw-semibold mb-1">Groupe GC-3B</h5>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <span class="badge-licence px-3 py-2" style="font-size: 0.7rem;">Licence 3 GC</span>
                                                        <span class="text-secondary small"><i class="bi bi-people"></i> 24 étudiants</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="room-badge-premium"><i class="bi bi-door-open"></i> Salle C204</span>
                                                <span class="room-badge-premium"><i class="bi bi-flask"></i> Labo matériaux</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> Dr. Leroy</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar3 text-secondary"></i>
                                                    <span class="small text-secondary">Mercredi 8h-12h (TP)</span>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Groupe Physique 1 -->
                                <div class="col-lg-3">
                                    <div class="glass-card p-4 d-flex flex-wrap gap-3 h-100">
                                        <div class="avatar-group" style="background: linear-gradient(145deg, #f59e0b, #d97706);">
                                            P1
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="fw-semibold mb-1">Groupe Physique 1</h5>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <span class="badge-licence px-3 py-2" style="font-size: 0.7rem;">Licence 2</span>
                                                        <span class="text-secondary small"><i class="bi bi-people"></i> 32 étudiants</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="room-badge-premium"><i class="bi bi-easel"></i> Amphi 3</span>
                                                <span class="room-badge-premium"><i class="bi bi-person-badge"></i> Pr. Durand</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar3 text-secondary"></i>
                                                    <span class="small text-secondary">Lundi 13h-15h · Jeudi 9h-11h</span>
                                                </div>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: var(--gray-100);">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3 : TIMELINE ÉVÉNEMENTS & SALLES -->
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="premium-card p-4 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h4 class="fw-bold mb-0">
                                                <i class="bi bi-book"></i> 
                                                Planning du jour
                                            </h4>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-5 px-4 py-2">
                                                12 février 2026
                                            </span>
                                        </div>
                                        <div class="timeline-premium ">
                                            <div class="timeline-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="fw-bold">08:30 - 10:30</span>
                                                        <h6 class="fw-semibold mt-1 mb-1">TD Analyse L1 Informatique</h6>
                                                        <p class="small text-secondary mb-1">Groupe A · Salle 101 · J. Dupont</p>
                                                        <span class="badge bg-light text-dark rounded-5 px-3 py-1">28 étudiants</span>
                                                    </div>
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-5 px-3 py-2">En cours</span>
                                                </div>
                                            </div>
                                            <div class="timeline-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="fw-bold">11:00 - 13:00</span>
                                                        <h6 class="fw-semibold mt-1 mb-1">TP Machine Learning M2</h6>
                                                        <p class="small text-secondary mb-1">Labo IA 208 · Pr. Bernard</p>
                                                        <span class="badge bg-light text-dark rounded-5 px-3 py-1">16 étudiants</span>
                                                    </div>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-5 px-3 py-2">À venir</span>
                                                </div>
                                            </div>
                                            <div class="timeline-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="fw-bold">14:00 - 17:00</span>
                                                        <h6 class="fw-semibold mt-1 mb-1">Projet tutoré Génie civil</h6>
                                                        <p class="small text-secondary mb-1">Salle C204 · Dr. Leroy</p>
                                                        <span class="badge bg-light text-dark rounded-5 px-3 py-1">24 étudiants</span>
                                                    </div>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-5 px-3 py-2">Préparation</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="#" class="text-decoration-none fw-semibold" style="color: var(--primary);">
                                                Voir le planning complet <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="premium-card p-4 h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h4 class="fw-bold mb-0"><i class="bi "></i>Salles & disponibilités</h4>
                                            <i class="bi bi-door-open fs-4" style="color: var(--primary);"></i>
                                        </div>
                                        <div class="d-flex flex-column gap-3">
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Amphi A</h6>
                                                    <span class="small text-secondary">200 places · Vidéo</span>
                                                </div>
                                                <span class="badge badge-success rounded-5 px-3 py-2">Disponible</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Salle B101</h6>
                                                    <span class="small text-secondary">48 places · TD</span>
                                                </div>
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-5 px-3 py-2">Occupée</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Labo IA 208</h6>
                                                    <span class="small text-secondary">24 postes · TP</span>
                                                </div>
                                                <span class="badge badge-warning rounded-5 px-3 py-2">Réservé 14h</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">Labo Chimie</h6>
                                                    <span class="small text-secondary">30 places · TP</span>
                                                </div>
                                                <span class="badge badge-success rounded-5 px-3 py-2">Libre</span>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn w-100 py-3 rounded-4" style="background: linear-gradient(145deg, var(--gray-100), white); border: 1px solid var(--gray-200);">
                                                <i class="bi bi-calendar-plus me-2"></i> Réserver une salle
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="premium-card p-4 h-100">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AUTRES ONGLETS (simplifiés pour rester concis) -->
                        <div class="tab-pane fade" id="pills-promos" role="tabpanel">
                            <div class="p-5 text-center">
                                <i class="bi bi-layers fs-1 text-gradient"></i>
                                <h4 class="mt-3 fw-bold">Gestion des promotions</h4>
                                <p class="text-secondary">Interface détaillée avec création de parcours, maquettes pédagogiques...</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-groups" role="tabpanel">
                            <div class="p-5 text-center">
                                <i class="bi bi-people fs-1 text-gradient"></i>
                                <h4 class="mt-3 fw-bold">Groupes & affectations</h4>
                                <p class="text-secondary">Drag & drop, composition automatique, équilibrage...</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-rooms" role="tabpanel">
                            <div class="p-5 text-center">
                                <i class="bi bi-door-open fs-1 text-gradient"></i>
                                <h4 class="mt-3 fw-bold">Salles & ressources</h4>
                                <p class="text-secondary">Plan interactif du campus, équipements, réservations...</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-planning" role="tabpanel">
                            <div class="p-5 text-center">
                                <i class="bi bi-calendar-week fs-1 text-gradient"></i>
                                <h4 class="mt-3 fw-bold">Planning hebdomadaire</h4>
                                <p class="text-secondary">Vue agrégée par promotion, salle ou enseignant...</p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-4">
                            <span class="small text-secondary">
                                <i class="bi bi-building me-1"></i> Université Prestige · Direction des formations
                            </span>
                            <span class="small text-secondary">
                                <i class="bi bi-arrow-repeat me-1"></i> Synchro: il y a 2 min
                            </span>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="small text-secondary">
                                <i class="bi bi-database"></i> 24 promotions · 86 groupes
                            </span>
                            <span class="small text-secondary">
                                <i class="bi bi-download"></i> Exporter
                            </span>
                        </div>
                    </div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Activation des tabs Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab button'));
        triggerTabList.forEach(function(triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>


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