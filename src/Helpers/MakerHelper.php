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

        $directory = count($names) > 1 ? $names[0] : null;
        $items = count($names) > 1 ? array_slice($names, 1) : [$names[0]];

        foreach ($items as $item) {
            self::createItem($type, $item, $filesystem, $output, $directory);
        }
    }

    public static function createItem(
        string $type,
        string $name,
        Filesystem $filesystem,
        OutputInterface $output,
        string $baseDir = null
    ) {
        $name = ucfirst($name);
        $type = ucfirst($type);

        $dirMap = [
            'models' => ['Entity', 'Repository', 'Factory', 'Service', 'Seeder'],
            'controllers' => ['Controller']
        ];

        foreach ($dirMap as $dir => $types) {
            if (in_array($type, $types)) {
                if ($type === 'Controller') {
                    echo $dirPath = $baseDir ? "{$dir}/{$baseDir}" : $dir;
                    $name = self::pluralizeNameIfNecessary($name, $type);
                } else {
                    $dirPath = $baseDir ? "{$dir}/{$baseDir}/{$name}" : "{$dir}/{$name}";
                }
                break;
            }
        }

        $path = "{$dirPath}/{$name}{$type}.php";

        DirectoryHelper::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = TemplateHelper::render(strtolower($type), ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>{$name}{$type} created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>{$name}{$type} already exists at {$path}.</error>");
        }
    }

    private static function pluralizeNameIfNecessary(string $name, string $type): string
    {
        if ($type === 'Controller') {
            $inflector = new EnglishInflector();
            return $inflector->pluralize($name)[0];
        }
        return $name;
    }
}
