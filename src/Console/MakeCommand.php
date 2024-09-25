<?php

namespace Turkpin\Maker\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\CommandHelper;

class MakeCommand extends Command
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
            ->setName('make')
            ->setDescription('General make command that runs Entity, Service, Repository, and Controller')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The name of the class (Entity, Service, Repository, and Controller will be created)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');

        CommandHelper::run('model', $names, $this->application, $output);
        CommandHelper::run('controller', $names, $this->application, $output);

        return Command::SUCCESS;
    }
}
