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
 * File Extension Handler Interface
 *
 * Defines the contract any file extension handler must follow
 */
interface HandlerInterface
{
    /**
     * Sets the license body
     *
     * @param string $license
     *
     * @return void
     */
    public function setLicense($license);

    /**
     * Gets the array of supported extensions
     *
     * @return array
     */
    public function getSupportedExtensions();

    /**
     * Inserts the given license text into the file contents
     *
     * @param string $contents
     *
     * @return string The processed contents
     */
    public function process($contents);

    /**
     * Returns true if the given file contents does not already contain license text
     *
     * @param string $contents
     *
     * @return bool
     */
    public function doesFileNeedProcessing($contents);
}
