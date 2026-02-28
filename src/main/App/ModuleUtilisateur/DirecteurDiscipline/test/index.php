<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$root = __DIR__ . '/../../..';  // = .../src/main/App

require_once $root . '/core/config/Database.php';
require_once $root . '/core/config/Model.php';
require_once $root . '/ModuleUtilisateur/models/Utilisateur.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Models/DirecteurDiscipline.php';
require_once $root . '/ModuleUtilisateur/DirecteurDiscipline/Dao/DirecteurDisciplineDAO.php';  // ←


use App\ModuleUtilisateur\DirecteurDiscipline\Dao\DirecteurDisciplineDAO;
use App\ModuleUtilisateur\DirecteurDiscipline\Models\DirecteurDiscipline;

echo "<h2>🧪 TEST DIRECTEUR DISCIPLINE</h2>";

   try {
    $directeur = new DirecteurDiscipline();
    $directeur->setNom('jvm');
    $directeur->setPrenom('Marcel');
    $directeur->setEmail('Marcel' . time() . '@gmail.com');
    $directeur->setMotDePasse(password_hash('123', PASSWORD_DEFAULT));
    $directeur->setRole('directeur_discipline');  // ← OBLIGATOIRE
    $directeur->setStatut('actif');               // ← OBLIGATOIRE
    $directeur->setBureau('Bureau 30');
    $directeur->setTelephonePro('70143569');
    $directeur->setDateDebut(date('Y-m-d'));    // ← OBLIGATOIRE (NOT NULL)

    // SAUVEGARDER
    $dao = new DirecteurDisciplineDAO();
    $resultat = $dao->save($directeur);
    
    if ($resultat) {
        echo "✅ Directeur enregistré ! ID: " . $directeur->getIdUtilisateur();
    } else {
        echo "❌ Échec";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}

?>