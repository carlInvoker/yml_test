<?php

namespace App\Http\CustomClasses;

use App\Models\Generated_task;
use App\Models\Temp;
use Illuminate\Support\Facades\Storage;

class DatabaseManager
{

  public function NewTask() {
     $task = new Generated_task;
  //   $task->status = "new";
     $task->save();
     $taskData = array(
       "id" => $task->id,
       "date" => $task->created_at
     );
     return $taskData;
  }

  public function MakeNewTemp() {
     $task = new Temp;
     $task->save();
     return $task->id;
  }

  public function SetTempPath($id, $name) {
     $task = Temp::find($id);
     $task->image = $name;
     $task->save();
     return true;
  }

  public function ChangeStatusProgress($id) {
     $task = Generated_task::find($id);
     $task->status = 'in-progress';
     $task->save();
  }

  public function ChangeStatusSuccess($id) {
    $task = Generated_task::find($id);
    $task->status = 'success';
    $task->save();
  }

  public function ChangeStatusFailed($id) {
    $task = Generated_task::find($id);
    $task->status = 'failed';
    $task->save();
  }

  public function getStatusById($id) {
     $task = Generated_task::find($id);
     if($task) {
       if($task->status == "success") {
      //   $url = Storage::url($id.'File.yml');
         $url = asset('storage/'.$id.'File.yml');
         return $url;
       }
       else {
         return $task->status;
       }
     }
     else {
       return "Task Not Found";
     }
  }

}
