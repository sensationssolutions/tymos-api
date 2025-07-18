<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsitePiece extends Model
{
   protected $fillable = [
     'type',
     'heading',
     'title',
     'description',
     'home_image',
     'about_image'
  ];
}
