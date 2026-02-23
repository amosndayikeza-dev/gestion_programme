<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/config/Database.php';
require_once __DIR__ . '/../core/config/Model.php';
require_once __DIR__ . '/../ModuleUtilisateur/models/Utilisateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Models/Administrateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Dao/AdminDao.php';

use App\ModuleUtilisateur\Models\Admin\Administrateur;
use App\ModuleUtilisateur\Admin\Dao\AdminDAO;

echo "<h2>🧪 TEST D'INSERTION ADMIN</h2>";
try {
    // CRÉATION SANS CONSTRUCTEUR (utilisation des setters)
    $admin = new Administrateur();
    
    // Valeurs REQUISES pour utilisateurs
    $admin->setNom('NDAYIKEA');
    $admin->setPrenom('Amos');
    $admin->setEmail('Amos' . time() . '@email.com'); // Email unique
    $admin->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $admin->setRole('administrateur');
    $admin->setStatut('actif');
    $admin->setDateCreation(date('Y-m-d H:i:s'));
    
    // Valeurs REQUISES pour administrateurs
    $admin->setNiveauAcces(3);
    $admin->setDepartement('IT');
    $admin->setDatePriseFonction(date('Y-m-d'));
    
    // Valeurs OPTIONNELLES
    $admin->setTelephone('0123456789');
    $admin->setAuthentification2Facteurs(false);
    $admin->setNiveauAudit('basique');
    
    echo "✅ Admin créé: " . $admin->getNom() . "<br>";
    
    // SAUVEGARDER
    $dao = new AdminDAO();
    $resultat = $dao->save($admin);
    
    if ($resultat) {
        echo "<span style='color:green'>✅ INSERTION RÉUSSIE !</span><br>";
        echo "ID Utilisateur: " . $admin->getIdUtilisateur() . "<br>";
        echo "ID Administrateur: " . $admin->getIdAdministrateur() . "<br>";
    } else {
        echo "<span style='color:red'>❌ ÉCHEC DE L'INSERTION</span><br>";
    }
    
} catch (Exception $e) {
    echo "<span style='color:red'>❌ ERREUR: " . $e->getMessage() . "</span><br>";
    echo "Fichier: " . $e->getFile() . "<br>";
    echo "Ligne: " . $e->getLine() . "<br>";
}
?>