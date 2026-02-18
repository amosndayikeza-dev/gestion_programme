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
                
                .main-school-premium {
                    padding: 1rem 1.5rem;
                    background: #F8FAFC;
                    font-family: 'Inter', sans-serif;
                    width: 100%;
                }
                
                .header-premium {
                    background: white;
                    padding: 1.2rem 1.8rem;
                    border-radius: 24px;
                    box-shadow: 0 10px 30px -10px rgba(10, 36, 114, 0.08);
                    border: 1px solid rgba(197, 160, 89, 0.15);
                    position: relative;
                    overflow: hidden;
                }
                
                .republic-seal {
                    font-size: 0.7rem;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.1em;
                    color: #0A2472;
                    background: rgba(10, 36, 114, 0.05);
                    padding: 0.2rem 0.8rem;
                    border-radius: 40px;
                }
                
                .live-badge {
                    background: linear-gradient(145deg, #22C55E, #16A34A);
                    color: white;
                    font-size: 0.65rem;
                    font-weight: 700;
                    padding: 0.2rem 0.6rem;
                    border-radius: 40px;
                    animation: pulse 2s infinite;
                }
                
                .page-title {
                    font-size: 1.8rem;
                    font-weight: 800;
                    background: linear-gradient(145deg, #0A2472, #1E3A8A);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .title-badge {
                    background: linear-gradient(145deg, #C5A059, #F4C430);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    font-size: 0.8rem;
                    padding: 0.2rem 0.8rem;
                    border: 1px solid rgba(197, 160, 89, 0.3);
                    border-radius: 40px;
                }
                
                .btn-prime {
                    background: linear-gradient(145deg, #0A2472, #1E3A8A);
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
                    box-shadow: 0 8px 20px -5px rgba(10, 36, 114, 0.3);
                }
                
                .btn-prime:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 15px 30px -8px rgba(10, 36, 114, 0.4);
                    color: white;
                }
                
                .btn-outline-premium {
                    background: white;
                    border: 1px solid rgba(197, 160, 89, 0.3);
                    color: #0A2472;
                    padding: 0.6rem 1rem;
                    border-radius: 12px;
                }
                
                .graph-card {
                    background: white;
                    border-radius: 24px;
                    padding: 1.2rem;
                    height: 100%;
                    border: 1px solid rgba(197, 160, 89, 0.1);
                    box-shadow: 0 10px 25px -10px rgba(0,0,0,0.02);
                    transition: 0.3s;
                }
                
                .graph-card:hover {
                    border-color: #C5A059;
                    box-shadow: 0 20px 35px -15px rgba(197, 160, 89, 0.15);
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
                    box-shadow: 0 0 15px rgba(244, 196, 48, 0.5);
                }
                
                .donut-chart {
                    position: relative;
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    background: conic-gradient(#0A2472 0% 68%, #C5A059 68% 83%, #1E555C 83% 92%, #6B2D5C 92% 100%);
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
                    color: #0A2472;
                    line-height: 1;
                }
                
                .filter-premium {
                    background: white;
                    border-radius: 20px;
                    padding: 1rem 1.2rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border: 1px solid rgba(197, 160, 89, 0.1);
                }
                
                .filter-scroll {
                    display: flex;
                    gap: 0.5rem;
                    overflow-x: auto;
                    padding-bottom: 0.2rem;
                }
                
                .filter-chip {
                    padding: 0.4rem 1rem;
                    background: #F1F5F9;
                    border-radius: 40px;
                    font-size: 0.8rem;
                    font-weight: 500;
                    color: #334155;
                    white-space: nowrap;
                    transition: 0.2s;
                    cursor: pointer;
                }
                
                .filter-chip.active {
                    background: linear-gradient(145deg, #0A2472, #1E3A8A);
                    color: white;
                }
                
                .filter-chip:hover {
                    background: #C5A059;
                    color: white;
                }
                
                .search-premium {
                    position: relative;
                    min-width: 250px;
                }
                
                .search-premium input {
                    width: 100%;
                    padding: 0.5rem 0.5rem 0.5rem 2.5rem;
                    border: 1px solid #e2e8f0;
                    border-radius: 40px;
                    font-size: 0.85rem;
                }
                

                .search-premium i {
                    position: absolute;
                    left: 1rem;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #94a3b8;
                }
                
                .profile-card-compact {
                    background: #F8FAFC;
                    border-radius: 16px;
                    padding: 0.8rem;
                    transition: all 0.3s;
                    border: 1px solid transparent;
                }
                
                .profile-card-compact:hover {
                    background: white;
                    border-color: #C5A059;
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px -10px rgba(197, 160, 89, 0.2);
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
                    background: #22C55E;
                    border: 2px solid white;
                    border-radius: 50%;
                }
                
                .badge-student {
                    background: #0A2472;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                    font-weight: 600;
                }
                
                .badge-gold {
                    background: linear-gradient(145deg, #C5A059, #F4C430);
                    color: #0A2472;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                    font-weight: 700;
                }
                
                .badge-professor {
                    background: #1E555C;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                }
                
                .badge-director {
                    background: #6B2D5C;
                    color: white;
                    padding: 0.15rem 0.5rem;
                    border-radius: 40px;
                    font-size: 0.6rem;
                }
                
               
                
                .table {
                    margin-bottom: 0;
                }
                
                .table thead th {
                    background: #F8FAFC;
                    color: #475569;
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
                    color: #64748b;
                    transition: 0.2s;
                }
                
                .btn-action:hover {
                    background: #C5A059;
                    color: white;
                }
                
                .alert-premium {
                    background: linear-gradient(145deg, white, #F8FAFC);
                    border-radius: 20px;
                    padding: 1rem 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    border: 1px solid rgba(197, 160, 89, 0.2);
                    margin-top: 1rem;
                }
                
                .btn-glass {
                    background: linear-gradient(145deg, #0A2472, #1E3A8A);
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
                    background: #F1F5F9;
                    border-radius: 10px;
                }
                
                .progress-fill {
                    height: 6px;
                    border-radius: 10px;
                }
            </style>
        </head>
        <body class="h-full bg-gray-50">
            <!-- Header -->
            <header class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-50">
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
<main class="flex-1 p-4 md:p-6 lg:p-8 animate-fade-in mt-[74px] ml-[230px]" style="width: calc(100% - 230px); ">
    <div class="main-school-premium" style="width: 100%; max-width: 100%;">
        <!-- EN-TÊTE MINISTÉRIEL -->
        <div class="header-premium d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="republic-seal">
                        <i class="ri-government-line"></i>
                         MINISTÈRE ÉDUCATION</span>
                    <span class="live-badge">📡 LIVE</span>
                </div>
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
                <button class="btn-prime">
                    <i class="ri-add-line"></i>
                    Nouveau profil
                    <span class="btn-glow"></span>
                </button>
                <button class="btn-outline-premium">
                    <i class="ri-download-2-line"></i>
                </button>
            </div>
        </div>

        <!-- DASHBOARD GRAPHIQUES PREMIUM -->
        <div class="row g-3 mb-4">
            <div class="col-lg-4">
                <div class="graph-card">
                    <div class="graph-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-"></i> Évolution des effectifs</span>
                        <span class="trend-badge">+12.4% <i class="ri-arrow-up-line"></i></span>
                    </div>
                    <div class="graph-container">
                        <div class="chart-bars">
                            <div class="bar" style="height: 40px; background: linear-gradient(to top, #0A2472, #4169E1);"></div>
                            <div class="bar" style="height: 55px; background: linear-gradient(to top, #0A2472, #4169E1);"></div>
                            <div class="bar" style="height: 48px; background: linear-gradient(to top, #0A2472, #4169E1);"></div>
                            <div class="bar" style="height: 62px; background: linear-gradient(to top, #0A2472, #4169E1);"></div>
                            <div class="bar" style="height: 70px; background: linear-gradient(to top, #C5A059, #F4C430);"></div>
                            <div class="bar" style="height: 68px; background: linear-gradient(to top, #C5A059, #F4C430);"></div>
                            <div class="bar" style="height: 75px; background: linear-gradient(to top, #C5A059, #F4C430);"></div>
                            <div class="bar active-bar" style="height: 82px; background: linear-gradient(to top, #C5A059, #FFD700);"></div>
                        </div>
                        <div class="chart-labels d-flex justify-content-between mt-2 px-1">
                            <span style="font-size: 0.7rem; color: #64748B;">S</span>
                            <span style="font-size: 0.7rem; color: #64748B;">O</span>
                            <span style="font-size: 0.7rem; color: #64748B;">N</span>
                            <span style="font-size: 0.7rem; color: #64748B;">D</span>
                            <span style="font-size: 0.7rem; color: #64748B;">J</span>
                            <span style="font-size: 0.7rem; color: #64748B;">F</span>
                            <span style="font-size: 0.7rem; color: #64748B;">M</span>
                            <span style="font-size: 0.7rem; color: #64748B;">A</span>
                        </div>
                    </div>

                    <div class="graph-footer d-flex justify-content-between mt-2">
                        <span style="font-size: 0.75rem; color: #475569;">Projection 2026: <strong>3,100</strong></span>
                        <span class="glass-badge" style="font-size: 0.7rem; background: #F1F5F9; padding: 0.2rem 0.6rem; border-radius: 40px;">Prévision +9%</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="graph-card">
                    <div class="graph-header d-flex justify-content-between align-items-center">
                        <span> Répartition par rôle</span>
                        <span class="glass-badge" style="font-size: 0.7rem; background: #F1F5F9; padding: 0.2rem 0.6rem; border-radius: 40px;">2026</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="donut-chart">
                            <div class="donut-center">
                                <span class="donut-total">2,847</span>
                                <span class="donut-label" style="font-size: 0.6rem; color: #64748B;">total</span>
                            </div>
                        </div>
                        <div class="legend-premium" style="font-size: 0.75rem;">
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #0A2472; border-radius: 4px;"></span> Élèves 68%</div>
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #C5A059; border-radius: 4px;"></span> Enseignants 15%</div>
                            <div class="d-flex align-items-center gap-2 mb-1"><span style="width: 10px; height: 10px; background: #1E555C; border-radius: 4px;"></span> Parents 9%</div>
                            <div class="d-flex align-items-center gap-2"><span style="width: 10px; height: 10px; background: #6B2D5C; border-radius: 4px;"></span> Direction 8%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="graph-card">
                    <div class="graph-header d-flex justify-content-between align-items-center">
                        <span> Taux de réussite</span>
                        <span class="score-badge" style="background: linear-gradient(145deg, #C5A059, #F4C430); color: white; padding: 0.2rem 0.8rem; border-radius: 40px; font-size: 0.8rem; font-weight: 700;">84.5%</span>
                    </div>
                    <div class="progress-stack">
                        <div class="progress-item mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CE2</span>
                                <span class="fw-bold" style="color: #0A2472; font-size: 0.75rem;">78%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 78%; background: linear-gradient(90deg, #0A2472, #4169E1);"></div>
                            </div>
                        </div>
                        <div class="progress-item mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CM1</span>
                                <span class="fw-bold" style="color: #0A2472; font-size: 0.75rem;">82%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 82%; background: linear-gradient(90deg, #0A2472, #4169E1);"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="font-size: 0.75rem;">CM2</span>
                                <span class="fw-bold" style="color: #C5A059; font-size: 0.75rem;">91%</span>
                            </div>
                            <div class="progress-premium">
                                <div class="progress-fill" style="width: 91%; background: linear-gradient(90deg, #C5A059, #F4C430);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="graph-footer mt-3">
                        <span style="font-size: 0.7rem; color: #475569;">📊 +4.2% vs semestre 1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTRES PREMIUM -->
        <div class="filter-premium mb-4">
            <div class="filter-scroll">
                <span class="filter-chip active">Tous (2,847)</span>
                <span class="filter-chip"><i class="bi bi-people"></i> Élèves (1,934)</span>
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
        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="cards-grid-premium">
                    <div class="grid-header d-flex justify-content-between align-items-center mb-3">
                        <h6 style="font-weight: 700; color: #0F172A; margin: 0;"><i class="ri-user-star-line" style="color: #C5A059;"></i> Profils récents</h6>
                        <span class="live-indicator" style="font-size: 0.7rem; color: #16A34A; animation: pulse 2s infinite">
                            <span class="" ></span> 
                            12 actifs maintenant
                        </span>
                    </div>
                    
                    <div class="row g-2">
                        <!-- Carte Élève -->
                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info" style="flex: 1;">
                                    <div class="name" style="font-weight: 700; font-size: 0.85rem;">Kouassi Yao</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-student">CM2</span>
                                        <span class="badge-gold">16.8/20</span>
                                    </div>
                                    <div class="meta-row d-flex justify-content-between align-items-center">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-parent-line"></i> Mme Yao</span>
                                        <span style="font-size: 0.6rem; color: #16A34A; font-weight: 700;">▲12%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Enseignant -->
                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👩</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. Aya N'Guessan</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-professor">Titulaire</span>
                                        <span class="badge" style="background: #F4C430; color: #0A2472; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem; font-weight: 700;">★ 4.8</span>
                                    </div>
                                    <div class="meta-row d-flex gap-2">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-flask-line"></i> Physique</span>
                                        <span style="font-size: 0.65rem; color: #64748B;">15 ans</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Parent -->
                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Konan Jean</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge" style="background: #1E555C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">Parent</span>
                                        <span class="badge-emerald" style="background: #10B981; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">3 enfants</span>
                                    </div>
                                    <div class="meta-row d-flex gap-2">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-heart-line"></i> Très actif</span>
                                        <span style="font-size: 0.65rem; color: #64748B;">APE</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Directeur -->
                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>👨</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Pr. François Kouadio</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge-director">Doyen</span>
                                        <span class="badge" style="background: #6B2D5C; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">24 ans</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;"><i class="ri-building-line"></i> UFR Droit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carte Préfet -->
                        <div class="col-6 col-xl-4">
                            <div class="profile-card-compact d-flex">
                                <div class="avatar-premium">
                                    <span>📋</span>
                                    <span class="status-online"></span>
                                </div>
                                <div class="profile-info">
                                    <div class="name">Michel Yao</div>
                                    <div class="badge-row d-flex gap-1 mb-1">
                                        <span class="badge" style="background: #059669; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">Préfet</span>
                                        <span class="badge" style="background: #047857; color: white; padding: 0.15rem 0.5rem; border-radius: 40px; font-size: 0.6rem;">1,200él</span>
                                    </div>
                                    <div class="meta-row">
                                        <span style="font-size: 0.65rem; color: #64748B;">
                                            <i class="ri-shield-line"></i>
                                             Discipline
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="view-all-link mt-3 text-end">
                        <a href="#" style="color: #0A2472; text-decoration: none; font-size: 0.8rem; font-weight: 600;">Voir tous les 2,847 profils 
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- TABLEAU RÉCAPITULATIF -->
            <div class="col-lg-5 ">
                <div class="table-premium bg-white rounded-4 py-4 h-100 ">
                    <div class="table-header d-flex justify-content-between align-items-center mb-3">
                        <h6 style="font-weight: 700; color: #0F172A; margin: 0;">
                            <i class="ri-table-line" style="color: #C5A059;"></i>
                             Récapitulatif & performances
                            </h6>
                        <span class="export-btn" style="cursor: pointer;"><i class="ri-download-line" style="color: #0A2472;"></i></span>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table p-3 bg-primary">
                            <thead>
                                <tr>
                                    <th>Rôle</th>
                                    <th>Effectif</th>
                                    <th>Moyenne</th>
                                    <th>Activité</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="role-indicator" style="background: #0A2472;"></span> Élèves</td>
                                    <td class="fw-bold">1,934</td>
                                    <td><span class="score" style="color: #0A2472; font-weight: 600;">14.2/20</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 82%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #C5A059;"></span> Enseignants</td>
                                    <td class="fw-bold">189</td>
                                    <td><span class="score" style="color: #0A2472; font-weight: 600;">4.7/5</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 94%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #1E555C;"></span> Parents</td>
                                    <td class="fw-bold">512</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-warning bg-opacity-10 text-warning">● 64%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #6B2D5C;"></span> Direction</td>
                                    <td class="fw-bold">24</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 100%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #8B5CF6;"></span> Inspecteurs</td>
                                    <td class="fw-bold">12</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-info bg-opacity-10 text-info">● 8 en cours</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #059669;"></span> Préfets</td>
                                    <td class="fw-bold">18</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 100%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #8B5CF6;"></span> Tuteurs</td>
                                    <td class="fw-bold">45</td>
                                    <td><span class="score" style="color: #0A2472; font-weight: 600;">82%</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 78%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #4B5563;"></span> Surveillants</td>
                                    <td class="fw-bold">28</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success">● 92%</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                                <tr>
                                    <td><span class="role-indicator" style="background: #7A8B8B;"></span> Bibliothèque</td>
                                    <td class="fw-bold">6</td>
                                    <td><span class="text-muted">-</span></td>
                                    <td><span class="badge bg-secondary bg-opacity-10">● 4 actifs</span></td>
                                    <td><button class="btn-action"><i class="ri-eye-line"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="table-footer d-flex justify-content-between align-items-center mt-3">
                        <span style="font-size: 0.75rem; color: #475569;">Total: <strong>2,847</strong> utilisateurs</span>
                        <span class="premium-badge" style="background: linear-gradient(145deg, #C5A059, #F4C430); color: white; padding: 0.2rem 0.8rem; border-radius: 40px; font-size: 0.65rem; font-weight: 700;">Taux évaluation: 74%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ALERTE SUIVI PREMIUM -->
        <div class="alert-premium">
            <div class="pulse-dot"></div>
            <div class="alert-content">
                <span style="font-size: 0.85rem; color: #0F172A;"><strong>Évaluations en cours</strong> · 156 élèves · 12 inspections · 8 réunions parents</span>
            </div>
            <button class="btn-glass">
                <i class="ri-file-copy-line"></i> Rapport
            </button>
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
                    if (menu) {
                        menu.classList.toggle('hidden');
                    }
                }
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    const menu = document.getElementById('userMenu');
                    const button = event.target.closest('button[onclick="toggleUserMenu()"]');
                    
                    if (!button && menu && !menu.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });
                
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
                
                // Progress bar animation
                document.querySelectorAll('.progress-fill').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 300);
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