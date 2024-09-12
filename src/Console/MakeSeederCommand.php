<?php

namespace Turkpin\Maker\Console;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;

class MakeSeederCommand extends Command
{
    protected static $defaultName = 'seeder';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create seeders, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The seeder names or directory and seeder names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            $this->createSeeder($names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $seeders = array_slice($names, 1);

            foreach ($seeders as $seeder) {
                $this->createSeeder($seeder, $filesystem, $output, $directory);
            }
        }

        return Command::SUCCESS;
    }

    private function createSeeder($name, Filesystem $filesystem, OutputInterface $output, $baseDir = null)
    {
        $seederName = "{$name}Seeder";

        $dirPath = $baseDir ? "models/{$baseDir}/{$name}" : "models/{$name}";
        $path = "{$dirPath}/{$seederName}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render(self::$defaultName, ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>Seeder '{$seederName}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>Seeder '{$seederName}' already exists at {$path}.</error>");
        }
    }
}
