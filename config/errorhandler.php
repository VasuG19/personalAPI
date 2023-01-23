<?php
/**
 * error handler
 * 
 * error handeler for the API to catch when errors occur
 * 
 * 
 * @author Mehtab Gill
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
   if ($errno != 2 && $errno != 8) {
       throw new Exception("Error Detected: [$errno] $errstr file: $errfile line: $errline", 1);
   }
}