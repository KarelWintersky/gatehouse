#!/usr/bin/env make

SHELL = /bin/bash
PROJECT  = "gatekeeper"
TARGET = /var/www/$(PROJECT)
WWW_ROOT = /var/www/$(PROJECT)/www

help:   ##@help Help
	@perl -e '$(HELP_ACTION)' $(MAKEFILE_LIST)

update:         ##@update Update project from GIT and build version file
	@echo Updating project from GIT
	@git pull
	@echo Updating version file...
	@git log --oneline --format=%B -n 1 HEAD | head -n 1 > ./www/.version
	@git log --oneline --format="%at" -n 1 HEAD | xargs -I{} date -d @{} +%Y-%m-%d >> ./www/.version
	@git rev-parse --short HEAD >> ./www/.version
	@chown www-data:www-data -R *
	@echo Updated.

build:          ##build Build DEB package
	@cd www/ && composer install

#install:		##install Install project to working directory
#	install -d $(TARGET)
#	cp -r www/* $(TARGET)/*


# ------------------------------------------------
# Add the following 'help' target to your makefile, add help text after each target name starting with '##'
# A category can be added with @category
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
WHITE  := $(shell tput -Txterm setaf 7)
RESET  := $(shell tput -Txterm sgr0)
HELP_ACTION = \
	%help; while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-_]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
	print "usage: make [target]\n\n"; for (sort keys %help) { print "${WHITE}$$_:${RESET}\n"; \
	for (@{$$help{$$_}}) { $$sep = " " x (32 - length $$_->[0]); print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; }; \
	print "\n"; }

# -eof-

