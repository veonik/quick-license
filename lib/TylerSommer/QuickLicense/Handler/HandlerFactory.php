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
