<?php

namespace Turkpin\Maker\Console\View;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\MakerHelper;

class MakeEditViewCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('edit_view')
            ->setDescription('Create edit view, optionally inside a directory')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The edit view names or directory and edit view names');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        MakerHelper::processItems('edit_view', $input, $output);
        return Command::SUCCESS;
    }
}
