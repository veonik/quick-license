<?php

namespace TylerSommer\QuickLicense\Processor;

use TylerSommer\QuickLicense\Handler\HandlerFactoryInterface;

class FileProcessor extends AbstractProcessor
{
    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        parent::__construct($handlerFactory);
    }

    /**
     * @param string $path
     *
     * @return void
     */
    public function processPath($path)
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (!in_array($extension, $this->handlerFactory->getSupportedExtensions())) {
            return;
        }

        $handler = $this->handlerFactory->getExtensionHandler($extension);
        $contents = file_get_contents($path);

        if ($handler->doesFileNeedProcessing($contents)) {
            file_put_contents($path, $handler->process($contents));
        }
    }
}
