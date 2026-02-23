<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$root = __DIR__ . '/../../..';
require_once $root . '/core/config/Database.php';
use App\core\config\Database;
use PDO;
use PDOException;

try {
    $db = (new Database())->getConnexion();
    
    echo "<h3>🔍 TEST DIRECT SUR LA BASE</h3>";
    
    // 1. Insérer DIRECTEMENT un utilisateur
    $sql = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role, statut, date_creation) 
            VALUES ('DEBUG', 'USER', 'debug" . time() . "@test.com', 'pass', 'proviseur', 'actif', NOW())";
    
    $result = $db->exec($sql);
    
    if ($result) {
        $id = $db->lastInsertId();
        echo "✅ Insertion directe RÉUSSIE ! ID: " . $id . "<br>";
        
        // Vérifier que l'utilisateur est bien là
        $check = $db->query("SELECT * FROM utilisateur WHERE id_utilisateur = $id")->fetch();
        if ($check) {
            echo "✅ Utilisateur trouvé en base !<br>";
            print_r($check);
        }
    } else {
        echo "❌ Échec de l'insertion directe<br>";
    }
    
    // 2. Vérifier la structure
    echo "<h3>Structure de la table:</h3>";
    $stmt = $db->query("DESCRIBE utilisateur");
    while ($row = $stmt->fetch()) {
        echo $row['Field'] . " - " . $row['Type'] . " - " . $row['Null'] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ ERREUR: " . $e->getMessage();
}
?>