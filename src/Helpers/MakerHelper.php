<?php

namespace Turkpin\Maker\Helpers;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\String\Inflector\EnglishInflector;

class MakerHelper
{
    public static function processItems(
        string $type,
        InputInterface $input,
        OutputInterface $output
    ) {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            self::createItem($type, $names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $items = array_slice($names, 1);

            foreach ($items as $item) {
                self::createItem($type, $item, $filesystem, $output, $directory);
            }
        }
    }

    public static function createItem(
        string $type,
        string $name,
        Filesystem $filesystem,
        OutputInterface $output,
        string $baseDir = null
    ) {
        if ($type === 'controller') {
            $inflector = new EnglishInflector();
            $namePlural = $inflector->pluralize($name)[0]; // İlk çoğul formu al
            $name = "{$namePlural}Controller";
        }

        // Alt klasör yapısı yalnızca 'controller' değilse oluşturulacak
        if ($type === 'controller') {
            $dirPath = $baseDir ? "controllers/{$baseDir}" : "controllers";
        } else {
            $dirPath = $baseDir ? "{$type}/{$baseDir}/{$name}" : "{$type}/{$name}";
        }

        $path = "{$dirPath}/{$name}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render($type, ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>{$type} '{$name}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>{$type} '{$name}' already exists at {$path}.</error>");
        }
    }
}
