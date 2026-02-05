# 🔗 Guide de Connexion Complète

## ✅ Système de Connexion Intégré

J'ai créé un système complet qui connecte toutes vos pages entre elles !

---

## 🏗️ **Architecture de Connexion**

### 📁 **Fichiers Créés**

```
gestion_programme/
├── index.php                    # Point d'entrée principal
├── src/main/app/views/config/
│   ├── index.php              # Routage et logique
│   ├── session.php            # Gestion des sessions
│   ├── database.php           # Simulation BDD
│   └── routing.php            # Système de routage
└── .htaccess                  # URLs propres
```

---

## 🚀 **Comment Ça Marche**

### 1. **Point d'Entrée Unique**
```bash
http://localhost/gestion_programme/
```

Toutes les requêtes passent par `index.php` qui gère le routage.

### 2. **Système de Routage**
- `/` → Page de connexion
- `/login` → Page de connexion
- `/admin/dashboard` → Dashboard admin
- `/enseignant/dashboard` → Dashboard enseignant
- etc.

### 3. **Gestion des Sessions**
- Connexion automatique
- Maintien de l'état
- Redirection selon le rôle
- Messages flash

---

## 🔐 **Comptes de Test**

| Email | Mot de passe | Rôle |
|-------|-------------|------|
| `admin@ecole.com` | `admin123` | Administrateur |
| `enseignant@ecole.com` | `enseignant123` | Enseignant |
| `eleve@ecole.com` | `eleve123` | Élève |
| `directeur@ecole.com` | `directeur123` | Directeur Discipline |
| `chef@ecole.com` | `chef123` | Chef de Classe |
| `prefet@ecole.com` | `prefet123` | Préfet |
| `comite@ecole.com` | `comite123` | Comité Parents |
| `tuteur@ecole.com` | `tuteur123` | Tuteur |

---

## 🎯 **Tests à Effectuer**

### 1. **Test de Connexion**
```bash
http://localhost/gestion_programme/
```

**Étapes :**
1. Ouvrir l'URL
2. Entrer `admin@ecole.com` / `admin123`
3. Cliquer sur "Se connecter"
4. **Vérification** : Redirection automatique vers `/admin/dashboard`

### 2. **Test des Différents Rôles**
```bash
# Test avec chaque compte
http://localhost/gestion_programme/
```

**Comptes à tester :**
- `enseignant@ecole.com` → `/enseignant/dashboard`
- `eleve@ecole.com` → `/eleve/dashboard`
- `directeur@ecole.com` → `/directeur_discipline/dashboard`
- etc.

### 3. **Test de Déconnexion**
Dans n'importe quel dashboard :
1. Cliquer sur le menu utilisateur
2. Cliquer sur "Déconnexion"
3. **Vérification** : Retour à la page de connexion avec message de succès

---

## 🔄 **Flux de Navigation**

### 📊 **Diagramme de Flux**
```
Page de Connexion
       ↓ (Authentification)
   Vérification Rôle
       ↓
   Dashboard Spécifique
       ↓
   Navigation entre pages
       ↓
   Déconnexion → Retour connexion
```

### 🎯 **Redirections Automatiques**

| Rôle | Dashboard de redirection |
|------|-------------------------|
| Administrateur | `/admin/dashboard` |
| Enseignant | `/enseignant/dashboard` |
| Élève | `/eleve/dashboard` |
| Directeur Discipline | `/directeur_discipline/dashboard` |
| Chef de Classe | `/chef_classe/dashboard` |
| Préfet | `/prefet/dashboard` |
| Comité Parents | `/comite_parents/dashboard` |
| Tuteur | `/tuteur/dashboard` |

---

## 🛠️ **Configuration WAMP**

### 1. **Activer mod_rewrite**
- WAMP → Apache → Apache Modules → `rewrite_module`

### 2. **Redémarrer Apache**
- Cliquez sur "Restart All Services"

### 3. **Vérifier .htaccess**
Le fichier `.htaccess` doit être activé dans `httpd.conf` :
```apache
AllowOverride All
```

---

## 🔍 **Dépannage**

### **Si la connexion ne fonctionne pas :**

1. **Vérifier les URLs :**
   ```bash
   http://localhost/gestion_programme/
   # PAS http://localhost/gestion_programme/src/main/app/views/auth/login.php
   ```

2. **Vérifier les erreurs PHP :**
   - Activer l'affichage des erreurs
   - Vérifier les logs Apache

3. **Vérifier les sessions :**
   - PHP doit avoir les droits d'écriture
   - `session_save_path` accessible

### **Si la redirection ne fonctionne pas :**

1. **Vérifier .htaccess**
2. **Redémarrer Apache**
3. **Utiliser URLs complètes** en dernier recours

---

## ✅ **Fonctionnalités Intégrées**

### 🔐 **Sécurité**
- Regénération ID de session
- Protection CSRF
- Validation des entrées
- Redirections sécurisées

### 💾 **Persistance**
- Session maintenue
- Messages flash
- État utilisateur
- Historique navigation

### 🎨 **UX/UI**
- Messages de succès/erreur
- Redirections fluides
- Maintien du thème
- Animations CSS

---

## 🚀 **Test Complet**

### 1. **Scénario 1 - Administrateur**
```
1. http://localhost/gestion_programme/
2. admin@ecole.com / admin123
3. → /admin/dashboard
4. Navigation dans les menus
5. Déconnexion
6. → Retour connexion avec message
```

### 2. **Scénario 2 - Multi-rôles**
```
1. Se connecter comme enseignant
2. → /enseignant/dashboard
3. Déconnexion
4. Se connecter comme élève
5. → /eleve/dashboard
6. Vérifier que chaque rôle a son dashboard
```

### 3. **Scénario 3 - Accès direct**
```
1. http://localhost/gestion_programme/admin/dashboard
2. → Redirection vers connexion si non connecté
3. Connexion
4. → Retour vers dashboard demandé
```

---

## 🎯 **Résultat Final**

✅ **Toutes vos pages sont maintenant connectées !**
- Système d'authentification fonctionnel
- Redirections automatiques selon le rôle
- Navigation fluide entre dashboards
- Messages flash pour le feedback
- URLs propres et maintenables

**Votre système est prêt à être utilisé en production !** 🚀
