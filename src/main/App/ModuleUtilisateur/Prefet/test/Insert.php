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

echo "<h2>🧪 TEST PRÉFET ENSEIGNANT</h2>";

try{
    $prefetEnseignant = new PrefetEnseignant();
    $prefetEnseignant->setNom('KABURA');
    $prefetEnseignant->setPrenom('Jean');
    $prefetEnseignant->setEmail('jean' . time() . '@gmail.com');
    $prefetEnseignant->setTelephone("0701234567");
    $prefetEnseignant->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $prefetEnseignant->setRole("prefet");
    $prefetEnseignant->setStatut('actif');

    $prefetEnseignant->setDateCreation(date('Y-m-d H:i:s'));
    $prefetEnseignant->setDerniereConnexion(date('Y-m-d H:i:s'));
    //$prefetEnseignant->setDateEmbauche(date('Y-m-d'));
    $prefetEnseignant->setTelephone('0701234567');
    $prefetEnseignant->setDepartement('Informatique');
    $prefetEnseignant->setSpecialite('Développement Web');
    $prefetEnseignant->setEchelleTraitement(10);
    
     // ID de l'enseignant existant

    $dao = new PrefetEnseignantDAO();
    $result = $dao->save($prefetEnseignant);

    if (!$result) {
       
        echo "❌ Échec de l'enregistrement.";
    } else {
         echo "✅ Préfet-Enseignant enregistré !";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}


















?>