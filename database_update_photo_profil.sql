-- =====================================================
-- MISE À JOUR DE LA BASE DE DONNÉES POUR AJOUTER PHOTO DE PROFIL
-- =====================================================

-- Utiliser la base de données existante
USE `ecole_secondaire_congo`;

-- =====================================================
-- AJOUT DE LA COLONNE PHOTO_PROFIL À LA TABLE UTILISATEUR
-- =====================================================

-- Ajouter la colonne photo_profil à la table utilisateur
ALTER TABLE `utilisateur` 
ADD COLUMN `photo_profil` VARCHAR(255) NULL AFTER `date_creation`;

-- Ajouter un index pour optimiser les recherches sur les photos
ALTER TABLE `utilisateur` 
ADD INDEX `idx_photo_profil` (`photo_profil`);

-- =====================================================
-- CRÉATION DES IMAGES PAR DÉFAUT SELON LES RÔLES
-- =====================================================

-- Note: Ces chemins devront être créés dans le système de fichiers
-- Structure suggérée pour les images par défaut:
-- assets/images/default/
-- ├── admin.png (pour administrateur)
-- ├── principal.png (pour proviseur)
-- ├── censeur.png (pour censeur)
-- ├── discipline.png (pour directeur_discipline)
-- ├── teacher.png (pour enseignant)
-- ├── student.png (pour élève)
-- ├── parent.png (pour parent)
-- ├── prefect.png (pour préfet)
-- ├── chef.png (pour chef_classe)
-- ├── president.png (pour president_eleves)
-- ├── comite.png (pour comite_parents)
-- ├── secretary.png (pour secrétaire)
-- ├── librarian.png (pour bibliothécaire)
-- ├── accountant.png (pour comptable)
-- └── user.png (par défaut)

-- =====================================================
-- MISE À JOUR DES UTILISATEURS EXISTANTS AVEC IMAGES PAR DÉFAUT
-- =====================================================

-- Mettre à jour les utilisateurs existants avec des images par défaut selon leur rôle
UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/admin.png' 
WHERE `role` = 'administrateur' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/principal.png' 
WHERE `role` = 'proviseur' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/censeur.png' 
WHERE `role` = 'censeur' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/discipline.png' 
WHERE `role` = 'directeur_discipline' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/teacher.png' 
WHERE `role` = 'enseignant' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/student.png' 
WHERE `role` = 'eleve' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/parent.png' 
WHERE `role` = 'parent' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/prefect.png' 
WHERE `role` = 'prefet' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/chef.png' 
WHERE `role` = 'chef_classe' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/president.png' 
WHERE `role` = 'president_eleves' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/comite.png' 
WHERE `role` = 'comite_parents' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/secretary.png' 
WHERE `role` = 'secretaire' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/librarian.png' 
WHERE `role` = 'bibliothecaire' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/accountant.png' 
WHERE `role` = 'comptable' AND `photo_profil` IS NULL;

UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/supervisor.png' 
WHERE `role` = 'surveillant' AND `photo_profil` IS NULL;

-- Pour tout autre rôle non couvert
UPDATE `utilisateur` SET `photo_profil` = 'assets/images/default/user.png' 
WHERE `photo_profil` IS NULL;

-- =====================================================
-- CRÉATION D'UNE VUE POUR LES INFORMATIONS UTILISATEURS AVEC PHOTOS
-- =====================================================

CREATE VIEW `vue_utilisateurs_avec_photos` AS
SELECT 
    u.*,
    CASE 
        WHEN u.photo_profil IS NOT NULL AND u.photo_profil != '' THEN u.photo_profil
        ELSE CONCAT('assets/images/default/', 
            CASE u.role
                WHEN 'administrateur' THEN 'admin.png'
                WHEN 'proviseur' THEN 'principal.png'
                WHEN 'censeur' THEN 'censeur.png'
                WHEN 'directeur_discipline' THEN 'discipline.png'
                WHEN 'enseignant' THEN 'teacher.png'
                WHEN 'eleve' THEN 'student.png'
                WHEN 'parent' THEN 'parent.png'
                WHEN 'prefet' THEN 'prefect.png'
                WHEN 'chef_classe' THEN 'chef.png'
                WHEN 'president_eleves' THEN 'president.png'
                WHEN 'comite_parents' THEN 'comite.png'
                WHEN 'secretaire' THEN 'secretary.png'
                WHEN 'bibliothecaire' THEN 'librarian.png'
                WHEN 'comptable' THEN 'accountant.png'
                WHEN 'surveillant' THEN 'supervisor.png'
                ELSE 'user.png'
            END
        )
    END as photo_path,
    CASE 
        WHEN u.photo_profil IS NOT NULL AND u.photo_profil != '' THEN 'personnalisée'
        ELSE 'par_défaut'
    END as photo_type
FROM utilisateur u;

-- =====================================================
-- PROCÉDURE POUR METTRE À JOUR LA PHOTO D'UN UTILISATEUR
-- =====================================================

DELIMITER //

CREATE PROCEDURE `mettre_a_jour_photo_utilisateur`(
    IN p_id_utilisateur INT,
    IN p_chemin_photo VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Vérifier si l'utilisateur existe
    IF NOT EXISTS (SELECT 1 FROM utilisateur WHERE id_utilisateur = p_id_utilisateur) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utilisateur non trouvé';
    END IF;
    
    -- Mettre à jour la photo
    UPDATE utilisateur 
    SET photo_profil = p_chemin_photo 
    WHERE id_utilisateur = p_id_utilisateur;
    
    COMMIT;
END //

DELIMITER ;

-- =====================================================
-- PROCÉDURE POUR SUPPRIMER LA PHOTO D'UN UTILISATEUR
-- =====================================================

DELIMITER //

CREATE PROCEDURE `supprimer_photo_utilisateur`(
    IN p_id_utilisateur INT
)
BEGIN
    DECLARE v_role VARCHAR(50);
    DECLARE v_photo_default VARCHAR(255);
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Récupérer le rôle de l'utilisateur
    SELECT role INTO v_role FROM utilisateur WHERE id_utilisateur = p_id_utilisateur;
    
    IF v_role IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utilisateur non trouvé';
    END IF;
    
    -- Déterminer l'image par défaut selon le rôle
    SET v_photo_default = CONCAT('assets/images/default/', 
        CASE v_role
            WHEN 'administrateur' THEN 'admin.png'
            WHEN 'proviseur' THEN 'principal.png'
            WHEN 'censeur' THEN 'censeur.png'
            WHEN 'directeur_discipline' THEN 'discipline.png'
            WHEN 'enseignant' THEN 'teacher.png'
            WHEN 'eleve' THEN 'student.png'
            WHEN 'parent' THEN 'parent.png'
            WHEN 'prefet' THEN 'prefect.png'
            WHEN 'chef_classe' THEN 'chef.png'
            WHEN 'president_eleves' THEN 'president.png'
            WHEN 'comite_parents' THEN 'comite.png'
            WHEN 'secretaire' THEN 'secretary.png'
            WHEN 'bibliothecaire' THEN 'librarian.png'
            WHEN 'comptable' THEN 'accountant.png'
            WHEN 'surveillant' THEN 'supervisor.png'
            ELSE 'user.png'
        END
    );
    
    -- Remettre l'image par défaut
    UPDATE utilisateur 
    SET photo_profil = v_photo_default 
    WHERE id_utilisateur = p_id_utilisateur;
    
    COMMIT;
END //

DELIMITER ;

-- =====================================================
-- FONCTION POUR VÉRIFIER SI UN UTILISATEUR A UNE PHOTO PERSONNALISÉE
-- =====================================================

DELIMITER //

CREATE FUNCTION `utilisateur_a_photo_personnalisee`(
    p_id_utilisateur INT
) RETURNS BOOLEAN
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE v_photo_profil VARCHAR(255);
    DECLARE v_a_photo BOOLEAN DEFAULT FALSE;
    
    SELECT photo_profil INTO v_photo_profil 
    FROM utilisateur 
    WHERE id_utilisateur = p_id_utilisateur;
    
    IF v_photo_profil IS NOT NULL AND v_photo_profil != '' THEN
        SET v_a_photo = TRUE;
    END IF;
    
    RETURN v_a_photo;
END //

DELIMITER ;

-- =====================================================
-- STATISTIQUES SUR LES PHOTOS DE PROFIL
-- =====================================================

-- Vue pour les statistiques sur les photos
CREATE VIEW `vue_statistiques_photos` AS
SELECT 
    role,
    COUNT(*) as total_utilisateurs,
    COUNT(CASE WHEN photo_profil IS NOT NULL AND photo_profil NOT LIKE 'assets/images/default/%' THEN 1 END) as photos_personnalisees,
    COUNT(CASE WHEN photo_profil IS NULL OR photo_profil LIKE 'assets/images/default/%' THEN 1 END) as photos_par_defaut,
    ROUND(
        (COUNT(CASE WHEN photo_profil IS NOT NULL AND photo_profil NOT LIKE 'assets/images/default/%' THEN 1 END) * 100.0) / 
        COUNT(*), 
        2
    ) as pourcentage_photos_personnalisees
FROM utilisateur 
GROUP BY role
ORDER BY role;

-- =====================================================
-- RAPPORT FINAL
-- =====================================================

SELECT 'Mise à jour terminée avec succès!' as message;
SELECT COUNT(*) as total_utilisateurs FROM utilisateur;
SELECT COUNT(*) as utilisateurs_avec_photo FROM utilisateur WHERE photo_profil IS NOT NULL;
SELECT COUNT(*) as utilisateurs_photo_par_defaut FROM utilisateur WHERE photo_profil LIKE 'assets/images/default/%';
SELECT COUNT(*) as utilisateurs_photo_personnalisee FROM utilisateur WHERE photo_profil IS NOT NULL AND photo_profil NOT LIKE 'assets/images/default/%';

-- =====================================================
-- INSTRUCTIONS POUR LES DÉVELOPPEURS
-- =====================================================

/*
INSTRUCTIONS POST-MISE À JOUR:

1. CRÉER LES RÉPERTOIRES ET IMAGES PAR DÉFAUT:
   - Créer le répertoire: assets/images/default/
   - Ajouter les images PNG correspondantes (64x64 pixels recommandé)

2. VALIDATION DES UPLOADS:
   - Limiter la taille des fichiers: max 5Mo
   - Extensions autorisées: jpg, jpeg, png, gif, webp
   - Valider le type MIME: image/jpeg, image/png, image/gif, image/webp

3. SÉCURITÉ:
   - Stocker les fichiers dans un répertoire non accessible directement
   - Utiliser des noms de fichiers uniques (hash)
   - Valider toutes les entrées utilisateur

4. PERFORMANCE:
   - Utiliser un CDN pour les images si possible
   - Compresser les images avant stockage
   - Mettre en cache les images fréquemment accédées

5. BACKUP:
   - Inclure les photos dans les sauvegardes régulières
   - Documenter la structure des répertoires
*/
