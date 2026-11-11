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

use PHPStan\File\FileHelper;

$fileHelper = new FileHelper((string) getcwd());
$path = (string) getenv('OPENEUROPA_PHPSTAN_CONFIGURATION');

if ($path === '') {
  foreach (['phpstan.neon', 'phpstan.neon.dist', 'phpstan.dist.neon'] as $file) {
    if (is_file($fileHelper->absolutizePath($file))) {
      return ['includes' => [$fileHelper->absolutizePath($file)]];
    }
  }
  return [];
}

// Relative paths are relative to the project, not to this file. Symlinks are
// not resolved, so relative paths inside the configuration keep working.
$path = $fileHelper->absolutizePath($path);
if (!is_file($path)) {
  throw new \RuntimeException(sprintf('The PHPStan configuration file "%s" set in OPENEUROPA_PHPSTAN_CONFIGURATION does not exist.', $path));
}

return ['includes' => [$path]];
