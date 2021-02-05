.PHONY: it
it: coding-standards tests ## Runs the coding-standards and tests targets

.PHONY: code-coverage
code-coverage: vendor ## Collects coverage from running unit tests with phpunit/phpunit
	vendor/bin/phpunit --configuration=./phpunit.xml --coverage-text

.PHONY: coding-standards
coding-standards: vendor ## Normalizes composer.json with ergebnis/composer-normalize, and fixes code style issues with squizlabs/php_codesniffer
	composer normalize
	composer cs-check
	composer cs-fix

.PHONY: dependency-analysis
dependency-analysis: vendor ## Runs a dependency analysis with maglnet/composer-require-checker
	.phive/composer-require-checker check --config-file=$(shell pwd)/composer-require-checker.json

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: tests
tests: vendor ## Runs auto-review, unit, and integration tests with phpunit/phpunit
	vendor/bin/phpunit --configuration=./phpunit.xml

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress

.PHONY: mutation-tests
mutation-tests: vendor ## Runs mutation tests with infection/infection
	vendor/bin/infection --configuration=infection.json

.PHONY: static-code-analysis
static-code-analysis: vendor ## Runs a static code analysis with phpstan/phpstan and vimeo/psalm
	vendor/bin/phpstan analyse --configuration=phpstan.neon --memory-limit=-1
	vendor/bin/psalm --config=psalm.xml --diff --show-info=false --stats --threads=4

.PHONY: static-code-analysis-baseline
static-code-analysis-baseline: vendor ## Generates a baseline for static code analysis with phpstan/phpstan and vimeo/psalm
	echo '' > phpstan-baseline.neon
	vendor/bin/phpstan analyze --configuration=phpstan.neon --error-format=baselineNeon --memory-limit=-1 > phpstan-baseline.neon || true
	vendor/bin/psalm --config=psalm.xml --set-baseline=psalm-baseline.xml