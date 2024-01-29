<?php declare(strict_types = 1);

use Contributte\Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';

// Configure Nette\Tester
Environment::setupTester();

// Configure timezone
Environment::setupTimezone('Europe/Prague');

// Configure many constants
Environment::setupFolders(__DIR__);

// Fill global variables
Environment::setupGlobalVariables();
