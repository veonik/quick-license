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

namespace TylerSommer\QuickLicense\Command;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TylerSommer\QuickLicense\Handler\HandlerFactoryInterface;
use TylerSommer\QuickLicense\Processor\DirectoryProcessor;
use TylerSommer\QuickLicense\Processor\FileProcessor;

class QuickLicenseCommand extends Command
{
    /**
     * @var \TylerSommer\QuickLicense\Handler\HandlerFactoryInterface
     */
    protected $handlerFactory;

    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;

        parent::__construct();
    }

    public function configure()
    {
        $helpText = <<<END
<comment>Quick License</comment> inserts the specified license text into your project files:

    <info>quick-license --license-file=/path/to/license path</info>

The path may be either a single file or a directory. The license file will usually be the LICENSE file in your
project's root folder.


Optionally, you can specify which types of files you want to be processed:

    <info>quick-license --extensions=["php","js"] --license-file=/path/to/license path</info>

<comment>Supported file extensions:</comment>
END;

        foreach ($this->handlerFactory->getSupportedExtensions() as $extension) {
            $helpText .= "\n  " . $extension;
        }

        $this->setName('quick-license')
            ->setDescription('Adds license text to files')
            ->addArgument('path', InputArgument::REQUIRED, 'Path or file to process')
            ->addOption('license-file', 'l', InputOption::VALUE_REQUIRED, 'File containing the license text')
            ->addOption('extensions', 'e', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'File extensions to process', $this->handlerFactory->getSupportedExtensions())
            ->addOption('help', 'h', InputOption::VALUE_NONE, 'Displays this help text')
            ->setHelp($helpText);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileLocator = new FileLocator(getcwd());

        $licenseFile = $input->getOption('license-file');
        try {
            $licenseFile = $fileLocator->locate($licenseFile);
        } catch (\InvalidArgumentException $e) {
            throw new \RuntimeException('The specified license file does not exist.');
        }

        $license = file_get_contents($licenseFile);

        $path = $input->getArgument('path');
        try {
            $path = $fileLocator->locate($path);
        } catch (\InvalidArgumentException $e) {
            throw new \RuntimeException('The specified path does not exist.');
        }

        $enabledExtensions = $input->getOption('extensions');
        $this->handlerFactory->setEnabledExtensions($enabledExtensions);

        foreach ($this->handlerFactory->getHandlers() as $handler) {
            $handler->setLicense($license);
        }

        if (is_dir($path)) {
            $processor = new DirectoryProcessor($this->handlerFactory);
        } else {
            $processor = new FileProcessor($this->handlerFactory);
        }

        $processor->processPath($path);
    }

    public function setHandlerFactory(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
    }
}
