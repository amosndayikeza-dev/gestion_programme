<?php
// test_minimal.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Config/Database.php';
require_once __DIR__ . '/../../Config/Model.php';
require_once __DIR__ . '/../../Models/Utilisateur/Utilisateur.php';
require_once __DIR__ . '/../../Models/Utilisateur/DirecteurDiscipline.php';
require_once __DIR__ . '/DirecteurDisciplineDAO.php';

use App\Config\Database;
use App\Models\Utilisateur\DirecteurDiscipline;
use App\Dao\Utilisateur\DirecteurDisciplineDAO;

echo "=== TEST AVEC DAO UNIQUEMENT ===\n\n";

try {
    // 1. Connexion
    $database = new Database();
    $db = $database->getConnexion();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion OK\n";

    // 2. Vérification des colonnes (optionnel mais utile)
    echo "\n📋 Colonnes de utilisateur:\n";
    $cols = $db->query("DESCRIBE utilisateur")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $col) {
        echo "   - " . $col['Field'] . "\n";
    }

    echo "\n📋 Colonnes de directeur_discipline:\n";
    $cols = $db->query("DESCRIBE directeur_discipline")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $col) {
        echo "   - " . $col['Field'] . "\n";
    }

    // 3. Création DAO
    echo "\n🔧 Création du DAO...\n";
    $dao = new DirecteurDisciplineDAO();
    echo "✅ DAO créé\n";

    // 4. Création objet
    echo "\n📦 Création de l'objet DirecteurDiscipline...\n";
    $directeur = new DirecteurDiscipline();
    $directeur->setNom('Diop');
    $directeur->setPrenom('Mamadou');
    $directeur->setEmail('amos.diop@ecole.sn');
    $directeur->setTelephone('771234567');
    $directeur->setMotDePasse(password_hash('pass123', PASSWORD_DEFAULT));
    $directeur->setRole('directeur_discipline');
    $directeur->setStatut('actif');
    $directeur->setBureau('Bureau 101');
    $directeur->setTelephonePro('778889999');
    $directeur->setPlagesDisponibilite('{}');
    $directeur->setDateDebut('2024-01-15');
    $directeur->setDateFin(null);
    
    echo "   Nom: " . $directeur->getNom() . "\n";
    echo "   Prénom: " . $directeur->getPrenom() . "\n";
    echo "   Email: " . $directeur->getEmail() . "\n";
    echo "   Bureau: " . $directeur->getBureau() . "\n";
    echo "✅ Objet créé\n";

    // 5. Insertion via DAO (UNIQUEMENT)
    echo "\n🚀 Insertion via DAO...\n";
    
    if ($dao->save($directeur)) {
        echo "✅ INSERTION RÉUSSIE !\n";
        echo "   ID Directeur: " . $directeur->getIdDirecteur() . "\n";
        echo "   ID Utilisateur: " . $directeur->getIdUtilisateur() . "\n";
    } else {
        echo "❌ ÉCHEC DE L'INSERTION\n";
    }

} catch (Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . " ligne " . $e->getLine() . "\n";
}