<?php
/**
 * exception handler
 * 
 * exception handeler for the API to catch when exceptions occur
 * 
 * 
 * 
 */
function exceptionHandler($e) {
   http_response_code(500);
   $output['message'] = $e->getMessage();
   $output['location']['file'] = $e->getFile();
   $output['location']['line'] = $e->getLine();
   echo json_encode($output);
}

