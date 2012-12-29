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

/**
 * Base class for any language handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var string The body of the license
     */
    protected $license;

    /**
     * @var string The formatted, ready-to-be-inserted license
     */
    protected $formattedLicense;

    /**
     * @var Formatter\FormatterInterface
     */
    protected $formatter;

    /**
     * Constructor
     *
     * @param string $license The body of the license
     */
    public function __construct($license = null)
    {
        if (null !== $license) {
            $this->setLicense($license);
        }
    }

    /**
     * Gets the associated formatter
     *
     * @return Formatter\FormatterInterface
     */
    abstract protected function getFormatter();

    /**
     * Gets the formatted license
     *
     * @return string
     */
    public function getFormattedLicense()
    {
        return $this->formattedLicense;
    }

    /**
     * Returns true if the given file contents does not already contain license text
     *
     * @param string $contents
     *
     * @return bool
     */
    public function doesFileNeedProcessing($contents)
    {
        return false === strpos($contents, $this->formattedLicense);
    }

    /**
     * Sets the license
     *
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
        $this->formattedLicense = $this->getFormatter()->formatLicense($license);
    }
}

