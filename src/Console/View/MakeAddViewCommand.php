<?php

namespace Turkpin\Maker\Console\View;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\MakerHelper;

class MakeAddViewCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('add_view')
            ->setDescription('Create add view, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The add view names or directory and add view names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        MakerHelper::processItems('add_view', $input, $output);
        return Command::SUCCESS;
    }
}
