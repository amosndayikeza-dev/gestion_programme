<?php
require_once __DIR__ . '/Component.php';

/**
 * Composant Card réutilisable
 * Thème: Bleu et Blanc
 */
class Card extends Container {
    private $title;
    private $subtitle;
    private $headerActions = [];
    private $footer;
    private $variant = 'default';
    
    public function __construct(string $title = '', array $options = []) {
        $this->title = $title;
        $this->subtitle = $options['subtitle'] ?? null;
        $this->variant = $options['variant'] ?? 'default';
        $this->headerActions = $options['headerActions'] ?? [];
        $this->footer = $options['footer'] ?? null;
        
        parent::__construct($options);
        $this->initCard();
    }
    
    private function initCard(): void {
        $baseClasses = Theme::getCardClasses();
        
        switch ($this->variant) {
            case 'primary':
                $this->addClass('bg-gradient-to-br from-blue-50 to-white border-blue-200');
                break;
            case 'stats':
                $this->addClass('bg-white border-blue-100 shadow-md hover:shadow-lg transition-shadow');
                break;
            case 'interactive':
                $this->addClass('bg-white border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 cursor-pointer');
                break;
            default:
                $this->addClass(implode(' ', $baseClasses));
        }
    }
    
    public function addHeaderAction(string $label, string $url, string $icon = '', string $variant = 'secondary'): self {
        $this->headerActions[] = [
            'label' => $label,
            'url' => $url,
            'icon' => $icon,
            'variant' => $variant
        ];
        return $this;
    }
    
    public function setFooter(string $footer): self {
        $this->footer = $footer;
        return $this;
    }
    
    public function render(): string {
        return '
        <div ' . $this->buildAttributes() . '>
            ' . $this->renderHeader() . '
            ' . $this->renderBody() . '
            ' . $this->renderFooter() . '
        </div>';
    }
    
    private function renderHeader(): string {
        if (empty($this->title) && empty($this->headerActions)) {
            return '';
        }
        
        $header = '<div class="p-6 pb-0">';
        
        if (!empty($this->title) || !empty($this->subtitle)) {
            $header .= '<div class="flex items-center justify-between">';
            
            // Titre et sous-titre
            if (!empty($this->title) || !empty($this->subtitle)) {
                $header .= '<div>';
                if (!empty($this->title)) {
                    $header .= '<h3 class="text-lg font-semibold text-gray-800">' . 
                        htmlspecialchars($this->title) . '</h3>';
                }
                if (!empty($this->subtitle)) {
                    $header .= '<p class="text-sm text-gray-500 mt-1">' . 
                        htmlspecialchars($this->subtitle) . '</p>';
                }
                $header .= '</div>';
            }
            
            // Actions du header
            if (!empty($this->headerActions)) {
                $header .= '<div class="flex items-center space-x-2">';
                foreach ($this->headerActions as $action) {
                    $icon = !empty($action['icon']) ? 
                        '<i class="' . htmlspecialchars($action['icon']) . ' mr-2"></i>' : '';
                    
                    $buttonClasses = Theme::getButtonClasses($action['variant']);
                    $header .= '
                    <a href="' . htmlspecialchars($action['url']) . '" 
                       class="' . implode(' ', $buttonClasses) . '">
                        ' . $icon . '
                        ' . htmlspecialchars($action['label']) . '
                    </a>';
                }
                $header .= '</div>';
            }
            
            $header .= '</div>';
        }
        
        $header .= '</div>';
        return $header;
    }
    
    private function renderBody(): string {
        $body = '<div class="p-6">';
        
        if (!empty($this->children)) {
            $body .= $this->renderChildren();
        }
        
        $body .= '</div>';
        return $body;
    }
    
    private function renderFooter(): string {
        if (empty($this->footer)) {
            return '';
        }
        
        return '
        <div class="px-6 py-4 bg-gray-50 border-t border-blue-100 rounded-b-xl">
            ' . $this->footer . '
        </div>';
    }
}

/**
 * Composant StatsCard pour les statistiques
 */
class StatsCard extends Card {
    private $value;
    private $change;
    private $changeType;
    private $icon;
    private $color;
    
    public function __construct(string $title, $value, array $options = []) {
        $this->value = $value;
        $this->change = $options['change'] ?? null;
        $this->changeType = $options['changeType'] ?? 'positive';
        $this->icon = $options['icon'] ?? 'fas fa-chart-line';
        $this->color = $options['color'] ?? 'blue';
        
        parent::__construct($title, ['variant' => 'stats']);
    }
    
    public function render(): string {
        $colorClasses = [
            'blue' => 'text-blue-600 bg-blue-100',
            'green' => 'text-green-600 bg-green-100',
            'red' => 'text-red-600 bg-red-100',
            'yellow' => 'text-yellow-600 bg-yellow-100',
            'purple' => 'text-purple-600 bg-purple-100'
        ];
        
        $iconBgClass = $colorClasses[$this->color] ?? $colorClasses['blue'];
        
        return '
        <div ' . $this->buildAttributes() . '>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">' . 
                            htmlspecialchars($this->title) . '</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">' . 
                            htmlspecialchars($this->value) . '</p>';
                        
                        if ($this->change !== null) {
                            $changeIcon = $this->changeType === 'positive' ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
                            $changeColor = $this->changeType === 'positive' ? 'text-green-600' : 'text-red-600';
                            
                            echo '
                            <p class="text-sm ' . $changeColor . ' mt-2">
                                <i class="' . $changeIcon . ' mr-1"></i>
                                ' . htmlspecialchars($this->change) . '
                            </p>';
                        }
                        
                        echo '
                    </div>
                    <div class="' . $iconBgClass . ' p-3 rounded-lg">
                        <i class="' . htmlspecialchars($this->icon) . ' text-xl"></i>
                    </div>
                </div>
            </div>
        </div>';
    }
}
 
/**
 * Composant ListCard pour les listes
 */

class ListCard extends Card {
    private $items = [];
    private $emptyMessage = 'Aucun élément à afficher';
    
    public function addItem(string $title, string $description = '', string $url = '', array $actions = []): self {
        $this->items[] = [
            'title' => $title,
            'description' => $description,
            'url' => $url,
            'actions' => $actions
        ];02136521
        return $this;
    }
    
    public function setEmptyMessage(string $message): self {
        $this->emptyMessage = $message;
        return $this;
    }
    
    protected function renderBody(): string {
        $body = '<div class="p-6">';
        
        if (empty($this->items)) {
            $body .= '
            <div class="text-center py-8">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">' . htmlspecialchars($this->emptyMessage) . '</p>
            </div>';
        } else {
            $body .= '<div class="space-y-3">';
            foreach ($this->items as $item) {
                $body .= $this->renderListItem($item);
            }
            $body .= '</div>';
        }
        
        $body .= '</div>';
        return $body;
    }
    
    private function renderListItem(array $item): string {
        $itemHtml = '
        <div class="flex items-center justify-between p-3 rounded-lg hover:bg-blue-50 transition-colors">';
        
        // Contenu principal
        $content = '<div class="flex-1">';
        if (!empty($item['url'])) {
            $content .= '<a href="' . htmlspecialchars($item['url']) . '" class="text-blue-600 hover:text-blue-800">';
        }
        
        $content .= '<h4 class="font-medium text-gray-800">' . htmlspecialchars($item['title']) . '</h4>';
        
        if (!empty($item['description'])) {
            $content .= '<p class="text-sm text-gray-500 mt-1">' . htmlspecialchars($item['description']) . '</p>';
        }
        
        if (!empty($item['url'])) {
            $content .= '</a>';
        }
        $content .= '</div>';
        
        // Actions
        $actions = '';
        if (!empty($item['actions'])) {
            $actions = '<div class="flex items-center space-x-2">';
            foreach ($item['actions'] as $action) {
                $icon = !empty($action['icon']) ? 
                    '<i class="' . htmlspecialchars($action['icon']) . '"></i>' : '';
                
                $actions .= '
                <button onclick="' . htmlspecialchars($action['onclick'] ?? '') . '" 
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                        title="' . htmlspecialchars($action['title'] ?? '') . '">
                    ' . $icon . '
                </button>';
            }
            $actions .= '</div>';
        }
        
        $itemHtml .= $content . $actions . '</div>';
        return $itemHtml;
    }
}
