<?php
/**
 * Classe de base pour tous les composants UI
 * Pattern: Component Base Class
 * Thème: Bleu et Blanc
 */
abstract class Component {
    protected $attributes = [];
    protected $classes = [];
    protected $styles = [];
    
    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
        $this->init();
    }
    
    protected function init() {
        // Méthode à surcharger par les classes enfants
    }
    
    public function addClass(string $class): self {
        $this->classes[] = $class;
        return $this;
    }
    
    public function addStyle(string $property, string $value): self {
        $this->styles[$property] = $value;
        return $this;
    }
    
    public function setAttribute(string $name, string $value): self {
        $this->attributes[$name] = $value;
        return $this;
    }
    
    protected function buildAttributes(): string {
        $attrs = [];
        
        if (!empty($this->classes)) {
            $attrs[] = 'class="' . implode(' ', $this->classes) . '"';
        }
        
        foreach ($this->styles as $property => $value) {
            $styleString[] = $property . ': ' . $value;
        }
        
        if (!empty($this->styles)) {
            $attrs[] = 'style="' . implode('; ', $styleString) . '"';
        }
        
        foreach ($this->attributes as $name => $value) {
            if ($name !== 'class' && $name !== 'style') {
                $attrs[] = $name . '="' . htmlspecialchars($value) . '"';
            }
        }
        
        return implode(' ', $attrs);
    }
    
    abstract public function render(): string;
    
    public function __toString(): string {
        return $this->render();
    }
}

/**
 * Classe de base pour les conteneurs
 */
abstract class Container extends Component {
    protected $children = [];
    
    public function addChild($child): self {
        $this->children[] = $child;
        return $this;
    }
    
    public function addChildren(array $children): self {
        $this->children = array_merge($this->children, $children);
        return $this;
    }
    
    protected function renderChildren(): string {
        $output = '';
        foreach ($this->children as $child) {
            if (is_string($child)) {
                $output .= $child;
            } elseif ($child instanceof Component) {
                $output .= $child->render();
            }
        }
        return $output;
    }
}

/**
 * Utilitaires pour le thème bleu et blanc
 */
class Theme {
    const PRIMARY_BLUE = '#2563eb';
    const LIGHT_BLUE = '#dbeafe';
    const MEDIUM_BLUE = '#3b82f6';
    const DARK_BLUE = '#1e40af';
    const WHITE = '#ffffff';
    const GRAY_LIGHT = '#f8fafc';
    const GRAY_MEDIUM = '#64748b';
    const GRAY_DARK = '#1e293b';
    
    public static function getButtonClasses(string $variant = 'primary'): array {
        $base = ['px-4', 'py-2', 'rounded-lg', 'font-medium', 'transition-all', 'duration-200'];
        
        switch ($variant) {
            case 'primary':
                return array_merge($base, ['bg-blue-600', 'text-white', 'hover:bg-blue-700']);
            case 'secondary':
                return array_merge($base, ['bg-blue-100', 'text-blue-800', 'hover:bg-blue-200']);
            case 'outline':
                return array_merge($base, ['border-2', 'border-blue-600', 'text-blue-600', 'hover:bg-blue-50']);
            default:
                return $base;
        }
    }
    
    public static function getCardClasses(): array {
        return ['bg-white', 'rounded-xl', 'shadow-lg', 'border', 'border-blue-100'];
    }
    
    public static function getSidebarClasses(): array {
        return ['bg-white', 'border-r', 'border-blue-200', 'shadow-lg'];
    }
    
    public static function getHeaderClasses(): array {
        return ['bg-white', 'border-b', 'border-blue-200', 'shadow-sm'];
    }
}
