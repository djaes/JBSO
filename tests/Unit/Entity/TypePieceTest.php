<?php
// tests/Unit/Entity/TypePieceTest.php
namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use JBSO\Entity\TypePiece;

class TypePieceTest extends TestCase
{
    public function testGetAndSetId()
    {
        $typePiece = new TypePiece();
        $typePiece->setId(1);
        $this->assertEquals(1, $typePiece->getId());
    }

    public function testGetAndSetLabel()
    {
        $typePiece = new TypePiece();
        $typePiece->setLabel('Salon');
        $this->assertEquals('Salon', $typePiece->getLabel());
    }
}
