<?php
namespace App\Models\academique;
class Activite{
    private $id_activite;
    private $nom_activite;
    private $type;
    private $instruction;
    public function __construct(
        $id_activite = null,
        $nom_activite = null,
        $type = null,
        $instruction = null
    ) {
        $this->id_activite = $id_activite;
        $this->nom_activite = $nom_activite;
        $this->type = $type;
        $this->instruction = $instruction;
    }
    public function getIdActivite(){ return $this->id_activite; }
    public function setIdActivite( $id_activite): void { $this->id_activite = $id_activite; }

    public function getNomActivite(){ return $this->nom_activite; }
    public function setNomActivite( $nom_activite): void { $this->nom_activite = $nom_activite; }

    public function getType(){ return $this->type; }    
    public function setType( $type): void { $this->type = $type; }
    
    public function getInstruction(){ return $this->instruction; }  
    public function setInstruction( $instruction): void { $this->instruction = $instruction; }  

}

?>