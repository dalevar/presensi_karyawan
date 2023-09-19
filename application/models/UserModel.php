<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class UserModel extends Eloquent
{
    protected $table = 'user';
    protected $primaryKey = 'login_oauth_uid';
    protected $fillable = ['login_oauth_uid', 'login_access', 'first_name', 'last_name', 'email_address', 'profile_picture', 'created_at', '	updated_at'];

    public function findByEmail($email)
    {
        return $this->where('email_address', $email)->first();
    }

    public function insertUser($data)
    {
        return self::create($data);
    }

    // public function updateUser($id, $data)
    // {
    //     return self::updateOrCreate(['login_oauth_uid' => $id], $data);
    // }

    // public function updateUser($id, $data)
    // {
    //     // Cari data berdasarkan ID
    //     $user = $this->find($id);
    //     if (!$user) {
    //         // Handle jika data tidak ditemukan
    //         return false;
    //     }

    //     // Update data user dengan data yang diterima
    //     $user->fill($data);
    //     return $user->save();
    // }

    public function getUsers($id = null)
    {
        $users = UserModel::query();

        if ($id !== null) {
            $users->where('id', $id);
        }

        return $users->get();
    }

    public function getUserById($userId)
    {
        return $this->where('id', $userId)->first();
    }

    public $timestamps = false;
}
