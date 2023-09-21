<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class KaryawanModel extends Eloquent
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'email', 'nama', 'tanggal_masuk', 'tipe_id', 'jabatan_id', 'tingkat_pendidikan', 'catatan'];

    public function getKaryawan()
    {
        return $this->select('karyawan.*', 'nama', 'tanggal_masuk', 'tipe.tipe', 'jabatan.jabatan', 'tingkat_pendidikan', 'catatan')
            ->leftJoin('tipe', 'tipe.id', '=', 'karyawan.tipe_id')
            ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.jabatan_id')
            ->leftjoin('user', 'user.id', '=', 'karyawan.user_id')
            ->get();
    }

    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class, 'jabatan_id');
    }

    public function user()
    {
        return $this->belongsTo('UserModel', 'user_id');
    }

    public function getById($id)
    {
        // Mengambil data karyawan berdasarkan ID
        return KaryawanModel::find($id);
    }

    public function getByUserId($userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function updateKaryawan($id, $data)
    {
        // Cari data karyawan berdasarkan ID
        $karyawan = $this->find($id);
        if (!$karyawan) {
            // Handle jika data tidak ditemukan
            return false;
        }

        // Update data karyawan dengan data yang diterima
        $karyawan->fill($data);
        return $karyawan->save();
    }

    public function deleteKaryawan($id)
    {
        try {
            $karyawan = $this->find($id);
            if (!$karyawan) {
                // Handle jika data tidak ditemukan
                return false;
            }

            // Hapus data karyawan menggunakan Eloquent
            $karyawan->delete();

            return true; // Berhasil menghapus data
        } catch (\Exception $e) {
            // Handle jika terjadi kesalahan
            return false;
        }
    }

    public $timestamps = false;
}
