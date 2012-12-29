<?php

/*
 * Copyright (c) 2012 Tyler Sommer
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

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
    const VERSION = '0.1.2';

    /**
     * @var \TylerSommer\QuickLicense\Handler\HandlerFactoryInterface
     */
    protected $handlerFactory;

    /**
     * Constructor
     *
     * @param \TylerSommer\QuickLicense\Handler\HandlerFactoryInterface $handlerFactory
     */
    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;

        parent::__construct('Quick License', self::VERSION);
    }

    /**
     * @return \TylerSommer\QuickLicense\Handler\HandlerFactoryInterface
     */
    public function getHandlerFactory()
    {
        return $this->handlerFactory;
    }

    /**
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    public function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputOption('--help',           '-h', InputOption::VALUE_NONE, 'Display this help message.')
        ));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'quick-license';
    }

    /**
     * @return array
     */
    protected function getDefaultCommands()
    {
        $mainCommand = new QuickLicenseCommand($this->handlerFactory);

        return array($mainCommand, new HelpCommand($mainCommand));
    }
}
