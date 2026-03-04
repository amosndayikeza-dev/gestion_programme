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

use App\ModuleUtilisateur\Proviseur\Models\Proviseur;
use App\ModuleUtilisateur\Proviseur\Dao\ProviseurDAO;

echo "<h2>🧪 TEST PROVISEUR</h2>";

try {
    $proviseur = new Proviseur();
    $proviseur->setNom('JAVA');
              $proviseur->setPrenom('JAVA');
              $proviseur->setEmail('JAVA' . time() . '@gmail.com');
              $proviseur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
              $proviseur->setRole('proviseur');
              $proviseur->setStatut('actif');
              $proviseur->setBureau('Bureau 101');
              $proviseur->setEtablissement('Don Bosco'); // Ajouté
              $proviseur->setDureeMandat(3); // Maintenant avec D majuscule si vous avez renommé
    
    $proviseurDAO = new ProviseurDAO();
    $result = $proviseurDAO->save($proviseur);
    
    if ($result === true) {
        echo "✅ Proviseur enregistré avec succès !";
    } else {
        // Si save retourne un tableau avec message
        $msg = is_array($result) ? $result['message'] : 'Erreur inconnue';
        echo "❌ Échec : $msg";
    }
    
} catch (Exception $e) {
    echo "❌ Exception : " . $e->getMessage();
}