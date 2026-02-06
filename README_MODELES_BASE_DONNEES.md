# 📊 Modèles PHP - Base de Données École Secondaire Congo

## 🎯 Vue d'Ensemble

J'ai créé les modèles PHP complets correspondant à la structure de la base de données pour les écoles secondaires congolaises. Chaque modèle inclut des méthodes utilitaires adaptées au contexte local.

---

## 📚 Modèles Créés

### 🏫 Modèles Académiques

#### 1. **Etablissement** (`src/main/app/model/Academique/Etablissement.php`)
- **Attributs** : id_ecole, nom_ecole, type_ecole, ministere_tutelle, province, territoire_commune, adresse, telephone, email, code_ecole, date_creation, statut
- **Fonctionnalités** :
  - Gestion des types d'écoles (Publique, Privée, Confessionnelle)
  - Validation des coordonnées téléphoniques congolaises
  - Génération automatique des codes d'école
  - Support des provinces congolaises
  - Calcul d'ancienneté

#### 2. **AnneeScolaire** (`src/main/app/model/Academique/AnneeScolaire.php`)
- **Attributs** : id_annee, libelle, date_debut, date_fin, active
- **Fonctionnalités** :
  - Gestion des trimestres académiques
  - Calcul de progression de l'année
  - Détermination automatique des périodes d'évaluation
  - Gestion des mois disponibles
  - Validation de la cohérence des dates

### 📖 Modèles Bibliothèque

#### 3. **Livre** (`src/main/app/model/Bibliotheque/Livre.php`)
- **Attributs** : id_livre, titre, auteur, edition, annee, isbn, quantite_total, quantite_disponible, categorie
- **Fonctionnalités** :
  - Gestion des emprunts et retours
  - Validation ISBN (ISBN-10 et ISBN-13)
  - Recherche textuelle avancée
  - Calcul de disponibilité
  - Génération de références bibliographiques

#### 4. **Emprunt** (`src/main/app/model/Bibliotheque/Emprunt.php`)
- **Attributs** : id_emprunt, id_livre, id_eleve, date_emprunt, date_retour_prevue, date_retour_effective, etat, penalite
- **Fonctionnalités** :
  - Calcul automatique des pénalités de retard
  - Gestion des états (En cours, Retourné, En retard, Perdu)
  - Prolongation des emprunts
  - Suivi des durées d'emprunt

### 🛠️ Modèles Ressources

#### 5. **Materiel** (`src/main/app/model/Ressources/Materiel.php`)
- **Attributs** : id_materiel, designation, categorie, quantite, etat, date_acquisition, valeur_unitaire, localisation
- **Fonctionnalités** :
  - Calcul d'amortissement comptable
  - Gestion des états (Bon, Moyen, Mauvais, Hors service)
  - Suivi de localisation
  - Calcul de valeur résiduelle
  - Gestion des catégories (Mobilier, Informatique, Laboratoire, Sport, Bureau)

#### 6. **Inventaire** (`src/main/app/model/Ressources/Inventaire.php`)
- **Attributs** : id_inventaire, id_materiel, date_inventaire, quantite_constatee, quantite_theorique, observation, responsable
- **Fonctionnalités** :
  - Calcul des écarts d'inventaire
  - Détermination de la gravité des différences
  - Génération de suggestions d'actions
  - Calcul d'impact financier
  - Suivi de la périodicité

---

## 🎨 Caractéristiques Communes

### 🔧 Méthodes Utilitaires
- **Validation** : Chaque modèle inclut des méthodes de validation adaptées
- **Conversion** : Méthodes `toArray()` pour l'export JSON
- **Calculs** : Méthodes de calcul spécifiques au contexte
- **États** : Gestion des états avec couleurs et icônes

### 🇨🇩 Adaptation Congolaise
- **Provinces** : Support des 11 provinces congolaises
- **Téléphones** : Validation des formats +243
- **Ministères** : MINEDUC, MINETERP, MINESU
- **Système Éducatif** : Trimestres, sections, grades A1-A10

### 📊 Statistiques et Rapports
- **Calculs Automatiques** : Taux, moyennes, progressions
- **États Visuels** : Couleurs et icônes Bootstrap
- **Rapports** : Méthodes de génération de rapports détaillés

---

## 🚀 Utilisation des Modèles

### Exemple : Etablissement
```php
$ecole = new Etablissement(
    null,
    'Lycée Mama Yemo',
    'Publique',
    'MINISTERE DE L\'EDUCATION NATIONALE',
    'Kinshasa',
    'Lukunga',
    'Avenue de la Paix',
    '+243812345678',
    'contact@lyceemamayemo.cd',
    null, // Sera généré automatiquement
    '2020-01-15',
    'Active'
);

// Validation
if ($ecole->isValid()) {
    echo "École valide";
}

// Génération du code
$code = $ecole->genererCodeEcole(); // LYME-KIN-LUK-2024
```

### Exemple : Livre
```php
$livre = new Livre(
    null,
    'Congo, une histoire',
    'Oscar Van Ghelue',
    'Éditions du Pavillon',
    2022,
    '978-2-87097-123-4',
    5,
    3,
    'Histoire'
);

// Recherche
if ($livre->rechercher('congo')) {
    echo "Livre trouvé";
}

// Emprunt
if ($livre->estDisponible()) {
    $livre->emprunterExemplaire();
}
```

### Exemple : Inventaire
```php
$inventaire = new Inventaire(
    null,
    1, // ID matériel
    '2024-01-15',
    45, // Quantité constatée
    50, // Quantité théorique
    '5 ordinateurs manquants',
    'Jean Mukendi'
);

// Analyse
if ($inventaire->aManque()) {
    echo "Manque de " . abs($inventaire->getDifference()) . " unités";
    echo "Gravité : " . $inventaire->getGravite();
}
```

---

## 🔄 Intégration avec la Base de Données

### Structure des Dossiers
```
src/main/app/model/
├── Academique/
│   ├── Etablissement.php
│   └── AnneeScolaire.php
├── Bibliotheque/
│   ├── Livre.php
│   └── Emprunt.php
├── Ressources/
│   ├── Materiel.php
│   └── Inventaire.php
└── Utilisateur/
    ├── utilisateur.php
    ├── RoleEnum.php
    ├── Parent.php
    ├── Prefet.php
    ├── DirecteurDiscipline.php
    ├── Proviseur.php
    ├── ChefClasse.php
    ├── PresidentEleves.php
    └── ComiteParents.php
```

### Connexion DAO
Chaque modèle est conçu pour fonctionner avec un DAO correspondant :
- `EtablissementDAO`
- `AnneeScolaireDAO`
- `LivreDAO`
- `EmpruntDAO`
- `MaterielDAO`
- `InventaireDAO`

---

## 📋 Validation des Données

### Types de Validation
1. **Format** : Validation des formats (email, téléphone, ISBN)
2. **Cohérence** : Vérification de la logique des données
3. **Contraintes** : Respect des contraintes métier
4. **Intégrité** : Validation des références

### Messages d'Erreur
```php
$erreurs = $ecole->validerTelephone();
if (!empty($erreurs)) {
    foreach ($erreurs as $erreur) {
        echo $erreur;
    }
}
```

---

## 🎯 Prochaines Étapes

### DAO à Créer
1. `EtablissementDAO` - Gestion des établissements
2. `AnneeScolaireDAO` - Gestion des années académiques
3. `LivreDAO` - Gestion de la bibliothèque
4. `EmpruntDAO` - Suivi des emprunts
5. `MaterielDAO` - Gestion des équipements
6. `InventaireDAO` - Contrôle des inventaires

### Services à Implémenter
1. `EtablissementService` - Logique métier
2. `BibliothequeService` - Gestion complète
3. `RessourcesService` - Gestion des matériels
4. `InventaireService` - Planification inventaires

### Contrôleurs à Développer
1. `EtablissementController` - Administration
2. `BibliothequeController` - Gestion bibliothèque
3. `RessourcesController` - Gestion matériels
4. `InventaireController` - Contrôle inventaires

---

## 🔧 Configuration Requise

### Extensions PHP
- `php-intl` : Pour les formats de dates
- `php-mbstring` : Pour les chaînes UTF-8
- `php-pdo` : Pour la connexion BDD

### Configuration PHP
```ini
date.timezone = Africa/Kinshasa
mbstring.internal_encoding = UTF-8
```

---

## 🎉 Conclusion

Les modèles PHP créés sont **100% adaptés** au contexte éducatif congolais avec :

- ✅ **Validation locale** (téléphones, provinces, ministères)
- ✅ **Logique métier** (trimestres, sections, grades)
- ✅ **Fonctionnalités avancées** (calculs, rapports, statistiques)
- ✅ **Architecture propre** (MVC, séparation des responsabilités)
- ✅ **Extensibilité** (facile à maintenir et étendre)

Prêts pour l'intégration complète dans votre système de gestion ! 🏫✨
