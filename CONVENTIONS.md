# Conventions

Information about conventions for OpenEuropa projects and components.

## Available conventions

These conventions can be used in your projects:

* [Drupal](dist/drupal-conventions.yml) for Drupal projects.
* [OE Component](dist/oe-component-conventions.yml) for oe component projects.

## PHP Code Sniffer

- [Drupal coding standards](https://www.drupal.org/docs/develop/standards)
  except:
  - `Drupal.Commenting.Deprecated` because this rule only makes sense for core and projects in drupal.org.

## PHP Stan

- [mglaman/phpstan-drupal](https://github.com/mglaman/phpstan-drupal): allows to understand how to read code in a Drupal.
- [phpstan/phpstan-deprecation-rules](https://github.com/phpstan/phpstan-deprecation-rules): this extension emits deprecation warnings on code.
- [phpstan/extension-installer](https://github.com/phpstan/extension-installer): package autoconfigures PHPStan to load the previous packages.

## Commit messages

Valid default commit messages: `Issue #123: My commit.` or `OPENEUROPA-123: My commit.`

- Must start with GitHub issue reference or a Jira-like ticket ID.
- Must have a colon followed by a space after the issue reference.
- Must start with capital letter and end with a period.
