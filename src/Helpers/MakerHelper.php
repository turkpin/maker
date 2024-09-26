<?php

namespace Turkpin\Maker\Helpers;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Inflector\EnglishInflector;

class MakerHelper
{
    protected static $config;

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
        self::loadConfig();

        $directory = self::$config['directories'][strtolower($type)];
        $template = self::$config['templates'][strtolower($type)];
        $variables = self::$config['variables'][strtolower($type)];
        $extension = self::$config['extensions'][strtolower($type)];

        $name = ucfirst($name);
        $type = ucfirst($type);

        if ($type === 'Controller') {
            $name = self::pluralizeNameIfNecessary($name);
            $dirPath = $baseDir ? "{$directory}/{$baseDir}" : $directory;
        } else {
            $dirPath = $baseDir ? "{$directory}/{$baseDir}/{$name}" : "{$directory}/{$name}";
        }

        $path = "{$dirPath}/{$name}{$type}.{$extension}";

        DirectoryHelper::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            foreach ($variables as $key => $value) {
                if (is_numeric($key)) {
                    $variables[$value] = $$value;
                    unset($variables[$key]);
                }
            }

            $content = TemplateHelper::render($template, $variables);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>{$name}{$type} created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>{$name}{$type} already exists at {$path}.</error>");
        }
    }

    private static function pluralizeNameIfNecessary(string $name): string
    {
        $inflector = new EnglishInflector();
        return $inflector->pluralize($name)[0];
    }

    public static function loadConfig()
    {
        self::$config = self::Preset();

        if (file_exists('maker.yaml')) {
            $config = Yaml::parseFile('maker.yaml');
            self::$config = ArrayHelper::arrayMergeRecursiveDistinct(self::$config, $config);
        }
    }

    private static function Preset()
    {
        return [
            'directories' => [
                'controller' => 'controllers',
                'entity' => 'models',
                'repository' => 'models',
                'factory' => 'models',
                'service' => 'models',
                'seeder' => 'models',
            ],
            'templates' => [
                'controller' => 'Templates/Controller/ControllerTemplate.stub',
                'entity' => 'Templates/Model/EntityTemplate.stub',
                'repository' => 'Templates/Model/RepositoryTemplate.stub',
                'factory' => 'Templates/Model/FactoryTemplate.stub',
                'service' => 'Templates/Model/ServiceTemplate.stub',
                'seeder' => 'Templates/Model/SeederTemplate.stub',
            ],
            'extensions' => [
                'controller' => 'php',
                'entity' => 'php',
                'repository' => 'php',
                'factory' => 'php',
                'service' => 'php',
                'seeder' => 'php',
            ],
            'variables' => [
                'controller' => ['name'],
                'entity' => ['name'],
                'repository' => ['name'],
                'factory' => ['name'],
                'service' => ['name'],
                'seeder' => ['name'],
            ],
        ];
    }
}
