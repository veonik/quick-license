quick-license
=============

[![Build Status](https://travis-ci.org/tyler-sommer/quick-license.png?branch=master)](https://travis-ci.org/tyler-sommer/quick-license)

Quickly add license text to all files in your project

This application will insert license text into each of your project files, if it does not already have it. It was
written because the alternative, manual way of accomplishing this is just way too difficult.


Installation
------------

Clone the repository:

    git clone git://github.com/tyler-sommer/quick-license.git

Quick License uses Composer for dependency management. If you don't have composer, go ahead and:

    curl -s https://getcomposer.org/installer | php

Then install the necessary dependencies:

    php composer.phar install


Usage
-----

 Quick License inserts the specified license text into your project files:

     quick-license --license-file=/path/to/license path

 The path may be either a single file or a directory. The license file will usually be the LICENSE file in your
 project's root folder.


 Optionally, you can specify which types of files you want to be processed:

     quick-license --extensions=["php","js"] --license-file=/path/to/license path

 Supported file extensions:

     php
