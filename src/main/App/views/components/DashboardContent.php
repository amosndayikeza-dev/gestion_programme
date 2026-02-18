<?php
require_once __DIR__ . '/Component.php';

/**
 * Classe pour générer le contenu des dashboards
 * Séparation du contenu pour une meilleure organisation
 */
class DashboardContent {
    
    /**
     * Génère les cartes de statistiques pour un dashboard
     */
    public static function renderStatsCards(array $stats, array $config): string {
        $cards = '';
        
        foreach ($config as $key => $item) {
            $value = $stats[$key] ?? 0;
            
            // Formatage spécial pour certaines valeurs
            if ($key === 'moyenne_generale') {
                $value = number_format($value, 2) . '/20';
            } elseif ($key === 'fonds_collectes') {
                $value = number_format($value, 0, '.', ' ') . ' FC';
            }
            
            $card = new StatsCard(
                $item['label'],
                $value,
                [
                    'icon' => $item['icon'],
                    'color' => $item['color'],
                    'change' => $item['change'] ?? null,
                    'changeType' => $item['changeType'] ?? 'positive'
                ]
            );
            
            $cards .= '<div class="animate-slide-in">' . $card->render() . '</div>';
        }
        
        return $cards;
    }
    
    /**
     * Génère une liste d'éléments avec actions
     */
    public static function renderListCard(string $title, array $items, array $options = []): string {
        $card = new ListCard($title, [
            'headerActions' => $options['headerActions'] ?? [],
            'emptyMessage' => $options['emptyMessage'] ?? 'Aucun élément à afficher'
        ]);
        
        foreach ($items as $item) {
            $card->addItem(
                $item['title'],
                $item['description'] ?? '',
                $item['url'] ?? '#',
                $item['actions'] ?? [],
                $item['class'] ?? []
            );
        }
        
        return $card->render();
    }
    
    /**
     * Génère une carte avec du contenu HTML personnalisé
     */
    public static function renderCustomCard(string $title, string $content, array $options = []): string {
        $card = new Card($title, $options);
        $card->addChild($content);
        return $card->render();
    }
    
    /**
     * Génère les alertes urgentes
     */
    public static function renderUrgentAlerts(array $alerts): string {
        if (empty($alerts)) {
            return '';
        }
        
        $html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">';
        
        foreach ($alerts as $alert) {
            $html .= '
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 animate-slide-in">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-1"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-800">' . htmlspecialchars($alert['title']) . '</h4>
                        <p class="text-red-700 text-sm mt-1">' . htmlspecialchars($alert['description']) . '</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs text-red-600">' . $alert['date'] . '</span>
                            <button onclick="window.location.href=\'' . $alert['action_url'] . '\'" 
                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors">
                                ' . htmlspecialchars($alert['action_text']) . '
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    /**
     * Génère un graphique simple avec barres de progression
     */
    public static function renderProgressChart(string $title, array $data): string {
        $card = new Card($title);
        
        $chart = '<div class="space-y-3">';
        foreach ($data as $item) {
            $color = $item['percentage'] >= 75 ? 'bg-green-500' : 
                     ($item['percentage'] >= 50 ? 'bg-yellow-500' : 'bg-red-500');
            
            $chart .= '
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">' . htmlspecialchars($item['label']) . '</span>
                    <span class="text-sm text-gray-500">' . $item['count'] . ' (' . $item['percentage'] . '%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="' . $color . ' h-2 rounded-full" style="width: ' . $item['percentage'] . '%"></div>
                </div>
            </div>';
        }
        $chart .= '</div>';
        
        $card->addChild($chart);
        return $card->render();
    }
    
    /**
     * Génère les actions rapides
     */
    public static function renderQuickActions(array $actions): string {
        $card = new Card('Actions rapides');
        
        $grid = '<div class="grid grid-cols-2 gap-3">';
        foreach ($actions as $action) {
            $grid .= '
            <button onclick="window.location.href=\'' . $action['url'] . '\'" 
                    class="p-4 ' . $action['bg_color'] . ' hover:' . $action['hover_color'] . ' rounded-lg text-center transition-colors">
                <i class="' . $action['icon'] . ' ' . $action['text_color'] . ' text-2xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">' . htmlspecialchars($action['label']) . '</p>
            </button>';
        }
        $grid .= '</div>';
        
        $card->addChild($grid);
        return $card->render();
    }
    
    /**
     * Génère un tableau simple
     */
    public static function renderTable(array $headers, array $rows, array $options = []): string {
        $card = new Card($options['title'] ?? 'Tableau', $options);
        
        $table = '<div class="overflow-x-auto">';
        $table .= '<table class="min-w-full divide-y divide-gray-200">';
        
        // En-tête
        $table .= '<thead class="bg-gray-50">';
        $table .= '<tr>';
        foreach ($headers as $header) {
            $table .= '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">' . htmlspecialchars($header) . '</th>';
        }
        $table .= '</tr>';
        $table .= '</thead>';
        
        // Corps
        $table .= '<tbody class="bg-white divide-y divide-gray-200">';
        foreach ($rows as $row) {
            $table .= '<tr>';
            foreach ($row as $cell) {
                $table .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">' . $cell . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        
        $table .= '</table>';
        $table .= '</div>';
        
        $card->addChild($table);
        return $card->render();
    }
}

/**
 * Contenus spécifiques pour chaque type de dashboard
 */
class DashboardContentFactory {
    
    /**
     * Contenu pour le dashboard administrateur
     */
    public static function getAdminContent(): array {
        return [
            'stats_config' => [
                'total_eleves' => ['label' => 'Élèves', 'icon' => 'fas fa-graduation-cap', 'color' => 'blue'],
                'total_enseignants' => ['label' => 'Enseignants', 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'green'],
                'total_classes' => ['label' => 'Classes', 'icon' => 'fas fa-school', 'color' => 'purple'],
                'total_cours' => ['label' => 'Cours', 'icon' => 'fas fa-book', 'color' => 'yellow'],
                'paiements_en_attente' => ['label' => 'Paiements en attente', 'icon' => 'fas fa-clock', 'color' => 'orange'],
                'discipline_cases' => ['label' => 'Cas discipline', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red']
            ],
            'recent_activities' => [
                ['title' => 'Nouvel élève inscrit', 'description' => 'Jean Mukendi - 6ème Scientifique', 'url' => '#'],
                ['title' => 'Paiement reçu', 'description' => 'Scolarité - Marie Kalonji', 'url' => '#'],
                ['title' => 'Nouveau cours créé', 'description' => 'Mathématiques - 5ème', 'url' => '#'],
                ['title' => 'Cas de discipline', 'description' => 'Retard - Pierre Kabeya', 'url' => '#']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard enseignant
     */
    public static function getEnseignantContent(): array {
        return [
            'stats_config' => [
                'total_classes' => ['label' => 'Classes', 'icon' => 'fas fa-door-open', 'color' => 'blue'],
                'total_cours' => ['label' => 'Cours', 'icon' => 'fas fa-book', 'color' => 'green'],
                'total_eleves' => ['label' => 'Élèves', 'icon' => 'fas fa-graduation-cap', 'color' => 'purple'],
                'notes_a_saisir' => ['label' => 'Notes à saisir', 'icon' => 'fas fa-edit', 'color' => 'yellow'],
                'examens_aujourdhui' => ['label' => 'Examens aujourd\'hui', 'icon' => 'fas fa-calendar-day', 'color' => 'orange'],
                'devoirs_a_corriger' => ['label' => 'Devoirs à corriger', 'icon' => 'fas fa-check-double', 'color' => 'red']
            ],
            'quick_actions' => [
                ['label' => 'Nouvel examen', 'url' => '/enseignant/evaluations/creer', 'icon' => 'fas fa-plus-circle', 'bg_color' => 'bg-blue-50', 'hover_color' => 'hover:bg-blue-100', 'text_color' => 'text-blue-600'],
                ['label' => 'Saisir notes', 'url' => '/enseignant/notes/saisir', 'icon' => 'fas fa-edit', 'bg_color' => 'bg-green-50', 'hover_color' => 'hover:bg-green-100', 'text_color' => 'text-green-600'],
                ['label' => 'Nouveau devoir', 'url' => '/enseignant/devoirs/creer', 'icon' => 'fas fa-tasks', 'bg_color' => 'bg-purple-50', 'hover_color' => 'hover:bg-purple-100', 'text_color' => 'text-purple-600'],
                ['label' => 'Annonce', 'url' => '/enseignant/communication/annonces', 'icon' => 'fas fa-bullhorn', 'bg_color' => 'bg-yellow-50', 'hover_color' => 'hover:bg-yellow-100', 'text_color' => 'text-yellow-600']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard élève
     */
    public static function getEleveContent(): array {
        return [
            'stats_config' => [
                'moyenne_generale' => ['label' => 'Moyenne', 'icon' => 'fas fa-chart-line', 'color' => 'blue'],
                'total_absences' => ['label' => 'Absences', 'icon' => 'fas fa-calendar-times', 'color' => 'red'],
                'devoirs_en_retard' => ['label' => 'Devoirs en retard', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'yellow'],
                'examens_a_venir' => ['label' => 'Examens', 'icon' => 'fas fa-calendar-check', 'color' => 'green'],
                'messages_non_lus' => ['label' => 'Messages', 'icon' => 'fas fa-envelope', 'color' => 'purple'],
                'bibliotheque_emprunts' => ['label' => 'Livres', 'icon' => 'fas fa-book', 'color' => 'orange']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard directeur de discipline
     */
    public static function getDirecteurDisciplineContent(): array {
        return [
            'stats_config' => [
                'cas_en_attente' => ['label' => 'Cas en attente', 'icon' => 'fas fa-clock', 'color' => 'yellow'],
                'cas_traites' => ['label' => 'Cas traités', 'icon' => 'fas fa-check-circle', 'color' => 'green'],
                'retards_ce_mois' => ['label' => 'Retards ce mois', 'icon' => 'fas fa-hourglass-half', 'color' => 'orange'],
                'absences_ce_mois' => ['label' => 'Absences ce mois', 'icon' => 'fas fa-calendar-times', 'color' => 'red'],
                'sanctions_appliquees' => ['label' => 'Sanctions appliquées', 'icon' => 'fas fa-gavel', 'color' => 'purple'],
                'cas_urgents' => ['label' => 'Cas urgents', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red']
            ],
            'sanctions_data' => [
                ['label' => 'Avertissement verbal', 'count' => 15, 'percentage' => 45],
                ['label' => 'Avertissement écrit', 'count' => 10, 'percentage' => 30],
                ['label' => 'Exclusion temporaire', 'count' => 5, 'percentage' => 15],
                ['label' => 'Tâches d\'intérêt général', 'count' => 3, 'percentage' => 10]
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard chef de classe
     */
    public static function getChefClasseContent(): array {
        return [
            'stats_config' => [
                'total_classes' => ['label' => 'Classes', 'icon' => 'fas fa-school', 'color' => 'blue'],
                'total_eleves' => ['label' => 'Élèves', 'icon' => 'fas fa-graduation-cap', 'color' => 'green'],
                'absences_ce_jour' => ['label' => 'Absences aujourd\'hui', 'icon' => 'fas fa-calendar-times', 'color' => 'red'],
                'notes_a_valider' => ['label' => 'Notes à valider', 'icon' => 'fas fa-edit', 'color' => 'yellow'],
                'messages_parents' => ['label' => 'Messages parents', 'icon' => 'fas fa-envelope', 'color' => 'purple'],
                'reunions_prevues' => ['label' => 'Réunions', 'icon' => 'fas fa-users', 'color' => 'orange']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard préfet
     */
    public static function getPrefetContent(): array {
        return [
            'stats_config' => [
                'surveillances_ce_jour' => ['label' => 'Surveillances aujourd\'hui', 'icon' => 'fas fa-eye', 'color' => 'blue'],
                'rapports_rediges' => ['label' => 'Rapports rédigés', 'icon' => 'fas fa-file-alt', 'color' => 'green'],
                'incidents_signales' => ['label' => 'Incidents signalés', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red'],
                'classes_assignees' => ['label' => 'Classes assignées', 'icon' => 'fas fa-school', 'color' => 'purple'],
                'messages_administration' => ['label' => 'Messages administration', 'icon' => 'fas fa-envelope', 'color' => 'yellow'],
                'prochaines_surveillances' => ['label' => 'Prochaines surveillances', 'icon' => 'fas fa-calendar-check', 'color' => 'orange']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard comité parents
     */
    public static function getComiteParentsContent(): array {
        return [
            'stats_config' => [
                'membres_actifs' => ['label' => 'Membres actifs', 'icon' => 'fas fa-users', 'color' => 'blue'],
                'reunions_ce_mois' => ['label' => 'Réunions ce mois', 'icon' => 'fas fa-calendar-check', 'color' => 'green'],
                'projets_en_cours' => ['label' => 'Projets en cours', 'icon' => 'fas fa-project-diagram', 'color' => 'purple'],
                'fonds_collectes' => ['label' => 'Fonds collectés', 'icon' => 'fas fa-coins', 'color' => 'yellow'],
                'messages_parents' => ['label' => 'Messages parents', 'icon' => 'fas fa-envelope', 'color' => 'orange'],
                'evenements_prevus' => ['label' => 'Événements', 'icon' => 'fas fa-calendar-day', 'color' => 'red']
            ]
        ];
    }
    
    /**
     * Contenu pour le dashboard tuteur
     */
    public static function getTuteurContent(): array {
        return [
            'stats_config' => [
                'eleves_suivis' => ['label' => 'Élèves suivis', 'icon' => 'fas fa-graduation-cap', 'color' => 'blue'],
                'paiements_en_retard' => ['label' => 'Paiements en retard', 'icon' => 'fas fa-exclamation-triangle', 'color' => 'red', 'changeType' => 'negative'],
                'messages_non_lus' => ['label' => 'Messages non lus', 'icon' => 'fas fa-envelope', 'color' => 'yellow'],
                'reunions_prevues' => ['label' => 'Réunions prévues', 'icon' => 'fas fa-users', 'color' => 'green'],
                'bulletins_disponibles' => ['label' => 'Bulletins disponibles', 'icon' => 'fas fa-file-alt', 'color' => 'purple'],
                'absences_recentes' => ['label' => 'Absences récentes', 'icon' => 'fas fa-calendar-times', 'color' => 'orange']
            ]
        ];
    }
}
