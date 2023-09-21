<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class JabatanModel extends Eloquent
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id';
    protected $fillable = ['jabatan'];

    public function karyawan()
    {
        return $this->hasMany(KaryawanModel::class, 'jabatan_id');
    }

    public function updateJabatan($id, $data)
    {
        // Cari data Jabatan berdasarkan ID
        $jabatan = $this->find($id);
        if (!$jabatan) {
            // Handle jika data tidak ditemukan
            return false;
        }

        // Update data Jabatan dengan data yang diterima
        $jabatan->fill($data);
        return $jabatan->save();
    }

    public function deleteJabatan($id)
    {
        try {
            $jabatan = $this->find($id);
            if (!$jabatan) {
                // Handle jika data tidak ditemukan
                return false;
            }

            // Hapus data jabatan menggunakan Eloquent
            $jabatan->delete();

            return true; // Berhasil menghapus data
        } catch (\Exception $e) {
            // Handle jika terjadi kesalahan
            return false;
        }
    }


    // Jika Anda memiliki timestamp di tabel (created_at, updated_at)
    public $timestamps = false;
}
