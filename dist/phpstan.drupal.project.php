<?php

/**
 * @file
 * Includes the project's PHPStan configuration in the GrumPHP PHPStan tasks.
 *
 * The path comes from the OPENEUROPA_PHPSTAN_CONFIGURATION environment
 * variable, which drupal-conventions.yml sets from the
 * "tasks.phpstan.configuration" GrumPHP parameter. Falls back to
 * phpstan.drupal.neon when it is not set.
 */

declare(strict_types=1);

$path = (string) getenv('OPENEUROPA_PHPSTAN_CONFIGURATION');
if ($path === '') {
  return ['includes' => [__DIR__ . DIRECTORY_SEPARATOR . 'phpstan.drupal.neon']];
}

// Relative paths are relative to the project, not to this file.
if (!preg_match('#^([a-z]:)?[\\\\/]#i', $path)) {
  $path = getcwd() . DIRECTORY_SEPARATOR . $path;
}

return ['includes' => [$path]];
