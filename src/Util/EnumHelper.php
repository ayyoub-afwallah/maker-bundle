<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Component\Finder\Finder;

class EnumHelper
{
    public function __construct(private FileManager $fileManager)
    {
    }

    public function getAllEnums(): array
    {
        $enums = [];
        $finder = new Finder();

        // Check all PHP files in src/ folder
        $finder->files()
            ->in($this->fileManager->getRootDirectory().'/src')
            ->name('*.php');

        foreach ($finder as $file) {
            $relativePath = str_replace([$this->fileManager->getRootDirectory().'/src/', '.php'], ['', ''], $file);
            $className = 'App\\'.str_replace('/', '\\', $relativePath);

            if (enum_exists($className)) {
                $enums[] = $className;
            }
        }

        return $enums;
    }
}
