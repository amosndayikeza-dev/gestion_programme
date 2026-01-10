<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
}
