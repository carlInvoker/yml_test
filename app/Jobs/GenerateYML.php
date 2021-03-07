<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\CustomClasses\DTO;
use App\Http\CustomClasses\FileCreator;

class GenerateYML implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;
    protected $tempID;
    protected $fileData;

    public function __construct($request, $tempID, $fileData)
    {
        $this->request = $request;
        $this->tempID = $tempID;
        $this->fileData = $fileData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    //  $image = $this->$request['image'];
      $requestData = $this->request;
      $requestData = DTO::Modify($requestData);
      $fileCreator = new FileCreator($requestData, $this->tempID);
      $fileCreator->CreateFile($this->fileData);
    }

    public function getId()
    {
        return $this->fileData['id'];
    }
}
