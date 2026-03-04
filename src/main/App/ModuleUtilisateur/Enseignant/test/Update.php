<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Models/Enseignant.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Dao/EnseignantDAO.php';

use App\ModuleUtilisateur\Enseignant\Dao\EnseignantDAO;
use App\ModuleUtilisateur\Enseignant\Models\Enseignant;

echo "<h2>🧪 TEST ENSEIGNANT</h2>";

try{
    $enseignantDao = new EnseignantDAO();
    $enseignant = $enseignantDao->findWithUser(52);
    if(!$enseignant){
        die("Enseignant non trouvé.");
    }
    $enseignant->setNom('Grace' . time());
    $enseignant->setPrenom('Alice' . time());
    $enseignant->setEmail('alice' . time() . '@gmail.com');
    $enseignant->setMotDePasse(password_hash('123', PASSWORD_DEFAULT)); 
    $enseignant->setGrade('Maître de conférences');
    $enseignant->setSpecialite('Informatique');
    $enseignant->setStatut('Actif');    
    $enseignant->setRole('enseignant');
    $enseignant->setTelephone('0701234567');        
    
    $resultat = $enseignantDao->updateEnseignant($enseignant);
    if($resultat){
        echo "✅ Enseignant mis à jour avec succès.";
    }else{
        echo "❌ Échec de la mise à jour de l'enseignant.";
    }
}
catch(Exception $e){
    echo "❌ Erreur: " . $e->getMessage();
}
?>
<?php










?>