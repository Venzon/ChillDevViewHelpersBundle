<!---
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 - 2013 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.1.5
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
-->

# Internals

## Development dependencies

In order to work on **ChillDevViewHelpersBundle** you need to install a few more things then basic dependencies:

-   `phpunit/phpunit` - for running tests;
-   `squizlabs/php_codesniffer` - for coding style rules compilance checking;
-   *phpcpd* - copy-paste detector for duplicated code parts;
-   *phpDocumentor* - for generating API documentation.

Most of them are defined in `composer.json` file, so running `composer.phar --dev install` will do the job. The only things you need to install manualy are [phpDocumentor](http://www.phpdoc.org/) are [phpcpd](https://github.com/sebastianbergmann/phpcpd) which do not have a valid **Composer** package yet. But you probably won't need *phpDocumentor*, since it's only used for publishing documentation. If you want to use it anyway, you will also need `php-xsl` extension.

## Coding style

Currently we just follow [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding rules.

## Makefile targets

This project utilizes `make` as primary build automation tool. It's `Makefile` defines following tasks:

-   `init` - initializes project by loading all **Git** submodules and installing dependencies with [Composer](http://getcomposer.org/);
-   `update` - updates dependencies with **Composer**;
-   `check` - performs syntax checking on all project files using `php -l`;
-   `lint` - checks coding standards compliance with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) and detects duplicated code parts with [phpcpd](https://github.com/sebastianbergmann/phpcpd);
-   `tests` - runs all unit tests and generate coverage report with [phpUnit](http://www.phpunit.de/manual/current/en/index.html);
-   `documentation` - generates project API documentation with [phpDocumentor](http://www.phpdoc.org/).

There are also meta-targets:

-   `all` which executes `check`, `lint`, `tests` and `documentation` subsequently (it is run by default);
-   `ci` which executes `check`, `lint` and `tests` (set of QA targets).

## Continous integration

This project uses [Travis-CI](https://travis-ci.org/) as it's [continous intergation](https://travis-ci.org/chilloutdevelopment/ChillDevViewHelpersBundle) environment. It is configured to evaluate `check`, `lint` and `tests` targets to ensure code matches quality standards.
