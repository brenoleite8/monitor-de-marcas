<?php
if (version_compare(PHP_VERSION, '7.4.0') == -1)
{
    die ('The minimum version required for PHP is 7.4.0');
}

if (!file_exists('app/config/application.ini'))
{
    die('Application configuration file not found');
}

ini_set('error_log', 'tmp/php_errors.log');

// define the autoloader
require_once 'lib/mad/util/GlobalFunctions.php';
require_once 'lib/adianti/core/AdiantiCoreLoader.php';

spl_autoload_register(array('Adianti\Core\AdiantiCoreLoader', 'autoload'));
Adianti\Core\AdiantiCoreLoader::loadClassMap();

$loader = require 'vendor/autoload.php';
$loader->register();

// read configurations
$ini = parse_ini_file('app/config/application.ini', true);
date_default_timezone_set($ini['general']['timezone']);
AdiantiCoreTranslator::setLanguage( $ini['general']['language'] );
ApplicationTranslator::setLanguage( $ini['general']['language'] );
BuilderTranslator::setLanguage( $ini['general']['language'] );
AdiantiApplicationConfig::load($ini);
AdiantiApplicationConfig::apply();

// define constants
define('APPLICATION_NAME', $ini['general']['application']);
define('OS', strtoupper(substr(PHP_OS, 0, 3)));
define('PATH', dirname(__FILE__));
define('LANG', $ini['general']['language']);
define('MAIN_DATABASE', $ini['general']['main_database'] ?? '');
define('APPLICATION_VERSION', $ini['general']['application_version'] ?? '');

// custom session name
session_name('PHPSESSID_'.$ini['general']['application']);

setlocale(LC_ALL, 'C');

