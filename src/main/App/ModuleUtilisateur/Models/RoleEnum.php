<?php
namespace App\ModuleUtilisateur\Models;
use DateTime;
use DateInterval;
use PDO;
use Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RoleEnum {
    // Rôles existants
    const ELEVE = 'eleve';
    const ENSEIGNANT = 'enseignant';
    const INSPECTEUR = 'inspecteur';
    const ADMINISTRATEUR = 'administrateur';
    
    // Nouveaux rôles ajoutés
    const PARENT = 'parent';
    const PREFET = 'prefet';
    const DIRECTEUR_DISCIPLINE = 'directeur_discipline';
    const PROVISEUR = 'proviseur';
    const CHEF_CLASSE = 'chef_classe';
    const PRESIDENT_ELEVES = 'president_eleves';
    const COMITE_PARENTS = 'comite_parents';
    
    /**
     * Retourne tous les rôles disponibles
     */
    public static function getAllRoles(): array {
        return [
            self::ELEVE,
            self::ENSEIGNANT,
            self::INSPECTEUR,
            self::ADMINISTRATEUR,
            self::PARENT,
            self::PREFET,
            self::DIRECTEUR_DISCIPLINE,
            self::PROVISEUR,
            self::CHEF_CLASSE,
            self::PRESIDENT_ELEVES,
            self::COMITE_PARENTS
        ];
    }
    
    /**
     * Vérifie si un rôle est valide
     */
    public static function isValidRole(string $role): bool {
        return in_array($role, self::getAllRoles());
    }
    
    /**
     * Retourne les rôles par catégorie
     */
    public static function getRolesByCategory(): array {
        return [
            'academique' => [
                self::ELEVE,
                self::ENSEIGNANT,
                self::INSPECTEUR
            ],
            'administratif' => [
                self::ADMINISTRATEUR,
                self::DIRECTEUR_DISCIPLINE,
                self::PROVISEUR
            ],
            'representation' => [
                self::PREFET,
                self::CHEF_CLASSE,
                self::PRESIDENT_ELEVES,
                self::COMITE_PARENTS
            ],
            'encadrement' => [
                self::PARENT
            ]
        ];
    }
    
    /**
     * Retourne le libellé d'un rôle
     */
    public static function getRoleLabel(string $role): string {
        $labels = [
            self::ELEVE => 'Élève',
            self::ENSEIGNANT => 'Enseignant',
            self::INSPECTEUR => 'Inspecteur',
            self::ADMINISTRATEUR => 'Administrateur',
            self::PARENT => 'Parent',
            self::PREFET => 'Préfet',
            self::DIRECTEUR_DISCIPLINE => 'Directeur de discipline',
            self::PROVISEUR => 'Proviseur',
            self::CHEF_CLASSE => 'Chef de classe',
            self::PRESIDENT_ELEVES => 'Président des élèves',
            self::COMITE_PARENTS => 'Comité de parents'
        ];
        
        return $labels[$role] ?? $role;
    }
}
?>
