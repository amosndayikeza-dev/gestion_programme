<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ ."/../../..";  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Eleve/Models/Eleve.php';
require_once $root . '/ModuleUtilisateur/Eleve/Dao/EleveDAO.php';  // ←


use App\ModuleUtilisateur\Dao\EleveDAO;
use App\ModuleUtilisateur\Eleve\Models\Eleve;


echo "<h2>🧪 TEST ELEVE</h2>";

   try {
    $eleveDAO = new EleveDAO();

    $eleve = $eleveDAO->findAllWithUser();
    if($eleve){
         echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
        
        foreach($eleve as $e){ 
            if(is_object($e)){
                echo "<tr>";
                echo "<td>" . $e->getIdUtilisateur() . "</td>";
                echo "<td>" . $e->getNom() . "</td>";
                echo "<td>" . $e->getPrenom() . "</td>";
                echo "<td>" . $e->getEmail() . "</td>";
                echo "<td>" . $e->getTelephone() . "</td>";
                echo "<td>" . $e->getDateNaissance() . "</td>";
                echo "<td>" . $e->getLieuNaissance() . "</td>";
                echo "<td>" . $e->getSexe() . "</td>";
                echo "<td>" . $e->getAdresse() . "</td>";
                echo "<td>" . $e->getDateInscription() . "</td>";
                echo "<td>" . $e->getMatricule() . "</td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='4'>❌ Directeur n'est pas un objet</td></tr>";
            }  echo "<p>Nom: " . $e->getNom() . " | Prénom: " . $e->getPrenom() . " | Email: " . $e->getEmail() . "</p>";
        }
    } else {
        echo "<p>Aucun élève trouvé.</p>";
    }
    echo "</table>";

   }catch (Exception $e){
        echo "Erreur : " . $e->getMessage();
   }


















?>