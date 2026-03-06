<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chemins absolus plus robustes
$baseDir = dirname(__DIR__, 3); // remonte de 3 niveaux depuis ce fichier
require_once $baseDir . '/core/config/Database.php';
require_once $baseDir . '/core/config/Model.php';
require_once $baseDir . '/ModuleUtilisateur/Models/Utilisateur.php'; // Attention à la casse
require_once $baseDir . '/ModuleUtilisateur/Tuteur/Models/Tuteur.php';
require_once $baseDir . '/ModuleUtilisateur/Tuteur/Dao/TuteurDAO.php';


use App\ModuleUtilisateur\Tuteur\Dao\TuteurDAO;
use App\ModuleUtilisateur\Tuteur\Models\Tuteur;

echo "<h2>🧪 TEST PROVISEUR</h2>";

try{
    $dao = new TuteurDAO();
    $tutteur = $dao->findWithUser(60);

    $tutteur->setNom("NDAYIKEZA");

    $result = $dao->updateTuteur($tutteur);

    if(!$tutteur){
        echo "Modification echoue .";
    }else{
        echo "Modification reussie .";
    }

}catch(PDOException $e){
    echo "ERREUR" .$e->getMessage();
}













?>