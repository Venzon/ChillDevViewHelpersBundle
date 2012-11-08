##
# @author Rafał Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
# @copyright 2012 © by Rafał Wrzeszcz - Wrzasq.pl.
# @version 0.0.1
# @since 0.0.1
# @package ChillDevViewHelpersBundle
##

PHP = $(shell which php)
COMPOSER = $(shell which composer.phar)

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
	#TODO

# tests running
test:
	#TODO

# documentation generation
documentation:
	#TODO
