<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Models/DirecteurDiscipline.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Dao/DirecteurDisciplineDAO.php';

// CORRECTION DU NAMESPACE
use App\ModuleUtilisateur\DirecteurDiscipline\Dao\DirecteurDisciplineDAO;
// use App\ModuleUtilisateur\Admin\Models\Directeur_discipline; ← À SUPPRIMER (mauvais namespace)

echo "<h2>🔄 TEST MODIFICATION</h2>";

try {
    $dao = new DirecteurDisciplineDAO();
    
    // 1. Récupérer le directeur (déjà un objet !)
    $directeur = $dao->findWithUser(195);  // ← C'est déjà un objet DirecteurDiscipline
    
    if (!$directeur) {
        die("❌ Directeur avec ID 193 non trouvé !");
    }
    
    echo "✅ Directeur trouvé: " . $directeur->getNom() . " " . $directeur->getPrenom() . "<br>";
    
    // 2. Modifier directement l'objet
    $directeur->setNom('NDAYIKEZA' . time());
    $directeur->setPrenom('Ammos');
    $directeur->setBureau('Bureau 30');
    $directeur->setTelephonePro('70143569');
    
    // 3. Sauvegarder (passer l'objet directement)
    $resultat = $dao->update($directeur);
    
    if ($resultat) {
        echo "<span style='color:green'>✅ Modification réussie !</span><br>";
        echo "Nouveau nom: " . $directeur->getNom() . "<br>";
        echo "Nouveau bureau: " . $directeur->getBureau() . "<br>";
    } else {
        echo "<span style='color:red'>❌ Échec de la modification</span><br>";
    }
    
} catch (Exception $e) {
    echo "<span style='color:red'>❌ ERREUR: " . $e->getMessage() . "</span><br>";
    echo "Fichier: " . $e->getFile() . "<br>";
    echo "Ligne: " . $e->getLine() . "<br>";
}
?>