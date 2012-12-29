<?php

namespace TylerSommer\QuickLicense\Command;

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

You can specify which types of files you wanted handled:

    <info>quick-license --extensions=["php","js"] path</info>

<comment>Supported file extensions:</comment>
END;

        foreach ($this->handlerFactory->getSupportedExtensions() as $extension) {
            $helpText .= "\n  " . $extension;
        }

        $this->setName('quick-license')
            ->setDescription('Adds license text to files')
            ->addArgument('path', InputArgument::REQUIRED, 'Path or file to process')
            ->addOption('extensions', 'e', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Which file extensions to process', $this->handlerFactory->getSupportedExtensions())
            ->addOption('help', 'h', InputOption::VALUE_NONE, 'Displays this help text')
            ->setHelp($helpText);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        if (!file_exists($path)) {
            throw new \RuntimeException(sprintf('The specified path does not exist.'));
        }

        $enabledExtensions = $input->getOption('extensions');
        $this->handlerFactory->setEnabledExtensions($enabledExtensions);

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
