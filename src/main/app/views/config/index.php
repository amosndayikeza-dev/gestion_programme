<?php
/**
 * Point d'entrée principal
 * Gère le routage et l'initialisation
 */

// Inclure les configurations
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/routing.php';

// Démarrer la session
SessionManager::start();

// Gérer la déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    SessionManager::destroy();
    SessionManager::flash('success', 'Vous avez été déconnecté avec succès');
    Router::redirect('/login');
}

// Gérer la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simulation d'authentification
    $users = [
        'admin@ecole.com' => ['password' => 'admin123', 'role' => 'administrateur', 'nom' => 'Administrateur'],
        'enseignant@ecole.com' => ['password' => 'enseignant123', 'role' => 'enseignant', 'nom' => 'Enseignant'],
        'eleve@ecole.com' => ['password' => 'eleve123', 'role' => 'eleve', 'nom' => 'Élève'],
        'directeur@ecole.com' => ['password' => 'directeur123', 'role' => 'directeur_discipline', 'nom' => 'Directeur Discipline'],
        'chef@ecole.com' => ['password' => 'chef123', 'role' => 'chef_classe', 'nom' => 'Chef de Classe'],
        'prefet@ecole.com' => ['password' => 'prefet123', 'role' => 'prefet', 'nom' => 'Préfet'],
        'comite@ecole.com' => ['password' => 'comite123', 'role' => 'comite_parents', 'nom' => 'Comité Parents'],
        'tuteur@ecole.com' => ['password' => 'tuteur123', 'role' => 'tuteur', 'nom' => 'Tuteur']
    ];
    
    if (isset($users[$email]) && $users[$email]['password'] === $password) {
        $user = [
            'email' => $email,
            'role' => $users[$email]['role'],
            'nom' => $users[$email]['nom'],
            'id_utilisateur' => array_search($email, array_keys($users)) !== false ? array_search($email, array_keys($users)) + 1 : 1
        ];
        
        SessionManager::setUser($user);
        SessionManager::regenerate();
        
        // Rediriger vers le dashboard approprié
        $dashboardRoutes = [
            'administrateur' => '/admin/dashboard',
            'enseignant' => '/enseignant/dashboard',
            'eleve' => '/eleve/dashboard',
            'directeur_discipline' => '/directeur_discipline/dashboard',
            'chef_classe' => '/chef_classe/dashboard',
            'prefet' => '/prefet/dashboard',
            'comite_parents' => '/comite_parents/dashboard',
            'tuteur' => '/tuteur/dashboard'
        ];
        
        $redirectUrl = $dashboardRoutes[$user['role']] ?? '/admin/dashboard';
        Router::redirect($redirectUrl);
    } else {
        SessionManager::flash('error', 'Email ou mot de passe incorrect');
        Router::redirect('/login');
    }
}

// Dispatcher la requête
echo Router::dispatch();
