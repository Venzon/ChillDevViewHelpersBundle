##
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDev\Bundle\ViewHelpersBundle
##

# environment-vary commands
PHP = $(shell which php)
COMPOSER = $(shell which composer.phar)
PHPDOC = $(shell which phpdoc)
PHPCS = ./vendor/bin/phpcs
PHPUNIT = ./vendor/bin/phpunit

# meta-targets

default: all

all: check lint tests documentation

# project initialization
init:
	$(COMPOSER) install

# update composer dependencies
update:
	$(COMPOSER) update

# syntax checking
check:
	find . -path "./vendor" -prune -o -name "*.php" -exec $(PHP) -l {} \;

# conde linting
lint:
	$(PHPCS) --standard=PSR2 --encoding=utf-8 --extensions=php --ignore=Tests --ignore=vendor --ignore=Resources .

# tests running
tests:
	$(PHPUNIT)

# documentation generation
documentation:
	$(PHPDOC) -t Resources/doc/gh-pages -d . -i "Tests/*" -i "vendor/*" -i "Resources/*" --title "ChillDev ViewHelpers Bundle - by Chillout Development" --sourcecode --parseprivate
