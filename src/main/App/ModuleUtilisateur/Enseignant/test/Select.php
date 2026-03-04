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
    $enseignant = $dao->fincAllWithUser();


    if($enseignant){
            echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
        
        foreach($enseignant as $ens){ 
            if(is_object($ens)){
                 echo "<tr>";
                echo "<tr>";
                echo "<td>" . $ens->getIdUtilisateur() . "</td>";
                echo "<td>" . $ens->getNom() . "</td>";
                echo "<td>" . $ens->getPrenom() . "</td>";
                echo "<td>" . $ens->getEmail() . "</td>";
                echo "<td>" . $ens->getTelephone() . "</td>";
                echo "<td>" . $ens->getSexe() . "</td>";
                echo "<td>" . $ens->getDateCreation() . "</td>";
                echo "<td>" . $ens->getSexe() . "</td>";
                echo "<td>" . $ens->getDateEmbauche() . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='4'>❌ Enseignant n'est pas un objet</td></tr>";
            }  echo "<p>Nom: " . $ens->getNom() . " | Prénom: " . $ens->getPrenom() . " | Email: " . $ens->getEmail() . "</p>";
        }
    } else {
        echo "<p>Aucun élève trouvé.</p>";
    }
    echo "</table>";
}catch(Exception $e){
    echo "❌ Erreur : " . $e->getMessage();
}













?>