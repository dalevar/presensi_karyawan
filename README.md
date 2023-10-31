## PRESENSI KARYAWAN CODEIGNATER 3
## Codeigniter 3.1.0 Integrated with Illuminate Database Eloquent

### Requires
Tidak bisa digunakan di PHP 8

Recomended Menggunakan php : [7.4.33](https://drive.google.com/file/d/1HeOdugxv82lA4z_SIriciXECL3W2JmmF/view?usp=drive_link)

php: >=5.5.9

### Installation 
### 1) Install the Illuminate Database package with Composer
Install the Illuminate Database package with Composer:

```sh
$ composer install
```

### 2) Import Database
### -> Lakukan Setup config database

```
use Illuminate\Database\Capsule\Manager as Capsule;

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'nama_database',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```

### 5) Sign In Account
![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/56902add-999f-46a4-85a8-708451e01bef)

### 6) Jika Belum ada account (Sign Up)
![image](![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/955fdf29-771e-41e4-a3e9-27b133950843) 
	```NOTE : Gunakan akun yang ingin dijadikan sebagai admin```

### KLICK TAMBAH
![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/40cbc49b-a58f-4d28-9f30-81aa2315521a)

### Tambahkan Data Karyawan Lalu Klick Save Changes
![image](https://github.com/dalevar/presensi_karyawan/assets/141650107/370cfe1f-9e60-4caa-bc08-b3bd73ee2753)





### Documentation

- [CodeIgniter documentation](http://www.codeigniter.com/user_guide/)

- [Laravel framework - Eloquent documentation](https://laravel.com/docs/5.1/eloquent)

- [Dashboard Template](https://iqonic.design/product/admin-templates/datum-lite-free-crm-html-admin-dashboard-template/)
