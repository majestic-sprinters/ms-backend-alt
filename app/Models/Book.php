<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Book extends Eloquent
{
    protected $collection = 'books';

    protected $fillable = ['name', 'description', 'author', 'year', 'publisher'];

}
