<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Proviseur/Models/Proviseur.php';
require_once $root . '/ModuleUtilisateur/Proviseur/Dao/ProviseurDAO.php';

use App\ModuleUtilisateur\Proviseur\Models\Proviseur;
use App\ModuleUtilisateur\Proviseur\Dao\ProviseurDAO;

echo "<h2>🧪 TEST PROVISEUR</h2>";

try {
    $proviseur = new Proviseur();
    $proviseur->setNom('JAVA');
    $proviseur->setPrenom('JAVA');
    $proviseur->setEmail('JAVA' . time() . '@gmail.com');
    $proviseur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $proviseur->setRole('proviseur');
    $proviseur->setStatut('actif');
    $proviseur->setDateCreation(date('Y-m-d H:i:s'));
    $proviseur->setBureau('Bureau 101');
    // $proviseur->setTelephonePro('0708091011');
    $proviseur->setDureeMandat(3);  // ← CORRIGÉ (D majuscule)
    
    $proviseurDAO = new ProviseurDAO();
    $result = $proviseurDAO->save($proviseur);
    
    if ($result) {
        echo "✅ Proviseur enregistré avec succès !";
    } else {
        echo "❌ Échec de l'enregistrement";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>