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
    $tuteur = new Tuteur();
    $tuteur->setNom('TUTEUR');
              $tuteur->setPrenom('TUTEUR');
              $tuteur->setEmail('TUTEUR' . time() . '@gmail.com');
              $tuteur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
              $tuteur->setRole('tuteur');
              $tuteur->setStatut('actif');
                $tuteur->setProfession('Enseignant');
                $tuteur->setAdresse('123 Rue du Tuteur, Ville');
                $tuteur->setLienParental('Parent');
                $tuteur->setPieceIdentite("Passeport");

    $dao = new TuteurDAO();
    $result = $dao->save($tuteur);   
    echo "<p>Tuteur enregistré avec succès : " . ($result ? "Oui" : "Non") . "</p>";
}catch(Exception $e){
    echo "❌ Exception : " . $e->getMessage();  
}











?>
























