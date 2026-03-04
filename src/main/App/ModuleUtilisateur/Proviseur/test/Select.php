<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chemins absolus (adaptez selon votre structure)
$baseDir = dirname(__DIR__, 3); // remonte de 3 niveaux depuis ce fichier
require_once $baseDir . '/core/config/Database.php';
require_once $baseDir . '/core/config/Model.php';
require_once $baseDir . '/ModuleUtilisateur/Models/Utilisateur.php';
require_once $baseDir . '/ModuleUtilisateur/Proviseur/Models/Proviseur.php';
require_once $baseDir . '/ModuleUtilisateur/Proviseur/Dao/ProviseurDAO.php';

use App\ModuleUtilisateur\Proviseur\Dao\ProviseurDAO;

echo "<h2>🧪 LISTE DES PROVISEURS</h2>";

try {
    $dao = new ProviseurDAO();
    $proviseurs = $dao->findAllWithUserInfos(); // Retourne un tableau d'objets Proviseur

    if (empty($proviseurs)) {
        echo "<p>❌ Aucun proviseur trouvé.</p>";
    } else {
        echo "<p>✅ Nombre de proviseurs : " . count($proviseurs) . "</p>";
        
        // Affichage sous forme de tableau HTML
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>ID Proviseur</th>
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
        
        foreach ($proviseurs as $p) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($p->getIdProviseur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getIdUtilisateur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getNom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getPrenom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getEmail() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getRole() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getStatut() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getTelephone() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getEtablissement() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getBureau() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($p->getDureeMandat() ?? '') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        // Affichage brut pour déboguer (optionnel)
        echo "<h3>🔍 Données brutes :</h3>";
        echo "<pre>";
        //print_r($proviseurs);
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Exception : " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>