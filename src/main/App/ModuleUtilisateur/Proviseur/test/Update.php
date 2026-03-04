<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chemins absolus plus robustes
$baseDir = dirname(__DIR__, 3); // remonte de 3 niveaux depuis ce fichier
require_once $baseDir . '/core/config/Database.php';
require_once $baseDir . '/core/config/Model.php';
require_once $baseDir . '/ModuleUtilisateur/Models/Utilisateur.php'; // Attention à la casse
require_once $baseDir . '/ModuleUtilisateur/Proviseur/Models/Proviseur.php';
require_once $baseDir . '/ModuleUtilisateur/Proviseur/Dao/ProviseurDAO.php';

//use App\ModuleUtilisateur\Proviseur\Models\Proviseur;
use App\ModuleUtilisateur\Proviseur\Dao\ProviseurDAO;

echo "<h2>🧪 TEST PROVISEUR</h2>";

try{
    $dao = new ProviseurDAO();
    $proviseur = $dao->findWithUser(52); // Remplacez 1 par un ID de proviseur existant
    
    if($proviseur){
        echo "✅ Proviseur trouvé : " . $proviseur->getNom() . " " . $proviseur->getPrenom() . "<br>";
        
        // Mise à jour de l'établissement
        $proviseur->setEtablissement("Lycée Mis à Jour");
        
        // Sauvegarde de la mise à jour
        $result = $dao->save($proviseur);
        
        if($result === true){
            echo "✅ Proviseur mis à jour avec succès !";
        } else {
            echo "❌ Échec de la mise à jour : " . (is_array($result) ? $result['message'] : 'Erreur inconnue');
        }
    } else {
        echo "❌ Aucun proviseur trouvé avec cet ID.";
    }
} catch(Exception $e){
    echo "❌ Exception : " . $e->getMessage();  

    }










?>