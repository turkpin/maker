<?php

namespace Turkpin\Maker\Helpers;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\String\Inflector\EnglishInflector;

class MakerHelper
{
    protected static $config = [];

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

        $directory = self::$config['directories'][strtolower($type)] ?? [];
        $template = self::$config['templates'][strtolower($type)] ?? [];
        $variables = self::$config['variables'][strtolower($type)] ?? [];
        $extension = self::$config['extensions'][strtolower($type)] ?? [];

        $name = ucfirst($name);
        $type = ucfirst($type);

        $dirPath = $baseDir ? "{$directory}/{$baseDir}/{$name}" : "{$directory}/{$name}";
        $path = "{$dirPath}/{$name}{$type}.{$extension}";

        if ($type === 'Controller') {
            $name = self::pluralizeNameIfNecessary($name);
            $dirPath = $baseDir ? "{$directory}/{$baseDir}" : $directory;
            $path = "{$dirPath}/{$name}{$type}.{$extension}";
        }

        if (str_contains($type, '_view')) {
            $name = self::pluralizeNameIfNecessary($name);
            $type = lcfirst(str_replace('_view', '', $type));
            $dirPath = $baseDir ? "{$directory}/{$baseDir}/{$name}" : "{$directory}/{$name}";
            $path = "{$dirPath}/{$type}.{$extension}";
        }

        if ($type === 'Route') {
            $dirPath = $directory;
            $tpye_name = lcfirst(self::pluralizeNameIfNecessary($type));
            $path = "{$directory}/{$tpye_name}.{$extension}";
        }

        $Name = $name;
        $name = lcfirst($name);

        DirectoryHelper::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path) || $type === 'Route') {
            foreach ($variables as $key => $value) {
                if (is_numeric($key)) {
                    $variables[$value] = $$value;
                    unset($variables[$key]);
                }
            }

            $content = TemplateHelper::render($template, $variables);

            if ($filesystem->exists($path) && $type === 'Route') {
                $content = str_replace("<?php\n", '', $content);
            }

            $filesystem->appendToFile($path, $content);
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
        $config_files = [
            'maker-preset.yaml',
            'maker.yaml',
        ];

        foreach ($config_files as $config_file) {
            if (file_exists($config_file)) {
                self::$config = Yaml::parseFile($config_file);
                return;
            }
        }
    }
}
