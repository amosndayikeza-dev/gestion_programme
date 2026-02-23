<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Models/Enseignant.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Dao/EnseignantDAO.php';  // ←

use App\ModuleUtilisateur\Enseignant\Dao\EnseignantDAO;
use App\ModuleUtilisateur\Enseignant\Models\Enseignant;

echo "<h2>🧪 TEST ENSEIGNANT</h2>";
try{
        
    $enseignant = new Enseignant();
    $enseignant->setNom('NDUWIMANA');
    $enseignant->setPrenom('Alice');
    $enseignant->setEmail('alice' . time() . '@gmail.com');
    $enseignant->setMotDePasse(password_hash('123', PASSWORD_DEFAULT)); 
    $enseignant->setGrade('Maître de conférences');
    $enseignant->setSpecialite('Informatique');
    $enseignant->setStatut('Actif');    
    $enseignant->setDateEmbauche(date('Y-m-d'));
    $enseignant->setTelephone('0701234567');        

    $dao = new EnseignantDAO();
    $resultat = $dao->save($enseignant);
    if ($resultat) {
        echo "✅ Enseignant enregistré ! ID: " . $enseignant->getIdUtilisateur();
    } else {
        echo "❌ Échec";
    }
}catch(Exception $e){
    echo "❌ Erreur: " . $e->getMessage();
}

?>












?>