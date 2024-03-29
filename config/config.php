<?php
/**
 * Config file
 * 
 * config file to set and define settings for the API
 * 
 * 
 * @author Mehtab Gill
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config/exceptionhandler.php';
set_exception_handler('exceptionHandler');

include 'config/errorhandler.php';
set_error_handler('errorHandler');

include 'config/autoloader.php';
spl_autoload_register('Autoload::autoloader');

define('BASEPATH', '/coursework/app/');
define('DATABASE', 'db/chiplay.sqlite');

$chi_play = new Database(DATABASE);

define('DEVELOPMENT_MODE', true);

ini_set('display_errors', DEVELOPMENT_MODE);
ini_set('display_startup_errors', DEVELOPMENT_MODE);

define('SECRET', ">4!F.oZ&}D8|gtX+U-~O@)8=KL>!?w");

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");