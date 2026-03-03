<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ ."/../../..";  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Eleve/Models/Eleve.php';
require_once $root . '/ModuleUtilisateur/Eleve/Dao/EleveDAO.php';  // ←


use App\ModuleUtilisateur\Dao\EleveDAO;
use App\ModuleUtilisateur\Eleve\Models\Eleve;


echo "<h2>🧪 TEST ELEVE</h2>";

try{
    
    $eleveDAO = new EleveDAO();
    $eleve = $eleveDAO->findWithUser(205);
    if(!$eleve){
        die("Élève non trouvé.");
    }
    // 3. Modifier
    $eleve->setNom('Flora' . time());
    $eleve->setAdresse('Nouvelle adresse, Kigali');
    $eleve->setSexe('Feminin');
    // 4. Sauvegarder
    $result = $eleveDAO->updateEleve($eleve);
        if($result){
            echo "<p>✅ Élève modifié avec succès !</p>";
        } else {
            echo "<p>❌ Échec de la modification.</p>";
        }

}catch(Exception $e){
    die("ERREUR: " . $e->getMessage());  
}










?>