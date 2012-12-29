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

namespace TylerSommer\QuickLicense\Handler\Formatter;

class CStyleFormatter implements FormatterInterface
{
    /**
     * Formats the given license
     *
     * @param string $license
     *
     * @return string The formatted license
     */
    public function formatLicense($license)
    {
        $lines = explode("\n\n", trim($license));

        $formattedLicense = "/*\n";

        foreach ($lines as $line) {
            $formattedLicense .= $this->formatLine($line) . $this->formatLine('');
        }

        return rtrim($formattedLicense, "* \n") . "\n */\n";
    }

    private function formatLine($line)
    {
        $formattedLine = '';
        $line = str_replace("\n", ' ', $line);
        do {
            $line = ' * ' . $line;
            $pos = strlen($line);

            if ($pos > 79) {
                $pos = 79;

                do {
                    if (' ' === $line{$pos}) {
                        break;
                    }

                    $pos--;
                } while ($pos > 0);
            }

            $formattedLine .= rtrim(substr($line, 0, $pos)) . "\n";
            $line = substr($line, $pos + 1);
        } while (strlen($line) > 0);

        return $formattedLine;
    }
}
