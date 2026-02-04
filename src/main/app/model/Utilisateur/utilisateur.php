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

    public function __construct(
         $idUtilisateur,
         $nom,
         $prenom,
         $email,
         $motDePasse,
         $role,
         $dateCreation
    ) {
        $this->idUtilisateur = $idUtilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->role = $role;
        $this->dateCreation = $dateCreation;
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
