<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GeneratedEntityTest extends KernelTestCase
{
    public function testEnumIsFound(): void
    {
        self::bootKernel();
        $enumHelper = self::$kernel->getContainer()->get('maker.enum_helper');
        
        $this->assertContains('App\Entity\Enum\Role', $enumHelper->getAllItems());
    }
}
