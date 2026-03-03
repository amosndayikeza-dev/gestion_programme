<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/config/Database.php';
require_once __DIR__ . '/../core/config/Model.php';
require_once __DIR__ . '/../ModuleUtilisateur/models/Utilisateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Models/Administrateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Dao/AdminDAO.php';

use App\ModuleUtilisateur\Models\Admin\Administrateur;
use App\ModuleUtilisateur\Admin\Dao\AdminDAO;

echo "<h2>🧪 TEST D'INSERTION ADMIN</h2>";

try {
    // CRÉATION DE L'ADMIN
    $admin = new Administrateur();
    
    // Données pour la table utilisateur
    $admin->setNom('Joe');
    $admin->setPrenom('Michel');
    $admin->setEmail('joe' . time() . '@email.com');
    $admin->setMotDePasse(password_hash('445', PASSWORD_DEFAULT));
    $admin->setRole('administrateur');
    $admin->setStatut('actif');
    $admin->setDateCreation(date('Y-m-d H:i:s'));
    $admin->setTelephone('665655555');
    
    // Données pour la table administrateurs
    $admin->setNiveauAcces(60);
    $admin->setDepartement('FC');
    $admin->setDatePriseFonction(date('Y-m-d'));
    $admin->setNiveauAudit('basique');
    $admin->setAuthentification2Facteurs(false);
    
    echo "✅ Admin créé: " . $admin->getNom() . " " . $admin->getPrenom() . "<br>";
    echo "📧 Email: " . $admin->getEmail() . "<br>";
    
    // SAUVEGARDER
    $dao = new AdminDAO();
    $resultat = $dao->save($admin);
    
    if ($resultat) {
        echo "<span style='color:green; font-weight:bold'>✅ INSERTION RÉUSSIE !</span><br>";
        echo "ID Utilisateur: " . $admin->getIdUtilisateur() . "<br>";
        echo "ID Administrateur: " . $admin->getIdAdministrateur() . "<br>";
        echo "<br>🔍 Allez vérifier dans phpMyAdmin :<br>";
        echo "- Table <strong>utilisateur</strong> (id_utilisateur = " . $admin->getIdUtilisateur() . ")<br>";
        echo "- Table <strong>administrateurs</strong> (id_administrateur = " . $admin->getIdAdministrateur() . ")<br>";
    } else {
        echo "<span style='color:red; font-weight:bold'>❌ ÉCHEC DE L'INSERTION</span><br>";
    }
    
} catch (Exception $e) {
    echo "<span style='color:red; font-weight:bold'>❌ ERREUR: " . $e->getMessage() . "</span><br>";
}
?>
