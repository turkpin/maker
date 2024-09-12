<?php

namespace Turkpin\Maker\Helpers;

use Symfony\Component\Filesystem\Filesystem;

class Directory
{
    public static function ensureDirectoryExists($dirPath, Filesystem $filesystem)
    {
        if (!$filesystem->exists($dirPath)) {
            $filesystem->mkdir($dirPath);
        }
    }
}
