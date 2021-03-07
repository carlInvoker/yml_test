<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
       'image'
     ];

     protected $primaryKey = 'id';
}
