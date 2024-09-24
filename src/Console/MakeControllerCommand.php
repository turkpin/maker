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
use Symfony\Component\String\Inflector\EnglishInflector;

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
        MakerHelper::processItems('controller', $input, $output);
        return Command::SUCCESS;
    }
}
