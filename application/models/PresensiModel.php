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

    public function getTanggalBulanTahun($bulan, $tahun)
    {
        return $this->select('tanggal')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->distinct()
            ->get()
            ->pluck('tanggal');
    }

    public function hitungKetidakHadirBulanTahun($userId, $bulan, $tahun)
    {
        $tanggalBulanTahun = $this->getTanggalBulanTahun($bulan, $tahun);

        $totalHadir = $this->where('user_id', $userId)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->count();

        $totalTanggal = count($tanggalBulanTahun);
        $ketidakHadir = $totalTanggal - $totalHadir;

        return $ketidakHadir;
    }

    public function getPresensiByUserTanggal($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->first();
    }

    public function getAbsensiByUserIdAndDate($user_id, $tanggal)
    {
        return $this->where('user_id', $user_id)
            ->where('tanggal', $tanggal)
            ->get()
            ->toArray();
    }
    public function karyawan()
    {
        return $this->belongsTo('KaryawanModel', 'created_by', 'id_karyawan');
    }

    public function getPresensiByTanggal($tanggal)
    {
        return $this->where('tanggal', $tanggal)->get();
    }

    public $timestamps = false;
}
