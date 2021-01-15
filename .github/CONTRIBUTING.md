# CONTRIBUTING

We are using [GitHub Actions](https://github.com/features/actions) as a continuous build and testings system.

For details, take a look at the following workflow configuration files:

- [`workflows/php_ci.yml`](workflows/php_ci.yml)

## Coding Standards

This library code is written with PSR-12 in mind so please use the same coding standard when implementing a new feature

To test for coding standard issues use this command

```
$ ./vendor/bin/phpcs ./src --standard=PSR12
```

## DocBlock

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

## Unit Testing

Each new function has to have at least one test case and the function should pass that test without errors.
