# CONTRIBUTING

We are using [GitHub Actions](https://github.com/features/actions) as a continuous build and testings system.

For details, take a look at the following workflow configuration file:

-   [`workflows/php_ci.yml`](workflows/php_ci.yml)

## Coding Standards

This library code is written with PSR-12 in mind so please use the same coding standard when implementing a new feature

We are using `[yamllint](https://github.com/adrienverge/yamllint)` to enforce coding standards in YAML files.

If you do not have `yamllint` installed yet, run

```
$ brew install yamllint
```

or

```
pip install --user yamllint
```

to install `yamllint`.

We are using `squizlabs/php_codesniffer` to enforce coding standards in PHP files.

To test for coding standard issues use this command

```
$ make coding-standards
```

Also we are using `ergebnis/composer-normalize` to normalize composer.json.

## Dependency Analysis

We are using `maglnet/composer-require-checker` to prevent the use of unknown symbols in production code.

Run

```
$ make dependency-analysis
```

to run a dependency analysis.

## Documentations

Each new function has to have a docblock that describe what that function do

Example:

```
/**
 * Sanitize value
 *
 * @param string $value
 *  The value of the malicious string you want to sanitize
 * @return string
 *  Return the sanitized string
 */
```

## Examples

Each new function has to have an example in the "examples" folder and named using this name convention

`function_name_example.php`

## Tests

Each new function has to have at least one test case and the function should pass that test without errors.

We are using `phpunit/phpunit` to drive the development.

Run

```
$ make tests
```

to run all the tests.

## Mutation Tests

We are using `infection/infection` to ensure a minimum quality of the tests.

Enable `pcov` or `Xdebug` and run

```
$ make mutation-tests
```

to run mutation tests.

## Extra lazy?

Run

```
$ make
```

to enforce coding standards, and run tests!

## Help

:bulb: Run

```
$ make help
```

to display a list of available targets with corresponding descriptions.
