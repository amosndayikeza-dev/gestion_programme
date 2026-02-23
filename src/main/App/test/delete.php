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

echo "<h2>🗑️ TEST DELETE</h2>";

try {
    $dao = new AdminDAO();
    
    // CHANGE CET ID SELON TON ADMIN
    $id = 105;
    
    echo "Suppression de l'admin avec ID: " . $id . "<br>";
    
    $resultat = $dao->delete($id);
    
    if ($resultat) {
        echo "<span style='color:green'>✅ SUCCÈS : Admin supprimé</span>";
    } else {
        echo "<span style='color:red'>❌ ÉCHEC : Admin non supprimé</span>";
    }
    
} catch (Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage();
}
?>