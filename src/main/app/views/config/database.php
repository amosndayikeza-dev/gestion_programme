<?php
/**
 * Configuration de la base de données
 * Simulation pour les tests
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        // Simulation de connexion - à remplacer avec vraie BDD
        $this->connection = new stdClass();
        $this->connection->connected = true;
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        // Simulation de requêtes
        return new MockResult();
    }
}

class MockResult {
    public function fetch() {
        // Simulation de données
        return [
            'id_utilisateur' => 1,
            'nom' => 'Admin',
            'email' => 'admin@ecole.com',
            'role' => 'administrateur'
        ];
    }
    
    public function fetchAll() {
        // Simulation de plusieurs résultats
        return [
            ['id_utilisateur' => 1, 'nom' => 'Admin', 'email' => 'admin@ecole.com', 'role' => 'administrateur'],
            ['id_utilisateur' => 2, 'nom' => 'Enseignant', 'email' => 'enseignant@ecole.com', 'role' => 'enseignant'],
            ['id_utilisateur' => 3, 'nom' => 'Eleve', 'email' => 'eleve@ecole.com', 'role' => 'eleve']
        ];
    }
}
