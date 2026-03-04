<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Models/Inspecteur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Dao/InspecteurDAO.php';

use App\ModuleUtilisateur\Inspecteur\Dao\InspecteurDAO;
use App\ModuleUtilisateur\Inspecteur\Models\Inspecteur;
echo "<h2>🧪 TEST DE LA FONCTION FIND (SELECT) POUR INSPECTEUR</h2>";

try{
    $dao = new InspecteurDAO();
    $inspecteurs = $dao->findAllWithUserInfo();

    if($inspecteurs){
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
        
        foreach($inspecteurs as $insp){ 
            if(is_object($insp)){
                 echo "<tr>";
                echo "<td>" . $insp->getIdUtilisateur() . "</td>";
                echo "<td>" . $insp->getNom() . "</td>";
                echo "<td>" . $insp->getPrenom() . "</td>";
                echo "<td>" . $insp->getEmail() . "</td>";
                echo "<td>" . $insp->getTelephone() . "</td>";
                echo "<td>" . $insp->getGrade() . "</td>";
                echo "<td>" . $insp->getDateCreation() . "</td>";
                echo "<td>" . $insp->getDateNomination() . "</td>";
                echo "<td>" . $insp->getZoneGeographique() . "</td>";
                echo "<td>" . $insp->getStatutMission() . "</td>";
                echo "<td>" . $insp->getStatut() . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='4'>❌ Inspecteur n'est pas un objet</td></tr>";
            }  echo "<p>Nom: " . $insp->getNom() . " | Prénom: " . $insp->getPrenom() . " | Email: " . $insp->getEmail() . "</p>";
        }
        echo "</table>";
    } else {
        echo "<p>Aucun inspecteur trouvé.</p>";
    }
}catch(Exception $e){
    echo "❌ Erreur : " . $e->getMessage();
}













?>