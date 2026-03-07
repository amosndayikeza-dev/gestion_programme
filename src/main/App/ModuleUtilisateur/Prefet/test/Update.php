<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Prefet/Models/PrefetEnseignant.php';
require_once $root . '/ModuleUtilisateur/Prefet/Dao/PrefetEnseignantDAO.php';


use App\ModuleUtilisateur\Prefet\Models\PrefetEnseignant;
//use App\ModuleUtilisateur\App\ModuleUtilisateur\Prefet\Dao\PrefetEnseignantDAO;

use App\ModuleUtilisateur\Prefet\Dao\PrefetEnseignantDAO;

echo "<h2>🧪 TEST MISE À JOUR PRÉFET ENSEIGNANT</h2>";
try{
    $dao = new PrefetEnseignantDAO();
    
    // 1. Récupérer TOUS les préfets existants
    $prefets = $dao->findAllWithUserInfo();
    if (empty($prefets)) {
        throw new Exception("Aucun préfet trouvé pour le test de mise à jour.");
    }
    $prefet = $prefets[0]; // Prendre le premier préfet trouvé
    
    echo "✅ Préfet trouvé: " . $prefet->getNom() . " " . $prefet->getPrenom() . "<br>";
    
    // 2. Modifier les informations du préfet
    $timestamp = time();
    $prefet->setNom('NDAYIKEZA' . $timestamp);
    $prefet->setPrenom('Amos');
    $prefet->setEchelleTraitement($timestamp);

    // 3. Mettre à jour le préfet dans la base de données
    $result = $dao->updatePrefet($prefet);
    if($result){
        echo "✅ Préfet-Enseignant mis à jour avec succès !";
    } else {
        echo "❌ Échec de la mise à jour.";
    }
}catch(Exception $e){
    echo "❌ Erreur: " . $e->getMessage();
}


















?>