# Documentation des Rôles Étendus du Système

## Vue d'ensemble

Le système de gestion a été étendu pour inclure 7 nouveaux rôles en plus des rôles existants (élève, enseignant, inspecteur, administrateur).

## Rôles Disponibles

### Rôles Académiques
- **Élève** (`eleve`) - Accès aux notes, activités, progression
- **Enseignant** (`enseignant`) - Gestion des cours, évaluation des élèves
- **Inspecteur** (`inspecteur`) - Inspection pédagogique, évaluation

### Rôles Administratifs
- **Administrateur** (`administrateur`) - Gestion complète du système
- **Proviseur** (`proviseur`) - Direction de l'établissement
- **Directeur de discipline** (`directeur_discipline`) - Gestion de la discipline

### Rôles de Représentation
- **Préfet** (`prefet`) - Représentation et discipline au niveau classe
- **Chef de classe** (`chef_classe`) - Représentation des élèves de classe
- **Président des élèves** (`president_eleves`) - Représentation de tous les élèves
- **Comité de parents** (`comite_parents`) - Représentation des parents

### Rôle d'Encadrement
- **Parent** (`parent`) - Suivi scolaire de ses enfants

## Structure Technique

### Modèles Créés

1. **RoleEnum.php** - Énumération des rôles et méthodes utilitaires
2. **Parent.php** - Classe spécialisée pour les parents
3. **Prefet.php** - Classe spécialisée pour les préfets
4. **DirecteurDiscipline.php** - Classe spécialisée pour le directeur de discipline
5. **Proviseur.php** - Classe spécialisée pour le proviseur
6. **ChefClasse.php** - Classe spécialisée pour les chefs de classe
7. **PresidentEleves.php** - Classe spécialisée pour le président des élèves
8. **ComiteParents.php** - Classe spécialisée pour les membres du comité de parents

### Contrôleurs Créés

1. **ParentController.php** - Gestion des fonctionnalités parentales
2. **PrefetController.php** - Gestion des fonctionnalités de préfet
3. **DirecteurDisciplineController.php** - Gestion de la discipline
4. **ProviseurController.php** - Gestion administrative complète

### Base de Données

Le fichier `database_update_roles.sql` contient :
- Mise à jour de la table `utilisateurs` avec les nouveaux rôles
- Tables spécialisées pour chaque type d'utilisateur
- Table de permissions étendues
- Données de test pour chaque rôle

## Permissions par Rôle

### Parent
- Voir les notes de ses enfants
- Voir les absences de ses enfants
- Contacter les enseignants
- Participer aux réunions

### Préfet
- Gérer la discipline de sa classe
- Signaler des problèmes
- Représenter sa classe
- Organiser des activités

### Directeur de Discipline
- Gérer la discipline de l'établissement
- Consulter les dossiers des élèves
- Sanctionner les élèves
- Gérer le conseil de discipline

### Proviseur
- Gérer le personnel enseignant
- Gérer les élèves
- Consulter tous les rapports
- Gérer le budget
- Représenter l'établissement

### Chef de Classe
- Représenter la classe
- Organiser des activités
- Communiquer avec l'administration
- Gérer les problèmes de classe

### Président des Élèves
- Représenter tous les élèves
- Organiser des événements
- Négocier avec l'administration
- Gérer le budget étudiant

### Comité de Parents
- Représenter les parents
- Participer aux réunions
- Proposer des projets
- Aider à l'organisation
- Collecter des fonds

## Installation

1. **Mettre à jour la base de données** :
   ```sql
   mysql -u username -p database_name < database_update_roles.sql
   ```

2. **Vérifier les fichiers** :
   - Les modèles sont dans `src/main/app/model/Utilisateur/`
   - Les contrôleurs sont dans `src/main/app/controller/Utilisateur/`

3. **Configurer les routes** :
   Ajouter les nouvelles routes dans votre fichier de routing pour chaque contrôleur.

## Utilisation

Chaque rôle a un tableau de bord personnalisé et des fonctionnalités spécifiques accessibles selon les permissions définies.

## Sécurité

- Validation des rôles dans chaque contrôleur
- Vérification des permissions avant accès aux fonctionnalités
- Séparation claire des responsabilités

## Extensions Futures

Le système est conçu pour être facilement extensible avec de nouveaux rôles et permissions.
