<?php

/**
 * Classe de base pour tous les composants
 */
abstract class Component {
    protected $options;
    
    public function __construct(array $options = []) {
        $this->options = $options;
    }
    
    /**
     * Méthode abstraite pour le rendu du composant
     */
    abstract public function render(): void;
    
    /**
     * Ajouter une classe CSS
     */
    protected function addClass(string $class): void {
        $this->options['class'] = $this->options['class'] ?? '';
        $this->options['class'] .= ' ' . $class;
        $this->options['class'] = trim($this->options['class']);
    }
    
    /**
     * Obtenir une option
     */
    protected function getOption(string $key, $default = null) {
        return $this->options[$key] ?? $default;
    }
    
    /**
     * Définir une option
     */
    protected function setOption(string $key, $value): void {
        $this->options[$key] = $value;
    }
}
?>
