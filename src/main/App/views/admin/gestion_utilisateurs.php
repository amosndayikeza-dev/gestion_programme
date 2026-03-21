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
            

            <style>

                * {
                    font-family: 'Inter', sans-serif;
                }
                
                body {
                    background: #fff; /* Changé pour un gris plus doux */
                    min-height: 100vh;
                    color: #1f2937;
                    font-size: 14px;
                }
                
                .main-school-premium {
                   padding-top:20px;
                    background:white; /* Harmonisé avec le body */
                    font-family: 'Inter', sans-serif;
                    width:99%;
                }
                
                .header-premium {
                    background: white;
                    padding:1rem 0 0 0;
                    border-radius: 24px;
                    position: relative;
                }
                
                .page-title {
                    font-size: 1.8rem;
                    font-weight: 800;
                    color: rgba(0,0,0,0.7);
                    
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    letter-spacing: -1px;
                    line-height: 1.2; 
                }
                
                .title-badge {
                    font-size: 0.8rem;
                    padding: 0.2rem 0.8rem;
                     background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .btn-prime {
                    background: linear-gradient(145deg, #2563eb, #1e40af);
                    color: white;
                    border: none;
                    padding: 0.6rem 1.5rem;
                    border-radius: 14px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    position: relative;
                    overflow: hidden;
                    transition: 0.3s;
                    box-shadow: 0 8px 20px -5px rgba(37, 99, 235, 0.3);
                }
                
                .btn-prime:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 15px 30px -8px rgba(37, 99, 235, 0.4);
                    color: white;
                }
                
                .btn-outline-premium {
                    background: white;
                    border: 1px solid #fde68a;
                    color: #2563eb;
                    padding: 0.6rem 1rem;
                    border-radius: 12px;
                }
                
                .graph-card {
                    background: white;
                    border-radius: 24px;
                    padding: 1.2rem;
                    height: 100%;
                    border: 1px solid #e5e7eb;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: 0.3s;
                }
                
                .graph-card:hover {
                    transform: scale(1.02);
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                }
                
                .chart-bars {
                    display: flex;
                    align-items: flex-end;
                    gap: 0.5rem;
                    height: 90px;
                }
                
                .bar {
                    flex: 1;
                    border-radius: 8px 8px 0 0;
                    transition: height 0.3s;
                }
                
                .active-bar {
                    box-shadow: 0 0 15px rgba(245, 158, 11, 0.5);
                }
                
                .donut-chart {
                    position: relative;
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    background: conic-gradient(#2563eb 0% 68%, #f59e0b 68% 83%, #10b981 83% 92%, #8b5cf6 92% 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .donut-center {
                    width: 60px;
                    height: 60px;
                    background: white;
                    border-radius: 50%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }
                
                .donut-total {
                    font-size: 1.2rem;
                    font-weight: 800;
                    color: #2563eb;
                    line-height: 1;
                }
                
                .filter-premium {
                    background: transparent;
                    border-radius: 20px;
                    padding: 0rem 1.2rem;
                    display: flex;
                    gap:5px;
                    justify-content: space-between;
                    align-items: center;
                }
                
                .filter-scroll {
                display: flex;
                gap: 0.5rem;
                border-radius: 20px;
                overflow-x: auto;
                display: flex;
                align-items: center;
                padding-bottom: 0.2rem;
            }

            .filter-scroll::-webkit-scrollbar {
                display: none;
            }
                
                .filter-chip {
                    padding: 0.4rem 0.6rem;
                    background: #f3f4f6;
                    border-radius: 40px;
                    font-size: 0.8rem;
                    font-weight: 500;
                    color: #4b5563;
                    white-space: nowrap;
                    transition: 0.2s;
                    cursor: pointer;
                }
                
                .filter-chip.active {
                    background: linear-gradient(145deg, #2563eb, #1e40af);
                    color: white;
                }
                
                .filter-chip:hover {
                    background: #e5e7eb;
                    transform:scale(1.05)
                }
                
                .search-premium {
                    position: relative;
                    min-width: 250px;
                }
                
                .search-premium input {
                    width: 100%;
                    padding: 0.3rem 0.5rem 0.5rem 2.5rem;
                    border: 1px solid #e5e7eb;
                    border-radius: 40px;
                    font-size: 0.85rem;
                }
                
                .search-premium input:focus{
                    outline:none;
                    border-color: #2563eb;
                }

                .search-premium i {
                    position: absolute;
                    left: 1rem;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #9ca3af;
                }
                
                .profile-card-compact {
                    background: #f9fafb;
                    border-radius: 16px;
                    padding: 0.8rem;
                    transition: all 0.3s;
                    border: 1px solid transparent;
                }
                
                .profile-card-compact:hover {
                    background: white;
                    border-color: #f59e0b;
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px -10px rgba(245, 158, 11, 0.2);
                }
                
                .avatar-premium {
                    position: relative;
                    margin-right: 0.8rem;
                    font-size: 2rem;
                }
                
                .status-online {
                    position: absolute;
                    bottom: 5px;
                    right: 0;
                    width: 10px;
                    height: 10px;
                    background: #10b981;
                    border: 2px solid white;
                    border-radius: 50%;
                }
                
                .badge-student {
                    background: #2563eb;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                    font-weight: 600;
                }
                
                .badge-gold {
                    background: linear-gradient(145deg, #f59e0b, #fbbf24);
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                    font-weight: 700;
                }
                
                .badge-professor {
                    background: #10b981;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                }
                
                .badge-director {
                    background: #8b5cf6;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                }
                
               
                
                .table {
                    margin-bottom: 0;
                }
                
                .table thead th {
                    background: #f3f4f6;
                    color: #4b5563;
                    font-size: 0.75rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    border-bottom: none;
                }
                
                .role-indicator {
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 4px;
                    margin-right: 0.5rem;
                }
                
                .btn-action {
                    width: 28px;
                    height: 28px;
                    border-radius: 8px;
                    border: none;
                    background: transparent;
                    color: #6b7280;
                    transition: 0.2s;
                }
                
                .btn-action:hover {
                    background: #f59e0b;
                    color: white;
                }
                
                .alert-premium {
                    background: linear-gradient(145deg, white, #f9fafb);
                    border-radius: 20px;
                    padding: 1rem 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    border: 1px solid #fde68a;
                    margin-top: 1rem;
                }
                
                .btn-glass {
                    background: linear-gradient(145deg, #2563eb, #1e40af);
                    color: white;
                    border: none;
                    padding: 0.4rem 1.2rem;
                    border-radius: 12px;
                    font-size: 0.8rem;
                    font-weight: 600;
                    margin-left: auto;
                }
                
                @keyframes pulse {
                    0% { opacity: 1; transform: scale(1); }
                    50% { opacity: 0.6; transform: scale(1.2); }
                    100% { opacity: 1; transform: scale(1); }
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                
                .animate-fade-in {
                    animation: fadeIn 0.5s ease;
                }
                
                .mt-\[74px\] {
                    margin-top: 74px;
                }
                
                .ml-\[230px\] {
                    margin-left: 230px;
                }
                
                .flex-1 {
                    flex: 1 1 0%;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                    color: #000000;
                    border-right: 1px solid rgba(0, 0, 0, 0.1);
                }
                
                .progress-premium {
                    height: 6px;
                    background: #f3f4f6;
                    border-radius: 10px;
                }
                
                .progress-fill {
                    height: 6px;
                    border-radius: 10px;
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Administration Système</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['fonction']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['experience']); ?> d'expérience</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="hidden md:flex items-center space-x-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-medium">
                                <i class="fas fa-server"></i>
                                <span>Système: <span class="font-bold">Opérationnel</span></span>
                            </div>
                            
                            <div class="relative">
                                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                                </button>
                            </div>
                            
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Administrateur Système</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($this->user['nom']); ?></p>
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
                            <h2 class="text-lg font-bold">Navigation Admin</h2>
                        </div>
                       
                        <nav class="space-y-2">

                             <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Dashboard', 'url'=>'dashboard_standalone_fixed.php', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-users', 'label' => 'Gestion Utilisateurs','url'=>'gestion_utilisateur.php', 'badge' => '3'],
                                ['icon' => 'fas fa-graduation-cap', 'label' => 'Élèves', 'url'=>'gestion_etudiant.php', 'badge' => '245'],
                                ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Enseignants', 'url'=>'gestion_enseignant.php', 'badge' => '32'],
                                ['icon' => 'fas fa-school', 'label' => 'Classes', 'url'=>'dashboard_standalone_fixed.php', 'badge' => '12'],
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
                        
                        <script>
                            document.querySelectorAll('.menu-item > a').forEach(link => {
                                link.addEventListener('click', function(e) {
                                    const submenu = this.parentElement.querySelector('.submenu');
                                    if (submenu) {
                                        e.preventDefault(); // empêche la navigation
                                        submenu.classList.toggle('hidden');
                                    }
                                });
                            });
                        </script>
                        
                        <div class="mt-8 pt-6 border-t border-black/10">
                            <div class="px-4 py-3 bg-black/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-3">État du système</p>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Sessions actives:</span>
                                        <span class="font-bold text-blue-600"><?php echo $content['system_data']['active_sessions']; ?></span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Uptime:</span>
                                        <span class="font-bold text-green-600"><?php echo $content['system_data']['uptime']; ?></span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-black/60">Dernière sauvegarde:</span>
                                        <span class="font-bold text-gray-600"><?php echo $content['system_data']['last_backup']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- MAIN CONTENT -->
<main class="flex-1 animate-fade-in mt-[74px] ml-[270px]" style="width: calc(100% - 270px); ;">

    <div id="containerTitre" style=" padding:10px; display: none; justify-content: space-between; align-items:center; width:99.5%; padding:0px; margin-left:18px; padding-right:10px">
        <h1 id="titreFormulaire" style="width:90%; font-size:25px; display:flex; justify-content: center; " class="">Ajouter un</h1>
        <span id="retourner" style="font-size:30px;  cursor:pointer; padding:10px; ">
        <i class="fas fa-times"></i>
        </span>
    </div>

    <!--Formulaires d'ajout-->
        <div id="zoneFormulaire" style="display:none; " class=" container pt-3 pb-3 rounded-0 ms-3 shadow-none">
            
        </div>
        
    <div class="main-school-premium" style="width: 100%; max-width: 100%; z-index:0;">


        
        <!-- EN-TÊTE MINISTÉRIEL -->

        

        <div class="header-premium d-flex justify-content-between align-items-center mb-4 position-relative " style=" z-index:0;">
             
            <div class="">
                <h1 class="page-title">
                    <i class="ri-group-2-line"></i>
                    Gestion des utilisateurs
                    <span class="title-badge">2,847 actifs</span>
                </h1>

                <div class="session-meta">
                    <span><i class="ri-calendar-line"></i> Année 2025-2026</span>
                    
                </div>
            </div>

            <div class="action-group d-flex gap-2">

               


                <div class="menu-wrapper">
                    <button class="btn-prime" id="ajoutUtilisateur">
                        <i class="ri-add-line"></i>
                        Nouveau 
                        <span class="btn-glow"></span>
                    </button>


                    <div class="submenu border border-1  rounded-4 shadow" id="submenuProfil">
                        <a href="#" id="btnEtudiant"  class="btnUserType"  data-type="etudiant">Étudiant</a>
                        <a href="#" id="btnEnseignant"  class="btnUserType"  data-type="enseignant" >enseignant</a>
                        <a href="#" id="btnPrefet"  class="btnUserType" data-type="Prefet" >Prefet</a>
                        <a href="#" id="btnParent"  class="btnUserType" data-type="parent" >parent</a>
                        <a href="#" id="btnInspecteur"  class="btnUserType" data-type="inspecteur" >inspecteur</a>
                        <a href="#" id="btnTuteur"  class="btnUserType" data-type="tuteur" >tuteur</a>
                        <a href="#" id="btnTitulaire"  class="btnUserType"  data-type="titulaire">titulaire</a>
                    </div>
                </div>






                <button class="btn-outline-premium">
                    <i class="ri-download-2-line"></i>
                </button>
            </div>
        </div>

        <!-- DASHBOARD GRAPHIQUES PREMIUM -->
         
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="graph-card">
                   
                    
                </div>
            </div>

            <div class="col-lg-4">
                <div class="graph-card">
                    <div class="graph-header d-flex justify-content-between align-items-center">
                        <span> Répartition par rôle</span>
                        <span class="glass-badge" style="font-size: 0.7rem; background: #f3f4f6; padding: 0.2rem 0.6rem; border-radius: 40px;">2026</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="donut-chart">
                            <div class="donut-center">
                                <span class="donut-total">2,847</span>
                                <span class="donut-label" style="font-size: 0.6rem; color: #6b7280;">total</span>
                            </div>
                        </div>
                        <div class="legend-premium" style="font-size: 0.75rem;">
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #2563eb; border-radius: 4px;"></span> Étudiant 68%</div>
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #f59e0b; border-radius: 4px;"></span> Enseignants 15%</div>
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #10b981; border-radius: 4px;"></span> Parents 9%</div>
                            <div class="d-flex align-items-center gap-2"><span style="width: 10px; height: 10px; background: #8b5cf6; border-radius: 4px;"></span> Direction 8%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="graph-card">
                    <div class="graph-header d-flex justify-content-between align-items-center">
                        <span> Taux de réussite</span>
                        <span class="score-badge" style="background: linear-gradient(145deg, #f59e0b, #fbbf24); color: white; padding: 0.2rem 0.8rem; border-radius: 40px; font-size: 0.8rem; font-weight: 700;">84.5%</span>
                    </div>
                    <div class="progress-stack">
                        <div class="progress-item mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CE2</span>
                                <span class="fw-bold" style="color: #2563eb; font-size: 0.75rem;">78%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 78%; background: linear-gradient(90deg, #2563eb, #60a5fa);"></div>
                            </div>
                        </div>
                        <div class="progress-item mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CM1</span>
                                <span class="fw-bold" style="color: #2563eb; font-size: 0.75rem;">82%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 82%; background: linear-gradient(90deg, #2563eb, #60a5fa);"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CM2</span>
                                <span class="fw-bold" style="color: #f59e0b; font-size: 0.75rem;">91%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 91%; background: linear-gradient(90deg, #f59e0b, #fbbf24);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="graph-footer mt-3">
                        <span style="font-size: 0.7rem; color: #4b5563;">📊 +4.2% vs semestre 1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTRES PREMIUM -->
        <div class="filter-premium mb-4">
            <div class="filter-scroll">
                <span class="filter-chip active">Tous (2,847)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Étudiants (1,934)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Enseignants (189)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Parents (512)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Direction (24)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Inspecteurs (12)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Préfets (18)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Tuteurs (45)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Titulaires (32)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Surveillants (28)</span>
                <span class="filter-chip"><i class="bi bi-book"></i> Bibliothèque (6)</span>
                <span class="filter-chip"><i class="bi "></i> Infirmiers (4)</span>
                <span class="filter-chip"><i class="bi "></i> Psychologues (3)</span>
                <span class="filter-chip"><i class="bi "></i> Cantine (8)</span>
                <span class="filter-chip"><i class="bi "></i> Entretien (12)</span>
            </div>

         

            <div class="search-premium">
                <i class="ri-search-line"></i>
                <input type="text" placeholder="Rechercher un profil...">
            </div>
        </div>

        <!-- GRILLE CARTES PREMIUM + TABLEAU -->
        <!-- GRILLE CARTES PREMIUM + TABLEAU -->
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="cards-grid-premium">
            <div class="grid-header d-flex justify-content-between align-items-center mb-3">
                <h6 style="font-weight: 700; color: #1f2937; margin: 0;">
                    <i class="ri-user-star-line" style="color: #f59e0b;"></i> Profils récents
                </h6>
                <span class="live-indicator" style="font-size: 0.7rem; color: #10b981; animation: pulse 2s infinite">
                    <i class="ri-record-circle-fill" style="font-size: 0.5rem;"></i> 12 actifs maintenant
                </span>
            </div>
            
            <div class="row g-2">
                <!-- Carte Élève -->
                <div class="col-6 col-xl-4">
                    <div class="profile-card-compact d-flex align-items-start gap-2">
                        <div class="avatar-premium position-relative">
                            <div class="rounded-circle bg-blue-100 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #dbeafe;">
                                <i class="fas fa-user-graduate" style="color: #2563eb; font-size: 1.2rem;"></i>
                            </div>
                            <span class="status-online"></span>
                        </div>
                        <div class="profile-info" style="flex: 1;">
                            <div class="name fw-bold" style="font-size: 0.9rem;">Kouassi Yao</div>
                            <div class="badge-row d-flex flex-wrap gap-1 mb-1">
                                <span class="badge-student"><i class="fas fa-graduation-cap me-1"></i>CM2</span>
                                <span class="badge-gold"><i class="fas fa-star me-1"></i>16.8/20</span>
                            </div>
                            <div class="meta-row d-flex justify-content-between align-items-center">
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-parent-line me-1"></i> Mme Yao</span>
                                <span style="font-size: 0.65rem; color: #10b981; font-weight: 600;"><i class="fas fa-arrow-up"></i> 12%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Enseignant -->
                <div class="col-6 col-xl-4">
                    <div class="profile-card-compact d-flex align-items-start gap-2">
                        <div class="avatar-premium position-relative">
                            <div class="rounded-circle bg-amber-100 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #fef3c7;">
                                <i class="fas fa-chalkboard-teacher" style="color: #f59e0b; font-size: 1.2rem;"></i>
                            </div>
                            <span class="status-online"></span>
                        </div>
                        <div class="profile-info">
                            <div class="name fw-bold" style="font-size: 0.9rem;">Pr. Aya N'Guessan</div>
                            <div class="badge-row d-flex flex-wrap gap-1 mb-1">
                                <span class="badge-professor"><i class="fas fa-id-card me-1"></i>Titulaire</span>
                                <span class="badge" style="background: #f59e0b; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-star me-1"></i>4.8</span>
                            </div>
                            <div class="meta-row d-flex gap-2">
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-flask-line me-1"></i>Physique</span>
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-time-line me-1"></i>15 ans</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Parent -->
                <div class="col-6 col-xl-4">
                    <div class="profile-card-compact d-flex align-items-start gap-2">
                        <div class="avatar-premium position-relative">
                            <div class="rounded-circle bg-emerald-100 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #d1fae5;">
                                <i class="fas fa-user-friends" style="color: #10b981; font-size: 1.2rem;"></i>
                            </div>
                            <span class="status-online"></span>
                        </div>
                        <div class="profile-info">
                            <div class="name fw-bold" style="font-size: 0.9rem;">Konan Jean</div>
                            <div class="badge-row d-flex flex-wrap gap-1 mb-1">
                                <span class="badge" style="background: #10b981; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-heart me-1"></i>Parent</span>
                                <span class="badge" style="background: #10b981; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-child me-1"></i>3 enfants</span>
                            </div>
                            <div class="meta-row d-flex gap-2">
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-heart-line me-1"></i>Très actif</span>
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-group-line me-1"></i>APE</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Doyen -->
                <div class="col-6 col-xl-4">
                    <div class="profile-card-compact d-flex align-items-start gap-2">
                        <div class="avatar-premium position-relative">
                            <div class="rounded-circle bg-purple-100 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #ede9fe;">
                                <i class="fas fa-user-tie" style="color: #8b5cf6; font-size: 1.2rem;"></i>
                            </div>
                            <span class="status-online"></span>
                        </div>
                        <div class="profile-info">
                            <div class="name fw-bold" style="font-size: 0.9rem;">Pr. François Kouadio</div>
                            <div class="badge-row d-flex flex-wrap gap-1 mb-1">
                                <span class="badge-director"><i class="fas fa-crown me-1"></i>Doyen</span>
                                <span class="badge" style="background: #8b5cf6; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-briefcase me-1"></i>24 ans</span>
                            </div>
                            <div class="meta-row">
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-building-line me-1"></i>UFR Droit</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Préfet -->
                <div class="col-6 col-xl-4">
                    <div class="profile-card-compact d-flex align-items-start gap-2">
                        <div class="avatar-premium position-relative">
                            <div class="rounded-circle bg-emerald-100 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #d1fae5;">
                                <i class="fas fa-shield-alt" style="color: #10b981; font-size: 1.2rem;"></i>
                            </div>
                            <span class="status-online"></span>
                        </div>
                        <div class="profile-info">
                            <div class="name fw-bold" style="font-size: 0.9rem;">Michel Yao</div>
                            <div class="badge-row d-flex flex-wrap gap-1 mb-1">
                                <span class="badge" style="background: #10b981; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-gavel me-1"></i>Préfet</span>
                                <span class="badge" style="background: #10b981; color: white; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-users me-1"></i>1,200 él.</span>
                            </div>
                            <div class="meta-row">
                                <span style="font-size: 0.7rem; color: #6b7280;"><i class="ri-shield-line me-1"></i>Discipline</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="view-all-link mt-3 text-end">
                <a href="#" style="color: #2563eb; text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                    Voir tous les 2,847 profils <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- TABLEAU RÉCAPITULATIF -->
    <div class="col-lg-5">
        <div class="table-premium bg-white rounded-4 p-4 h-100 border border-gray-100" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <div class="table-header d-flex justify-content-between align-items-center mb-3">
                <h6 style="font-weight: 700; color: #1f2937; margin: 0;">
                    <i class="ri-table-line" style="color: #f59e0b;"></i> Récapitulatif & performances
                </h6>
                <span class="export-btn" style="cursor: pointer; color: #2563eb; transition: 0.2s;">
                    <i class="ri-download-line"></i>
                </span>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle" style="border-collapse: separate; border-spacing: 0 4px;">
                    <thead>
                        <tr style="background: transparent;">
                            <th class="border-0" style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Rôle</th>
                            <th class="border-0" style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Effectif</th>
                            <th class="border-0" style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Moyenne</th>
                            <th class="border-0" style="font-size: 0.7rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Activité</th>
                            <th class="border-0"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-bottom" style="transition: 0.2s; cursor: default; border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.5rem 0;"><span class="role-indicator" style="background: #2563eb;"></span> Étudiant</td>
                            <td class="fw-bold" style="color: #1f2937;">1,934</td>
                            <td><span class="score" style="color: #2563eb; font-weight: 600;">14.2/20</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 82%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #f59e0b;"></span> Enseignants</td>
                            <td class="fw-bold">189</td>
                            <td><span class="score" style="color: #2563eb; font-weight: 600;">4.7/5</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 94%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #10b981;"></span> Parents</td>
                            <td class="fw-bold">512</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #fff3cd; color: #f59e0b; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 64%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #8b5cf6;"></span> Direction</td>
                            <td class="fw-bold">24</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 100%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #8b5cf6;"></span> Inspecteurs</td>
                            <td class="fw-bold">12</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #dbeafe; color: #2563eb; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 8 en cours</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #10b981;"></span> Préfets</td>
                            <td class="fw-bold">18</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 100%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #8b5cf6;"></span> Tuteurs</td>
                            <td class="fw-bold">45</td>
                            <td><span class="score" style="color: #2563eb; font-weight: 600;">82%</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 78%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr class="border-bottom" style="transition: 0.2s; border-bottom: 1px solid #f3f4f6;">
                            <td><span class="role-indicator" style="background: #4b5563;"></span> Surveillants</td>
                            <td class="fw-bold">28</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #e6f7e6; color: #10b981; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 92%</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                        <tr>
                            <td><span class="role-indicator" style="background: #6b7280;"></span> Bibliothèque</td>
                            <td class="fw-bold">6</td>
                            <td><span class="text-muted">-</span></td>
                            <td><span class="badge" style="background: #e5e7eb; color: #4b5563; padding: 0.2rem 0.6rem; border-radius: 40px; font-size: 0.65rem; font-weight: 600;"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> 4 actifs</span></td>
                            <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-gray-100">
                <span style="font-size: 0.75rem; color: #4b5563;">Total: <strong>2,847</strong> utilisateurs</span>
                <span class="premium-badge" style="background: linear-gradient(145deg, #f59e0b, #fbbf24); color: white; padding: 0.3rem 0.8rem; border-radius: 40px; font-size: 0.7rem; font-weight: 600;">
                    <i class="ri-bar-chart-2-line me-1"></i> Taux évaluation: 74%
                </span>
            </div>
        </div>
    </div>
</div>

        <!-- ALERTE SUIVI PREMIUM -->
        <div class="alert-premium">
            <div class="pulse-dot"></div>
            <div class="alert-content">
                <span style="font-size: 0.85rem; color: #1f2937;"><strong>Évaluations en cours</strong> · 156 élèves · 12 inspections · 8 réunions parents</span>
            </div>
            <button class="btn-glass">
                <i class="ri-file-copy-line"></i> Rapport
            </button>
        </div>
    </div>
 <br><br><br><br><br><br>






<style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f5f7fb;
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



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
        <!-- En-tête principal -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-blue-600"></i>
                    Gestion des utilisateurs
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>
                    Année scolaire 2025-2026 · Administration complète
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover-lift stat-card">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total utilisateurs</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statTotal">0</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-green-600"><i class="fas fa-arrow-up"></i> +12% ce mois</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Étudiants</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statStudents">0</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full">
                        <i class="fas fa-graduation-cap text-amber-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-green-600"><i class="fas fa-arrow-up"></i> +8%</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Enseignants</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statTeachers">0</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full">
                        <i class="fas fa-chalkboard-user text-emerald-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-500">Stable</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 hover-lift">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Parents / Tuteurs</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="statParents">0</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full">
                        <i class="fas fa-user-friends text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-3 text-xs text-amber-600"><i class="fas fa-chart-line"></i> +5%</div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap gap-2" id="roleFiltersContainer">
                <button data-role="all" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 active">Tous <span id="filterTotal">0</span></button>
                <button data-role="etudiant" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Étudiants <span id="filterStudents">0</span></button>
                <button data-role="enseignant" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Enseignants <span id="filterTeachers">0</span></button>
                <button data-role="parent" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Parents <span id="filterParents">0</span></button>
                <button data-role="admin" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Admin <span id="filterAdmin">0</span></button>
                <button data-role="prefet" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Préfets <span id="filterPrefets">0</span></button>
                <button data-role="inspecteur" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Inspecteurs <span id="filterInspecteurs">0</span></button>
                <button data-role="tuteur" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Tuteurs <span id="filterTuteurs">0</span></button>
                <button data-role="titulaire" class="filter-chip px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700">Titulaires <span id="filterTitulaires">0</span></button>
            </div>
            <div class="relative w-full sm:w-64">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Rechercher nom ou email..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Classe</label><input type="text" id="studentClass" value="${extra.classe || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Moyenne</label><input type="text" id="studentAverage" value="${extra.moyenne || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                    </div>
                `;
            } else if (role === 'enseignant') {
                html = `
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Matière(s)</label><input type="text" id="teacherSubject" value="${extra.matiere || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Ancienneté</label><input type="text" id="teacherExp" value="${extra.anciennete || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                    </div>
                `;
            } else if (role === 'parent') {
                html = `
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'enfants</label><input type="text" id="parentChildren" value="${extra.enfants || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Association</label><input type="text" id="parentAssoc" value="${extra.association || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>
                    </div>
                `;
            } else if (role === 'admin') {
                html = `<div><label class="block text-sm font-medium text-gray-700 mb-1">Service</label><input type="text" id="adminService" value="${extra.service || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>`;
            } else if (role === 'prefet') {
                html = `<div><label class="block text-sm font-medium text-gray-700 mb-1">Secteur / Élèves sous responsabilité</label><input type="text" id="prefetSecteur" value="${extra.secteur || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>`;
            } else if (role === 'inspecteur') {
                html = `<div><label class="block text-sm font-medium text-gray-700 mb-1">Zone d'inspection</label><input type="text" id="inspecteurZone" value="${extra.zone || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>`;
            } else if (role === 'tuteur') {
                html = `<div><label class="block text-sm font-medium text-gray-700 mb-1">Spécialité</label><input type="text" id="tuteurSpecialite" value="${extra.specialite || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>`;
            } else if (role === 'titulaire') {
                html = `<div><label class="block text-sm font-medium text-gray-700 mb-1">Fonction</label><input type="text" id="titulaireFonction" value="${extra.fonction || ''}" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></div>`;
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${escapeHtml(user.name)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${escapeHtml(user.email)}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span class="badge-role">${roleLabel}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-500">${escapeHtml(extraInfo) || '—'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
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


</main>



            


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