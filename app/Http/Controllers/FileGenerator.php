<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateYML;
use App\Http\Requests\GenerateFile;
use Validator;
use App\Http\CustomClasses\ImageManager;
use App\Http\CustomClasses\DatabaseManager;
use App\Http\CustomClasses\StringModifier;

class FileGenerator extends Controller
{
    private $DB;
    public function __construct() {
      $this->DB = new DatabaseManager();
    }

    public function GenerateFile(GenerateFile $request)
    {
        $validated = $request->validated();
        $image = $request->file('image');
        $imageManager = new ImageManager($image);

        $fileData = $this->DB->NewTask();

        $tempID = $imageManager->SafeTempImage();
        $requestData = $request->all();
        unset($requestData["image"]);
        $generationJob = new GenerateYML($requestData, $tempID, $fileData);
        dispatch($generationJob);
        return $fileData['id'];
    }

    public function GetFile($id)
    {
        if($id) {
          $url = $this->DB->getStatusById($id);
          return $url;
        }
        else {
          return "Id Required";
        }
    }

    public function EditName(Request $request) {
      $validated = $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string|max:255',
      ]);
      return $this->FileEditor($request->input('id'), $request->input('name'), 'name');
    }

    public function EditPrice(Request $request) {
      $validated = $request->validate([
        'id' => 'required|integer',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
      ]);
      return $this->FileEditor($request->input('id'), $request->input('price'), 'price');
    }

    public function EditImage(Request $request) {
      $validated = $request->validate([
        'id' => 'required|integer',
        'image' => 'required|mimes:jpg,png|max:8192',
      ]);
      $image = $request->file('image');
      $fileName   = $request->input('id') . '.' . $image->getClientOriginalExtension();
      $imageManager = new ImageManager();
      return $imageManager->EditImage($image, $fileName);
    }

    public function EditCategory(Request $request) {
      $validated = $request->validate([
        'id' => 'required|integer',
        'category' => 'required|string|max:255',
      ]);
      return $this->FileEditor($request->input('id'), $request->input('category'), 'category');
    }

    private function FileEditor($id, $param, $prop) {
      $modifiedString = StringModifier::RemoveBannedSymbols($param);
      $fileName = $id.'File.yml';
      if(file_exists(public_path('/storage/'.$fileName))) {
        $fileData = file_get_contents(public_path('/storage/'.$fileName));
        $xmlObj = simplexml_load_string($fileData);
        $xmlObj->shop->offers->offer->$prop = $modifiedString;
        file_put_contents(public_path('/storage/'.$fileName), $xmlObj->asXML());
        return $prop.' edited';
      }
      else {
        return "Probably file with such ID Does not Exist";
      }
    }

}
