<?php

namespace TylerSommer\QuickLicense\Processor;

use TylerSommer\QuickLicense\Handler\HandlerFactoryInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    protected $handlerFactory;

    public function __construct(HandlerFactoryInterface $handlerFactory)
    {
        $this->handlerFactory = $handlerFactory;
    }
}
