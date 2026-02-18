<?php
require_once __DIR__ . '/Component.php';

/**
 * Composant Footer réutilisable
 * Thème: Bleu et Blanc
 */
class Footer extends Component {
    private $copyright;
    private $links = [];
    private $socialLinks = [];
    private $showYear = true;
    
    public function __construct(array $options = []) {
        $this->copyright = $options['copyright'] ?? 'Gestion Programme - Tous droits réservés';
        $this->showYear = $options['showYear'] ?? true;
        $this->links = $options['links'] ?? [];
        $this->socialLinks = $options['socialLinks'] ?? [];
        
        parent::__construct($options);
        $this->addClass('bg-white border-t border-blue-200 mt-auto');
    }
    
    public function addLink(string $label, string $url): self {
        $this->links[] = [
            'label' => $label,
            'url' => $url
        ];
        return $this;
    }
    
    public function addSocialLink(string $platform, string $url, string $icon = ''): self {
        $this->socialLinks[] = [
            'platform' => $platform,
            'url' => $url,
            'icon' => $icon
        ];
        return $this;
    }
    
    public function render(): string {
        $year = $this->showYear ? date('Y') . ' - ' : '';
        
        return '
        <footer ' . $this->buildAttributes() . '>
            <div class="container mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <!-- Copyright -->
                    <div class="text-gray-600 text-sm mb-4 md:mb-0">
                        <p>&copy; ' . $year . htmlspecialchars($this->copyright) . '</p>
                    </div>
                    
                    <!-- Liens -->
                    ' . $this->renderLinks() . '
                    
                    <!-- Réseaux sociaux -->
                    ' . $this->renderSocialLinks() . '
                </div>
            </div>
        </footer>';
    }
    
    private function renderLinks(): string {
        if (empty($this->links)) {
            return '';
        }
        
        $links = '<div class="flex items-center space-x-6 mb-4 md:mb-0">';
        
        foreach ($this->links as $link) {
            $links .= '
            <a href="' . htmlspecialchars($link['url']) . '" 
               class="text-gray-600 hover:text-blue-600 text-sm transition-colors">
                ' . htmlspecialchars($link['label']) . '
            </a>';
        }
        
        $links .= '</div>';
        return $links;
    }
    
    private function renderSocialLinks(): string {
        if (empty($this->socialLinks)) {
            return '';
        }
        
        $social = '<div class="flex items-center space-x-4">';
        
        foreach ($this->socialLinks as $socialLink) {
            $icon = !empty($socialLink['icon']) ? 
                '<i class="' . htmlspecialchars($socialLink['icon']) . '"></i>' : 
                '<span class="text-xs">' . htmlspecialchars(substr($socialLink['platform'], 0, 1)) . '</span>';
            
            $social .= '
            <a href="' . htmlspecialchars($socialLink['url']) . '" 
               class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors"
               title="' . htmlspecialchars($socialLink['platform']) . '">
                ' . $icon . '
            </a>';
        }
        
        $social .= '</div>';
        return $social;
    }
}

/**
 * Footer simplifié pour les pages d'authentification
 */
class SimpleFooter extends Footer {
    public function __construct(array $options = []) {
        parent::__construct($options);
        $this->addClass('bg-gray-50 border-0');
    }
    
    public function render(): string {
        return '
        <footer ' . $this->buildAttributes() . '>
            <div class="container mx-auto px-4 py-4">
                <div class="text-center text-gray-500 text-sm">
                    <p>&copy; ' . date('Y') . ' ' . htmlspecialchars($this->copyright) . '</p>
                </div>
            </div>
        </footer>';
    }
}
