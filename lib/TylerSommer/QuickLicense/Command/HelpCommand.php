<?php

namespace TylerSommer\QuickLicense\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\HelpCommand as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class HelpCommand extends BaseCommand
{
    public function __construct(Command $command)
    {
        $this->setCommand($command);

        parent::__construct();
    }
}
