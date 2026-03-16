<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Tests\Util;

use Composer\Autoload\ClassLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Util\EnumHelper;

class EnumHelperTest extends TestCase
{
    private string $fixturesDir = __DIR__.'/fixtures/enum_helper';
    private ClassLoader $classLoader;

    protected function setUp(): void
    {
        $this->classLoader = new ClassLoader();
        $this->classLoader->addPsr4('App\\', $this->fixturesDir.'/src');
        $this->classLoader->register(true);
    }

    protected function tearDown(): void
    {
        $this->classLoader?->unregister();
    }

    public function testGetAllEnumsReturnsEnumClasses(): void
    {
        $fileManager = $this->createMock(FileManager::class);
        $fileManager->method('getRootDirectory')
            ->willReturn($this->fixturesDir);

        $enumHelper = new EnumHelper($fileManager);
        $enums = $enumHelper->getAllEnums();

        $this->assertCount(2, $enums);
        $this->assertContains('App\\Enum\\Status', $enums);
        $this->assertContains('App\\Enum\\Priority', $enums);
    }

    public function testGetAllEnumsExcludesNonEnumClasses(): void
    {
        $fileManager = $this->createMock(FileManager::class);
        $fileManager->method('getRootDirectory')
            ->willReturn($this->fixturesDir);

        $enumHelper = new EnumHelper($fileManager);
        $enums = $enumHelper->getAllEnums();

        $this->assertNotContains('App\\Entity\\User', $enums);
    }

    public function testGetAllEnumsReturnsEmptyArrayWhenSrcDirDoesNotExist(): void
    {
        $fileManager = $this->createMock(FileManager::class);
        $fileManager->method('getRootDirectory')
            ->willReturn(__DIR__.'/nonexistent');

        $enumHelper = new EnumHelper($fileManager);
        $enums = $enumHelper->getAllEnums();

        $this->assertIsArray($enums);
        $this->assertEmpty($enums);
    }
}

