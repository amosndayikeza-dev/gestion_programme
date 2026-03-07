<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Models/Enseignant.php';
require_once $root . '/ModuleUtilisateur/Enseignant/Dao/EnseignantDAO.php';

use App\ModuleUtilisateur\Enseignant\Dao\EnseignantDAO;
use App\ModuleUtilisateur\Enseignant\Models\Enseignant;
echo "<h2>🧪 TEST DE LA FONCTION FIND (SELECT) POUR ENSEIGNANT</h2>";

try{
    $dao = new EnseignantDAO();
    $enseignant = $dao->findAllWithUser();

if ($enseignant) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Téléphone</th><th>Sexe</th><th>Date création</th><th>Date embauche</th></tr>";

    foreach ($enseignant as $ens) {
        if (is_object($ens)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($ens->getIdUtilisateur() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getNom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getPrenom() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getEmail() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getTelephone() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getSexe() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getDateCreation() ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($ens->getDateEmbauche() ?? '') . "</td>";
            echo "</tr>";
        } else {
            echo "<tr><td colspan='8'>❌ Enseignant n'est pas un objet</td></tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p>Aucun enseignant trouvé.</p>";
}
}catch(Exception $e){
    echo "❌ Erreur : " . $e->getMessage();
}













?>