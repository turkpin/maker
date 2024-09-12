<?php

namespace Turkpin\Maker\Helpers;

use Symfony\Component\Console\Output\OutputInterface;

class Command
{
    public static function run($commandName, $names, $application,  OutputInterface $output)
    {
        $command = $application->find($commandName);

        $input = new \Symfony\Component\Console\Input\ArrayInput([
            'command' => $commandName,
            'names' => $names,
        ]);

        return $command->run($input, $output);
    }
}
