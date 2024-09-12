<?php

namespace Turkpin\Maker\Console;

use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeControllerCommand extends Command
{
    protected static $defaultName = 'controller';
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create controllers, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The controller names or directory and controller names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            $this->createController($names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $controllers = array_slice($names, 1);

            foreach ($controllers as $controller) {
                $this->createController($controller, $filesystem, $output, $directory);
            }
        }

        return Command::SUCCESS;
    }

    private function createController($name, Filesystem $filesystem, OutputInterface $output, $baseDir = null)
    {
        $namePlural = "{$name}s";
        $controllerName = "{$namePlural}Controller";

        $dirPath = $baseDir ? "controllers/{$baseDir}" : "controllers";
        $path = "{$dirPath}/{$controllerName}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render(self::$defaultName, ['name' => $namePlural]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>Controller '{$controllerName}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>Controller '{$controllerName}' already exists at {$path}.</error>");
        }
    }
}
