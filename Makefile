.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | gawk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

composer.lock: composer.json
	composer update

vendor:
	composer install --prefer-dist --no-suggest

.PHONY: install
install: vendor

.PHONY: server
server: install
	php -S localhost:8000 -t public/ -d display_errors=1

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