# PHP CLI COMMON

[![Build Status](https://travis-ci.org/francetv/php-cli-common.svg?branch=master)](https://travis-ci.org/francetv/php-cli-common)

## Usage

Add the dependency in your composer.json :

    ...
    "require": {
        ...
        "ftven/cli-common": "1.*"
    }

Then update your dependency :

    $ ./composer.phar update ftven/cli-common

Then you can use it directly in your scripts :

    <?php

    // ...

    require_once '/path/to/vendor/autoload.php';

    $cli = new Ftven\Build\Cli\Application\CliApplication('mytool', '1.0.0');

    $cli->addExtension(new MyNamespace\MyExtension());

    $cli->run();

CliApplication is a full Symfony Console Application, so you can use all available methods on it to add commands, etc...
As a best practices, we recommand not adding directly commands on the CliApplication, rather create an extension.
For further information on creating extension, read CoreExtension class, or search for php-cli-xxx-extension on our GitHub.

Enjoy !

FTVEN Build Team.
