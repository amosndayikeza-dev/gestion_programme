<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/config/Database.php';
require_once __DIR__ . '/../core/config/Model.php';
require_once __DIR__ . '/../ModuleUtilisateur/models/Utilisateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Models/Administrateur.php';
require_once __DIR__ . '/../ModuleUtilisateur/Admin/Dao/AdminDao.php';

use App\ModuleUtilisateur\Admin\Models\Administrateur;
use App\ModuleUtilisateur\Admin\Dao\AdminDAO;

echo "<h2>🔄 TEST MODIFICATION</h2>";

try {
    $dao = new AdminDAO();
    
    // 1. Récupérer l'admin (tableau)
    $data = $dao->findWithUser(105);
    
    if (!$data) {
        die("❌ Admin avec ID 105 non trouvé !");
    }
    
    // 2. Convertir en objet (utilisez votre méthode)
    $admin = $dao->createEntity($data);
    
    // 3. Modifier
    $admin->setNom('NouveauNom_' . time());
    $admin->setDepartement('RH');
    
    // 4. Sauvegarder
    $resultat = $dao->update($admin);
    
    if ($resultat) {
        echo "✅ Modification réussie !";
    } else {
        echo "❌ Échec de la modification";
    }
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage();
}
?>