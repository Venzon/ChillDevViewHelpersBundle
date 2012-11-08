##
# This file is part of the ChillDev ViewHelpers bundle.
#
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDevViewHelpersBundle
##

# environment-vary commands
PHP = $(shell which php)
COMPOSER = $(shell which composer.phar)
PHPDOC = $(shell which phpdoc)
PHPCS = ./tools/phpcs
PHPUNIT = ./tools/phpunit

# meta-targets

default: all

all: check lint test documentation

# project initialization
init:
	$(COMPOSER) install

# update composer dependencies
update:
	$(COMPOSER) update

# syntax checking
check:
	find library -name "*.php" -exec $(PHP) -l {} \;

# conde linting
lint:
	$(PHPCS) --standard=PSR2 --encoding=utf-8 --extensions=php --ignore=library/ChillDev/Bundle/ViewHelpersBundle/Tests library

# tests running
test:
	$(PHPUNIT) library

# documentation generation
doc:
	$(PHPDOC) -t documentation -d library -i "library/ChillDev/Bundle/ViewHelpersBundle/Tests/*" --title "ChillDev ViewHelpers Bundle - by Chillout Development" --sourcecode --parseprivate #TODO
