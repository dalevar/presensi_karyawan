<?php
// function check_already_login()
// {
//     $ci = &get_instance();
//     $user_id = $ci->session->userdata('id');

//     if ($user_id) {
//         $ci->load->model('UserModel');

//         // Menggunakan Eloquent untuk mengambil data pengguna berdasarkan ID
//         $user = $ci->UserModel->find($user_id);

//         if ($user) {
//             if ($user->login_access == 1) {
//                 redirect('admin/dashboard');
//             } else {
//                 redirect('user/dashboard');
//             }
//         }
//     }
// }

use Google\Service\Sheets\Padding;

function check_not_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('access_token');
    //ketika tidak login
    if (!$user_session) {
        redirect('auth');
    }
}

function admin_access()
{
    $ci = &get_instance();
    $userData = $ci->fungsi->user_login();
    // $login_access = $ci->fungsi->user_login()->login_access;

    if (isset($userData['login_access']) && $userData['login_access'] != 1) {
        // Jika login_access adalah 0, block akses
        redirect('user/dashboard');
        // show_error('Access Denied', 403);
    }
}

function user_access()
{
    $ci = &get_instance();
    $userData = $ci->fungsi->user_login();

    // $login_access = $ci->fungsi->user_login()->login_access;

    if (isset($userData['login_access']) && $userData['login_access'] != 0) {

        redirect('admin/dashboard');
    }
}

function hitungJumlahTidakMasuk($user_id, $tanggal)
{
    $ci = &get_instance();
    // Load model AbsensiModel (pastikan model sudah ada)
    $ci->load->model('PresensiModel');

    // Menggunakan model untuk mengambil data absensi berdasarkan user_id dan tanggal_absensi
    $absensiModel = new PresensiModel();
    $absensiData = $absensiModel->getAbsensiByUserIdAndDate($user_id, $tanggal);

    // Hitung jumlah tidak masuk
    $jumlah_tidak_masuk = 0;

    foreach ($absensiData as $absensi) {
        if ($absensi['status'] == 'Tidak Masuk') {
            $jumlah_tidak_masuk++;
        }
    }

    return $jumlah_tidak_masuk;
}


function getHariLibur()
{

    // Load library HTTP client
    $CI = get_instance();
    $CI->load->library('curl');

    // Permintaan ke API Hari Libur
    $response = $CI->curl->simple_get('https://api-harilibur.vercel.app/api');

    if ($response) {
        // Data JSON dari API
        $data = json_decode($response);

        $filteredData = array_filter($data, function ($item) {
            return isset($item->is_national_holiday) && $item->is_national_holiday === true;
        });
        // Proses data sesuai kebutuhan Anda
        // Misalnya, Anda dapat menyimpannya ke dalam model atau menggunakannya dalam logika bisnis

        return $filteredData;
    } else {
        // Handle kesalahan jika tidak dapat terhubung ke API
        return false;
    }
}

function getTanggal()
{
    $ci = &get_instance();

    // Mendapatkan bulan dan tahun saat ini
    $bulanIni = date('m');
    $tahunIni = date('Y');

    // Menghitung jumlah hari dalam bulan ini
    $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahunIni);

    // Menghasilkan daftar tanggal dalam bulan ini
    $tanggalBulanIni = array();
    for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
        $tanggalFormatted = sprintf("%04d-%02d-%02d 08:00:00", $tahunIni, $bulanIni, $tanggal);
        $tanggalBulanIni[] = $tanggalFormatted;
    }

    return $tanggalBulanIni;
}

function getNamaHari($tanggal)
{
    $namaHariEnglish = date("D", strtotime($tanggal));

    // Daftar nama hari dalam bahasa Indonesia
    $namaHariIndonesia = [
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu'
    ];

    // Mengganti nama hari dalam bahasa Inggris dengan nama dalam bahasa Indonesia
    return $namaHariIndonesia[$namaHariEnglish];
}


// function getTanggalHari()
// {
//     $ci = &get_instance();

//     // Mendapatkan bulan dan tahun saat ini
//     $bulanIni = date('m');
//     $tahunIni = date('Y');

//     // Menghitung jumlah hari dalam bulan ini
//     $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanIni, $tahunIni);

//     // Menghasilkan daftar tanggal dalam bulan ini dengan format "Senin, 01"
//     $tanggalBulanIni = array();
//     for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
//         // Format tanggal dengan format "Senin, 01" dalam bahasa Indonesia
//         $tanggalFormatted = getHariIndonesia(date('N', strtotime("$tahunIni-$bulanIni-$tanggal"))) . ', ' . date('d', strtotime("$tahunIni-$bulanIni-$tanggal")) . date('S', strtotime("$tahunIni-$bulanIni-$tanggal"));
//         $tanggalBulanIni[] = $tanggalFormatted;
//     }

//     return $tanggalBulanIni;
// }

//nama hari indonesia
function getHariIndonesia($dayOfWeek)
{
    // Daftar nama hari dalam bahasa Indonesia
    $hariIndonesia = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );

    return $hariIndonesia[$dayOfWeek - 1];
}

function indo_date($date, $print_day = false)
{
    $day        = [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $month      = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $split      = explode('-', $date);
    $nice_date  = $month[(int) $split[1]] . ', ' .  $split[2];

    if ($print_day) {
        $num = date('N', strtotime($date));
        return $day[$num] . ', ' . $nice_date;
    }
    return $nice_date;
}

function getIndonesianMonth($monthNameEnglish)
{
    $indonesianMonths = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );

    return $indonesianMonths[$monthNameEnglish];
}

function getPresensiData($userId, $year, $month)
{

    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $presensiModel = new PresensiModel();

    // Panggil metode model yang sesuai untuk mengambil data presensi berdasarkan bulan dan tahun.
    $presensiData = $presensiModel->getPresensiData($userId, $year, $month);

    return $presensiData;
}

function generatePresensiHTML($presensiData)
{
    // Inisialisasi variabel untuk menyimpan HTML hasil
    $html = '';

    // Loop melalui data presensi dan hasilkan HTML untuk setiap catatan presensi
    foreach ($presensiData as $presensi) {
        $tanggalPresensi = $presensi->created_on; // Misalnya, asumsi tanggal ada dalam data presensi

        // Tambahkan HTML sesuai dengan data presensi (Anda dapat menyesuaikan ini sesuai kebutuhan)
        $html .= "<div class='presensi-item'>";
        $html .= "<span class='tanggal'>$tanggalPresensi</span>";
        // Tambahkan informasi lain tentang presensi sesuai kebutuhan
        // Contoh: $html .= "<span class='keterangan'>$presensi->keterangan</span>";
        $html .= "</div>";
    }

    // Kembalikan HTML yang dihasilkan
    return $html;
}



function generateCalendar($userId, $year, $month, $tanggal)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');

    //get hari pertama
    $firstDay = mktime(0, 0, 0, $month, 1, $year);
    // Get angka hari di bulanIni
    $numDays = date('t', $firstDay);
    // Get nama bulan
    $monthName = date('F', $firstDay);
    $indonesianMonthName = getIndonesianMonth($monthName);
    //Hari Libur Nasional
    $dataLibur = getHariLibur();

    //Data Presensi
    $presensiModel = new PresensiModel();
    // mengambil data presensi dibulan ini
    $presensi = $presensiModel->getPresensiBulanIni($userId, $tanggal);

    // Create hari indonesia
    $dayNames = [
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    ];

    // Create the table header
    echo "<div class='gc-calendar-header d-flex flex-wrap justify-content-between align-items-center pr-3'>";
    echo "<h4>$indonesianMonthName $year</h4>";
    // Bulan Dan Tahun Dropdown Select
    echo "<div class='form-group mb-0 d-flex flex-row'>";
    echo "<div class='col-md-6'>";
    echo "<select id='month' name='month' class='custom-select custom-select-sm form-control form-control-sm'>";
    for ($i = 1; $i <= 12; $i++) {
        $selected = ($i == $month) ? 'selected' : '';
        echo "<option value='$i' $selected>" . getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<select id='year' name='year' class='custom-select custom-select-sm form-control form-control-sm'>";
    $currentYear = date('Y');
    $startYear = $currentYear - 5;
    $endYear = $currentYear + 77;
    for ($i = $startYear; $i <= $endYear; $i++) {
        $selected = ($i == $year) ? 'selected' : '';
        echo "<option value='$i' $selected>$i</option>";
    }
    echo "</select>";
    echo "</div>";

    // Add a button to submit the form or use JavaScript to trigger a reload with the selected month and year
    echo "<button onclick='updateCalendar()' class='btn-sm btn-secondary text-center'><i class='ri-calendar-fill'></i></button>";
    echo "</div>";
    // JavaScript function to update the calendar with the selected month and year
    echo "<script>
        function updateCalendar() {
            var selectedMonth = document.getElementById('month').value;
            var selectedYear = document.getElementById('year').value;
            window.location.href = 'dashboard?year=' + selectedYear + '&month=' + selectedMonth;
        }
    </script>";
    echo "</div>";


    echo "<table class='calendar slide-in-left table-borderless table-responsive'>";
    echo "<div id='presensi-data'></div>";
    echo "<thead>";
    echo "<tr>";
    foreach ($dayNames as $dayName) {
        echo "<th class='dayname'>$dayName</th>";
    }
    echo "</tr>";
    echo "</thead>";

    // Create the first row and fill in the empty cells
    echo "<tr>";
    for ($i = 1; $i < date('N', $firstDay); $i++) {
        echo "<td></td>";
    }

    // Fill in the days of the month
    for ($day = 1; $day <= $numDays; $day++) {
        // Determine if the day is a Sunday
        $isSunday = date('N', mktime(0, 0, 0, $month, $day, $year)) == 7;

        // Apply CSS class for Sundays
        $dayClass = $isSunday ? 'text-red' : '';
        $circle = $isSunday ? 'sunday' : '';
        $icon = $isSunday ? 'sunday' : '';


        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        $tanggalPresensi = date('Y-m-d 08:00:00', strtotime($currentDate));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));


        foreach ($presensi as $absen) {
            if ($absen->tanggal == $tanggalPresensi) {
                if ($absen->created_on <= $tanggalPresensi) {
                    $dayClass = 'text-green';
                    $icon = 'ri-checkbox-circle-line';
                    $circle .= ' with-circle-hadir';
                    $tooltip = 'Ini adalah tanggal 20!';
                } else {
                    $dayClass .= 'text-warning';
                    $icon = 'ri-error-warning-line';
                    $circle .= ' with-circle-terlambat';
                    $tooltip = 'Ini adalah tanggal 20!';
                }
                break;
            } else {
            }
        }


        // Mendapatkan status hari libur
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggalLibur) {
                $dayClass = 'text-red';
                $icon = 'ri-emotion-happy-line';
                $tooltip = $libur->holiday_name;
                break;
            } else {
                $tooltip = '';
            }
        }

        echo "<td class='day current-month' style='Padding: 20px;' id='tanggal'>
        <a type='button' class='btn-gc-cell'><span class='day-number $dayClass'>$day <i class='$icon'></i></span></a>";

        if ($isSunday) {
            echo "<div class='gc-event badge bg-danger mt-1'>Minggu Libur</div>";
        } else if ($libur->holiday_date == $tanggalLibur) {
            echo "<div class='gc-event badge bg-danger mt-1 text-left' data-toggle='tooltip' data-placement='bottom' title='$tooltip'>Libur : <div class='text-truncate' style='width: 60px' >{$libur->holiday_name}</div>
            </div>";
        } else {
            echo "</td>";
        }

        // echo "<td class='$dayClass $circle' title='$tooltip'>$day</td>";


        if (date('N', mktime(0, 0, 0, $month, $day, $year)) == 7) {
            echo "</tr>";
            if ($day < $numDays) {
                echo "<tr>";
            }
        }
    }

    echo "</tr>";
    echo "</table>";
}




function getStatusLibur($tanggal)
{
    // Mengambil data dari API Hari Libur
    $dataHariLibur = getHariLibur();

    foreach ($dataHariLibur as $hariLibur) {
        //Hari Libur sama dengan tanggal lalu ditampilkan tanggal mana saja yang menyediakan hari libur
        if ($hariLibur->holiday_date == $tanggal) {
            echo "Libur : $hariLibur->holiday_name"; // tampil hari libur
            return;
        }
    }
    return "";
}

function getStatus($userId, $bulanIni)
{
    $ci = &get_instance();

    $dataLibur = getHariLibur();

    // Fetch presensi data using your model
    $ci->load->model('PresensiModel');
    $presensiModel = new PresensiModel();
    $presensiBulanIni = $presensiModel->getPresensiBulanIni($userId, $bulanIni);

    $status = array();

    // Tentukan tanggal awal dan akhir bulan
    $tanggalAwal = date('Y-m-01 08:00:00', strtotime($bulanIni));
    $tanggalAkhir = date('Y-m-t 08:00:00', strtotime($bulanIni));

    // Loop untuk menghasilkan status untuk semua tanggal dalam bulan ini
    $currentDate = $tanggalAwal;
    while ($currentDate <= $tanggalAkhir) {
        $tanggal = date('Y-m-d', strtotime($currentDate));
        $tanggalPresensi = date('Y-m-d 08:00:00', strtotime($currentDate));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $selisihTotalMenit = 0;

        $indodate = indo_date($tanggal);

        $statusItem = array(
            'tanggal' => $indodate,
            'status' => '' // Default status
        );

        // Cek apakah tanggal ini merupakan hari libur
        foreach ($dataLibur as $holiday) {
            if ($holiday->holiday_date == $tanggalLibur) {
                $statusItem['status'] = "<span class='text-danger'>Libur: {$holiday->holiday_name}</span>";
                break;
            }
        }

        foreach ($presensiBulanIni as $presensi) {
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));

            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $selisihTotalMenit += $selisihMenit;
            }

            if ($presensi->tanggal == $tanggalPresensi) {
                if ($presensi->created_on <= $tanggalPresensi) {
                    $statusItem['status'] = "<span class='text-success'><i class='ri-checkbox-circle-line'></i> Hadir</span>";
                } else {
                    $statusItem['status'] = "<span class='text-warning'><i class='ri-error-warning-line'></i> Terlambat : {$selisihMenit} Menit</span>";
                    break;
                }
            }
        }


        //hari minggu
        $hari = date('N', strtotime($tanggalPresensi));
        if ($hari == 7) {
            $statusItem['status'] = "<span class='text-danger'>Libur</span>";
        }

        // Tambahkan status ke dalam array
        $status[] = $statusItem;

        // Lanjutkan ke tanggal berikutnya
        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
    }

    // Tampilkan semua status
    return $status;
}



function qrcode($data, $filename)
{
    $CI = &get_instance();
    $CI->load->library('ciqrcode');

    $base64Data = base64_encode($data);
    $urlEncodedData = urlencode($base64Data);
    // $url = base_url("presensi/" . $urlEncodedData);
    $url = base_url('presensi?data=' . $urlEncodedData);

    // Membuat URL dengan data yang sudah dibersihkan
    // $url = base_url("presensi/" . $base64Data);

    QRcode::png($url, FCPATH . "./uploads/qrcode/$filename.png", QR_ECLEVEL_H, 10);
    return $url;
}
