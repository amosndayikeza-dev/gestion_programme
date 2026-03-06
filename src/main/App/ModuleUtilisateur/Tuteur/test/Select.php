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
$tuteur = $dao->findAllWithUserInfos(60); // Remplacez 1 par un ID de titulaire existant

if(!$tuteur) {
    echo "❌ Tuteur non trouvé";
}else{
   
    // Affichage sous forme de tableau HTML
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>ID Titulaire</th>
                <th>ID Utilisateur</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Téléphone</th>
                <th>Établissement</th>
                <th>Bureau</th>
                <th>Durée mandat</th>
              </tr>";
        
        foreach ($tuteur as $tu) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($tu->getIdTuteur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getIdUtilisateur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getNom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getPrenom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getEmail() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getRole() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getStatut() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getTelephone() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getProfession() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getAdresse() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($tu->getPieceIdentite() ?? '') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }


}catch(Exception $e){
    echo "❌ Exception : " . $e->getMessage();  
}
















?>