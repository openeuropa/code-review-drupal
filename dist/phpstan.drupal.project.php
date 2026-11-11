<?php

/**
 * @file
 * Includes the project's PHPStan configuration in the GrumPHP PHPStan tasks.
 *
 * The path comes from the OPENEUROPA_PHPSTAN_CONFIGURATION environment
 * variable, which drupal-conventions.yml sets from the
 * "tasks.phpstan.configuration" GrumPHP parameter. When it is empty, the
 * configuration is looked up the same way PHPStan does.
 */

declare(strict_types=1);

$cwd = (string) getcwd();
$path = (string) getenv('OPENEUROPA_PHPSTAN_CONFIGURATION');

if ($path === '') {
  // Same file names and order as PHPStan's own lookup.
  foreach (['.phpstan.neon', 'phpstan.neon', '.phpstan.neon.dist', 'phpstan.neon.dist', '.phpstan.dist.neon', 'phpstan.dist.neon'] as $file) {
    if (is_file($cwd . DIRECTORY_SEPARATOR . $file)) {
      return ['includes' => [$cwd . DIRECTORY_SEPARATOR . $file]];
    }
  }
  return [];
}

// Relative paths are relative to the project, not to this file. Symlinks are
// not resolved, so relative paths inside the configuration keep working.
if (!preg_match('#^([a-z]:)?[\\\\/]#i', $path)) {
  $path = $cwd . DIRECTORY_SEPARATOR . $path;
}
if (!is_file($path)) {
  throw new \RuntimeException(sprintf('The PHPStan configuration file "%s" set in OPENEUROPA_PHPSTAN_CONFIGURATION does not exist.', $path));
}

return ['includes' => [$path]];
