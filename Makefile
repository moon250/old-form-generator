composer.lock: composer.json
	composer update --prefer-dist --no-suggest

vendor:
	composer install --prefer-dist --no-suggest

.PHONY: install
install: vendor

.PHONY: format
format: install
	vendor\bin\phpcs
	vendor\bin\php-cs-fixer fix --dry-run

.PHONY: fix
fix: install
	vendor\bin\phpcbf
	vendor\bin\php-cs-fixer fix

.PHONY: lint
lint: vendor/autoload.php install
	vendor\bin\phpstan analyse --memory-limit=32

.PHONY: tests
tests: install
	vendor\bin\phpunit --stop-on-failure

.PHONY: tt
tt: install
	vendor\bin\phpunit-watcher watch