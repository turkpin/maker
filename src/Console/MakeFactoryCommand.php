<?php

namespace Turkpin\Maker\Console;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;

class MakeFactoryCommand extends Command
{
    protected static $defaultName = 'factory';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create factorys, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The factory names or directory and factory names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            $this->createFactory($names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $factorys = array_slice($names, 1);

            foreach ($factorys as $factory) {
                $this->createFactory($factory, $filesystem, $output, $directory);
            }
        }

        return Command::SUCCESS;
    }

    private function createFactory($name, Filesystem $filesystem, OutputInterface $output, $baseDir = null)
    {
        $factoryName = "{$name}Factory";

        $dirPath = $baseDir ? "models/{$baseDir}/{$name}" : "models/{$name}";
        $path = "{$dirPath}/{$factoryName}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render(self::$defaultName, ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>Factory '{$factoryName}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>Factory '{$factoryName}' already exists at {$path}.</error>");
        }
    }
}
