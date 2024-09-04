# code-review-drupal
[![Packagist](https://img.shields.io/packagist/v/openeuropa/code-review-drupal.svg)](https://packagist.org/packages/openeuropa/code-review-drupal)

Coding standard dependencies for Drupal components.

### Installation
Install the code review component via Composer:

```bash
composer require --dev openeuropa/code-review-drupal
```

In your project root create the following `grumphp.yml.dist`:

```yaml
imports:
  - { resource: ./vendor/openeuropa/code-review-drupal/dist/drupal-conventions.yml }
```

### Commands

GrumPHP tasks will be run at every commit, if you wish to run them without performing a commit use the following command:

```bash
./vendor/bin/grumphp run
```

If you want to simulate the tasks that will be run when creating a new commit:

```bash
./vendor/bin/grumphp git:pre-commit
```

Check [GrumPHP documentation](https://github.com/phpro/grumphp/tree/master/doc) for more.

### Customization

This component offers a variety of ready conventions that all projects need to follow.
This list of default conventions can be found in [CONVENTIONS.md](CONVENTIONS.md).

Since GrumPHP uses the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection.html)
you can override specific parameters in your project's `grumphp.yml.dist` file as follows:

```yaml
imports:
  - { resource: ./vendor/openeuropa/code-review-drupal/dist/drupal-conventions.yml }

parameters:
  tasks.git_commit_message.matchers: ['/^JIRA-\d+: [A-Z].+\./']
```

Below the list of task parameters can that be overridden on a per-project basis:

- `tasks.phpcs.standard`
- `tasks.phpcs.ignore_patterns`
- `tasks.phpcs.triggered_by`
- `tasks.phpcs.whitelist_patterns`
- `tasks.phpcs.warning_severity`
- `tasks.phpstan.autoload_file`
- `tasks.phpstan.configuration`
- `tasks.phpstan.level`
- `tasks.phpstan.force_patterns`
- `tasks.phpstan.triggered_by`
- `tasks.git_commit_message.matchers`

It is also possible to extend the list of tasks to be run by adding tasks under the `tasks:` tree as shown below:

```yaml
imports:
  - { resource: ./vendor/openeuropa/code-review-drupal/dist/drupal-conventions.yml }

grumphp:
  tasks:
    phpparser: ~
```

GrumPHP already has a series of tasks that can be used out of the box, you can find the complete list in the
[GrumPHP tasks page](https://github.com/phpro/grumphp/blob/v2.x/doc/tasks.md).

If you wih you can create your own tasks as explained in the [GrumPHP extensions page](https://github.com/phpro/grumphp/blob/v2.x/doc/extensions.md).
