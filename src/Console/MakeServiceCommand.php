<?php

namespace Turkpin\Maker\Console;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;

class MakeServiceCommand extends Command
{
    protected static $defaultName = 'service';

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create services, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The service names or directory and service names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');
        $filesystem = new Filesystem();

        if (count($names) === 1) {
            $this->createService($names[0], $filesystem, $output);
        } elseif (count($names) > 1) {
            $directory = $names[0];
            $services = array_slice($names, 1);

            foreach ($services as $service) {
                $this->createService($service, $filesystem, $output, $directory);
            }
        }

        return Command::SUCCESS;
    }

    private function createService($name, Filesystem $filesystem, OutputInterface $output, $baseDir = null)
    {
        $serviceName = "{$name}Service";

        $dirPath = $baseDir ? "models/{$baseDir}/{$name}" : "models/{$name}";
        $path = "{$dirPath}/{$serviceName}.php";

        Directory::ensureDirectoryExists($dirPath, $filesystem);

        if (!$filesystem->exists($path)) {
            $content = Template::render(self::$defaultName, ['name' => $name]);
            $filesystem->dumpFile($path, $content);
            $output->writeln("<info>Service '{$serviceName}' created successfully at {$path}.</info>");
        } else {
            $output->writeln("<error>Service '{$serviceName}' already exists at {$path}.</error>");
        }
    }
}
