<?php

namespace Turkpin\Maker\Console;

use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\MakerHelper;

class MakeRepositoryCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('repository')
            ->setDescription('Create repositories, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The repository names or directory and repository names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        MakerHelper::processItems('repository', $input, $output);
        return Command::SUCCESS;
    }
}
