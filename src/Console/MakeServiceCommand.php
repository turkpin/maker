<?php

namespace Turkpin\Maker\Console;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\Template;
use Turkpin\Maker\Helpers\Directory;
use Turkpin\Maker\Helpers\MakerHelper;

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
        MakerHelper::processItems('service', $input, $output);
        return Command::SUCCESS;
    }
}
