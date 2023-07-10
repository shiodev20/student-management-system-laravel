<?php

namespace App\Utils;

class GenerateId {
  
  public static function generateId($prefix = '', $length = 0): string {
    $unique = (string)(time() * rand(0, 9999));
    $id = substr($unique, -$length);

    return $prefix.$id;
  }

}