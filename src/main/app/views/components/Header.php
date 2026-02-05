<?php
require_once __DIR__ . '/Component.php';

/**
 * Composant Header réutilisable
 * Thème: Bleu et Blanc
 */
class Header extends Component {
    private $title;
    private $logo;
    private $user;
    private $navigation = [];
    
    public function __construct(string $title = 'Gestion Programme', array $options = []) {
        $this->title = $title;
        $this->logo = $options['logo'] ?? '/assets/images/logo.png';
        $this->user = $options['user'] ?? null;
        $this->navigation = $options['navigation'] ?? [];
        
        parent::__construct($options);
        $this->addClass('w-full');
    }
    
    public function addNavigationItem(string $label, string $url, string $icon = ''): self {
        $this->navigation[] = [
            'label' => $label,
            'url' => $url,
            'icon' => $icon
        ];
        return $this;
    }
    
    public function render(): string {
        $classes = array_merge(Theme::getHeaderClasses(), $this->classes);
        $this->classes = $classes;
        
        return '
        <header ' . $this->buildAttributes() . '>
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo et Titre -->
                    <div class="flex items-center space-x-4">
                        <img src="' . htmlspecialchars($this->logo) . '" 
                             alt="Logo" 
                             class="h-10 w-auto rounded-lg">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">' . htmlspecialchars($this->title) . '</h1>
                            <p class="text-xs text-gray-500">Système de Gestion Scolaire</p>
                        </div>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center space-x-6">
                        ' . $this->renderNavigation() . '
                    </nav>
                    
                    <!-- Utilisateur -->
                    <div class="flex items-center space-x-4">
                        ' . $this->renderUserMenu() . '
                    </div>
                    
                    <!-- Menu Mobile -->
                    <button class="md:hidden p-2 rounded-lg hover:bg-blue-50 transition-colors"
                            onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Menu Mobile (caché) -->
                <div id="mobileMenu" class="hidden md:hidden pb-4">
                    ' . $this->renderMobileNavigation() . '
                </div>
            </div>
        </header>';
    }
    
    private function renderNavigation(): string {
        $nav = '';
        foreach ($this->navigation as $item) {
            $icon = !empty($item['icon']) ? 
                '<i class="' . htmlspecialchars($item['icon']) . ' mr-2"></i>' : '';
            
            $nav .= '
            <a href="' . htmlspecialchars($item['url']) . '" 
               class="flex items-center px-3 py-2 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                ' . $icon . '
                <span>' . htmlspecialchars($item['label']) . '</span>
            </a>';
        }
        return $nav;
    }
    
    private function renderMobileNavigation(): string {
        $nav = '<div class="space-y-2">';
        foreach ($this->navigation as $item) {
            $icon = !empty($item['icon']) ? 
                '<i class="' . htmlspecialchars($item['icon']) . ' mr-2"></i>' : '';
            
            $nav .= '
            <a href="' . htmlspecialchars($item['url']) . '" 
               class="block px-3 py-2 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                ' . $icon . '
                <span>' . htmlspecialchars($item['label']) . '</span>
            </a>';
        }
        $nav .= '</div>';
        return $nav;
    }
    
    private function renderUserMenu(): string {
        if (!$this->user) {
            return '
            <div class="flex items-center space-x-2">
                <a href="/auth/login" class="' . implode(' ', Theme::getButtonClasses('outline')) . '">
                    Connexion
                </a>
            </div>';
        }
        
        return '
        <div class="relative">
            <button onclick="toggleUserMenu()" 
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                <img src="' . htmlspecialchars($this->user['photo'] ?? '/assets/images/default-avatar.png') . '" 
                     alt="Avatar" 
                     class="w-8 h-8 rounded-full">
                <span class="hidden md:block text-sm font-medium text-gray-700">
                    ' . htmlspecialchars($this->user['name'] ?? 'Utilisateur') . '
                </span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <!-- Menu déroulant utilisateur -->
            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-blue-100 z-50">
                <div class="p-3 border-b border-blue-100">
                    <p class="text-sm font-medium text-gray-800">' . htmlspecialchars($this->user['name'] ?? '') . '</p>
                    <p class="text-xs text-gray-500">' . htmlspecialchars($this->user['role'] ?? '') . '</p>
                </div>
                <div class="py-2">
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                        <i class="fas fa-user mr-2"></i> Mon Profil
                    </a>
                    <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                        <i class="fas fa-cog mr-2"></i> Paramètres
                    </a>
                    <hr class="my-2 border-blue-100">
                    <a href="/gestion_programme/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>';
    }
}
