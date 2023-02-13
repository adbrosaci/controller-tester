<?php declare(strict_types = 1);

use Contributte\Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';

// Configure Nette\Tester
Environment::setupTester();

// Configure timezone (Europe/Prague by default)
Environment::setupTimezone();

// Configure many constants
Environment::setupVariables(__DIR__);

// Fill global variables
Environment::setupGlobalVariables();
