<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitedetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'instagram',
        'facebook',
        'phone1',
        'phone2',
        'email',
        'address',
        'logo',
        'favicon'
    ];
}