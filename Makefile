##
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDevViewHelpersBundle
##

# environment-vary commands
PHP = $(shell which php)
COMPOSER = $(shell which composer.phar)
PHPCS = ./tools/phpcs

# project setup
DIRECTORIES = tools/

# meta-targets

default: all

all: check lint test documentation

# project initialization
init: $(DIRECTORIES)
	$(COMPOSER) install

# update composer dependencies
update:
	$(COMPOSER) update

# syntax checking
check:
	find library -name "*.php" -exec $(PHP) -l {} \;

# conde linting
lint:
	$(PHPCS) --standard=PSR2 --encoding=utf-8 --extensions=php library

# tests running
test:
	#TODO

# documentation generation
documentation:
	#TODO

# file-specific rules

$(DIRECTORIES):
	mkdir -p $@
