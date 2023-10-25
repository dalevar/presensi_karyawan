<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class HolidaysModel extends Eloquent
{
    protected $table = 'holidays';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    public $timestamps = false;
}
