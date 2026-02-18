# 🏫 Base de Données Complète - École Secondaire Congo

## 📋 Vue d'Ensemble

Cette base de données est spécialement conçue pour les écoles secondaires congolaises, en intégrant le vocabulaire administratif local et les structures adaptées au contexte éducatif congolais.

## 🗂️ Structure Complète (32 Tables)

### 📚 Tables Académiques
1. **ECOLE** - Informations générales de l'établissement
2. **ANNEE_SCOLAIRE** - Gestion des années académiques
3. **OPTION_ETUDE** - Options (Littéraire, Scientifique, Commerciale, etc.)
4. **SECTION** - Sections spécifiques (Latin-Philosophie, Math-Physique, etc.)
5. **CLASSE** - Classes par niveau et cycle
6. **SALLE** - Salles de classe, laboratoires, etc.
7. **ELEVE** - Informations complètes des élèves
8. **TUTEUR** - Parents/tuteurs des élèves
9. **INSCRIPTION** - Inscriptions annuelles
10. **TRANSFERT** - Gestion des transferts
11. **ENSEIGNANT** - Personnel enseignant avec grades A1-A10
12. **PERSONNEL** - Personnel administratif et technique
13. **FONCTION** - Fonctions administratives
14. **COURS** - Matières par classe et enseignant
15. **HORAIRE** - Emplois du temps

### 📊 Tables Évaluation
16. **PRESENCE** - Suivi des présences/absences
17. **EXAMEN** - Types d'examens
18. **NOTE** - Notes par élève et matière
19. **BULLETIN** - Bulletins trimestriels

### 💰 Tables Financières
20. **FRAIS_SCOLAIRE** - Structure des frais
21. **PAIEMENT** - Suivi des paiements
22. **DEPENSE** - Gestion des dépenses
23. **BUDGET** - Budget prévisionnel et réalisé

### ⚖️ Tables Discipline
24. **DISCIPLINE** - Fautes et incidents
25. **SANCTION** - Sanctions appliquées

### 📚 Tables Ressources
26. **LIVRE** - Gestion de la bibliothèque
27. **EMPRUNT** - Emprunts de livres
28. **MATERIEL** - Équipements et mobilier
29. **INVENTAIRE** - Suivi des inventaires

### 🔐 Tables Système
30. **ROLE** - Rôles utilisateurs étendus
31. **UTILISATEUR** - Accès au système
32. **JOURNAL_ACTIVITE** - Traçabilité des actions

## 🎯 Particularités Congolaises

### 📋 Grades Enseignants
- **A1 à A10** : Système de grades administratifs congolais
- **Specialités** : Adaptées au curriculum national

### 🏫 Types d'Établissements
- **Publique** : Écoles gouvernementales
- **Privée** : Écoles privées agréées
- **Confessionnelle** : Écoles religieuses

### 📍 Organisation Territoriale
- **Province** : Division administrative principale
- **Territoire/Commune** : Niveau local
- **Ministère de Tutelle** : MINETERP, MINEDUC, etc.

### 🎓 Sections Spécifiques
- **Latin-Philosophie** : Section classique
- **Math-Physique** : Section scientifique
- **Bio-Chimie** : Section sciences naturelles
- **Économie-Gestion** : Section commerciale

## 🔧 Fonctionnalités Avancées

### 📊 Vues Prédéfinies
- **vue_eleves_complet** : Informations complètes élèves avec classe
- **vue_statistiques_paiement** : État des paiements par élève

### ⚡ Procédures Stockées
- **calculer_moyenne_eleve** : Calcul automatique des moyennes
- **statistiques_annuelles** : Rapports statistiques complets

### 🔄 Triggers Automatiques
- Mise à jour automatique du stock de livres
- Journalisation des actions sensibles
- Cohérence des données

## 🚀 Installation

### 1. Importation de la Base
```bash
mysql -u username -p nom_database < database_ecole_congo.sql
```

### 2. Configuration Initiale
```sql
-- Activer l'année scolaire courante
UPDATE annee_scolaire SET active = TRUE WHERE libelle = '2024-2025';

-- Créer l'administrateur système
INSERT INTO utilisateur (nom_utilisateur, mot_de_passe, id_role)
VALUES ('admin', 'mot_de_passe_securise', 1);
```

## 📈 Statistiques Inclues

### 🎓 Effectifs
- Total élèves par classe/section
- Répartition par sexe
- Évolution des inscriptions

### 💰 Finances
- Recettes par type de frais
- Suivi des paiements
- Budget vs réalisé

### 📊 Académique
- Moyennes par classe
- Taux de réussite
- Statistiques de présence

### ⚖️ Discipline
- Types de fautes par période
- Sanctions appliquées
- Tendances disciplinaires

## 🔐 Sécurité et Traçabilité

### 👤 Rôles Disponibles
- Administrateur système
- Proviseur / Censeur
- Directeur de discipline
- Enseignants
- Élèves
- Parents/Tuteurs
- Personnel administratif

### 📝 Journalisation
- Toutes les actions sont tracées
- Adresse IP et navigateur enregistrés
- Tables concernées identifiées

## 🎯 Utilisation Recommandée

### 📅 Par Année Scolaire
1. **Début d'année** : Inscriptions, affectations classes
2. **Pendant l'année** : Suivi notes, présence, discipline
3. **Fin d'année** : Bulletins, décisions, statistiques

### 💰 Par Période
1. **Trimestrielle** : Bulletins, réunions parents
2. **Mensuelle** : Paiements, rapports discipline
3. **Hebdomadaire** : Présences, planning

### 📊 Reporting
- **Rapports proviseur** : Vue d'ensemble complète
- **Rapports censeur** : Aspects pédagogiques
- **Rapports comptables** : Situation financière
- **Rapports discipline** : État des sanctions

## 🔄 Maintenance

### 📙 Sauvegardes
```sql
-- Export complet
mysqldump -u username -p nom_database > backup_complet.sql

-- Export par année
mysqldump -u username -p --where="id_annee=1" nom_database inscription note bulletin > backup_2024.sql
```

### 🧹 Nettoyage
```sql
-- Archivage des anciennes années
-- Nettoyage du journal d'activité
-- Réindexation des tables
```

## 📞 Support Technique

Cette base de données est conçue pour être :
- **Scalable** : Supporte plusieurs milliers d'élèves
- **Robuste** : Contraintes d'intégrité fortes
- **Flexible** : Facilement extensible
- **Compatible** : MySQL 5.7+ / PostgreSQL 10+

## 🎉 Prochaines Évolutions

- Module d'emplois du temps automatique
- Intégration SMS pour parents
- Portail web élèves/parents
- Mobile app pour enseignants
- Analytics avancés

---

**🏫 Prête pour l'éducation secondaire congolaise moderne !**
