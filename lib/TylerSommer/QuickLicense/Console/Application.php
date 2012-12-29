<?php

namespace TylerSommer\QuickLicense\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use TylerSommer\QuickLicense\Command\HelpCommand;
use TylerSommer\QuickLicense\Command\QuickLicenseCommand;
use TylerSommer\QuickLicense\Handler\HandlerFactoryInterface;

class Application extends BaseApplication
{
    const VERSION = '0.1.0';

    /**
     * @var \TylerSommer\QuickLicense\Handler\HandlerFactoryInterface
     */
    protected $handlerFactory;

    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;

        parent::__construct('Quick License', self::VERSION);
    }

    public function getHandlerFactory()
    {
        return $this->handlerFactory;
    }

    public function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputOption('--help',           '-h', InputOption::VALUE_NONE, 'Display this help message.')
        ));
    }

    protected function getCommandName(InputInterface $input)
    {
        return 'quick-license';
    }

    protected function getDefaultCommands()
    {
        $mainCommand = new QuickLicenseCommand($this->handlerFactory);

        return array($mainCommand, new HelpCommand($mainCommand));
    }
}
