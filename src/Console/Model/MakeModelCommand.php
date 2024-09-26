<?php

namespace Turkpin\Maker\Console\Model;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Turkpin\Maker\Helpers\CommandHelper;

class MakeModelCommand extends Command
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
            ->setName('model')
            ->setDescription('Create models, including Entity, Service, and Repository')
            ->addArgument('names', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'The name(s) of the model(s)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names = $input->getArgument('names');

        CommandHelper::run('entity', $names, $this->application, $output);
        CommandHelper::run('service', $names, $this->application, $output);
        CommandHelper::run('repository', $names, $this->application, $output);
        CommandHelper::run('factory', $names, $this->application, $output);
        CommandHelper::run('seeder', $names, $this->application, $output);

        return Command::SUCCESS;
    }
}
