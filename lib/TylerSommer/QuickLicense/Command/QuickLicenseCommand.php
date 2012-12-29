<?php

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

    <info>quick-license path</info>

The path may be either a single file or a directory.


You can specify which types of files you wanted handled:

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
