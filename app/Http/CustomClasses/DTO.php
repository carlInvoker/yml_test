<?php

namespace App\Http\CustomClasses;

class DTO
{
  public static function Modify($request) {
    foreach ($request as &$value) {
      $value = StringModifier::RemoveBannedSymbols($value);
    }
    unset($value);
    return $request;
  }
}
