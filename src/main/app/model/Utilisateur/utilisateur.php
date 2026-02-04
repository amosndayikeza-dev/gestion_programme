<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/RoleEnum.php';

class Utilisateur
{
    private  $idUtilisateur;
    private  $nom;
    private  $prenom;
    private  $email;
    private  $motDePasse;
    private  $role;
    private  $dateCreation;
    private  $photoProfil;

    public function __construct(
         $idUtilisateur,
         $nom,
         $prenom,
         $email,
         $motDePasse,
         $role,
         $dateCreation,
         $photoProfil = null
    ) {
        $this->idUtilisateur = $idUtilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->role = $role;
        $this->dateCreation = $dateCreation;
        $this->photoProfil = $photoProfil;
    }

    public function getIdUtilisateur() { return $this->idUtilisateur; }
    public function setIdUtilisateur( $id) { $this->idUtilisateur = $id; }

    public function getNom() { return $this->nom; }
    public function setNom( $nom) { $this->nom = $nom; }

    public function getPrenom() { return $this->prenom; }
    public function setPrenom( $prenom) { $this->prenom = $prenom; }

    public function getEmail() { return $this->email; }
    public function setEmail( $email) { $this->email = $email; }

    public function getMotDePasse() { return $this->motDePasse; }
    public function setMotDePasse( $mdp) { $this->motDePasse = $mdp; }

    public function getRole() { return $this->role; }
    public function setRole( $role) { $this->role = $role; }

    public function getDateCreation() { return $this->dateCreation; }
    public function setDateCreation( $date) { $this->dateCreation = $date; }

    public function getPhotoProfil() { return $this->photoProfil; }
    public function setPhotoProfil( $photo) { $this->photoProfil = $photo; }

    /**
     * Vérifie si l'utilisateur a une photo de profil
     */
    public function aPhotoProfil(): bool {
        return !empty($this->photoProfil);
    }

    /**
     * Retourne le chemin de la photo de profil ou une image par défaut
     */
    public function getPhotoProfilPath(): string {
        if ($this->aPhotoProfil()) {
            return $this->photoProfil;
        }
        
        // Image par défaut selon le rôle
        $defaultImages = [
            'administrateur' => 'assets/images/default/admin.png',
            'proviseur' => 'assets/images/default/principal.png',
            'censeur' => 'assets/images/default/censeur.png',
            'directeur_discipline' => 'assets/images/default/discipline.png',
            'enseignant' => 'assets/images/default/teacher.png',
            'eleve' => 'assets/images/default/student.png',
            'parent' => 'assets/images/default/parent.png',
            'prefet' => 'assets/images/default/prefect.png',
            'chef_classe' => 'assets/images/default/chef.png',
            'president_eleves' => 'assets/images/default/president.png',
            'comite_parents' => 'assets/images/default/comite.png'
        ];
        
        return $defaultImages[$this->role] ?? 'assets/images/default/user.png';
    }

    /**
     * Retourne l'URL complète de la photo de profil
     */
    public function getPhotoProfilUrl(): string {
        $path = $this->getPhotoProfilPath();
        
        // Si c'est déjà une URL complète
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        // Si c'est un chemin relatif, ajouter la base URL
        if (strpos($path, '/') === 0) {
            return $path;
        }
        
        return '/' . $path;
    }

    /**
     * Vérifie si la photo de profil existe
     */
    public function photoProfilExists(): bool {
        $path = $this->getPhotoProfilPath();
        
        // Si c'est une URL, on ne peut pas vérifier facilement
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }
        
        return file_exists($path);
    }

    /**
     * Retourne les informations sur la photo de profil
     */
    public function getPhotoProfilInfo(): array {
        return [
            'a_photo' => $this->aPhotoProfil(),
            'path' => $this->getPhotoProfilPath(),
            'url' => $this->getPhotoProfilUrl(),
            'exists' => $this->photoProfilExists(),
            'is_default' => !$this->aPhotoProfil(),
            'extension' => $this->getPhotoExtension(),
            'size' => $this->getPhotoSize()
        ];
    }

    /**
     * Retourne l'extension de la photo
     */
    public function getPhotoExtension(): string {
        if (!$this->aPhotoProfil()) {
            return 'png'; // Extension par défaut
        }
        
        $path = $this->photoProfil;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? $extension : 'png';
    }

    /**
     * Retourne la taille du fichier photo en octets
     */
    public function getPhotoSize(): int {
        if (!$this->aPhotoProfil() || !file_exists($this->photoProfil)) {
            return 0;
        }
        
        return filesize($this->photoProfil);
    }

    /**
     * Retourne la taille formatée du fichier photo
     */
    public function getPhotoSizeFormatted(): string {
        $size = $this->getPhotoSize();
        
        if ($size === 0) {
            return '0 octets';
        }
        
        $units = ['octets', 'Ko', 'Mo', 'Go'];
        $unitIndex = 0;
        
        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }
        
        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Valide le format de la photo de profil
     */
    public function validerPhotoProfil(): array {
        $erreurs = [];
        
        if (!$this->aPhotoProfil()) {
            return $erreurs; // Photo non obligatoire
        }
        
        $path = $this->photoProfil;
        
        // Vérifier si le fichier existe
        if (!file_exists($path)) {
            $erreurs[] = 'Le fichier photo n\'existe pas';
            return $erreurs;
        }
        
        // Vérifier l'extension
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($extension, $extensionsAutorisees)) {
            $erreurs[] = 'L\'extension du fichier n\'est pas autorisée (jpg, jpeg, png, gif, webp)';
        }
        
        // Vérifier la taille (max 5Mo)
        $size = filesize($path);
        if ($size > 5 * 1024 * 1024) {
            $erreurs[] = 'La taille du fichier ne doit pas dépasser 5Mo';
        }
        
        // Vérifier le type MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $path);
        finfo_close($finfo);
        
        $mimesAutorises = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mimeType, $mimesAutorises)) {
            $erreurs[] = 'Le type de fichier n\'est pas une image valide';
        }
        
        return $erreurs;
    }

    /**
     * Vérifie si le rôle de l'utilisateur est valide
     */
    public function hasValidRole(): bool {
        return RoleEnum::isValidRole($this->role);
    }

    /**
     * Retourne le libellé du rôle
     */
    public function getRoleLabel(): string {
        return RoleEnum::getRoleLabel($this->role);
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique
     */
    public function hasRole(string $role): bool {
        return $this->role === $role;
    }

    /**
     * Vérifie si l'utilisateur appartient à une catégorie de rôles
     */
    public function belongsToCategory(string $category): bool {
        $rolesByCategory = RoleEnum::getRolesByCategory();
        return isset($rolesByCategory[$category]) && 
               in_array($this->role, $rolesByCategory[$category]);
    }

    /**
     * Retourne les permissions de l'utilisateur selon son rôle
     */
    public function getPermissions(): array {
        switch($this->role) {
            case RoleEnum::ADMINISTRATEUR:
                return ['manage_users', 'manage_system', 'view_all', 'edit_all'];
            case RoleEnum::PROVISEUR:
                return ['manage_teachers', 'manage_students', 'view_reports', 'manage_discipline'];
            case RoleEnum::DIRECTEUR_DISCIPLINE:
                return ['manage_discipline', 'view_student_records', 'sanction_students'];
            case RoleEnum::ENSEIGNANT:
                return ['manage_courses', 'view_students', 'grade_students'];
            case RoleEnum::ELEVE:
                return ['view_own_grades', 'participate_activities'];
            case RoleEnum::PARENT:
                return ['view_child_grades', 'view_child_attendance'];
            case RoleEnum::PREFET:
                return ['manage_class_discipline', 'report_issues'];
            case RoleEnum::CHEF_CLASSE:
                return ['represent_class', 'organize_activities'];
            case RoleEnum::PRESIDENT_ELEVES:
                return ['represent_students', 'organize_events'];
            case RoleEnum::COMITE_PARENTS:
                return ['represent_parents', 'participate_meetings'];
            case RoleEnum::INSPECTEUR:
                return ['inspect_teaching', 'evaluate_teachers', 'view_reports'];
            default:
                return [];
        }
    }
}
