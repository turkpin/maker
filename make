#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Turkpin\Maker\Console\MakeCommand;
use Symfony\Component\Console\Application;
use Turkpin\Maker\Console\MakeModelCommand;
use Turkpin\Maker\Console\MakeEntityCommand;
use Turkpin\Maker\Console\MakeSeederCommand;
use Turkpin\Maker\Console\MakeFactoryCommand;
use Turkpin\Maker\Console\MakeServiceCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Turkpin\Maker\Console\MakeControllerCommand;
use Turkpin\Maker\Console\MakeRepositoryCommand;
use Symfony\Component\Console\Output\ConsoleOutput;

$application = new Application();

$application->setName('Turkpin Maker');
$application->setVersion('1.0.0');

$application->addCommands([
    new MakeEntityCommand(),
    new MakeServiceCommand(),
    new MakeRepositoryCommand(),
    new MakeControllerCommand(),
    new MakeFactoryCommand(),
    new MakeSeederCommand(),
    new MakeCommand($application),
    new MakeModelCommand($application),
]);

$commandName = $argv[1] ?? null;

if (!$application->has($commandName)) {
    $input = new ArrayInput([
        'command' => 'make',
        'names' => array_slice($argv, 1),
    ]);

    $output = new ConsoleOutput();
    $application->run($input, $output);
} else {
    $application->run();
}
