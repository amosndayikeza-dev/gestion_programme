<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/config/Database.php';
require_once __DIR__ . '/../core/config/Model.php';
require_once __DIR__ . '/../ModuleUtilisateur/models/Utilisateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Models/Administrateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Dao/AdminDao.php';


// CORRECTION 1 : Le chemin du namespace
use App\ModuleUtilisateur\Admin\Models\Administrateur;  // ← Changé !
use App\ModuleUtilisateur\Admin\Dao\AdminDAO;

echo "<h2>📋 TEST AFFICHAGE</h2>";

try {
    $dao = new AdminDAO();
    
    // 1. TEST findAll() - Tous les admins
    echo "<h3>1. Tous les admins :</h3>";
    
    // CORRECTION 2 : "all()" avec minuscule
    $admins = $dao->all();  // ← "all" pas "All"
    
    // DEBUG : Afficher ce que retourne all()
    echo "Nombre d'admins trouvés: " . count($admins) . "<br>";
    
    if (empty($admins)) {
        echo "Aucun admin trouvé<br>";
    } else {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Département</th><th>Niveau</th></tr>";
        
        foreach ($admins as $admin) {
            // DEBUG : Vérifier que admin est un objet
            if (is_object($admin)) {
                echo "<tr>";
                echo "<td>" . $admin->getIdUtilisateur() . "</td>";
                echo "<td>" . $admin->getNom() . "</td>";
                echo "<td>" . $admin->getPrenom() . "</td>";
                echo "<td>" . $admin->getEmail() . "</td>";
                echo "<td>" . $admin->getDepartement() . "</td>";
                echo "<td>" . $admin->getNiveauAcces() . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='6'>Erreur: admin n'est pas un objet</td></tr>";
            }
        }
        echo "</table>";
    }
    
    // 2. TEST findWithUser() - Un admin spécifique
    if (!empty($admins)) {
        $id = $admins[0]->getIdUtilisateur();
        echo "<h3>2. Admin avec ID $id :</h3>";
        
        $admin = $dao->findWithUser($id);
        if ($admin) {
            echo "Nom: " . $admin->getNom() . "<br>";
            echo "Email: " . $admin->getEmail() . "<br>";
            echo "Département: " . $admin->getDepartement() . "<br>";
        } else {
            echo "Admin non trouvé<br>";
        }
    }
    
    // 3. TEST count()
    echo "<h3>3. Nombre total d'admins :</h3>";
    echo $dao->count() . " admin(s)";
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage();
}
?>