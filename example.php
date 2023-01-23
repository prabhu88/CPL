<?php
require_once 'src/Logger.php';
use Cpl\Logger;

if (class_exists('Cpl\Logger')) {
    $logger = new Logger();
    $path = __DIR__.DIRECTORY_SEPARATOR.'log_folder'.DIRECTORY_SEPARATOR ;
    $log_with_location = new Logger($path);
}

$logger->log('hello',"logger","info");
$logger->log('hello',"sad","debug");
$logger->log('ello',"sad","error");

$log_with_location->log('hello',"test","info");
$log_with_location->log('hello',"sad","debug");
$log_with_location->log('ello',"sad","error");

echo "Awesome Logger";
?>
