<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chemins absolus plus robustes
$baseDir = dirname(__DIR__, 3); // remonte de 3 niveaux depuis ce fichier
require_once $baseDir . '/core/config/Database.php';
require_once $baseDir . '/core/config/Model.php';
require_once $baseDir . '/ModuleUtilisateur/Models/Utilisateur.php'; // Attention à la casse
require_once $baseDir . '/ModuleUtilisateur/Titulaire/Models/Titulaire.php';
require_once $baseDir . '/ModuleUtilisateur/Titulaire/Dao/TitulaireDAO.php';


use App\ModuleUtilisateur\Titulaire\Dao\TitulaireDAO;
use App\ModuleUtilisateur\Titulaire\Models\Titulaire;


echo "<h2>🧪 TEST PROVISEUR</h2>";

try{
    $titulaire = new Titulaire();
    $titulaire->setNom('TITULAIRE');
              $titulaire->setPrenom('TITULAIRE');
              $titulaire->setEmail('TITULAIRE' . time() . '@gmail.com');
              $titulaire->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
              $titulaire->setRole('titulaire');
              $titulaire->setStatut('actif');
    $titulaire->setMatierePrincipale('Mathématiques');
    $titulaire->setVolumeHoraire(20);


    $dao = new TitulaireDAO();
    $result = $dao->save($titulaire);   
    echo "<p>Titulaire enregistré avec succès : " . ($result ? "Oui" : "Non") . "</p>";
}catch(Exception $e){
    echo "❌ Exception : " . $e->getMessage();  
}











?>