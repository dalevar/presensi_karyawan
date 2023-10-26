## PRESENSI KARYAWAN CODEIGNATER 3
## Codeigniter 3.1.0 Integrated with Illuminate Database Eloquent

### Requires
Cannot Use in PHP 8

Recomended Use php : 7.4.33

php: >=5.5.9

### Installation 
### 1) Install the Illuminate Database package with Composer
Install the Illuminate Database package with Composer:

```sh
$ composer install
```

### 2) Import Database

### 3) Create Akun Admin :
Open Folder :	```->Application
		->controllers
		->Auth.php```
Then Edit The Code :
```
 if (!$user->exists) {
                    if ($data['email'] == $karyawan->email) {
                        if ($karyawan) {
                            // Data pengguna belum ada, masukkan data
                            $user->login_access = 0;
                            $user->first_name = $data['given_name'];
                            $user->last_name = $data['family_name'];
                            $user->email_address = $data['email'];
                            $user->profile_picture = $data['picture'];
                            $user->created_at = $current_datetime;
                            $user->save();

                            $this->session->set_flashdata('berhasil', 'Email Anda Telah Terdaftar Harap Login kembali');
                            redirect('auth/berhasil');
                        }
                    } else {
			    $user->login_access = 1;
                            $user->first_name = $data['given_name'];
                            $user->last_name = $data['family_name'];
                            $user->email_address = $data['email'];
                            $user->profile_picture = $data['picture'];
                            $user->created_at = $current_datetime;
                            $user->save();
                        $this->session->set_flashdata('gagal', 'Email Tidak Terdaftar!');
                        redirect('auth/gagal');
                    }
```

### Setelah itu kembali ke halaman login Lalu Gunakan Email yang ingin dijadikan sebagai admin 

### 4) Remove The this code :
```
			    $user->login_access = 1;
                            $user->first_name = $data['given_name'];
                            $user->last_name = $data['family_name'];
                            $user->email_address = $data['email'];
                            $user->profile_picture = $data['picture'];
                            $user->created_at = $current_datetime;
                            $user->save();
```
### Make sure your code like this (Auth.php):
```
 if (!$user->exists) {
                    if ($data['email'] == $karyawan->email) {
                        if ($karyawan) {
                            // Data pengguna belum ada, masukkan data
                            $user->login_access = 0;
                            $user->first_name = $data['given_name'];
                            $user->last_name = $data['family_name'];
                            $user->email_address = $data['email'];
                            $user->profile_picture = $data['picture'];
                            $user->created_at = $current_datetime;
                            $user->save();

                            $this->session->set_flashdata('berhasil', 'Email Anda Telah Terdaftar Harap Login kembali');
                            redirect('auth/berhasil');
                        }
                    } else {
                        $this->session->set_flashdata('gagal', 'Email Tidak Terdaftar!');
                        redirect('auth/gagal');
                    }
```

### 5) Login as admin
Pilih Email Yang tersimpan sebagai admin

![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/56902add-999f-46a4-85a8-708451e01bef)

### 6) Tambahkan Data Karyawan
Pilih Dibagian sidebar ```Management Users```

![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/3d94b1da-9b11-4f8a-af76-2cb1ae5b4c3d) 

### KLICK TAMBAH
![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/40cbc49b-a58f-4d28-9f30-81aa2315521a)

### Tambahkan Data Karyawan Lalu Klick Save Changes
![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/370cfe1f-9e60-4caa-bc08-b3bd73ee2753)





### Documentation

- [CodeIgniter documentation](http://www.codeigniter.com/user_guide/)

- [Laravel framework - Eloquent documentation](https://laravel.com/docs/5.1/eloquent)

- [Dashboard Template](https://iqonic.design/product/admin-templates/datum-lite-free-crm-html-admin-dashboard-template/)
