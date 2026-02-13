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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
            
            
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
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: ;
                color: #1e293b;
                line-height: 1.5;
                padding: 2rem;
            }



            /* Typographie premium */
            h1, h2, h3, h4, h5, h6 {
                font-weight: 600;
                letter-spacing: -0.01em;
            }

            .text-accent {
                color: #6366f1;
            }

            .bg-soft {
                background-color: #f8fafd;
            }

            /* Cartes élégantes */
            .card-premium {
                background: white;
                border: none;
                border-radius: 20px;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.02);
                transition: all 0.2s ease;
            }

            .card-premium:hover {
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.04);
                transform: translateY(-2px);
            }

            /* Statuts */
            .badge-permanent {
                background-color: #e6f7e6;
                color: #0b5e42;
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 30px;
                font-size: 0.8rem;
            }

            .badge-vacataire {
                background-color: #fff3e0;
                color: #b85b14;
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 30px;
                font-size: 0.8rem;
            }

            .badge-doctorant {
                background-color: #eef2ff;
                color: #4f46e5;
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 30px;
                font-size: 0.8rem;
            }

            .badge-emerite {
                background-color: #f3e8ff;
                color: #7e22ce;
                font-weight: 500;
                padding: 0.5rem 1rem;
                border-radius: 30px;
                font-size: 0.8rem;
            }

            /* Boutons */
            .btn-premium {
                padding: 0.6rem 1.5rem;
                border-radius: 40px;
                font-weight: 500;
                font-size: 0.95rem;
                transition: all 0.2s;
                border: none;
            }

            .btn-premium-primary {
                background: #6366f1;
                color: white;
            }

            .btn-premium-primary:hover {
                background: #4f52e0;
                color: white;
                transform: scale(0.98);
            }

            .btn-premium-outline {
                background: transparent;
                border: 1.5px solid #e2e8f0;
                color: #475569;
            }

            .btn-premium-outline:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            /* Recherche */
            .search-wrapper {
                background: white;
                border-radius: 60px;
                padding: 0.4rem 0.4rem 0.4rem 1.5rem;
                border: 1.5px solid #f1f5f9;
                transition: all 0.2s;
            }

            .search-wrapper:focus-within {
                border-color: #6366f1;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }

            .search-input {
                border: none;
                background: transparent;
                padding: 0.6rem 0;
                font-size: 0.95rem;
            }

            .search-input:focus {
                outline: none;
                box-shadow: none;
            }

            /* Avatar / initiales */
            .avatar-initials {
                width: 48px;
                height: 48px;
                border-radius: 16px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 1.1rem;
            }

            /* Filtres */
            .filter-chip {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1.2rem;
                background: white;
                border: 1.5px solid #e2e8f0;
                border-radius: 40px;
                font-size: 0.9rem;
                font-weight: 500;
                color: #475569;
                transition: all 0.2s;
                cursor: pointer;
            }

            .filter-chip.active {
                background: #6366f1;
                border-color: #6366f1;
                color: white;
            }

            .filter-chip:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
            }

            .filter-chip.active:hover {
                background: #4f52e0;
            }

            .sidebar-premium {
                background: white;
                border-radius: 24px;
                padding: 1.8rem;
                height: fit-content;
            }

            /* Grille enseignants */
            .teacher-card {
                border-radius: 24px;
                padding: 1.5rem;
                transition: all 0.25s;
                border: 1px solid #f1f5f9;
                height: 100%;
            }

            .teacher-card:hover {
                border-color: transparent;
                box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05);
                transform: translateY(-4px);
            }

            /* Progress bar */
            .progress-premium {
                height: 8px;
                background: #f1f5f9;
                border-radius: 20px;
                overflow: hidden;
            }

            .progress-bar-premium {
                background: #6366f1;
                border-radius: 20px;
            }


            /* Responsive */
            @media (max-width: 768px) {
                body { padding: 1rem; }
                .teacher-card { padding: 1.2rem; }
            }
        </style>

                <!-- Main Content -->
                <main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-[230px]">
                        
                    <div class="dashboard">

                            <!-- ======== EN-TÊTE ======== -->
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <div>
                                <h1 class="display-6 fw-semibold d-flex gap-2 align-items-center " style="color: #0f172a;">
                                    <i class="bi bi-people"></i>Enseignants
                                    <span style="font-size: 0.9rem; font-weight: 400; color: #94a3b8; margin-left: 1rem;">
                                        45 enseignants actifs
                                    </span>
                                </h1>
                                <p class="text-secondary-emphasis mt-1" style="color: #64748b;">
                                    Gestion et suivi des personnels académiques · 2025-2026
                                </p>
                            </div>
                            <div class="d-flex gap-3">
                                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-soft rounded-5">
                                    <i class="bi bi-calendar3 text-secondary"></i>
                                    <span class="fw-medium" style="color: #334155;">Février 2026</span>
                                </div>
                                <div class="avatar-initials" style="background: linear-gradient(145deg, #2563eb, #7c3aed);">
                                    AM
                                </div>
                            </div>
                        </div>

                        <!-- ======== STATISTIQUES RAPIDES ======== -->
                        <div class="row g-4 mb-5">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card-premium p-4 d-flex align-items-start">
                                    <div class="rounded-4 p-3 bg-primary bg-opacity-10 mb-3">
                                        <i class="bi bi-people-fill fs-4" style="color: #6366f1;"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary text-uppercase small fw-semibold tracking-wide">Total</span>
                                        <h2 class="display-5 fw-bold mb-0" style="color: #0f172a;">45</h2>
                                        <span class="text-success small">+3 ce semestre</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card-premium p-4 d-flex align-items-start">
                                    <div class="rounded-4 p-3 bg-success bg-opacity-10 mb-3">
                                        <i class="bi bi-person-check-fill fs-4" style="color: #10b981;"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary text-uppercase small fw-semibold">Permanents</span>
                                        <h2 class="display-5 fw-bold mb-0" style="color: #0f172a;">32</h2>
                                        <span class="text-secondary small">71%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card-premium p-4 d-flex align-items-start">
                                    <div class="rounded-4 p-3 bg-warning bg-opacity-15 mb-3">
                                        <i class="bi bi-person-up fs-4" style="color: #f59e0b;"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary text-uppercase small fw-semibold">Vacataires</span>
                                        <h2 class="display-5 fw-bold mb-0" style="color: #0f172a;">13</h2>
                                        <span class="text-secondary small">29%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="card-premium p-4 d-flex align-items-start">
                                    <div class="rounded-4 p-3 bg-info bg-opacity-10 mb-3">
                                        <i class="bi bi-clock-history fs-4" style="color: #3b82f6;"></i>
                                    </div>
                                    <div>
                                        <span class="text-secondary text-uppercase small fw-semibold">Volume horaire</span>
                                        <h2 class="display-5 fw-bold mb-0" style="color: #0f172a;">1 248h</h2>
                                        <span class="text-secondary small">Moy. 156h</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                             <!-- ======== BARRE D'OUTILS ======== -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 ">
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-premium btn-premium-primary d-flex align-items-center gap-2">
                                    <i class="bi bi-plus-lg"></i> Nouvel enseignant
                                </button>
                                <button class="btn btn-premium btn-premium-outline d-flex align-items-center gap-2">
                                    <i class="bi bi-upload"></i> Importer
                                </button>
                                <button class="btn btn-premium btn-premium-outline d-flex align-items-center gap-2">
                                    <i class="bi bi-download"></i> Exporter
                                </button>
                                <button class="btn btn-premium btn-premium-outline d-flex align-items-center gap-2">
                                    <i class="bi bi-arrow-repeat"></i> Sync
                                </button>
                            </div>

                            <div class="d-flex gap-2">
                                <span class="filter-chip active">Tous</span>
                                <span class="filter-chip">Permanents</span>
                                <span class="filter-chip">Vacataires</span>
                            </div>
                        </div>

                         <!-- ======== RECHERCHE + FILTRES AVANCÉS ======== -->
                        <div class="row g-3 mb-5">
                            <div class="col-lg-6">
                                <div class="search-wrapper d-flex align-items-center">
                                    <i class="bi bi-search text-secondary me-2"></i>
                                    <input type="text" class="form-control search-input" placeholder="Rechercher un enseignant, département..." aria-label="Recherche">
                                    <span class="badge bg-light text-secondary px-3 py-2 rounded-5">⌘K</span>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex gap-2 align-items-center justify-content-lg-end">
                                <i class="bi bi-funnel text-secondary"></i>
                                <span class="text-secondary me-2">Filtres avancés</span>
                                <select class="form-select w-auto rounded-5 border-light-subtle bg-white" style="padding: 0.5rem 2rem 0.5rem 1.2rem;">
                                    <option>Tous départements</option>
                                    <option>Mathématiques</option>
                                    <option>Informatique</option>
                                    <option>Physique</option>
                                    <option>Génie civil</option>
                                    <option>Chimie</option>
                                </select>
                                <select class="form-select w-auto rounded-5 border-light-subtle bg-white">
                                    <option>Tous statuts</option>
                                    <option>Permanent</option>
                                    <option>Vacataire</option>
                                    <option>Doctorant</option>
                                </select>
                            </div>
                        </div>


                        <div class="row g-5">
                            <!-- COLONNE PRINCIPALE : CARTES ENSEIGNANTS -->
                            <div class="col-xl-8">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="fw-semibold mb-0"><span class="text-accent">45</span> enseignants</h5>
                                    <div class="d-flex gap-2 align-items-center">
                                        <span class="text-secondary small">Tri:</span>
                                        <span class="fw-medium" style="color: #0f172a;">Nom <i class="bi bi-arrow-down-short"></i></span>
                                        <span class="text-secondary mx-1">·</span>
                                        <span class="text-secondary">Date d'arrivée</span>
                                    </div>
                                </div>

                                <div class="row g-4">

                                    <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                     <!-- CARTE 1 : -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="teacher-card bg-white ">
                                            <div class="d-flex align-items-start gap-3 mb-3">
                                                <div class="avatar-initials" style="background: linear-gradient(145deg, #3b82f6, #2563eb);">JD</div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <h5 class="fw-semibold mb-0" style="color: #0f172a;">Jean DUPONT</h5>
                                                        <span class="badge-permanent">Permanent</span>
                                                    </div>

                                                    <div class="text-secondary small mb-1">
                                                        <span>cours: </span>
                                                        <span>javascript</span>
                                                    </div>

                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-building fs-7 text-secondary"></i>
                                                        <span class="small" style="color: #334155;">
                                                            <span>Faculte:</span>
                                                           </span> Mathématiques</span>
                                                        <span class="text-secondary">·</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="bi bi-envelope text-secondary"></i>
                                                    <span class="small" style="color: #475569;">
                                                        jean@gmail.com
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1 text-danger">
                                                    <i class="bi bi-telephone"></i>
                                                    <span class="small" >+257 61000000</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <div>
                                                    <span class="fw-semibold" style="color: #0f172a;">192h</span>
                                                    <span class="text-secondary small">/année</span>
                                                    <span class="mx-2 text-secondary">·</span>
                                                    <span class="small" style="color: #475569;">16h/semaine</span>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm rounded-4 px-3 py-1" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-bar-chart"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm rounded-4 px-3" style="background: #f1f5f9; color: #334155; border: none;">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        

                                       
                                    </div>

                                    

                                   
                                </div>

                                <!-- PAGINATION -->
                                <div class="d-flex justify-content-between align-items-center mt-5">
                                    <span class="text-secondary small">Affichage 1-6 sur 45 enseignants</span>
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            <li class="page-item disabled"><span class="page-link border-0 bg-transparent text-secondary">←</span></li>
                                            <li class="page-item"><a class="page-link border-0 bg-transparent fw-semibold" href="#" style="color: #6366f1;">1</a></li>
                                            <li class="page-item"><a class="page-link border-0 bg-transparent text-secondary" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link border-0 bg-transparent text-secondary" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link border-0 bg-transparent text-secondary" href="#">4</a></li>
                                            <li class="page-item"><a class="page-link border-0 bg-transparent text-secondary" href="#">→</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                            <!-- ======== SIDEBAR : PANNEAU LATÉRAL PREMIUM ======== -->
                                        <div class="col-xl-4">
                                            <div class="sidebar-premium">
                                                <div class="d-flex align-items-center gap-2 mb-4">
                                                    <i class="bi bi-sliders2 fs-5" style="color: #6366f1;"></i>
                                                    <h5 class="fw-semibold mb-0">Filtres & actions</h5>
                                                </div>

                                                <!-- RECHERCHE  -->
                                                <div class="search-wrapper d-flex align-items-center mb-4 w-100">
                                                    <i class="bi bi-search text-secondary me-2"></i>
                                                    <input type="text" class="form-control search-input" placeholder="Recherche rapide..." style="padding: 0.5rem 0;">
                                                    <span class="badge bg-light text-secondary px-3 py-2 rounded-5">⌘K</span>
                                                </div>

                                                <!-- DÉPARTEMENTS -->
                                                <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-folder2-open text-secondary"></i> Départements
                                                </h6>
                                                <div class="list-group list-group-flush mb-4">
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptAll" checked>
                                                            <label class="form-check-label fw-medium" for="deptAll">Tous</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">45</span>
                                                    </div>
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptMaths">
                                                            <label class="form-check-label" for="deptMaths">Mathématiques</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">12</span>
                                                    </div>
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptInfo" checked>
                                                            <label class="form-check-label" for="deptInfo">Informatique</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">15</span>
                                                    </div>
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptPhysique">
                                                            <label class="form-check-label" for="deptPhysique">Physique</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">8</span>
                                                    </div>
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptGenie">
                                                            <label class="form-check-label" for="deptGenie">Génie civil</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">6</span>
                                                    </div>
                                                    <div class="list-group-item border-0 px-0 py-1 d-flex justify-content-between align-items-center bg-transparent">
                                                        <div>
                                                            <input class="form-check-input me-2" type="checkbox" id="deptChimie">
                                                            <label class="form-check-label" for="deptChimie">Chimie</label>
                                                        </div>
                                                        <span class="badge bg-light text-dark rounded-pill">4</span>
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="#" class="text-decoration-none small" style="color: #6366f1;">+ Ajouter un département</a>
                                                    </div>
                                                </div>

                                                <!-- STATUTS -->
                                                <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-badge text-secondary"></i> Statut
                                                </h6>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <span class="badge-permanent me-2">●</span> Permanent
                                                        </div>
                                                        <span class="fw-semibold">32</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <span class="badge-vacataire me-2">●</span> Vacataire
                                                        </div>
                                                        <span class="fw-semibold">13</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <span class="badge-doctorant me-2">●</span> Doctorant
                                                        </div>
                                                        <span class="fw-semibold">4</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="badge-emerite me-2">●</span> Émérite
                                                        </div>
                                                        <span class="fw-semibold">2</span>
                                                    </div>
                                                </div>

                                                <!-- ANALYTIQUE : CHARGE HORAIRE -->
                                                <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-graph-up text-secondary"></i> Charge horaire moyenne
                                                </h6>
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="small text-secondary">Moyenne</span>
                                                        <span class="fw-bold" style="color: #0f172a;">156h / an</span>
                                                    </div>
                                                    <div class="progress-premium mb-3">
                                                        <div class="progress-bar-premium" style="width: 72%;"></div>
                                                    </div>
                                                    <div class="d-flex justify-content-between small">
                                                        <span style="color: #475569;">Min: 64h</span>
                                                        <span style="color: #475569;">Max: 208h</span>
                                                    </div>
                                                </div>

                                                <!-- ACTIONS RAPIDES -->
                                                <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-lightning-charge text-secondary"></i> Actions rapides
                                                </h6>
                                                <div class="d-grid gap-2 mb-4">
                                                    <button class="btn btn-light text-start d-flex align-items-center gap-3 py-2 px-3 rounded-4" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <i class="bi bi-book" style="color: #6366f1;"></i>
                                                        <span>Affecter un cours</span>
                                                        <i class="bi bi-chevron-right ms-auto small"></i>
                                                    </button>
                                                    <button class="btn btn-light text-start d-flex align-items-center gap-3 py-2 px-3 rounded-4" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <i class="bi bi-arrow-repeat" style="color: #f59e0b;"></i>
                                                        <span>Modifier statut</span>
                                                        <i class="bi bi-chevron-right ms-auto small"></i>
                                                    </button>
                                                    <button class="btn btn-light text-start d-flex align-items-center gap-3 py-2 px-3 rounded-4" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <i class="bi bi-calendar-week" style="color: #10b981;"></i>
                                                        <span>Emploi du temps</span>
                                                        <i class="bi bi-chevron-right ms-auto small"></i>
                                                    </button>
                                                    <button class="btn btn-light text-start d-flex align-items-center gap-3 py-2 px-3 rounded-4" style="background: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <i class="bi bi-clock-history" style="color: #8b5cf6;"></i>
                                                        <span>Historique des affectations</span>
                                                        <i class="bi bi-chevron-right ms-auto small"></i>
                                                    </button>
                                                </div>

                                                <!-- ÉVÉNEMENTS À VENIR -->
                                                <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar-event text-secondary"></i> Événements à venir
                                                </h6>
                                                <div class="bg-light p-3 rounded-4" style="background: #f8fafc !important;">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <div class="bg-warning bg-opacity-10 p-2 rounded-3">
                                                            <i class="bi bi-person-up text-warning"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium">Martin S. - Départ</div>
                                                            <span class="small text-secondary">31 août 2026</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <div class="bg-success bg-opacity-10 p-2 rounded-3">
                                                            <i class="bi bi-arrow-repeat text-success"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium">Petit A. - Renouvellement</div>
                                                            <span class="small text-secondary">1 sept. 2026</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="bg-primary bg-opacity-10 p-2 rounded-3">
                                                            <i class="bi bi-mic text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium">Réunion des chefs</div>
                                                            <span class="small text-secondary">15 févr. 2026</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        </div>
                        <div class="modal fade" id="ajoutEnseignantModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 24px; border: none; padding: 0.5rem;">
                        
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