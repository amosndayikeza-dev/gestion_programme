<?php
/**
 * Dashboard Inspecteur - Version Standalone
 * Design moderne pour la supervision académique
 */

// Mode démo - utilisateur simulé
$user = [
    'nom' => 'Dr. Alain Bernard',
    'role' => 'inspecteur',
    'email' => 'a.bernard@education.gouv.fr',
    'id_utilisateur' => 3,
    'grade' => 'Inspecteur Pédagogique',
    'specialite' => 'Sciences & Mathématiques',
    'telephone' => '+33 6 23 45 67 89'
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
    public static function getInspecteurContent() {
        return [
            'stats_config' => [
                'visites_planifiees' => [
                    'label' => 'Visites planifiées',
                    'icon' => 'fas fa-calendar-check',
                    'color' => 'blue'
                ],
                'rapports_a_rediger' => [
                    'label' => 'Rapports à rédiger',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'orange'
                ],
                'enseignants_evalues' => [
                    'label' => 'Enseignant évalués',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'color' => 'green'
                ],
                'ecoles_visitees' => [
                    'label' => 'Écoles visitées',
                    'icon' => 'fas fa-school',
                    'color' => 'purple'
                ],
                'recommandations' => [
                    'label' => 'Recommand',
                    'icon' => 'fas fa-lightbulb',
                    'color' => 'yellow'
                ],
                'alertes_qualite' => [
                    'label' => 'Alertes qualité',
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'red'
                ]
            ],
            'visits_data' => [
                [
                    'date' => '2024-01-22',
                    'time' => '09:00 - 12:00',
                    'school' => 'Lycée Descartes',
                    'teacher' => 'Prof. Martin',
                    'subject' => 'Mathématiques',
                    'status' => 'confirmée'
                ],
                [
                    'date' => '2024-01-23',
                    'time' => '14:00 - 17:00',
                    'school' => 'Collège Pasteur',
                    'teacher' => 'Prof. Dubois',
                    'subject' => 'Physique-Chimie',
                    'status' => 'planifiée'
                ],
                [
                    'date' => '2024-01-24',
                    'time' => '10:30 - 13:00',
                    'school' => 'Lycée Voltaire',
                    'teacher' => 'Prof. Laurent',
                    'subject' => 'Sciences',
                    'status' => 'à confirmer'
                ],
                [
                    'date' => '2024-01-25',
                    'time' => '08:30 - 11:30',
                    'school' => 'Collège Curie',
                    'teacher' => 'Prof. Simon',
                    'subject' => 'Mathématiques',
                    'status' => 'planifiée'
                ]
            ],
            'evaluations_data' => [
                [
                    'teacher' => 'Prof. Martin',
                    'school' => 'Lycée Descartes',
                    'date' => '15/01/2024',
                    'score' => 4.2,
                    'trend' => 'up'
                ],
                [
                    'teacher' => 'Prof. Dubois',
                    'school' => 'Collège Pasteur',
                    'date' => '12/01/2024',
                    'score' => 3.8,
                    'trend' => 'stable'
                ],
                [
                    'teacher' => 'Prof. Laurent',
                    'school' => 'Lycée Voltaire',
                    'date' => '10/01/2024',
                    'score' => 4.5,
                    'trend' => 'up'
                ],
                [
                    'teacher' => 'Prof. Simon',
                    'school' => 'Collège Curie',
                    'date' => '08/01/2024',
                    'score' => 3.5,
                    'trend' => 'down'
                ]
            ],
            'reports_data' => [
                [
                    'type' => 'Évaluation pédagogique',
                    'teacher' => 'Prof. Martin',
                    'date' => 'Aujourd\'hui',
                    'status' => 'brouillon'
                ],
                [
                    'type' => 'Rapport d\'établissement',
                    'teacher' => 'Lycée Descartes',
                    'date' => 'Hier',
                    'status' => 'à valider'
                ],
                [
                    'type' => 'Analyse de pratique',
                    'teacher' => 'Prof. Dubois',
                    'date' => '12/01/2024',
                    'status' => 'validé'
                ],
                [
                    'type' => 'Synthèse trimestrielle',
                    'teacher' => 'Secteur Nord',
                    'date' => '05/01/2024',
                    'status' => 'publié'
                ]
            ],
            'quick_actions' => [
                [
                    'title' => 'Planifier visite',
                    'icon' => 'fas fa-calendar-plus',
                    'color' => 'blue',
                    'link' => '#'
                ],
                [
                    'title' => 'Rédiger rapport',
                    'icon' => 'fas fa-edit',
                    'color' => 'green',
                    'link' => '#'
                ],
                [
                    'title' => 'Analyser données',
                    'icon' => 'fas fa-chart-bar',
                    'color' => 'purple',
                    'link' => '#'
                ],
                [
                    'title' => 'Gérer alertes',
                    'icon' => 'fas fa-bell',
                    'color' => 'red',
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
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-search text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">© 2024 Inspection Académique</p>
                            <p class="text-xs text-gray-500">Système d\'Inspection v4.1</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-book mr-1"></i> Référentiel
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-question-circle mr-1"></i> Support
                        </a>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900">
                            <i class="fas fa-shield-alt mr-1"></i> Confidentialité
                        </a>
                    </div>
                </div>
            </div>
        </footer>';
    }
}

/**
 * Dashboard Inspecteur - Version Standalone Améliorée
 */
class InspecteurDashboardStandalone extends Component {
    private $user;
    
    public function __construct(array $options = []) {
        $this->user = AuthMiddleware::getUser();
    }
    
    public function render(): string {
        $content = DashboardContentFactory::getInspecteurContent();
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr" class="h-full">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Espace Inspecteur - Dashboard</title>
            
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
                                'academic': {
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
                                'pulse-subtle': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Serif+Pro:wght@400;600;700&display=swap" rel="stylesheet">
            
            <style>
                * {
                    font-family: 'Inter', sans-serif;
                }
                
                body {
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    min-height: 100vh;
                    font-size: 14px; /* Taille réduite pour compacité */
                    color: #000000;
                }
                
                .heading {
                    font-family: 'Source Serif Pro', serif;
                    font-weight: 600;
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
                    background: linear-gradient(135deg, #1e40af 0%, #0ea5e9 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                
                .sidebar {
                    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
                    color: #000000;
                }
                
                .sidebar .text-white {
                    color: #000000 !important;
                }
                
                .sidebar .bg-white/5 {
                    background: rgba(0, 0, 0, 0.05);
                }
                
                .sidebar .bg-white/10 {
                    background: rgba(0, 0, 0, 0.1);
                }
                
                .sidebar .bg-white/20 {
                    background: rgba(0, 0, 0, 0.2);
                }
                
                .sidebar .border-white/10 {
                    border-color: rgba(0, 0, 0, 0.1);
                }
                
                .sidebar .text-white/80 {
                    color: rgba(0, 0, 0, 0.8) !important;
                }
                
                .sidebar .text-white/60 {
                    color: rgba(0, 0, 0, 0.6) !important;
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
                
                .score-card {
                    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
                }
                
                .score-badge {
                    font-variant-numeric: tabular-nums;
                }
                
                .visit-today {
                    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
                    border-left: 4px solid #3b82f6;
                }
            </style>
        </head>
        <body class="h-full">
            <!-- Header -->
            <header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-3">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 heading">Espace Inspecteur</h1>
                                <div class="flex items-center mt-1">
                                    <span class="text-sm font-medium text-gray-700 mr-2"><?php echo htmlspecialchars($this->user['grade']); ?></span>
                                    <span class="mx-2 text-gray-300">•</span>
                                    <span class="text-sm text-gray-600"><?php echo htmlspecialchars($this->user['specialite']); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Document Search -->
                            <div class="relative hidden md:block">
                                <input type="text" 
                                       placeholder="Rechercher rapports..." 
                                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-3 h-3 bg-orange-500 rounded-full"></span>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                        <?php echo substr($this->user['nom'], 0, 1); ?>
                                    </div>
                                    <div class="text-left hidden lg:block">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500">Inspection Académique</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900 heading"><?php echo htmlspecialchars($this->user['nom']); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo htmlspecialchars($this->user['email']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">N° d'agrément: INSP-<?php echo str_pad($this->user['id_utilisateur'], 4, '0', STR_PAD_LEFT); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-tie mr-3 text-blue-600"></i>
                                        Mon Profil Professionnel
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-graduation-cap mr-3 text-green-600"></i>
                                        Spécialités & Compétences
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-calendar-alt mr-3 text-purple-600"></i>
                                        Agenda d'inspection
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-blue-600 hover:bg-blue-50 font-medium">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Déconnexion
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex min-h-screen">
                <!-- Sidebar -->
                <aside class="sidebar w-64 text-black hidden md:block fixed top-[73px] left-0 h-[calc(100vh-73px)] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex items-center mb-8">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-400 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold heading">Inspection</h2>
                        </div>
                        
                        <nav class="space-y-2">
                            <?php foreach([
                                ['icon' => 'fas fa-tachometer-alt', 'label' => 'Tableau de bord', 'active' => true, 'badge' => ''],
                                ['icon' => 'fas fa-calendar-check', 'label' => 'Visites', 'badge' => '4'],
                                ['icon' => 'fas fa-file-alt', 'label' => 'Rapports', 'badge' => '12'],
                                ['icon' => 'fas fa-chalkboard-teacher', 'label' => 'Évaluations', 'badge' => '8'],
                                ['icon' => 'fas fa-school', 'label' => 'Établissements', 'badge' => ''],
                                ['icon' => 'fas fa-chart-bar', 'label' => 'Analyses', 'badge' => ''],
                                ['icon' => 'fas fa-lightbulb', 'label' => 'Recommandations', 'badge' => '5'],
                                ['icon' => 'fas fa-users', 'label' => 'Formations', 'badge' => '3'],
                                ['icon' => 'fas fa-cog', 'label' => 'Paramètres', 'badge' => '']
                            ] as $item): ?>
                            <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition-colors <?php echo ($item['active'] ?? false) ? 'bg-white/10 shadow-inner' : ''; ?>">
                                <i class="<?php echo $item['icon']; ?> w-5 mr-3"></i>
                                <span class="flex-1"><?php echo $item['label']; ?></span>
                                <?php if(!empty($item['badge'])): ?>
                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-bold"><?php echo $item['badge']; ?></span>
                                <?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </nav>
                        
                        <!-- Sidebar Progress -->
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <div class="px-4 py-3 bg-white/5 rounded-lg">
                                <p class="text-sm font-medium text-black/80 mb-2">Objectif trimestriel</p>
                                <div class="w-full bg-white/20 rounded-full h-2 mb-2">
                                    <div class="bg-green-400 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                                <p class="text-xs text-black/60">13/20 visites réalisées</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Mobile Sidebar Toggle -->
                <button id="mobileMenuToggle" class="md:hidden fixed bottom-6 right-6 z-40 w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Main Content -->
                <main class="flex-1 ml-64 p-4 md:p-6 lg:p-8 animate-fade-in overflow-y-auto" style="margin-top: 73px;">
                    <!-- Welcome Header -->
                    <div class="mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 heading mb-2">
                                    Supervision <span class="gradient-text">Pédagogique</span>
                                </h1>
                                <p class="text-gray-600">
                                    <i class="fas fa-calendar-day text-blue-600 mr-2"></i>
                                    <?php
                                    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                    $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                                    echo $jours[date('w')] . ' ' . date('d') . ' ' . $mois[date('n')-1] . ' ' . date('Y');
                                    ?>
                                    &nbsp;&nbsp;•&nbsp;&nbsp;
                                    <i class="fas fa-chart-line text-green-600 mr-1"></i>
                                    Trimestre 2 - Suivi qualité
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium flex items-center">
                                    <i class="fas fa-tag mr-2"></i>
                                    <span><?php echo htmlspecialchars($this->user['specialite']); ?></span>
                                </span>
                                <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center font-medium">
                                    <i class="fas fa-download mr-2"></i>
                                    Exporter données
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                        <?php 
                        $statsValues = [
                            'visites_planifiees' => '4',
                            'rapports_a_rediger' => '3',
                            'enseignants_evalues' => '8',
                            'ecoles_visitees' => '12',
                            'recommandations' => '5',
                            'alertes_qualite' => '2'
                        ];
                        
                        if (isset($content['stats_config'])) {
                            foreach($content['stats_config'] as $key => $stat): 
                                $value = $statsValues[$key] ?? '0';
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
                            <?php if(in_array($key, ['enseignants_evalues', 'ecoles_visitees'])): ?>
                            <div class="mt-4 pt-3 border-t border-<?php echo $stat['color']; ?>-100">
                                <p class="text-xs font-medium text-<?php echo $stat['color']; ?>-700 flex items-center">
                                    <i class="fas fa-arrow-<?php echo rand(0,1) ? 'up' : 'down'; ?> mr-1"></i>
                                    <?php echo rand(1, 15); ?>% vs dernier trimestre
                                </p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php 
                            endforeach;
                        } else {
                            echo '<div class="col-span-6 p-4 text-center text-gray-500">Indicateurs non disponibles</div>';
                        }
                        ?>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Visites à venir -->
                        <div class="lg:col-span-2">
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 heading">
                                            <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                                            Agenda des visites
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">Prochaines interventions pédagogiques</p>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                        Voir agenda complet
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-3">
                                    <?php 
                                    if (isset($content['visits_data']) && is_array($content['visits_data'])) {
                                        foreach($content['visits_data'] as $index => $visit): 
                                            $isToday = ($visit['date'] === date('Y-m-d'));
                                    ?>
                                    <div class="flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition-all animate-slide-in-right <?php echo $isToday ? 'visit-today' : 'bg-white'; ?>" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-lg flex flex-col items-center justify-center mr-4 <?php echo $isToday ? 'bg-blue-100' : 'bg-gray-100'; ?>">
                                                <span class="text-lg font-bold text-gray-900"><?php echo date('d', strtotime($visit['date'])); ?></span>
                                                <span class="text-xs text-gray-600"><?php echo date('M', strtotime($visit['date'])); ?></span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($visit['teacher']); ?></h4>
                                                <div class="flex items-center text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center mr-4">
                                                        <i class="fas fa-school mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($visit['school']); ?>
                                                    </span>
                                                    <span class="flex items-center">
                                                        <i class="fas fa-book mr-1.5 text-gray-400"></i>
                                                        <?php echo htmlspecialchars($visit['subject']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-sm font-medium text-gray-900"><?php echo $visit['time']; ?></span>
                                            <span class="mt-1 px-3 py-1 bg-<?php echo match($visit['status']) {
                                                'confirmée' => 'green',
                                                'planifiée' => 'blue',
                                                default => 'yellow'
                                            }; ?>-100 text-<?php echo match($visit['status']) {
                                                'confirmée' => 'green',
                                                'planifiée' => 'blue',
                                                default => 'yellow'
                                            }; ?>-800 text-xs font-medium rounded-full">
                                                <?php echo $visit['status']; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune visite planifiée</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Évaluations récentes -->
                        <div>
                            <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 heading">
                                        <i class="fas fa-star text-yellow-600 mr-2"></i>
                                        Notes d'évaluation
                                    </h3>
                                    <a href="#" class="text-sm font-medium text-yellow-600 hover:text-yellow-800 flex items-center">
                                        Statistiques
                                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <?php 
                                    if (isset($content['evaluations_data']) && is_array($content['evaluations_data'])) {
                                        foreach($content['evaluations_data'] as $index => $eval): 
                                            $score = $eval['score'];
                                            $scoreColor = $score >= 4 ? 'green' : ($score >= 3.5 ? 'yellow' : 'red');
                                    ?>
                                    <div class="score-card rounded-lg p-4 border border-gray-200 animate-slide-in-right" style="animation-delay: <?php echo ($index + 0.5) * 0.1; ?>s">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($eval['teacher']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($eval['school']); ?></p>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="score-badge text-lg font-bold text-<?php echo $scoreColor; ?>-700 mr-2"><?php echo number_format($score, 1); ?>/5</span>
                                                <i class="fas fa-arrow-<?php echo $eval['trend']; ?> text-<?php echo $eval['trend'] === 'up' ? 'green' : ($eval['trend'] === 'down' ? 'red' : 'gray'); ?>-500"></i>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span><?php echo $eval['date']; ?></span>
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-chart-line" title="Suivi"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-800">
                                                    <i class="fas fa-file-alt" title="Rapport"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        endforeach;
                                    } else {
                                        echo '<div class="text-center py-8 text-gray-500">Aucune évaluation disponible</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Rapports en cours -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-clipboard-list text-green-600 mr-2"></i>
                                    Rapports en cours
                                </h3>
                                <a href="#" class="text-sm font-medium text-green-600 hover:text-green-800 flex items-center">
                                    Archives
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                            <div class="space-y-4">
                                <?php 
                                if (isset($content['reports_data']) && is_array($content['reports_data'])) {
                                    foreach($content['reports_data'] as $report): 
                                        $statusColor = match($report['status']) {
                                            'brouillon' => 'yellow',
                                            'à valider' => 'orange',
                                            'validé' => 'green',
                                            'publié' => 'blue',
                                            default => 'gray'
                                        };
                                ?>
                                <div class="flex items-start p-4 rounded-lg border-l-4 border-<?php echo $statusColor; ?>-500 bg-gradient-to-r from-gray-50 to-white hover:border-<?php echo $statusColor; ?>-600 transition-colors">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-<?php echo $statusColor; ?>-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-<?php echo match($report['type']) { 
                                                'Évaluation pédagogique' => 'chalkboard-teacher', 
                                                'Rapport d\'établissement' => 'school',
                                                'Analyse de pratique' => 'chart-line',
                                                default => 'file-alt' 
                                            }; ?> text-<?php echo $statusColor; ?>-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="font-semibold text-gray-900"><?php echo htmlspecialchars($report['type']); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo htmlspecialchars($report['teacher']); ?></p>
                                            </div>
                                            <div class="flex flex-col items-end">
                                                <span class="px-2 py-1 bg-<?php echo $statusColor; ?>-100 text-<?php echo $statusColor; ?>-800 text-xs font-medium rounded-full mb-1">
                                                    <?php echo $report['status']; ?>
                                                </span>
                                                <p class="text-xs text-gray-400"><?php echo $report['date']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    endforeach;
                                } else {
                                    echo '<div class="text-center py-8 text-gray-500">Aucun rapport en cours</div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Actions rapides -->
                        <div class="glass-card rounded-xl shadow-md p-6 hover-lift">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 heading">
                                    <i class="fas fa-tasks text-purple-600 mr-2"></i>
                                    Actions pédagogiques
                                </h3>
                                <span class="text-xs text-gray-500">Outils d'inspection</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <?php 
                                if (isset($content['quick_actions']) && is_array($content['quick_actions'])) {
                                    foreach($content['quick_actions'] as $action): 
                                ?>
                                <a href="<?php echo $action['link'] ?? '#'; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color'] ?? 'blue'; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color'] ?? 'blue'; ?>-500 to-<?php echo $action['color'] ?? 'blue'; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
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
                                        ['title' => 'Planifier visite', 'icon' => 'fas fa-calendar-plus', 'color' => 'blue', 'link' => '#'],
                                        ['title' => 'Rédiger rapport', 'icon' => 'fas fa-edit', 'color' => 'green', 'link' => '#'],
                                        ['title' => 'Analyser données', 'icon' => 'fas fa-chart-bar', 'color' => 'purple', 'link' => '#'],
                                        ['title' => 'Gérer alertes', 'icon' => 'fas fa-bell', 'color' => 'orange', 'link' => '#'],
                                    ];
                                    
                                    foreach($defaultActions as $action):
                                ?>
                                <a href="<?php echo $action['link']; ?>" 
                                   class="group flex flex-col items-center justify-center p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border-2 border-gray-200 hover:border-<?php echo $action['color']; ?>-400 hover:shadow-lg transition-all duration-300">
                                    <div class="w-14 h-14 bg-gradient-to-br from-<?php echo $action['color']; ?>-500 to-<?php echo $action['color']; ?>-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform shadow-md">
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
                            
                            <!-- Grille d'évaluation -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-clipboard-check text-white"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">Grille d'évaluation</p>
                                            <p class="text-xs text-gray-600">Critères pédagogiques 2024</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 mt-3">
                                        <button class="px-3 py-2 bg-white text-blue-700 text-xs rounded border border-blue-300 hover:bg-blue-50 transition-colors">
                                            <i class="fas fa-download mr-1"></i>Télécharger
                                        </button>
                                        <button class="px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs rounded hover:opacity-90 transition-opacity">
                                            <i class="fas fa-print mr-1"></i>Imprimer
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
                
                // Search functionality
                const searchInput = document.querySelector('input[placeholder*="Rechercher"]');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            const query = this.value.trim();
                            if (query) {
                                alert(`Recherche de rapports pour: ${query}\n\nCette fonctionnalité serait connectée à la base de données.`);
                            }
                        }
                    });
                }
                
                // Auto-update today's visits
                function highlightTodayVisits() {
                    const today = new Date();
                    const todayStr = today.toISOString().split('T')[0];
                    
                    document.querySelectorAll('.visit-today').forEach(el => {
                        el.classList.remove('visit-today');
                    });
                    
                    document.querySelectorAll('.bg-white').forEach(el => {
                        const dateElement = el.querySelector('span.text-lg');
                                        if (dateElement) {
                                            const day = parseInt(dateElement.textContent);
                                            const month = today.getMonth() + 1;
                                            const monthStr = month < 10 ? '0' + month : month;
                                            const dayStr = day < 10 ? '0' + day : day;
                                            const elementDate = `${today.getFullYear()}-${monthStr}-${dayStr}`;
                                            
                                            if (elementDate === todayStr) {
                                                el.classList.add('visit-today');
                                                el.classList.remove('bg-white');
                                            }
                                        }
                                    });
                                }
                
                // Update evaluation trends
                function updateEvaluationTrends() {
                    document.querySelectorAll('[class*="score-card"]').forEach(card => {
                        const arrow = card.querySelector('.fa-arrow-up, .fa-arrow-down, .fa-arrow-right');
                        if (arrow && Math.random() > 0.7) {
                            const newTrend = Math.random() > 0.5 ? 'up' : (Math.random() > 0.5 ? 'down' : 'stable');
                            arrow.className = arrow.className.replace(/arrow-(up|down|right)/, `arrow-${newTrend}`);
                            arrow.classList.remove('text-green-500', 'text-red-500', 'text-gray-500');
                            arrow.classList.add(`text-${newTrend === 'up' ? 'green' : (newTrend === 'down' ? 'red' : 'gray')}-500`);
                        }
                    });
                }
                
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
                    }
                    
                    // Update today's visits
                    highlightTodayVisits();
                }
                
                // Update every minute
                setInterval(updateTime, 60000);
                
                // Update trends every 30 seconds
                setInterval(updateEvaluationTrends, 30000);
                
                // Initial updates
                updateTime();
                highlightTodayVisits();
                
                // Export data button
                const exportBtn = document.querySelector('[class*="Exporter données"]');
                if (exportBtn) {
                    exportBtn.addEventListener('click', () => {
                        alert('📊 Génération du rapport d\'inspection...\n\nLe rapport sera téléchargé au format PDF.');
                        // Simulate download
                        setTimeout(() => {
                            alert('✅ Rapport généré avec succès!\n\nTéléchargement démarré.');
                        }, 1500);
                    });
                }
                
                // Tooltips for evaluation scores
                document.querySelectorAll('.score-badge').forEach(badge => {
                    badge.addEventListener('mouseenter', function() {
                        const score = parseFloat(this.textContent);
                        let message = '';
                        if (score >= 4.5) message = 'Excellente pratique';
                        else if (score >= 4) message = 'Bonne pratique';
                        else if (score >= 3.5) message = 'Pratique satisfaisante';
                        else if (score >= 3) message = 'Pratique à améliorer';
                        else message = 'Pratique insuffisante';
                        
                        this.setAttribute('title', `${message} - ${score}/5`);
                    });
                });
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Rendu du dashboard
$dashboard = new InspecteurDashboardStandalone();
echo $dashboard->render();
?>