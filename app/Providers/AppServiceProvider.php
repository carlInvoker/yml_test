<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use App\Http\CustomClasses\DatabaseManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Queue::failing(function (JobFailed $event) {
         // $event->connectionName
         $id = $event->job->getJobId();
         $DB = new DatabaseManager();
         $DB->ChangeStatusFailed($id);
         // $event->exception

      });

      Queue::before(function (JobProcessing $event) {
         // $event->connectionName
         $id = $event->job->getJobId();
         $DB = new DatabaseManager();
         $DB->ChangeStatusProgress($id);
         // $event->job->payload()

      });

     Queue::after(function (JobProcessed $event) {
         // $event->connectionName
         $id = $event->job->getJobId();
         $DB = new DatabaseManager();
         $DB->ChangeStatusSuccess($id);
         // $event->job->payload()
     });
    }
}
