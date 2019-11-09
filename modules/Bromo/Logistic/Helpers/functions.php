<?php
if(!function_exists('startsWith')) {
  function startsWith ($string, $startString) 
  { 
      $len = strlen($startString); 
      return (substr($string, 0, $len) === $startString); 
  }
}
 