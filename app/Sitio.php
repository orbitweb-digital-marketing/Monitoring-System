<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $fillable = ['nombre','url'];
    public $timestamps = false;
}
