<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorie extends Model
{
   
    protected $fillable =['name','user_id'];
    public $timestamps = false;
}
