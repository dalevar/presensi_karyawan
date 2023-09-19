<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class LoginModel extends Eloquent
{
    protected $table = 'chat_user';
    protected $primaryKey = 'login_oauth_uid';
    protected $fillable = ['login_oauth_uid', 'login_access', 'first_name', 'last_name', 'email_address', 'profile_picture', 'created_at', '	updated_at'];

    public $timestamps = false;

    public function updateUser($id, $data)
    {
        return self::updateOrCreate(['login_oauth_uid' => $id], $data);
    }
    // Untuk Insert_user_data, Anda bisa menggunakan metode create dari Eloquent.

    public function insertUser($data)
    {
        return self::create($data);
    }
}
