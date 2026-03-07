<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';
require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Models/Inspecteur.php';
require_once $root . '/ModuleUtilisateur/Inspecteur/Dao/InspecteurDAO.php';

use  App\ModuleUtilisateur\Inspecteur\Dao\InspecteurDAO;
use App\ModuleUtilisateur\Inspecteur\Models\Inspecteur; // ← CORRIGÉ !

echo "<h2>🧪 TEST INSPECTEUR</h2>";
// Afficher le chemin réel du fichier Utilisateur chargé
$reflector = new ReflectionClass('App\ModuleUtilisateur\Models\Utilisateur');
echo "Fichier Utilisateur chargé: " . $reflector->getFileName() . "<br>";
try {
    $inspecteurDAO = new InspecteurDAO();
    $inspecteur = $inspecteurDAO->findWithUserInfo(95);
    
    if (!$inspecteur) {
        die("❌ Inspecteur non trouvé.");
    }
    
    echo "<p>✅ Inspecteur trouvé: " . $inspecteur->getNom() . " " . $inspecteur->getPrenom() . "</p>";
    
    
    $timestamp = time();
    $inspecteur->setNom('VIVA_' . $timestamp);
    $inspecteur->setPrenom('Dupont_' . $timestamp);
    $inspecteur->setEmail('jean.dupont.' . $timestamp . '@gmail.com');
    $inspecteur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $inspecteur->setStatut('actif');
    //$inspecteur->setRole('inspecteurs');  // ✅ 'inspecteur' est dans la liste
    $inspecteur->setTelephone('0701234567');

    $result = $inspecteurDAO->updateInspecteur($inspecteur);
    
    if (!$result) {
        die("❌ Erreur lors de la mise à jour de l'inspecteur.");
    }
    
    echo "<p style='color:green; font-weight:bold;'>✅ Inspecteur mis à jour avec succès !</p>";
    echo "<p>ID: " . $inspecteur->getIdUtilisateur() . "</p>";
    
} catch(Exception $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ Erreur: " . $e->getMessage() . "</p>";
    
    // Debug supplémentaire
    echo "<p>Fichier: " . $e->getFile() . "</p>";
    echo "<p>Ligne: " . $e->getLine() . "</p>";
}
?>