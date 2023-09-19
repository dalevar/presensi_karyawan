<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class QrcodeModel extends Eloquent
{
    protected $table = 'qrcode_presensi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code',
        'created_on'
    ];


    // public function codeData($qrcode = "")
    // {
    //     if (!empty($qrcode)) {
    //         $this->where('code', $qrcode);
    //     }

    //     return $this->get()
    //         ->first();
    // }

    // public function saveCode()
    // {
    //     $qrcode_data = $this->codeQr();

    //     $this->save($qrcode_data);
    // }

    // public function codeQr()
    // {
    //     $this->load->helper('string');
    //     $code = strtoupper(random_string('alnum', 6));
    //     $tanggal = date('Y-m-d');
    //     $cek_data = QrcodeModel::find($code);
    //     if (!empty($cek_data)) {
    //         $code = substr_replace($code, count($cek_data) + 1, 5);
    //     }

    //     $this->code = $code;
    //     $this->created_on = $tanggal;
    //     return $code;
    // }


    public $timestamps = false;
}
