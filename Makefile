SHELL := /bin/bash

tests:
	APP_ENV=test symfony console doctrine:database:drop --force || true
	APP_ENV=test symfony console doctrine:database:create
	APP_ENV=test symfony console doctrine:schema:update --force
	APP_ENV=test symfony console doctrine:fixtures:load -n
	APP_ENV=dev symfony php bin/phpunit $(MAKECMDGOALS)

phpstan:
	APP_ENV=dev symfony php vendor/bin/phpstan analyse --level 3 --memory-limit=-1

php-cs-fixer:
	APP_ENV=dev symfony php vendor/bin/php-cs-fixer fix
php-cs-fixer-dry-run:
	APP_ENV=dev symfony php vendor/bin/php-cs-fixer fix --dry-run	

quality: phpstan php-cs-fixer tests	

.PHONY: tests