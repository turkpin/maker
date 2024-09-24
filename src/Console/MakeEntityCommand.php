<?php

namespace Turkpin\Maker\Console;

use Turkpin\Maker\Helpers\MakerHelper;
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
        MakerHelper::processItems('entity', $input, $output);
        return Command::SUCCESS;
    }
}
