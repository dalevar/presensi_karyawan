<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class KonfigModel extends Eloquent
{
    protected $table = 'konfig';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'nilai'];

    public $timestamps = false;
}
