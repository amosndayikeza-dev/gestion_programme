<?php
require_once __DIR__ . '/Component.php';

/**
 * Composant Sidebar réutilisable
 * Thème: Bleu et Blanc
 */
class Sidebar extends Component {
    private $menuItems = [];
    private $user;
    private $collapsed = false;
    
    public function __construct(array $options = []) {
        $this->user = $options['user'] ?? null;
        $this->collapsed = $options['collapsed'] ?? false;
        
        parent::__construct($options);
        $this->addClass('fixed left-0 top-0 h-full z-40 transition-all duration-300');
    }
    
    public function addMenuItem(string $label, string $url, string $icon = '', array $submenu = []): self {
        $this->menuItems[] = [
            'label' => $label,
            'url' => $url,
            'icon' => $icon,
            'submenu' => $submenu,
            'active' => false
        ];
        return $this;
    }
    
    public function setActiveItem(string $url): self {
        foreach ($this->menuItems as &$item) {
            if ($item['url'] === $url) {
                $item['active'] = true;
            }
            foreach ($item['submenu'] as &$subitem) {
                if ($subitem['url'] === $url) {
                    $item['active'] = true;
                    $subitem['active'] = true;
                }
            }
        }
        return $this;
    }
    
    public function toggleCollapse(): self {
        $this->collapsed = !$this->collapsed;
        return $this;
    }
    
    public function render(): string {
        $classes = array_merge(Theme::getSidebarClasses(), $this->classes);
        $this->classes = $classes;
        
        $width = $this->collapsed ? 'w-16' : 'w-64';
        $this->addClass($width);
        
        return '
        <aside ' . $this->buildAttributes() . '>
            <!-- Header Sidebar -->
            <div class="p-4 border-b border-blue-200">
                <div class="flex items-center justify-between">
                    ' . $this->renderLogo() . '
                    <button onclick="toggleSidebar()" 
                            class="p-2 rounded-lg hover:bg-blue-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4">
                ' . $this->renderMenu() . '
            </nav>
            
            <!-- Footer Sidebar -->
            ' . $this->renderFooter() . '
        </aside>';
    }
    
    private function renderLogo(): string {
        if ($this->collapsed) {
            return '
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">G</span>
            </div>';
        }
        
        return '
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">G</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Gestion</h2>
                <p class="text-xs text-gray-500">Programme</p>
            </div>
        </div>';
    }
    
    private function renderMenu(): string {
        $menu = '<div class="space-y-2">';
        
        foreach ($this->menuItems as $item) {
            $menu .= $this->renderMenuItem($item);
        }
        
        $menu .= '</div>';
        return $menu;
    }
    
    private function renderMenuItem(array $item): string {
        $activeClass = $item['active'] ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600';
        $collapsedClass = $this->collapsed ? 'justify-center' : '';
        
        $icon = !empty($item['icon']) ? 
            '<i class="' . htmlspecialchars($item['icon']) . ' text-lg"></i>' : '';
        
        $label = $this->collapsed ? '' : 
            '<span class="ml-3">' . htmlspecialchars($item['label']) . '</span>';
        
        $arrow = !empty($item['submenu']) && !$this->collapsed ? 
            '<i class="fas fa-chevron-down ml-auto text-xs"></i>' : '';
        
        $menuItem = '
        <div class="menu-item">
            <a href="' . htmlspecialchars($item['url']) . '" 
               class="flex items-center px-3 py-2 rounded-lg transition-all duration-200 ' . $activeClass . ' ' . $collapsedClass . '">
                ' . $icon . '
                ' . $label . '
                ' . $arrow . '
            </a>';
        
        // Rendre le sous-menu s'il existe
        if (!empty($item['submenu']) && !$this->collapsed) {
            $submenuClass = $item['active'] ? 'block' : 'hidden';
            $menuItem .= '
            <div class="submenu ' . $submenuClass . ' ml-8 mt-1 space-y-1">';
            
            foreach ($item['submenu'] as $subitem) {
                $subActiveClass = ($subitem['active'] ?? false) ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:text-blue-600';
                $menuItem .= '
                <a href="' . htmlspecialchars($subitem['url']) . '" 
                   class="flex items-center px-3 py-1 rounded text-sm transition-all duration-200 ' . $subActiveClass . '">
                    <i class="' . htmlspecialchars($subitem['icon'] ?? 'fas fa-circle') . ' text-xs mr-2"></i>
                    ' . htmlspecialchars($subitem['label']) . '
                </a>';
            }
            
            $menuItem .= '
            </div>';
        }
        
        $menuItem .= '</div>';
        return $menuItem;
    }
    
    private function renderFooter(): string {
        if ($this->collapsed) {
            return '
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-200">
                <div class="flex justify-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 text-xs font-bold">' . 
                            strtoupper(substr($this->user['name'] ?? 'U', 0, 1)) . '</span>
                    </div>
                </div>
            </div>';
        }
        
        return '
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-200">
            <div class="flex items-center space-x-3">
                <img src="' . htmlspecialchars($this->user['photo'] ?? '/assets/images/default-avatar.png') . '" 
                     alt="Avatar" 
                     class="w-8 h-8 rounded-full">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">
                        ' . htmlspecialchars($this->user['name'] ?? 'Utilisateur') . '
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        ' . htmlspecialchars($this->user['role'] ?? '') . '
                    </p>
                </div>
            </div>
        </div>';
    }
}
