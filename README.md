# PHP CLI COMMON

## Usage

Add the dependency in your composer.json :

    ...
    "require": {
        ...
        "ftven/php-cli-common": "dev-master"
    }

Then update your dependency :

    $ ./composer.phar update ftven/php-cli-common

Then you can use it directly in your scripts :

    <?php

    // ...

    require_once '/path/to/vendor/autoload.php';

    $cli = new Ftven\Build\Application\CliApplication('mytool', '1.0.0');

    $cli->addExtension(new MyNamespace\MyExtension());

    $cli->run();

CliApplication is a full Symfony Console Application, so you can use all available methods on it to add commands, etc...
As a best practices, we recommand not adding directly commands on the CliApplication, rather create an extension.
For further information on creating extension, read CoreExtension class, or search for php-cli-xxx-extension on our GitHub.

Enjoy !

FTVEN Build Team.
