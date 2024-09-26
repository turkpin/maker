<?php

namespace Turkpin\Maker\Console\View;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\CommandHelper;

class MakeViewCommand extends Command
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('view')
            ->setDescription('Create views, including list, show, add, and edit')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The name(s) of the view(s)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');

        CommandHelper::run('list_view', $names, $this->application, $output);
        CommandHelper::run('show_view', $names, $this->application, $output);
        CommandHelper::run('add_view', $names, $this->application, $output);
        CommandHelper::run('edit_view', $names, $this->application, $output);

        return Command::SUCCESS;
    }
}
