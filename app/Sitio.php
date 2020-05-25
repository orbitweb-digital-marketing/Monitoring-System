<?php

namespace monitor;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $table = 'sitios';

    protected $primaryKey = 'id';

    public $timestamps = false;


    protected $fillable = [
        'nombre',
	'url',
	'server',
	'maintenace'
    ];

    protected $guarded = [];
}
