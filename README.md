quick-license
=============

Quickly add license text to all files in your project

This application will insert license text into each of your project files, if it does not already have it. It was
written because the alternative, manual way of accomplishing this is just way too difficult.


Installation
------------

Install via packagist


Usage
-----

Quick License inserts the specified license text into your project files:

     quick-license path

 The path may be either a single file or a directory.


 You can specify which types of files you wanted handled:

     quick-license --extensions=["php","js"] --license-file=/path/to/license path

 Supported file extensions:
   php

