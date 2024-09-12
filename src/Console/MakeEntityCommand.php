<?php

namespace Turkpin\Maker\Console;

use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeEntityCommand extends Command
{
    protected static $defaultName = 'entity';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create entities, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The entity names or directory and entity names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            $this->createEntity($names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $entities = array_slice($names, 1);

            foreach ($entities as $entity) {
                $this->createEntity($entity, $filesystem, $output, $directory);
            }
        }

        return Command::SUCCESS;
    }

    private function createEntity($name, Filesystem $filesystem, OutputInterface $output, $baseDir = null)
    {
        $entityName = $name;

        $dirPath = $baseDir ? "models/{$baseDir}/{$name}" : "models/{$name}";
        $path = "{$dirPath}/{$entityName}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render(self::$defaultName, ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>Entity '{$entityName}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>Entity '{$entityName}' already exists at {$path}.</error>");
        }
    }
}
