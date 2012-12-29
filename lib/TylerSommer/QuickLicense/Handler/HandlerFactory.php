<?php

namespace TylerSommer\QuickLicense\Handler;

class HandlerFactory implements HandlerFactoryInterface
{
    /**
     * @var array|HandlerInterface[]
     */
    protected $map = array();

    /**
     * @var array|HandlerInterface[]
     */
    protected $handlers = array();

    /**
     * Constructor
     *
     * @param array|HandlerInterface[] $handlers
     */
    public function __construct(array $handlers = array())
    {
        foreach ($handlers as $handler) {
            $this->addHandler($handler);
        }
    }

    /**
     * @param HandlerInterface $handler
     *
     * @return HandlerFactoryInterface The current instance
     */
    public function addHandler(HandlerInterface $handler)
    {
        foreach ($handler->getSupportedExtensions() as $extension) {
            $this->map[$extension] = $handler;
            $this->handlers[] = $handler;
        }
    }

    /**
     * @param string $extension
     *
     * @throws HandlerNotFoundException if unable to locate the necessary handler
     * @return HandlerInterface
     */
    public function getExtensionHandler($extension)
    {
        if (!isset($this->map[$extension])) {
            throw HandlerNotFoundException::create($extension);
        }

        return $this->map[$extension];
    }

    /**
     * @return array
     */
    public function getSupportedExtensions()
    {
        return array_keys($this->map);
    }

    /**
     * @param array $extensions
     */
    public function setEnabledExtensions(array $extensions)
    {
        foreach ($this->map as $extension => $handler) {
            if (!in_array($extension, $extensions)) {
                unset($this->map[$extension]);
            }
        }
    }

    /**
     * @return array|HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}
