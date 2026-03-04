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
echo "<h2>🧪 TEST TITULAIRE - SELECT</h2>";

try{
    $dao = new TitulaireDAO();
    $titulaire = $dao->findAllWithUserInfos(); // Remplacez 1 par un ID de titulaire existant
    
    if(empty($titulaire)){
        echo "❌ Aucun titulaire trouvé.";
    } else {
        echo "<p>✅ Nombre de titulaires : " . count($titulaire) . "</p>";
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
        
        foreach ($titulaire as $t) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($t->getIdTitulaire() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getIdUtilisateur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getNom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getPrenom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getEmail() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getRole() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getStatut() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getTelephone() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getMatierePrincipale() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getVolumeHoraire() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($t->getDateCreation() ?? '') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }

}catch(Exception $e){
    echo "❌ Exception : " . $e->getMessage();
}













?>