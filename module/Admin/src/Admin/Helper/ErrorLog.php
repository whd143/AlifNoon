<?php 
namespace Admin\Helper;

class ErrorLog {
  public static function log($data, $return = false) {
    ob_start();
    var_dump($data);
    $debug = ob_get_contents();
    ob_end_clean();

    return ($return) 
      ? var_export($data, true)
      : error_log($debug);
  }
}
