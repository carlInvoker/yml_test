<?php

namespace App\Http\CustomClasses;

class StringModifier
{
  public static function RemoveBannedSymbols($string) {
//    /[\x00-\x08\x0B-\x0C\x0E-\x1F\x80-\xFF]/
    $resultString = preg_replace('/[\x00-\x08\x0B-\x0C\x0E-\x1F\x80-\xFF]/', '', $string);
    $resultString = preg_replace('/[\x26]/', '&amp;', $resultString);  // &
    $resultString = preg_replace('/[\x27]/', '&apos;',$resultString);  // '
    $resultString = preg_replace('/[\x3C]/', '&lt;', $resultString); // <
    $resultString = preg_replace('/[\x3E]/', '&gt;', $resultString);  // >
    $resultString = preg_replace('/[\x22]/', '&quot;',$resultString);  // "
    return $resultString;
  }
}
