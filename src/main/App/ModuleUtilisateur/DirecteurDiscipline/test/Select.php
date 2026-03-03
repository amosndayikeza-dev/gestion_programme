<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Models/DirecteurDiscipline.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Dao/DirecteurDisciplineDAO.php';

use App\ModuleUtilisateur\DirecteurDiscipline\Dao\DirecteurDisciplineDAO;

echo "<h2>🗑️ TEST AFFICHAGE DIRECTEURS</h2>";

try {
    $dao = new DirecteurDisciplineDAO();
    
    // Récupérer tous les directeurs
    $directeurs = $dao->findAllWithUser();
    
    if(empty($directeurs)){
        echo "❌ Aucun directeur trouvé";
    } else {
        echo "<h3>📋 Liste des directeurs :</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Bureau</th></tr>";
        
        foreach($directeurs as $dir){
            if(is_object($dir)){
                echo "<tr>";
                echo "<td>" . $dir->getIdUtilisateur() . "</td>";
                echo "<td>" . $dir->getNom() . "</td>";
                echo "<td>" . $dir->getPrenom() . "</td>";
                echo "<td>" . $dir->getBureau() . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='4'>❌ Directeur n'est pas un objet</td></tr>";
            }
        }
        echo "</table>";
        
        // Afficher le premier directeur avec findWithUser
        if(!empty($directeurs)){
            $id = $directeurs[0]->getIdUtilisateur();
            $dir = $dao->findWithUser($id);
            
            if($dir){
                echo "<h3>🔍 Détails du premier directeur (ID: $id) :</h3>";
                // CORRECTION ICI : Utiliser les getters, pas la notation tableau
                echo "Nom : " . $dir->getNom() . "<br>";
                echo "Prénom : " . $dir->getPrenom() . "<br>";
                echo "Bureau : " . $dir->getBureau() . "<br>";
                echo "Email : " . $dir->getEmail() . "<br>";
            }
        }
    }
    
} catch(Exception $e) {  // PDOException ou Exception
    echo "❌ ERREUR: " . $e->getMessage() . "<br>";
    echo "Fichier: " . $e->getFile() . "<br>";
    echo "Ligne: " . $e->getLine() . "<br>";
}
?>