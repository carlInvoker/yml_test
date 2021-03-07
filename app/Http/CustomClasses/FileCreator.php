<?php

namespace App\Http\CustomClasses;

use Illuminate\Support\Facades\Storage;

class FileCreator
{
  private $FileData;
  private $tempID;
  private $imageURL;

  public function __construct($requestData, $tempID) {
    $this->FileData = $requestData;
    $this->tempID = $tempID;
  }

  public function CreateFile($fileData) {
    // $DBtask = new DatabaseManager();
    // $fileData = $DBtask->NewTask();

    $imageManager = new ImageManager();
    $this->imageURL = $imageManager->SafeImage($fileData["id"], $this->tempID);

    $ymlFileName = $fileData["id"].'File.yml';
    $content = $this->FormContent($fileData["date"], $fileData["id"]);
    Storage::disk('public')->put($ymlFileName, $content, 'public');
    return asset('storage/'.$ymlFileName);
  }

  private function FormContent($date, $id) {
    $content = <<<EOT
    <?xml version="1.0" encoding="UTF-8"?>
    <yml_catalog date="$date">
        <shop>
            <name>SomeShop</name>
            <company>Some Company</company>
            <url>Some URL</url>
            <currencies>
                <currency id="US" rate="1"/>
            </currencies>
            <offers>
                <offer id="$id">
                    <name>{$this->FileData['name']}</name>
                    <price>{$this->FileData['price']}</price>
                    <image>$this->imageURL</image>
                    <category>{$this->FileData['category']}</category>
                </offer>
            </offers>
        </shop>
    </yml_catalog>
    EOT;
    return $content;
  }
}
