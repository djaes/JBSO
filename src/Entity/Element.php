<?php
namespace JBSO\Entity;

class Element
{
    private int $id;
    private string $nom;
    private TypeElement $typeElement;
    private Piece $piece;
    private DegreFinition $degreFinition;
    private ?Couleur $couleur;

    // Getters et Setters
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function getTypeElementId(): TypeElement { return $this->typeElement; }
    public function setTypeElementId(TypeElement $typeElement): void { $this->typeElement = $typeElement; }
    public function getPiece(): Piece { return $this->piece; }
    public function setPiece(Piece $piece): void { $this->piece = $piece; }
    public function getDegreFinition(): DegreFinition { return $this->degreFinition; }
    public function setDegreFinition(DegreFinition $degreFinition): void { $this->degreFinition = $degreFinition; }
    public function getCouleur(): ?Couleur { return $this->couleur; }
    public function setCouleur(?Couleur $couleur): void { $this->couleur = $couleur; }
}
