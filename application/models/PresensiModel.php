<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class PresensiModel extends Eloquent
{
    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'tanggal',
        'created_by',
        'created_on'
    ];

    public function getPresensiByUserTanggal($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();
    }

    public $timestamps = false;
}
