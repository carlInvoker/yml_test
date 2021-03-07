<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generated_task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
       'status'
     ];

     protected $primaryKey = 'id';
}
