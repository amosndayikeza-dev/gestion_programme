
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


/**  ================================
=====================================
                MAIN
==================================
====================================
 */


    <style>

        @keyframes fadeIn {
            to { opacity: 1; }
        }
        
        /* ===== CARTES STATISTIQUES ===== */
        .stat-card {
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            box-shadow: 0 15px 30px rgba(0,0,0,0.04), 0 5px 12px rgba(0,0,0,0.02);
            transform: translateY(-2px);
        }
        
        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0a1e2f;
            line-height: 1.2;
            margin-bottom: 6px;
        }
        
        .stat-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #5e6f8c;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .stat-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 50px;
            background: #f1f5f9;
            color: #2c3e5c;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        /* ===== BARRE D'OUTILS ===== */

        
        .search-input-group {
            display: flex;
            align-items: center;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 8px 18px;
            transition: all 0.2s;
        }
        
        .search-input-group:focus-within {
            border-color: #3b7c9c;
            box-shadow: 0 0 0 3px rgba(59,124,156,0.08);
        }
        
        .search-input-group i {
            color: #94a3b8;
            margin-right: 10px;
        }
        
        .search-input-group input {
            border: none;
            background: transparent;
            width: 100%;
            padding: 6px 0;
            outline: none;
            font-size: 0.95rem;
        }
        
        .filter-select {
            border-radius: 50px;
            padding: 10px 32px 10px 18px;
            font-size: 0.9rem;
            color: #1e293b;
            background-color: white;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2347566b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 12px;
        }
        .filter-select:focus{
            border:none;
        }
        
        .btn-action {
            border-radius: 50px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #1e293b;
            transition: all 0.15s;
        }
        
        .btn-action:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        
        .btn-primary-custom {
            background: #1e4a6b;
            border-color: #1e4a6b;
            color: white;
        }
        
        .btn-primary-custom:hover {
            background: #0f3b55;
            border-color: #0f3b55;
            color: white;
        }
        
        /* ===== TABLEAU BOOTSTRAP PERSONNALISÉ ===== */

        
  
        
        .table-custom td {
            vertical-align: middle;
            color: #1e2a3a;
            font-weight: 450;
            border-bottom: 1px solid #edf1f6;
            background: white;
        }
        
        .table-custom tbody tr:hover td {
            background-color: #fafdff;
        }
        
        .student-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 1px solid rgba(30,74,107,0.1);
        }

        .student-image img{
            width: 100%;
            height:100%;
            object-fit:cover;
            border-radius:50%;
        }
       
        .student-name {
            font-weight: 650;
            color: #0a1e2f;
            margin-bottom: 4px;
        }
        
        .student-email {
            font-size: 0.75rem;
            color: #6f7f94;
        }
        
        .badge-custom {
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: inline-block;
            background: #eef2f6;
            color: #2d4356;
            border: 1px solid #dce3eb;
        }
        
        .badge-active {
            background: #e2f3e9;
            color: #16634a;
            border-color: #c0e0d2;
        }
        
        .badge-pending {
            background: #fff5e6;
            color: #9e6300;
            border-color: #ffe3b7;
        }
        
        .badge-inactive {
            background: #f0f2f5;
            color: #535e6b;
            border-color: #dee3e9;
        }
        
        .progress-thin {
            width: 110px;
            height: 6px;
            background: #e6edf2;
            border-radius: 50px;
            overflow: hidden;
        }
        
        .progress-bar-custom {
            height: 6px;
            background: linear-gradient(90deg, #2e6b8c, #1f4f6f);
            border-radius: 50px;
        }
        
        .action-icons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7f94;
            background: transparent;
            border: 1px solid transparent;
            transition: all 0.15s;
        }
        
        .action-btn:hover {
            background: #f1f7fc;
            border-color: #dce5ec;
            color: #1e4a6b;
        }
        
        /* ===== PAGINATION ===== */

        .pagination-custom {
            display: flex;
            justify-content:end;
            gap: 8px;
        }
        
        .page-link-custom {
            padding: 10px 18px;
            border-radius: 12px;
            background: white;
            border: 1px solid #e2e8f0;
            color: #2e4258;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.15s;
            text-decoration: none;
        }
        
        .page-link-custom:hover {
            background: #f1f7fc;
            border-color: #cbd5e1;
        }
        
        .page-link-custom.active {
            background: #1e4a6b;
            border-color: #1e4a6b;
            color: white;
        }
        
        /* ===== SECTION SUIVI ===== */
        
        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0a1e2f;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        canvas {
            max-height: 200px;
            width: 100% !important;
        }
        
        /* ===== UTILITAIRES ===== */
        .text-primary-dark {
            color: #1e4a6b;
        }
        
        .bg-soft-blue {
            background: linear-gradient(145deg, #ecf6ff, #e2eff9);
        }
    </style>



        
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
                  
                
                    <div class="container-fluid p-2 ps-4">
                        <!-- HEADER AVEC BOOTSTRAP -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h1 class="display-6 fw-bold text-success" style="color: #0a1e2f; ">
                                    <i class="fas fa-user-graduate me-3" style="color: #1e4a6b;"></i>
                                    Gestion des étudiants
                                </h1>
                                <p class="text-secondary-emphasis ms-1">
                                    <i class="fas fa-database me-2" style="color: #5e7b96;"></i>
                                    543 inscrits · Mise à jour 10:24
                                </p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-white text-dark p-3 border rounded-4 shadow-sm">
                                    <i class="fas fa-calendar-alt me-2 text-primary" style="color: #1e4a6b;"></i>
                                    2025-2026
                                </span>
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-4 border px-4 py-2 fw-semibold dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>Admin
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ROW STATISTIQUES - BOOTSTRAP GRID -->
                        <div class="row d-flex align-items-center py-2 mb-4 ">
                            <div class="col-xl-3 col-md-6  ">
                                <div class="stat-card bg-white py-4 shadow rounded-4 h-100 d-flex gap-2 align-items-center px-2">
                                    <div class="stat-icon bg-soft-blue">
                                        <i class="fas fa-users" style="color: #1e4a6b;"></i>
                                    </div>

                                    <div class="col">
                                        <div class="d-flex g-1  align-items-center">
                                            <div class="stat-number"> 543</div>
                                            <div class="stat-label">Étudiants actifs</div>
                                        </div>
                                        <div class="d-flex gap-3 align-items-center"> 
                                            <span class="stat-badge">
                                                <i class="fas fa-arrow-up text-success me-1"></i> +8,2%
                                            </span>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 ">
                                <div class="stat-card bg-white py-4 shadow rounded-4 h-100 d-flex gap-2 align-items-center px-2">
                                    <div class="stat-icon bg-soft-blue">
                                        <i class="fas fa-file-signature" style="color: #1f7a5c;"></i>
                                    </div>

                                    <div class="col">
                                        <div class="d-flex g-1  align-items-center">
                                            <div class="stat-number">324</div>
                                            <div class="stat-label">Nouveaux 2025</div>
                                        </div>
                                        <div class="d-flex gap-3 align-items-center"> 
                                            <span class="stat-badge">
                                                <i class="fas fa-arrow-up text-success me-1"></i> +12,2%
                                            </span>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 ">
                                <div class="stat-card bg-white py-4 shadow rounded-4 h-100 d-flex gap-2 align-items-center px-2">
                                    <div class="stat-icon bg-soft-blue">
                                        <i class="fas fa-clock" style="color: #b45f4b;"></i>
                                    </div>

                                    <div class="col">
                                        <div class="d-flex g-1  align-items-center">
                                            <div class="stat-number">47</div>
                                            <div class="stat-label">Dossiers incomplets</div>
                                        </div>
                                        <div class="d-flex gap-3 align-items-center"> 
                                            <span class="stat-badge">
                                                <i class="fas fa-flag me-1" style="color: #b45f4b;"></i> Action requise
                                            </span>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 ">
                                <div class="stat-card bg-white py-4 shadow rounded-4 h-100 d-flex gap-2 align-items-center px-2">
                                    <div class="stat-icon bg-soft-blue">
                                        <i class="fas fa-clock" style="color: #b45f4b;"></i>
                                    </div>

                                    <div class="col">
                                        <div class="d-flex g-1  align-items-center">
                                            <div class="stat-number">87%</div>
                                            <div class="stat-label">Taux de présence</div>
                                        </div>
                                        <div class="d-flex gap-3 align-items-center"> 
                                            <span class="stat-badge">
                                                <i class="fas fa-minus me-1 text-secondary"></i> -2 pts
                                            </span>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            
                        </div>
                        
                        <!-- BARRE D'OUTILS - BOOTSTRAP ROW -->
                        <div class="toolbar-card bg-white py-3 px-2 shadow mb-2 rounded-4">
                            <div class="row  align-items-center">
                                <div class="col-lg-5 col-md-6">
                                    <div class="search-input-group">
                                        <i class="fas fa-search"></i>
                                        <input type="text" placeholder="Rechercher par nom, matricule ou email...">
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-6">
                                    <div class="d-flex flex-wrap gap-3 justify-content-md-end ">
                                        <select class="filter-select">
                                            <option>Tous programmes</option>
                                            <option>Informatique</option>
                                            <option>Gestion</option>
                                            <option>Droit</option>
                                            <option>Médecine</option>
                                            <option>Sciences</option>
                                        </select>

                                        <select class="filter-select">
                                            <option>Tous statuts</option>
                                            <option>Actif</option>
                                            <option>En attente</option>
                                            <option>Inactif</option>
                                        </select>

                                        <button class="btn-action">
                                            <i class="fas fa-sliders-h me-2"></i>Filtres
                                        </button>
                                        <button class="btn-action btn-primary-custom">
                                            <i class="fas fa-plus me-2"></i>Nouvel étudiant
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- TABLEAU DE GESTION - BOOTSTRAP -->
                        <div class="rounded-4 p-0 shadow pt-2 ">
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Étudiant</th>
                                            <th>Matricule</th>
                                            <th>Faculité</th>
                                            <th>Année</th>
                                            <th>Progression</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="student-image ">
                                                        <img src="obede.jpg" alt="student" >
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-3">

                                                    <div>
                                                        <div class="student-name">Emma Chen</div>
                                                        <div class="student-email">emma.chen@universite.fr</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="fw-semibold">IA-2025-042</span></td>
                                            <td>INFORMATIQUE</td>
                                            <td>BAC1</td>
                                            <td>
                                                <div class="progress-thin">
                                                    <div class="progress-bar-custom" style="width: 78%;"></div>
                                                </div>
                                                <span class="text-secondary" style="font-size: 0.7rem;">78%</span>
                                            </td>
                                            <td><span class="badge-custom badge-active">Actif</span></td>
                                            <td>
                                                <div class="action-icons">
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </a>
                                                    <a href="#" class="action-btn">
                                                        <i class="fa-regular fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        
                                    
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- PAGINATION BOOTSTRAP -->

                            <div class="px-4 py-3 border-top">
                                <div class="pagination-custom">
                                    <a href="#" class="page-link-custom">Précédent</a>
                                    <a href="#" class="page-link-custom active">1</a>
                                    <a href="#" class="page-link-custom">2</a>
                                    <a href="#" class="page-link-custom">3</a>
                                    <a href="#" class="page-link-custom">4</a>
                                    <a href="#" class="page-link-custom">5</a>
                                    <a href="#" class="page-link-custom">Suivant</a>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- SECTION SUIVI - BOOTSTRAP ROW -->
                        <div class="row g-4 mt-2">
                            <div class="col-lg-6 ">
                                <div class="chart-card rounded-4 p-3 shadow h-100 bg-warning">
                                    <div class="chart-title ">
                                        <i class="fas fa-chart-pie" style="color: #1e4a6b;"></i>
                                        Répartition par programme
                                    </div>
                                    
                                    <canvas id="programChart" class="w-100 "></canvas>
                                    <div class="row mt-4 g-2">
                                        <div class="col-6 d-flex gap-1 flex-column">
                                            <div class="d-flex align-items-center gap-2  justify-content-start">
                                                <span style="width: 12px; height: 12px; background: #1e4a6b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Informatique</span>
                                                <span class="">850</span>
                                            </div>

                                            <div class="d-flex align-items-center gap-2  justify-content-start">
                                                <span style="width: 12px; height: 12px; background: #1f7a5c; border-radius: 4px;"></span>
                                                <span class="text-secondary">Gestion</span>
                                                <span class="">620</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #9e6300; border-radius: 4px;"></span>
                                                <span class="text-secondary">Droit</span>
                                                <span class="">430</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2">
                                                <span style="width: 12px; height: 12px; background: #b45f4b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Médecine</span>
                                                <span class="">380</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #4a637b; border-radius: 4px;"></span>
                                                <span class="text-secondary">Sciences</span>
                                                <span class="">263</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <span style="width: 12px; height: 12px; background: #8a7f8c; border-radius: 4px;"></span>
                                                <span class="text-secondary">Total</span>
                                                <span class="">2 543</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="chart-card bg-info h-100 p-3 rounded-4">
                                    <div class="chart-title">
                                        <i class="fas fa-chart-line" style="color: #1e4a6b;"></i>
                                        Évolution des inscriptions
                                    </div>

                                    <canvas id="evolutionChart"></canvas>
                                    
                                    <div class="d-flex justify-content-between mt-4 px-2">
                                        <div class="text-center">
                                            <span class="text-secondary small">Sept</span>
                                            <div class="fw-bold">1 240</div>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-secondary small">Jan</span>
                                            <div class="fw-bold">2 100</div>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-secondary small">Juin</span>
                                            <div class="fw-bold">2 543</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- ACTIONS RAPIDES -->
                        <div class="d-flex gap-3 mt-4 pt-2 pb-4">
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2">
                                <i class="fas fa-download me-2"></i>Exporter .CSV
                            </button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2">
                                <i class="fas fa-print me-2"></i>Imprimer
                            </button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2">
                                <i class="fas fa-bell me-2"></i>Alertes absences
                            </button>
                            <button class="btn btn-outline-secondary rounded-5 px-4 py-2">
                                <i class="fas fa-file-pdf me-2"></i>Rapport
                            </button>
                        </div>
                    </div>
    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Graphique répartition
                            new Chart(document.getElementById('programChart'), {
                                type: 'pie',
                                data: {
                                    labels: ['Informatique', 'Gestion', 'Droit', 'Médecine', 'Sciences'],
                                    datasets: [{
                                        data: [850, 620, 430, 380, 263],
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
                            
                            // Graphique évolution
                            
                            new Chart(document.getElementById('evolutionChart'), {
                                type: 'line',
                                data: {
                                    labels: ['Sept', 'Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin'],
                                    datasets: [{
                                        label: 'Inscriptions',
                                        data: [1240, 1480, 1720, 1930, 2100, 2250, 2380, 2450, 2510, 2543],
                                        borderColor: '#1e4a6b',
                                        backgroundColor: 'rgba(30,74,107,0.02)',
                                        borderWidth: 2.5,
                                        pointBackgroundColor: '#1e4a6b',
                                        pointBorderColor: 'white',
                                        pointBorderWidth: 2,
                                        pointRadius: 3,
                                        pointHoverRadius: 5,
                                        tension: 0.2,
                                        
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        y: { 
                                            beginAtZero: false,
                                            grid: { color: 'rgba(0,0,0,0.02)' }
                                        },
                                        x: { grid: { display: false } }
                                    }
                                }
                            });
                        });
                    </script>
                    
   
                     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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