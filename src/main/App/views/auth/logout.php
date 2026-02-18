<?php
/**
 * Script de déconnexion
 */
session_start();

// Destruction de la session
session_destroy();

// Redirection vers la page de connexion avec message
header('Location: /auth/login?success=' . urlencode('Vous avez été déconnecté avec succès'));
exit;

/**
 * Composant LogoutButton pour inclusion dans les interfaces
 */
class LogoutButton extends Component {
    private $redirectUrl;
    private $variant;
    
    public function __construct(array $options = []) {
        $this->redirectUrl = $options['redirect'] ?? '/auth/login';
        $this->variant = $options['variant'] ?? 'outline';
        
        parent::__construct($options);
    }
    
    public function render(): string {
        $buttonClasses = Theme::getButtonClasses($this->variant);
        
        return '
        <form action="/gestion_programme/logout.php" method="POST" class="inline">
            <button type="submit" 
                    class="' . implode(' ', $buttonClasses) . '"
                    onclick="return confirm(\'Êtes-vous sûr de vouloir vous déconnecter?\')">
                <i class="fas fa-sign-out-alt mr-2"></i>
                Déconnexion
            </button>
        </form>';
    }
}

/**
 * Middleware d'authentification
 */
class AuthMiddleware {
    public static function requireAuth() {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login?error=' . urlencode('Vous devez être connecté pour accéder à cette page'));
            exit;
        }
    }
    
    public static function requireRole(array $allowedRoles) {
        self::requireAuth();
        
        $userRole = $_SESSION['user']['role'] ?? null;
        
        if (!in_array($userRole, $allowedRoles)) {
            header('Location: /auth/login?error=' . urlencode('Vous n\'avez pas les permissions nécessaires pour accéder à cette page'));
            exit;
        }
    }
    
    public static function getUser() {
        return $_SESSION['user'] ?? null;
    }
    
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }
    
    public static function hasRole(string $role): bool {
        return self::isLoggedIn() && ($_SESSION['user']['role'] ?? null) === $role;
    }
}

/**
 * Service d'authentification
 */
class AuthService {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    public function login(string $email, string $password): ?array {
        try {
            // Recherche de l'utilisateur
            $stmt = $this->db->prepare("
                SELECT u.*, e.nom as nom_eleve, e.prenom as prenom_eleve,
                       en.nom as nom_enseignant, en.prenom as prenom_enseignant
                FROM utilisateur u
                LEFT JOIN eleve e ON u.id_utilisateur = e.id_eleve AND u.role = 'eleve'
                LEFT JOIN enseignant en ON u.id_utilisateur = en.id_enseignant AND u.role = 'enseignant'
                WHERE u.email = ? AND u.statut = 'actif'
            ");
            
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user || !password_verify($password, $user['mot_de_passe'])) {
                return null;
            }
            
            // Mise à jour de la dernière connexion
            $this->updateLastLogin($user['id_utilisateur']);
            
            // Préparation des données de session
            $sessionData = [
                'id_utilisateur' => $user['id_utilisateur'],
                'email' => $user['email'],
                'role' => $user['role'],
                'nom' => $this->getUserName($user),
                'photo' => $user['photo_profil'] ?? '/assets/images/default-avatar.png',
                'date_creation' => $user['date_creation'],
                'last_login' => date('Y-m-d H:i:s')
            ];
            
            // Stockage en session
            $_SESSION['user'] = $sessionData;
            
            return $sessionData;
            
        } catch (Exception $e) {
            error_log('Erreur de connexion: ' . $e->getMessage());
            return null;
        }
    }
    
    private function getUserName(array $user): string {
        if ($user['role'] === 'eleve' && $user['nom_eleve']) {
            return $user['nom_eleve'] . ' ' . $user['prenom_eleve'];
        }
        
        if ($user['role'] === 'enseignant' && $user['nom_enseignant']) {
            return $user['nom_enseignant'] . ' ' . $user['prenom_enseignant'];
        }
        
        return $user['nom'] . ' ' . $user['prenom'];
    }
    
    private function updateLastLogin(int $userId): void {
        try {
            $stmt = $this->db->prepare("
                UPDATE utilisateur 
                SET last_login = NOW() 
                WHERE id_utilisateur = ?
            ");
            $stmt->execute([$userId]);
        } catch (Exception $e) {
            error_log('Erreur mise à jour last login: ' . $e->getMessage());
        }
    }
    
    public function logout(): void {
        session_destroy();
    }
    
    public function register(array $userData): ?array {
        try {
            // Validation des données
            if (!$this->validateRegistrationData($userData)) {
                return null;
            }
            
            // Hash du mot de passe
            $userData['mot_de_passe'] = password_hash($userData['mot_de_passe'], PASSWORD_DEFAULT);
            
            // Insertion de l'utilisateur
            $stmt = $this->db->prepare("
                INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role, date_creation)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $userData['nom'],
                $userData['prenom'],
                $userData['email'],
                $userData['mot_de_passe'],
                $userData['role']
            ]);
            
            $userId = $this->db->lastInsertId();
            
            // Création des données spécifiques selon le rôle
            $this->createRoleSpecificData($userId, $userData);
            
            // Connexion automatique
            return $this->login($userData['email'], $userData['plain_password']);
            
        } catch (Exception $e) {
            error_log('Erreur d\'inscription: ' . $e->getMessage());
            return null;
        }
    }
    
    private function validateRegistrationData(array $userData): bool {
        $required = ['nom', 'prenom', 'email', 'mot_de_passe', 'role'];
        
        foreach ($required as $field) {
            if (empty($userData[$field])) {
                return false;
            }
        }
        
        // Validation email
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Validation mot de passe
        if (strlen($userData['mot_de_passe']) < 8) {
            return false;
        }
        
        return true;
    }
    
    private function createRoleSpecificData(int $userId, array $userData): void {
        try {
            switch ($userData['role']) {
                case 'eleve':
                    $stmt = $this->db->prepare("
                        INSERT INTO eleve (id_eleve, matricule, nom, prenom, email, date_inscription)
                        VALUES (?, ?, ?, ?, ?, NOW())
                    ");
                    $matricule = 'ELE' . date('Y') . str_pad($userId, 4, '0', STR_PAD_LEFT);
                    $stmt->execute([$userId, $matricule, $userData['nom'], $userData['prenom'], $userData['email']]);
                    break;
                    
                case 'enseignant':
                    $stmt = $this->db->prepare("
                        INSERT INTO enseignant (id_enseignant, matricule, nom, prenom, email, grade)
                        VALUES (?, ?, ?, ?, ?, 'A1')
                    ");
                    $matricule = 'ENS' . date('Y') . str_pad($userId, 4, '0', STR_PAD_LEFT);
                    $stmt->execute([$userId, $matricule, $userData['nom'], $userData['prenom'], $userData['email']]);
                    break;
            }
        } catch (Exception $e) {
            error_log('Erreur création données spécifiques: ' . $e->getMessage());
        }
    }
}
