<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Inscription
{
    private  $idInscription;
    private  $idUtilisateur;
    private  $idClasse;
    private  $dateInscription;
    private  $statut;

    public function __construct(
         $idInscription,
         $idUtilisateur,
         $idClasse,
         $dateInscription,
         $statut
    ) {
        $this->idInscription = $idInscription;
        $this->idUtilisateur = $idUtilisateur;
        $this->idClasse = $idClasse;
        $this->dateInscription = $dateInscription;
        $this->statut = $statut;
    }

    public function getIdInscription()  { return $this->idInscription; }
    public function getIdUtilisateur() { return $this->idUtilisateur; }
    public function getIdClasse()  { return $this->idClasse; }
    public function getStatut()  { return $this->statut; }
}
