<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class TipeModel extends Eloquent
{
    protected $table = 'tipe';
    protected $primaryKey = 'id';
    protected $fillable = ['tipe'];

    public function updateTipe($id, $data)
    {
        // Cari data Tipe berdasarkan ID
        $tipe = $this->find($id);
        if (!$tipe) {
            // Handle jika data tidak ditemukan
            return false;
        }

        // Update data tipe dengan data yang diterima
        $tipe->fill($data);
        return $tipe->save();
    }

    public function deleteTipe($id)
    {
        try {
            $Tipe = $this->find($id);
            if (!$Tipe) {
                // Handle jika data tidak ditemukan
                return false;
            }

            // Hapus data Tipe menggunakan Eloquent
            $Tipe->delete();

            return true; // Berhasil menghapus data
        } catch (\Exception $e) {
            // Handle jika terjadi kesalahan
            return false;
        }
    }

    // Jika Anda memiliki timestamp di tabel (created_at, updated_at)
    public $timestamps = false;
}
