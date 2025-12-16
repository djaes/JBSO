<?php
// src/Entity/TypeTacheElementTraitement.php
namespace JBSO\Entity;

class TypeTacheElementTraitement extends AbstractEntity
{
    protected  ?int $type_element_id;
    protected  ?int $type_traitement_id;
    protected  ?int $type_finition_id;
    protected  ?int $type_tache_id;
    protected  ?int $ordre;
    
    // Getters 
    public function getTypeElementId(): ?int { return $this->type_element_id; }
    public function getTypeTraitementId(): ?int { return $this->type_traitement_id; }
    public function getTypeFinitionId(): ?int { return $this->type_finition_id; }
    public function getTypeTacheId(): ?int { return $this->type_tache_id; }
    public function getOrdre(): ?int { return $this->ordre; }

    // Setters
    public function setTypeElementId(?int $type_element_id): void { $this->type_element_id = $type_element_id; }
    public function setTypeTraitementId(?int $type_traitement_id): void { $this->type_traitement_id = $type_traitement_id; }
    public function setTypeFinitionId(?int $type_finition_id): void { $this->type_finition_id = $type_finition_id; }
    public function setTypeTacheId(?int $type_tache_id): void { $this->type_tache_id = $type_tache_id; }
    public function setOrdre(?int $ordre): void { $this->ordre = $ordre; }
    
}
