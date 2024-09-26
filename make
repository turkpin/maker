#!/usr/bin/env php
<?php

use Turkpin\Maker\Console\MakeCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Turkpin\Maker\Console\View\MakeViewCommand;
use Turkpin\Maker\Console\Model\MakeModelCommand;
use Turkpin\Maker\Console\route\MakeRouteCommand;
use Turkpin\Maker\Console\Model\MakeEntityCommand;
use Turkpin\Maker\Console\Model\MakeSeederCommand;
use Turkpin\Maker\Console\View\MakeAddViewCommand;
use Symfony\Component\Console\Output\ConsoleOutput;
use Turkpin\Maker\Console\Model\MakeFactoryCommand;
use Turkpin\Maker\Console\Model\MakeServiceCommand;
use Turkpin\Maker\Console\View\MakeEditViewCommand;
use Turkpin\Maker\Console\View\MakeListViewCommand;
use Turkpin\Maker\Console\View\MakeShowViewCommand;
use Turkpin\Maker\Console\Model\MakeRepositoryCommand;
use Turkpin\Maker\Console\Controller\MakeControllerCommand;


if (PHP_SAPI !== 'cli') {
    echo 'This script can only be run from the command line.';
    exit(1);
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../autoload.php')) {
    require __DIR__ . '/../../autoload.php';
} else {
    echo 'Autoload file not found.';
    exit(1);
}

$application = new Application();

$application->setName('Turkpin Maker');
$application->setVersion('1.0.0');

$application->addCommands([
    new MakeRouteCommand(),
    new MakeEntityCommand(),
    new MakeServiceCommand(),
    new MakeRepositoryCommand(),
    new MakeFactoryCommand(),
    new MakeSeederCommand(),
    new MakeListViewCommand(),
    new MakeShowViewCommand(),
    new MakeEditViewCommand(),
    new MakeAddViewCommand(),
    new MakeControllerCommand(),
    new MakeCommand($application),
    new MakeModelCommand($application),
    new MakeViewCommand($application),
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
