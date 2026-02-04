# 📋 Routes pour le Préfet des Études

## 🎯 Gestion des Classes par le Préfet des Études

Le préfet des études peut ajouter, modifier, supprimer et gérer toutes les classes proposées dans le système.

---

## 🚀 Routes Principales

### Tableau de Bord
```
GET /prefet-etudes/dashboard
```
- **Contrôleur**: `PrefetEtudesController::dashboard()`
- **Vue**: `views/prefet_etudes/dashboard.php`
- **Description**: Tableau de bord avec statistiques, graphiques et actions rapides

### Ajouter une Classe
```
GET /prefet-etudes/ajouter-classe
POST /prefet-etudes/ajouter-classe
```
- **Contrôleur**: `PrefetEtudesController::ajouterClasse()`
- **Vue**: `views/prefet_etudes/ajouter_classe.php`
- **Description**: Formulaire complet pour ajouter une nouvelle classe

### Lister les Classes
```
GET /prefet-etudes/classes
```
- **Contrôleur**: `PrefetEtudesController::listerClasses()`
- **Vue**: `views/prefet_etudes/lister_classes.php`
- **Description**: Liste de toutes les classes avec filtres

### Modifier une Classe
```
GET /prefet-etudes/modifier-classe?id={id}
POST /prefet-etudes/modifier-classe
```
- **Contrôleur**: `PrefetEtudesController::modifierClasse()`
- **Vue**: `views/prefet_etudes/modifier_classe.php`
- **Description**: Formulaire de modification d'une classe existante

### Supprimer une Classe
```
POST /prefet-etudes/supprimer-classe
```
- **Contrôleur**: `PrefetEtudesController::supprimerClasse()`
- **Description**: Suppression d'une classe (avec confirmation)

### Voir une Classe
```
GET /prefet-etudes/voir-classe?id={id}
```
- **Contrôleur**: `PrefetEtudesController::voirClasse()`
- **Vue**: `views/prefet_etudes/voir_classe.php`
- **Description**: Détails complets d'une classe (élèves, enseignants, emploi du temps)

---

## 📊 Routes Statistiques

### Statistiques Générales
```
GET /prefet-etudes/statistiques
```
- **Contrôleur**: `PrefetEtudesController::statistiques()`
- **Vue**: `views/prefet_etudes/statistiques.php`
- **Description**: Statistiques détaillées avec graphiques

---

## 📁 Routes Import/Export

### Importer des Classes
```
GET /prefet-etudes/importer-classes
POST /prefet-etudes/importer-classes
```
- **Contrôleur**: `PrefetEtudesController::importerClasses()`
- **Vue**: `views/prefet_etudes/importer_classes.php`
- **Description**: Importation de classes en masse (CSV/Excel)

### Exporter des Classes
```
GET /prefet-etudes/exporter-classes?format={csv|excel}&filtres=...
```
- **Contrôleur**: `PrefetEtudesController::exporterClasses()`
- **Description**: Exportation de la liste des classes

---

## ⚙️ Configuration des Routes

### Configuration Apache (.htaccess)
```apache
RewriteEngine On

# Routes Préfet des Études
RewriteRule ^prefet-etudes/dashboard$ index.php?route=prefet-etudes/dashboard [L]
RewriteRule ^prefet-etudes/ajouter-classe$ index.php?route=prefet-etudes/ajouter-classe [L]
RewriteRule ^prefet-etudes/classes$ index.php?route=prefet-etudes/classes [L]
RewriteRule ^prefet-etudes/modifier-classe$ index.php?route=prefet-etudes/modifier-classe [L]
RewriteRule ^prefet-etudes/supprimer-classe$ index.php?route=prefet-etudes/supprimer-classe [L]
RewriteRule ^prefet-etudes/voir-classe$ index.php?route=prefet-etudes/voir-classe [L]
RewriteRule ^prefet-etudes/statistiques$ index.php?route=prefet-etudes/statistiques [L]
RewriteRule ^prefet-etudes/importer-classes$ index.php?route=prefet-etudes/importer-classes [L]
RewriteRule ^prefet-etudes/exporter-classes$ index.php?route=prefet-etudes/exporter-classes [L]
```

### Configuration Nginx
```nginx
location /prefet-etudes/ {
    try_files $uri $uri/ /index.php?route=$uri&$args;
}
```

---

## 🔐 Contrôle d'Accès

### Middleware d'Authentification
```php
// Vérification du rôle préfet
if ($_SESSION['user_role'] !== RoleEnum::PREFET) {
    header('HTTP/1.0 403 Forbidden');
    exit('Accès réservé au préfet des études');
}
```

### Permissions Requises
- **Ajouter**: `manage_classes`
- **Modifier**: `edit_classes`
- **Supprimer**: `delete_classes`
- **Voir**: `view_classes`
- **Importer**: `import_classes`
- **Exporter**: `export_classes`

---

## 📱 Paramètres des Formulaires

### Ajout/Modification de Classe
```php
$_POST = [
    'nom_classe' => '6ème Latin-Philosophie A',
    'niveau' => '6ème',
    'cycle' => 'Secondaire',
    'id_option' => 1, // Optionnel
    'id_section' => 2, // Optionnel
    'capacite' => 50,
    'id_ecole' => 1,
    'description' => 'Classe de 6ème année section Latin-Philosophie',
    'effectif_maximal' => 50,
    'annee_scolaire' => 2024
];
```

### Filtres pour la Liste
```php
$_GET = [
    'niveau' => '6ème',
    'cycle' => 'Secondaire',
    'id_option' => 1,
    'id_section' => 2,
    'id_ecole' => 1,
    'annee_scolaire' => 2024
];
```

---

## 🎨 Templates des Vues

### Structure des Vues
```
views/prefet_etudes/
├── dashboard.php              # Tableau de bord
├── ajouter_classe.php         # Formulaire d'ajout
├── lister_classes.php         # Liste avec filtres
├── modifier_classe.php        # Formulaire de modification
├── voir_classe.php            # Détails de la classe
├── statistiques.php           # Statistiques et graphiques
├── importer_classes.php      # Importation en masse
└── partials/
    ├── sidebar.php           # Barre latérale
    ├── header.php            # En-tête
    └── footer.php            # Pied de page
```

### Éléments Communs
- **Navigation**: Sidebar avec menu du préfet
- **Breadcrumb**: Fil d'Ariane pour la navigation
- **Alertes**: Messages de succès/erreur
- **Pagination**: Pour les listes longues
- **Filtres**: Recherche et filtrage avancé

---

## 🔄 Workflow de Validation

### Processus d'Ajout de Classe
1. **Saisie** → Formulaire avec validation
2. **Vérification** → Contrôle des données
3. **Enregistrement** → Sauvegarde en base
4. **Journalisation** → Traçabilité de l'action
5. **Notification** → Confirmation utilisateur

### Validation des Données
```php
// Champs obligatoires
$champs_obligatoires = ['nom_classe', 'niveau', 'cycle', 'id_ecole'];

// Validation spécifique
if (empty($classe->getNomClasse()) || 
    empty($classe->getNiveau()) || 
    empty($classe->getCycle()) || 
    empty($classe->getIdEcole())) {
    throw new Exception("Champs obligatoires manquants");
}
```

---

## 📈 Statistiques Disponibles

### Statistiques Générales
- Total des classes
- Classes actives
- Total des élèves
- Propositions en attente

### Répartition
- Classes par niveau
- Classes par section
- Classes par option
- Effectifs par classe

### Tendances
- Évolution mensuelle
- Taux d'occupation
- Comparaisons annuelles

---

## 🔧 Intégrations

### Services Externes
- **Export PDF**: Génération de rapports
- **Email**: Notifications automatiques
- **Stockage**: Fichiers importés/exportés

### API Interne
- **Service Classes**: Logique métier
- **Service Écoles**: Informations des établissements
- **Service Utilisateurs**: Gestion des accès

---

## 🚨 Gestion des Erreurs

### Codes d'Erreur
- **400**: Requête invalide
- **403**: Accès interdit
- **404**: Classe non trouvée
- **500**: Erreur serveur

### Messages d'Erreur
```php
$_SESSION['error'] = [
    'message' => 'Erreur lors de l\'ajout de la classe',
    'details' => 'Le nom de la classe existe déjà',
    'type' => 'validation'
];
```

---

## 📝 Journalisation

### Actions Journalisées
- AJOUT_CLASSE
- MODIF_CLASSE
- SUPPR_CLASSE
- IMPORT_CLASSES
- EXPORT_CLASSES

### Format du Journal
```php
[
    'id_utilisateur' => 123,
    'action' => 'AJOUT_CLASSE',
    'description' => 'Ajout de la classe: 6ème Latin-Philosophie A',
    'date_action' => '2024-01-15 10:30:00',
    'ip' => '192.168.1.100',
    'table_concernee' => 'classe',
    'id_enregistrement' => 456
]
```

---

## 🎯 Prochaines Évolutions

### Fonctionnalités Futures
- **Gestion des salles**: Affectation automatique
- **Emplois du temps**: Intégration complète
- **Notifications**: Alertes en temps réel
- **Mobile**: Application responsive

### Améliorations Techniques
- **WebSocket**: Mises à jour en temps réel
- **Cache**: Optimisation des performances
- **API REST**: Interface pour applications tierces
- **Tests**: Suite de tests automatisée
