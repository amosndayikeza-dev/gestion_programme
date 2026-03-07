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

    $inspecteurs = $dao->findAllWithUser(); // Retourne un tableau
    if ($inspecteurs) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
        foreach ($inspecteurs as $ins) {
            echo "<tr>";
            echo "<td>" . $ins->getIdUtilisateur() . "</td>";
            echo "<td>" . htmlspecialchars($ins->getNom()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getPrenom()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getEmail()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getTelephone()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getExperience()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getGrade()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getZoneGeographique()) . "</td>";
            echo "<td>" . htmlspecialchars($ins->getStatut()) . "</td>";

            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "<p>Aucun inspecteur trouvé.</p>";
    }
}catch(Exception $e){
        echo "❌ Erreur : " . $e->getMessage();
}













?>