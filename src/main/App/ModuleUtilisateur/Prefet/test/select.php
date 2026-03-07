<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Prefet/Models/PrefetEnseignant.php';
require_once $root . '/ModuleUtilisateur/Prefet/Dao/PrefetEnseignantDAO.php';


use App\ModuleUtilisateur\Prefet\Models\PrefetEnseignant;
//use App\ModuleUtilisateur\App\ModuleUtilisateur\Prefet\Dao\PrefetEnseignantDAO;
//use PDO;
//use PDOException;
use App\ModuleUtilisateur\Prefet\Dao\PrefetEnseignantDAO;

echo "<h2>🧪 TEST PRÉFET ENSEIGNANT</h2>";

try{
$dao = new PrefetEnseignantDAO();
$prefet = $dao->findAllWithUserInfo();

if(! $prefet){
    echo "ECHCE D'AFFICHAGE";
}else{
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
    foreach ($prefet as $ins) {
        echo "<tr>";
        echo "<td>" . $ins->getIdUtilisateur() . "</td>";
        echo "<td>" . htmlspecialchars($ins->getNom()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getPrenom()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getEmail()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getTelephone()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getExperience()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getDepartement()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getEchelleCouleur()) . "</td>";
        echo "<td>" . htmlspecialchars($ins->getStatut()) . "</td>";

        echo "</tr>";
    }
    echo "</table>";
}



}catch(PDOException $e){
    echo "ERREUR".$e->getMessage();
}















?>