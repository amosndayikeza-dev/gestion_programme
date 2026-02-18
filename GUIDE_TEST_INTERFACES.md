<?php
/**
 * Script de Test des Interfaces
 * Vérifie que tous les fichiers existent et sont accessibles
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
$baseDir = __DIR__ . '/src/main/app/views';
$testResults = [];

echo "<h1>🧪 Test des Interfaces - Gestion Programme</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    .test-item { margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    .file-exists { background-color: #d4edda; }
    .file-missing { background-color: #f8d7da; }
    .syntax-error { background-color: #fff3cd; }
</style>";

// Tests des composants de base
echo "<h2>🏗️ Composants de Base</h2>";

$components = [
    'Component.php',
    'Header.php', 
    'Sidebar.php',
    'Card.php',
    'Footer.php',
    'DashboardContent.php'
];

foreach ($components as $component) {
    $file = $baseDir . '/components/' . $component;
    $result = testFile($file, $component);
    echo $result;
}

// Tests de l'authentification
echo "<h2>🔐 Authentification</h2>";

$authFiles = [
    'login.php',
    'logout.php'
];

foreach ($authFiles as $file) {
    $filePath = $baseDir . '/auth/' . $file;
    $result = testFile($filePath, $file);
    echo $result;
}

// Tests des dashboards
echo "<h2>📊 Dashboards</h2>";

$dashboards = [
    'admin/dashboard.php',
    'enseignant/dashboard.php',
    'eleve/dashboard.php',
    'directeur_discipline/dashboard.php',
    'chef_classe/dashboard.php',
    'prefet/dashboard.php',
    'comite_parents/dashboard.php',
    'tuteur/dashboard.php',
    'admin/dashboard_simple.php'
];

foreach ($dashboards as $dashboard) {
    $filePath = $baseDir . '/' . $dashboard;
    $result = testFile($filePath, $dashboard);
    echo $result;
}

// Test de syntaxe PHP
echo "<h2>🔍 Tests de Syntaxe PHP</h2>";

$allFiles = array_merge(
    array_map(fn($c) => $baseDir . '/components/' . $c, $components),
    array_map(fn($f) => $baseDir . '/auth/' . $f, $authFiles),
    array_map(fn($d) => $baseDir . '/' . $d, $dashboards)
);

$syntaxErrors = [];
foreach ($allFiles as $file) {
    if (file_exists($file)) {
        $output = [];
        $returnCode = 0;
        exec("php -l \"$file\" 2>&1", $output, $returnCode);
        
        if ($returnCode !== 0) {
            $syntaxErrors[] = [
                'file' => basename($file),
                'error' => implode("\n", $output)
            ];
        }
    }
}

if (empty($syntaxErrors)) {
    echo '<div class="test-item file-exists"><span class="success">✅ Tous les fichiers ont une syntaxe PHP correcte</span></div>';
} else {
    echo '<div class="test-item file-missing"><span class="error">❌ Erreurs de syntaxe trouvées:</span>';
    foreach ($syntaxErrors as $error) {
        echo "<div class='test-item syntax-error'><strong>{$error['file']}:</strong><br><pre>{$error['error']}</pre></div>";
    }
    echo '</div>';
}

// Test des dépendances
echo "<h2>🔗 Tests des Dépendances</h2>";

$dependencies = [
    'Font Awesome CDN' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
    'Tailwind CSS CDN' => 'https://cdn.tailwindcss.com'
];

foreach ($dependencies as $name => $url) {
    echo "<div class='test-item'>";
    echo "<strong>$name:</strong> ";
    
    $headers = @get_headers($url);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo '<span class="success">✅ Accessible</span>';
    } else {
        echo '<span class="warning">⚠️ Non accessible (vérifier connexion internet)</span>';
    }
    echo "</div>";
}

// Résumé
echo "<h2>📋 Résumé des Tests</h2>";
$totalFiles = count($components) + count($authFiles) + count($dashboards);
$existingFiles = count($testResults['exists'] ?? []);
$missingFiles = count($testResults['missing'] ?? []);

echo "<div class='test-item'>";
echo "<strong>📁 Fichiers totaux:</strong> $totalFiles<br>";
echo "<strong>✅ Fichiers existants:</strong> <span class='success'>$existingFiles</span><br>";
echo "<strong>❌ Fichiers manquants:</strong> <span class='error'>$missingFiles</span><br>";
echo "<strong>🔍 Erreurs de syntaxe:</strong> <span class='error'>" . count($syntaxErrors) . "</span>";
echo "</div>";

// Instructions de test
echo "<h2>🚀 Instructions de Test Manuel</h2>";
echo "<div class='test-item'>";
echo "<h3>1. Test Local:</h3>";
echo "<code>http://localhost/gestion_programme/src/main/app/views/auth/login.php</code><br><br>";

echo "<h3>2. Tests à effectuer:</h3>";
echo "<ul>";
echo "<li>✅ Vérifier que la page de connexion s'affiche correctement</li>";
echo "<li>✅ Tester les comptes de démo (admin@ecole.com / admin123)</li>";
echo "<li>✅ Vérifier que chaque dashboard s'affiche selon le rôle</li>";
echo "<li>✅ Tester la responsivité mobile</li>";
echo "<li>✅ Vérifier les animations et transitions</li>";
echo "<li>✅ Tester les liens de navigation</li>";
echo "</ul>";
echo "</div>";

function testFile($filePath, $fileName) {
    global $testResults;
    
    echo "<div class='test-item'>";
    echo "<strong>📄 $fileName:</strong> ";
    
    if (file_exists($filePath)) {
        echo '<span class="success">✅ Existe</span>';
        $testResults['exists'][] = $fileName;
        
        // Vérifier la taille du fichier
        $size = filesize($filePath);
        echo " (<span class='info'>" . number_format($size) . " octets</span>)";
        
        // Vérifier si c'est lisible
        if (is_readable($filePath)) {
            echo ' <span class="success">✅ Lisible</span>';
        } else {
            echo ' <span class="error">❌ Non lisible</span>';
        }
        
        // Vérifier le contenu de base
        $content = file_get_contents($filePath);
        if (strpos($content, '<?php') !== false) {
            echo ' <span class="success">✅ PHP valide</span>';
        } else {
            echo ' <span class="warning">⚠️ Pas de PHP détecté</span>';
        }
        
    } else {
        echo '<span class="error">❌ Manquant</span>';
        $testResults['missing'][] = $fileName;
    }
    
    echo "</div>";
}
?>

// logique modele entre eleve et utilisateur(les classe)

┌─────────────────────────────┐
│      UTILISATEUR            │
├─────────────────────────────┤
│ - idUtilisateur             │◄─────┐
│ - nom, prenom               │      │
│ - email, motDePasse         │      │ Héritage
│ - role, statut              │      │
│ - telephone, dateCreation   │      │
│ - photoProfil, tokenReset   │      │
├─────────────────────────────┤      │
│ + hydrate()                 │      │
│ + toArray()                 │      │
└─────────────────────────────┘      │
              ▲                      │
              │                      │
              │ extends              │
              │                      │
┌─────────────┴───────────────┐      │
│           ELEVE             │      │
├─────────────────────────────┤      │
│ - idEleve                   │◄─────┘
│ - idClasse                  │  (même ID)
│ - idTuteur                  │
│ - dateNaissance             │
│ - lieuNaissance             │
│ - sexe                      │
│ - adresse                   │
│ - dateInscription           │
│ - matricule                 │
├─────────────────────────────┤
│ + hydrate() [surchargée]    │
│ + toArray() [surchargée]    │
│ + getAge()                  │
│ + isAdult()                 │
│ + fromDbRow() [statique]    │
└─────────────────────────────┘