<?php

namespace App\Http\CustomClasses;

use Illuminate\Support\Facades\Storage;
use File;

class ImageManager
{
  private $image;

  public function __construct($file = null) {
    $this->image = $file;
  }

  public function SafeImage($id, $tempID) {
      if ($id && $tempID) {
        $fileName = $id.'.'.substr($tempID, -3);
        File::move(public_path('/images/temp/'.$tempID), public_path("/images/".$fileName));
        return url('/images/'.$fileName); //url('/images/1.png');
      }
      else {
        return null;
      }
  }

  public function SafeTempImage() {
      if ($this->image) {
        $DB = new DatabaseManager();
        $tempImageID = $DB->MakeNewTemp();
        $fileName   = $tempImageID . '.' . $this->image->getClientOriginalExtension();
        $this->image->move(public_path('/images/temp'), $fileName);
        $DB->SetTempPath($tempImageID, asset('images/temp'.$fileName));
        return $fileName;
      }
      else {
        return null;
      }
  }

  public function EditImage($image, $fileName) {
     if(file_exists(public_path("/images/".$fileName))) {
        unlink(public_path("/images/".$fileName));
        $image->move(public_path('/images/'), $fileName);
        return "File Replaced";
     }
     else {
        return "Such File Does not Exist !";
     }
  }


}
