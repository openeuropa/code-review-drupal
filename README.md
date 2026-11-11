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
- `tasks.phpstan_deprecations.blocking`
- `tasks.git_commit_message.matchers`

### PHPStan deprecations

Deprecations do not fail the build. PHPStan runs as two GrumPHP tasks:

- `phpstan` reports every error except deprecations, and fails the run.
- `phpstan_deprecations` reports only deprecations and is non-blocking: GrumPHP
  lists them as failed (in yellow), but exits successfully.

An error counts as a deprecation when its message uses deprecation wording,
such as `Call to deprecated method ...` from [phpstan-deprecation-rules](https://github.com/phpstan/phpstan-deprecation-rules),
`Not supporting attribute discovery is deprecated in drupal:11.2.0 ...` from
[phpstan-drupal](https://github.com/mglaman/phpstan-drupal) or `Deprecated in PHP 8.4: ...`.
Errors whose message does not say "deprecated", even if they come from a
deprecation rule, still fail the build.

Both tasks run your project's PHPStan configuration (`tasks.phpstan.configuration`),
so its `excludePaths` and `ignoreErrors` apply to both.

Only GrumPHP treats deprecations as warnings: running PHPStan directly with your
configuration still reports them as errors.

Keep in mind that:

- When selecting tasks with `--tasks` or in `testsuites`, include
  `phpstan_deprecations` next to `phpstan`, or deprecations are not reported.
- Errors PHPStan cannot ignore, such as syntax errors, are reported by both tasks.
- Overriding the whole `phpstan` task in your `grumphp.yml` replaces this setup:
  that task then reports deprecations as errors again.
- With `stop_on_failure: true`, deprecations are only reported when all other
  tasks pass, as `phpstan_deprecations` runs last.

To make deprecations fail the build again:

```yaml
parameters:
  tasks.phpstan_deprecations.blocking: true
```

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

### Transition from code-review 2.x

If you wish to transition to code-review-drupal from code-review version 2.x, please replace the package via Composer:

```bash
composer remove --dev openeuropa/code-review
composer require --dev openeuropa/code-review-drupal
```

Besides replacement of the package, some adjustments are needed in `grumphp.yml` file.

This component removes ExtraTasks extension. Any aditional task previously declared in `extra_tasks` will need to be placed inside `tasks` under `grumphp` tree.

```diff yaml

- extra_tasks:
-   phpparser:
-      ignore_patterns:
-       - vendor/
-
- grumphp:
-   extensions:
-     - OpenEuropa\CodeReview\ExtraTasksExtension

+ grumphp:
+   tasks:
+     phpparser:
+      ignore_patterns:
+        - vendor/

```

In addition, PHP Mess Detector is no longer available as part of the configured tasks. The task and related parameters have been removed. If you wish to continue using PHP Mess Detector, you can add it as part of GrumPHP as previously described.

All other conventions and parameters remain the same.
