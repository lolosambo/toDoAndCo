DOCKER = docker

ENV_PHP = $(DOCKER) exec toDoAndCo_php-fpm
ENV_COMPOSER = $(ENV_PHP) composer
ENV_BLACKFIRE = $(DOCKER) exec toDoAndCo_blackfire

## SYMFONY commandes
console:
	    $(ENV_PHP) ./bin/console $(COMMAND)

## ENV commandes
cache-clear: var/cache
	    $(ENV_PHP) rm -rf var/cache/*

router: ##debug router
	    $(ENV_PHP) ./bin/console debug:router

container: ##debug container
	    $(ENV_PHP) ./bin/console debug:container

## DOCTRINE commands
create-database: #create postrgesql database
	    $(ENV_PHP) ./bin/console doctrine:database:create

schema-validate:
	    $(ENV_PHP) ./bin/console doctrine:schema:validate 

schema-update:
	    $(ENV_PHP) ./bin/console doctrine:schema:update --force

doctrine-cache-clear: ## make the doctrine cache empty
	    $(ENV_PHP) ./bin/console doctrine:cache:clear-metadata

fixtures: ## load fixtures in the database
	    $(ENV_PHP) ./bin/console doctrine:fixtures:load --env=test

drop-database: ##cancel full database
	    $(ENV_PHP) ./bin/console doctrine:database:drop --force


## PHPUNIT commands
all-tests: tests
	    $(ENV_PHP) ./vendor/bin/phpunit -v

unit-tests: tests
	    $(ENV_PHP) ./vendor/bin/phpunit -v  --group unit

functional-tests: tests
	    $(ENV_PHP) ./vendor/bin/phpunit -v --group functional

blackfire-tests: tests
	    $(ENV_PHP) ./vendor/bin/phpunit -v --group Blackfire

coverage: tests
	    $(ENV_PHP) ./vendor/bin/phpunit --coverage-html web/test-coverage

## COMPOSER commands
require: composer.json
	    $(ENV_COMPOSER) require $(PACKAGE)

recipes: composer.json
	    $(ENV_COMPOSER) req  $(PACKAGE)

require-dev: composer.json
	    $(ENV_COMPOSER) require $(PACKAGE) --dev

composer-update: composer.lock
	    $(ENV_COMPOSER) update

composer-install: composer.lock
	    $(ENV_COMPOSER) install

autoload: composer.json
	    $(ENV_COMPOSER) dump-autoload -o

## BLACKFIRE commands
profile: ##profile a route with Blackfire
	    $(ENV_BLACKFIRE) blackfire curl http://172.18.0.1:8086$(URL) --samples $(SAMPLES)

blackfire-config: ##Blackfire config
	    $(ENV_BLACKFIRE) blackfire config

## CS FIXER commands
csfixer: ##profile a route with Blackfire
	    $(ENV_PHP) php-cs-fixer fix $(FOLDER)


