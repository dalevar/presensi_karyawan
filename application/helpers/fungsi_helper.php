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


// function getHariLibur()
// {
//     // Load library HTTP client
//     $CI = get_instance();
//     $CI->load->library('curl');
//     $CI->load->model('HolidaysModel');
//     $holidaysModel = new HolidaysModel();
//     //lakukan pengecekan terhadap api

//     // Permintaan ke API Hari Libur
//     $response = $CI->curl->simple_get('https://api-harilibur.vercel.app/api');
//     //lalu cek data ke database, jika ada lakukan responsenya terhadap data
//     //jika data api ini tidak ada di dalam database maka masukkan data kedalam database

//     // dd($response);
//     if ($response) {
//         // Data JSON dari API
//         $data = json_decode($response);

//         $filteredData = array_filter($data, function ($item) {
//             return isset($item->is_national_holiday) && $item->is_national_holiday === true;
//         });

//         foreach ($filteredData as $item) {
//             // Lakukan pengecekan apakah data dengan tanggal tertentu sudah ada dalam database
//             $existingHoliday = $holidaysModel->where('holiday_date', $item->holiday_date)->first();

//             if (!$existingHoliday) {
//                 // Jika data belum ada, masukkan ke database
//                 $newHoliday = new HolidaysModel();
//                 $newHoliday->holiday_date = $item->holiday_date;
//                 $newHoliday->holiday_name = $item->holiday_name;
//                 $newHoliday->is_national_holiday = $item->is_national_holiday;
//                 $newHoliday->save();
//             }
//         }

//         return $filteredData;
//     } else {
//         // Handle kesalahan jika tidak dapat terhubung ke API
//         return false;
//     }
// }

function getHariLibur()
{
    $CI = get_instance();
    $CI->load->model('HolidaysModel');
    $holidaysModel = new HolidaysModel();

    // Dapatkan tahun saat ini
    $tahunSaatIni = date('Y');

    // Periksa apakah ada data dalam database untuk tahun saat ini
    $dataLibur = $holidaysModel
        ->whereYear('holiday_date', $tahunSaatIni)
        ->get();

    if (!$dataLibur->isEmpty()) {
        // Jika data untuk tahun saat ini sudah ada dalam database, kembalikan datanya
        return $dataLibur;
    } else {
        // Jika tidak ada data untuk tahun saat ini, ambil data libur baru dari API
        $response = $CI->curl->simple_get('https://api-harilibur.vercel.app/api');

        if ($response) {
            $data = json_decode($response);

            $filteredData = array_filter($data, function ($item) {
                return isset($item->is_national_holiday) && $item->is_national_holiday === true;
            });

            foreach ($filteredData as $item) {
                $dataLiburBaru = new HolidaysModel();
                $dataLiburBaru->holiday_date = $item->holiday_date;
                $dataLiburBaru->holiday_name = $item->holiday_name;
                $dataLiburBaru->is_national_holiday = $item->is_national_holiday;
                $dataLiburBaru->save();
            }

            return $filteredData;
        } else {
            return false;
        }
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

function generateTanggalKerja($year, $month)
{
    $tanggalKerja = array();
    $tanggalAwal = new DateTime("$year-$month-01");
    $tanggalAkhir = new DateTime("$year-$month-" . date('t', strtotime("$year-$month-01")));

    while ($tanggalAwal <= $tanggalAkhir) {
        $dayOfWeek = $tanggalAwal->format('N'); // Mendapatkan hari dalam format 1 (Senin) hingga 7 (Minggu)

        // Memeriksa apakah hari adalah hari kerja (Senin hingga Sabtu)
        if ($dayOfWeek >= 1 && $dayOfWeek <= 6) {
            $tanggalKerja[] = $tanggalAwal->format('Y-m-d');
        }

        $tanggalAwal->modify('+1 day');
    }

    return $tanggalKerja;
}


function generateCalendar($userId, $year, $month)
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

    // mengambil data presensi per tiap bulan/tahun
    $presensiList = $presensiModel->getPresensiData($userId, $year, $month);

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
    //Select Bulan
    echo "<select id='month' name='month' class='custom-select custom-select-sm form-control form-control-sm'>";
    for ($i = 1; $i <= 12; $i++) {
        $selected = ($i == $month) ? 'selected' : '';
        echo "<option value='$i' $selected>" . getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    //Select Tahun
    echo "<select id='year' name='year' class='custom-select custom-select-sm form-control form-control-sm'>";
    $currentYear = date('Y');
    $startYear = $currentYear - 2;
    // $endYear = $currentYear + 77;
    for ($i = $startYear; $i <= $currentYear; $i++) {
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

    echo "<div class='row d-flex flex-wrap justify-content-between align-items-center mx-auto mb-3'>";
    echo "<ul class='nav nav-tabs' id='myTab-1' role='tablist'>";
    echo "<li class='nav-item'>
    <a class='nav-link active' id='presensi-tab' data-toggle='tab' href='#presensi' role='tab' aria-controls='presensi' aria-selected='true'>Presensi</a>
 </li>";
    echo "<li class='nav-item'>
 <a class='nav-link' id='keterangan-tab' data-toggle='tab' href='#keterangan' role='tab' aria-controls='keterangan' aria-selected='false'>Keterangan</a>
</li>";
    echo "</div>";

    echo "<div class='tab-content' id='myTabContent-2'>";
    echo "<div class='tab-pane fade show active' id='presensi' role='tabpanel' aria-labelledby='presensi-tab'>";
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

        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

        // Apply CSS class for Sundays
        $dayClass = $isSunday ? 'text-red' : '';
        // $circle = $isSunday ? 'sunday' : '';
        $icon = $isSunday ? 'sunday' : '';

        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        // $jamPresensi = strtotime(date('H:i:s', strtotime('08:00:00')));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));

        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
            $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
            $isSakit = $presensi->is_sakit;

            if ($isWeekday && $tanggalPresensi == $currentDate) {
                // Presensi ditemukan untuk tanggal ini
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));

                // jam perbandingan dengan waktu presensinya
                $jamPresensi = strtotime('08:00:00');
                $jamTidakHadir = strtotime('00:00:00');
                if ($waktuPresensi == $jamTidakHadir) {
                    $dayClass = 'text-secondary';
                    $icon = 'ri-close-circle-line';
                    $tooltip = '-';
                }

                if ($isSakit == 1) {
                    $dayClass = 'text-secondary';
                    $icon = 'ri-hospital-line';
                    $tooltip = '-';
                }

                if ($waktuPresensi <= $jamPresensi && $waktuPresensi != $jamTidakHadir) {
                    // Presensi tepat waktu
                    $dayClass = 'text-green';
                    $icon = 'ri-checkbox-circle-line';
                    $tooltip = 'Presensi tepat waktu';
                } else if ($waktuPresensi > $jamPresensi) {
                    // Presensi terlambat
                    $dayClass = 'text-warning';
                    $icon = 'ri-error-warning-line';
                    $tooltip = 'Presensi terlambat';
                }
                // Keluar dari loop setelah menemukan presensi yang sesuai
                break;
            }
            if ($isWeekday && $presensiCreated  >= $currentDate) {
                $dayClass = 'text-secondary';
                $icon = 'ri-close-circle-line';
                $tooltip = 'Presensi Tidak Hadir';
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

        // dd($presensi);
        if ($isWeekday) {
            echo "<td class='day current-month' style='Padding: 20px;' id='tanggal'>
            <a type='button' class='btn-gc-cell' id='btn-keterangan' data-target-tab='#keterangan' data-toggle='tab' href='#keterangan' role='tab' aria-controls='keterangan' aria-selected='false'><span class='day-number $dayClass'>$day <i class='$icon'></i></span></a>";
        } else {
            echo "<td class='day current-month' style='Padding: 20px;' id='tanggal'>
            <a type='button' class='btn-gc-cell'><span class='day-number $dayClass'>$day <i class='$icon'></i></span></a>";
        }


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
    echo "</div>";
    echo "<div class='tab-pane fade' id='keterangan' role='tabpanel' aria-labelledby='keterangan-tab'>";
    echo "<table id='datatable' class='table data-table table-striped table-bordered'>";
    echo "<thead class='table-color-heading'>";
    echo "<tr>
        <th width='23%'>Tanggal</th>
        <th>Keterangan</th>
        <th width='30%'>Jam Presensi</th>
    </tr>";
    echo "</thead>";
    echo "<tbody>";


    for ($day = 1; $day <= $numDays; $day++) {
        // Determine if the day is a Sunday
        $isSunday = date('N', mktime(0, 0, 0, $month, $day, $year)) == 7;

        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        // $jamPresensi = strtotime(date('H:i:s', strtotime('08:00:00')));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";
        $tidakHadirSakit = "<span class='text-secondary font-weight-bold'><i class='ri-hospital-line'></i> Sakit</span>";

        $keterangan = array();
        $statusJam = array();

        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
            // jam perbandingan dengan waktu presensinya
            $jamPresensi = strtotime('08:00:00');
            $jamTidakBerhadir = strtotime('00:00:00');
            $isWFH = $presensi->is_wfh; // Ambil data is_wfh
            $isSakit = $presensi->is_sakit;


            if ($isWeekday && $tanggalPresensi == $currentDate) {
                // // Presensi ditemukan untuk tanggal ini
                // $foundPresensi = true;
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                if ($waktuPresensi <= $jamTidakBerhadir) {
                    if ($isSakit == 1) {
                        $tidakHadir = null;
                        $keterangan[] = $tidakHadirSakit;
                    }
                    $keterangan[] = $tidakHadir;
                    $tidakHadir = null;
                }
                if ($waktuPresensi <= $jamPresensi && $waktuPresensi != $jamTidakBerhadir) {
                    $keterangan[] = "<span class='text-success font-weight-bold'><i class='ri-checkbox-circle-line'></i> Berhadir</span>";
                    $statusJam[] = "<span class='text-success'>Jam " .  date('H:i', $waktuPresensi) . " Pagi <i class='ri-checkbox-circle-line'></i></span>";
                    // Ubah $tidakHadir menjadi null jika ada data presensi
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                } elseif ($waktuPresensi > $jamPresensi) {
                    $keterangan[] = "<span class='text-warning font-weight-bold'><i class='ri-error-warning-line'></i> Terlambat</span>";
                    $statusJam[] = "<span class='text-warning'>Terlambat (" . floor(($waktuPresensi - $jamPresensi) / 60) . "menit) <i class='ri-error-warning-line'></i></span>";
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                }
                break;
            }
            if ($isWeekday && $presensiCreated == $currentDate) {
                $tidakHadir = null;
            }
        }

        // Mendapatkan status hari libur
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggalLibur) {
                $keterangan[] = 'Libur Nasional';
                break;
            } else {
                $tooltip = '';
            }
        }

        //ISI TABLE
        // Periksa apakah $currentDate lebih kecil dari atau sama dengan tanggal sekarang
        if (strtotime($currentDate) <= strtotime(date('Y-m-d'))) {
            //ISI TABLE
            echo "<tr>";
            if ($day == $isWeekday) {
                echo "<td>$day $indonesianMonthName $year</td>";
                // Tampilkan status sesuai dengan nilai $tidakHadir
                echo "<td>";
                if ($tidakHadir !== null) {
                    echo $tidakHadir;
                } elseif ($libur->holiday_date == $tanggalLibur) {
                    echo implode("<br>", $keterangan);
                } else {
                    echo implode("<br> ", $keterangan);
                }
                echo "</td>";
                echo "<td >";
                if (!empty($statusJam)) {
                    echo implode(", ", $statusJam);
                } else {
                    echo "-";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

    echo "<script>
    $(document).ready(function() {
        $('.btn-gc-cell').click(function() {
            $('#presensi-tab').removeClass('active');
            $('#keterangan-tab').addClass('active');
            var targetTab = $(this).data('target-tab');
            $('#keterangan-tab').tab('show');
        });
    });
    </script>
    ";
}

function generateRekap($userId, $year, $month)
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

    // mengambil data presensi per tiap bulan/tahun
    $presensiList = $presensiModel->getPresensiData($userId, $year, $month);

    for ($day = 1; $day <= $numDays; $day++) {
        // Determine if the day is a Sunday
        $isSunday = date('N', mktime(0, 0, 0, $month, $day, $year)) == 7;

        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        // $jamPresensi = strtotime(date('H:i:s', strtotime('08:00:00')));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";
        $tidakHadirSakit = "<span class='text-secondary font-weight-bold'><i class='ri-hospital-line'></i> Sakit</span>";
        $keterangan = array();
        $statusJam = array();

        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
            // jam perbandingan dengan waktu presensinya
            $jamPresensi = strtotime('08:00:00');
            $jamTidakHadir = strtotime('00:00:00');
            $isWFH = $presensi->is_wfh; // Ambil data is_wfh
            $isSakit = $presensi->is_sakit;

            if ($isWeekday && $tanggalPresensi == $currentDate) {
                // Presensi ditemukan untuk tanggal ini
                $foundPresensi = true;
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                if ($waktuPresensi == $jamTidakHadir) {
                    if ($isSakit) {
                        $keterangan[] = $tidakHadirSakit;
                        $tidakHadir = null;
                    }
                }

                if ($waktuPresensi <= $jamPresensi && $waktuPresensi != $jamTidakHadir) {
                    $keterangan[] = "<span class='text-success font-weight-bold'><i class='ri-checkbox-circle-line'></i> Berhadir</span>";
                    $statusJam[] = "<span class='text-success font-weight-bold'>Jam " .  date('H:i', $waktuPresensi) . " Pagi <i class='ri-checkbox-circle-line'></i></span>";
                    // Ubah $tidakHadir menjadi null jika ada data presensi
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                } elseif ($waktuPresensi > $jamPresensi) {
                    $keterangan[] = "<span class='text-warning font-weight-bold'><i class='ri-error-warning-line'></i> Terlambat</span>";
                    $statusJam[] = "<span class='text-warning font-weight-bold'>Terlambat (" . floor(($waktuPresensi - $jamPresensi) / 60) . "menit) <i class='ri-error-warning-line'></i></span>";
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                }
                break;
            }
            if ($isWeekday && $presensiCreated == $currentDate) {
                $tidakHadir = null;
            }
        }

        // Mendapatkan status hari libur
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggalLibur) {
                $keterangan[] = "<span class='text-danger font-weight-bold'>Libur Nasional</span>";
                $tidakHadir = null;
                break;
            } else {
                $tooltip = '';
            }
        }

        //ISI TABLE
        if (strtotime($currentDate) <= strtotime(date('Y-m-d'))) {
            echo "<tr>";
            if ($day == $isWeekday) {
                echo "<td>$day $indonesianMonthName $year</td>";
                // Tampilkan status sesuai dengan nilai $tidakHadir
                echo "<td>";
                if ($tidakHadir !== null) {
                    echo $tidakHadir;
                } elseif ($libur->holiday_date == $tanggalLibur) {
                    echo implode("  ", $keterangan);
                } else {
                    echo implode("<br>", $keterangan);
                }
                echo "</td>";
                echo "<td >";
                if (!empty($statusJam)) {
                    echo implode(", ", $statusJam);
                } else {
                    echo "-";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
    }
}

function generateDataRekapTahunan($userId, $year)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('JabatanModel');
    $ci->load->model('KaryawanModel');
    $ci->load->model('KonfigModel');


    $dataLibur = getHariLibur();


    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getDataPresensiTahun($userId, $year);

    $karyawanModel = new KaryawanModel();
    $karyawan = $karyawanModel->getByUserId($userId);
    if ($karyawan) {
        $jabatanId = $karyawan->jabatan_id;
        $cuti = JabatanModel::where('id', $jabatanId)->first();
        if ($cuti) {
            $alokasiCuti = $cuti->alokasi_cuti;
        } else {
            echo "-";
        }
        // dd($jabatanId);
    } else {
        echo "-";
    }

    $bulanText = array(); // Buat array untuk menyimpan nama bulan
    $totalPresensiBulan = array();
    $totalTerlambat = array();
    $totalWFH = array();
    $totalCuti = array();
    $totalHariKerja = array();
    $totalTidakHadir = array();
    $totalSakit = array();

    // Loop melalui bulan dan tanggal dalam tahun
    for ($month = 1; $month <= 12; $month++) {
        $totalTidakHadir = $presensiModel->tidakHadirBulanTahun($userId, $year, $month);
        $totalSakit = $presensiModel->hitungTotalSakitBulanan($userId, $month);
        $bulanText[$month] = getIndonesianMonth(date('F', mktime(0, 0, 0, $month, 1, $year))); // Simpan nama bulan
        $totalPresensiBulan[$month] = 0;
        $totalTerlambat[$month] = 0;
        $totalWFH[$month] = 0;
        $totalHariKerja[$month] = 0;
        $jumlahTotalTidakHadir[$month] = $totalTidakHadir;
        if (is_numeric($totalTidakHadir) && is_numeric($totalSakit)) {
            $jumlahSeluruhTotalTidakHadir[$month] = $totalTidakHadir += $totalSakit;
        } else {
            $jumlahSeluruhTotalTidakHadir[$month] = $totalTidakHadir;
        }
        $jumlahTotalSakit[$month] = $totalSakit;
        $dataSakit = KonfigModel::where('nama', 'sakit')->first();
        $dataSakitPenguranganCuti = KonfigModel::where('nama', 'cuti_kurang')->first();
        $batasSakit = $dataSakit->nilai;
        $penguranganCutiSakit = $dataSakitPenguranganCuti->nilai;

        $alokasiCuti = $alokasiCuti;

        // $alokasiCuti = $alokasiCuti -= $jumlahTotalSakit[$month];
        // dd($jumlahTotalSakit[$month]);


        //Tidak Hadir Terlambat
        $jumlahTotalTidakHadirTerlambat[$month] = 0; //Menghitung Tidak Hadir
        $totalKeterlambatan = 0; //Menampung waktu yang sudah lebih dari 8 jam
        $totalWaktuTerlambat = 0; //Menampun keseluruhan waktu
        $formatWaktuTerlambat = '';

        //Tidak Hadir WFH
        $jumlahTotalTidakHadirWFH[$month] = 0;
        $totalKeterlambatanWFH = 0;
        $totalWaktuWFH = 0;
        $formatWaktuWFH = '';


        $keterangan[$month] = array();
        $statusJam[$month] = array();

        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($day = 1; $day <= $jumlahHariBulan; $day++) {
            $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
            $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);

            if ($isWeekday) {
                $isHoliday = false;
                foreach ($dataLibur as $libur) {
                    if ($currentDate == $libur->holiday_date) {
                        $isHoliday = true;
                        break;  // Jika ditemukan sebagai hari libur, keluar dari loop
                    }
                }
                if (!$isHoliday) {
                    $totalHariKerja[$month]++;
                }
            }
        }

        echo "<tr>";
        $totalCuti[$month] = $alokasiCuti;
        // dd($totalCuti[$month]);

        // Loop melalui data presensi per bulan
        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));
            $jamTidakHadir = strtotime('00:00:00');
            $isWFH = $presensi->is_wfh;
            $isSakit = $presensi->is_sakit;

            $monthPresensi = date('n', strtotime($tanggalPresensi)); // Ambil bulan dari data presensi
            if ($monthPresensi >= 1 && $monthPresensi <= 12 && $monthPresensi == $month && $waktuPresensi != $jamTidakHadir) {
                // Pastikan bulan dari data presensi adalah antara 1 dan 12
                if (isset($totalPresensiBulan[$monthPresensi])) {
                    $totalPresensiBulan[$monthPresensi]++; // Tambahkan jumlah presensi untuk bulan ini

                    if ($waktuPresensi <= strtotime('08:00:00')) {
                        $keterangan[$monthPresensi][] = "<span class='text-success font-weight-bold'><i class='ri-checkbox-circle-line'></i> Berhadir</span>";
                        $statusJam[$monthPresensi][] = "<span class='text-success font-weight-bold'>Jam " . date('H:i', $waktuPresensi) . " Pagi <i 'class='ri-checkbox-circle-line'></i></span>";
                    } elseif ($waktuPresensi > strtotime('08:00:00')) {
                        $keterangan[$monthPresensi][] = "<span class='text-warning font-weight-bold'><i class='ri-error-warning-line'></i> Terlambat</span>";
                        $statusJam[$monthPresensi][] = "<span class='text-warning font-weight-bold'>Terlambat (" . floor(($waktuPresensi - strtotime('08:00:00')) / 60) . " menit) <i class='ri-error-warning-line'></i></span>";
                        $totalTerlambat[$monthPresensi]++;
                        // dd($totalTerlambat);

                        $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
                        if ($selisihWaktu > 0) {
                            // Mengkonversi selisih waktu ke menit
                            $selisihMenit = floor($selisihWaktu / 60);
                            $totalKeterlambatan += $selisihMenit;
                            $totalWaktuTerlambat += $selisihMenit;
                            // $totalWaktuTerlambat += $totalKeterlambatanWFH;

                            // Hitung jumlah jam
                            $totalJam = floor($totalWaktuTerlambat / 60);

                            // Hitung jumlah menit sisa setelah mengurangkan jam
                            $totalMenit = $totalWaktuTerlambat  % 60;
                            // $totalMenit += $totalKeterlambatanWFH;

                            $formatWaktuTerlambat = $totalJam . " jam " . $totalMenit . " menit";
                            // Periksa apakah total keterlambatan mencapai 8 jam (480 menit)
                            if ($totalKeterlambatan >= 480) {
                                $jumlahTotalTidakHadirTerlambat[$monthPresensi]++;
                                $jumlahSeluruhTotalTidakHadir[$monthPresensi]++;
                                // dd($jumlahTotalTidakHadir);
                                if ($totalCuti > 0) {
                                    $totalCuti[$monthPresensi]--;
                                }
                                // Kurangi 8 jam (480 menit) dari total keterlambatan
                                $totalKeterlambatan -= 480;
                            }
                        }
                    } elseif ($waktuPresensi == $jamTidakHadir && $isSakit == 0) {
                        if ($totalCuti > 0) {
                            $totalCuti[$monthPresensi]--;
                        }
                    }

                    if ($penguranganCutiSakit == 1) {
                        if ($isSakit == 1) {
                            if ($totalCuti > 0) {
                                $totalCuti[$monthPresensi]--;
                            }
                        }
                    }

                    if ($isWFH == 1) {
                        $keterangan[$monthPresensi][] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                        $totalWFH[$monthPresensi]++;

                        // Dapatkan data konfigurasi WFH
                        $dataWFH = KonfigModel::where('nama', 'wfh')->first();

                        if ($dataWFH) {
                            $nilaiWFH = $dataWFH->nilai;
                            if ($isWFH == 1) {
                                // Ubah nilai konfigurasi WFH ke dalam bentuk menit
                                $nilaiWFH = intval($nilaiWFH); // Mengambil angka dari string

                                // Tambahkan nilai konfigurasi WFH ke total keterlambatan
                                $totalKeterlambatanWFH += $nilaiWFH;
                                $totalWaktuWFH += $nilaiWFH;

                                // Hitung jumlah jam
                                $totalJamWFH = floor($totalWaktuWFH / 60);

                                // Hitung jumlah menit sisa setelah mengurangkan jam
                                $totalMenitWFH = $totalWaktuWFH  % 60;
                                // $totalMenit += $totalKeWFHanWFH;
                                $formatWaktuWFH = $totalJamWFH . " jam " . $totalMenitWFH . " menit";

                                if ($totalKeterlambatanWFH >= 480) {
                                    $jumlahTotalTidakHadirWFH[$monthPresensi]++;
                                    $jumlahSeluruhTotalTidakHadir[$monthPresensi]++;

                                    if ($totalCuti > 0) {
                                        $totalCuti[$monthPresensi]--;
                                    }
                                    // Kurangi 8 jam (480 menit) dari total keterlambatan
                                    $totalKeterlambatanWFH -= 480;
                                }
                            } else {
                                $formatWaktuWFH = '-';
                            }
                        }
                    }
                } else {
                }
            }
        }

        if ($totalPresensiBulan[$month] > 0) {
            echo "<td>" . $totalHariKerja[$month] . " Hari Kerja</td>";
            echo "<td><a type='button' class='btn-gc-cell text-info' id='btn-keterangan' data-month='$month'>$bulanText[$month]</a></td>";
            echo "<td>Total Presensi: " . $totalPresensiBulan[$month] . "</td>";
            echo "<td>";
            echo "Total Tidak Hadir : $jumlahSeluruhTotalTidakHadir[$month]";
            echo "<button class='btn btn-sm text-danger' id='toggleDetailButton$month'><i class='ri-error-warning-line'></i> Detail</button>";
            echo "<ul class='list-group' id='statusList$month' style='display: none'>
    <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
        Tidak Hadir
        <span class='badge badge-danger badge-pill'>$jumlahTotalTidakHadir[$month]</span>
    </li>
    <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
        Sakit
        <span class='badge badge-danger badge-pill'>$jumlahTotalSakit[$month]</span>
    </li>
    <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-warning' >
        Terlambat
        <span class='badge badge-warning badge-pill'>$jumlahTotalTidakHadirTerlambat[$month]</span>
    </li>
    <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-info'>
        WFH
        <span class='badge badge-info badge-pill'>$jumlahTotalTidakHadirWFH[$month]</span>
    </li>
</ul>";
            echo "</td>";
            echo "<td>";
            echo "Total Terlambat : $totalTerlambat[$month]";
            echo "<br><button class='btn btn-sm text-warning p-0' id='waktuDetailButton$month'><i class='ri-error-warning-line'></i>Total Waktu</button>";
            echo "<ul class='list-group' id='waktu$month' style='display: none'>
        <span class='badge badge-danger badge-pill'>$formatWaktuTerlambat</span>
</ul>";
            echo "</td>";
            echo "<td>";
            echo "Total WFH : $totalWFH[$month]";
            echo "<br><button class='btn btn-sm text-warning p-0' id='WFHDetailButton$month'><i class='ri-error-warning-line'></i>Total Waktu</button>";
            echo "<ul class='list-group' id='WFH$month' style='display: none'>
        <span class='badge badge-danger badge-pill'>$formatWaktuWFH</span>
</ul>";
            echo "</td>";
            echo "<td>";
            if ($totalCuti[$month] > $alokasiCuti) {
                echo "Total Cuti: 0 Hari";
            } else {
                echo "Total Cuti: " . $totalCuti[$month] . " Hari";
            }
            echo "<br><button class='btn btn-sm text-secondary p-0' id='cutiDetailButton$month'><i class='ri-error-warning-line'></i>Keterangan</button>";
            echo "<ul class='list-group' id='cuti$month' style='display: none'>
            <span class='badge text-primary badge-pill'>Total Cuti dikurangi dari :</span>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-warning' >
            Izin/Tidak Hadir
            <span class='badge badge-danger badge-pill'>$jumlahTotalTidakHadir[$month]</span>
        </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-warning' >
            Terlambat
            <span class='badge badge-warning badge-pill'>$jumlahTotalTidakHadirTerlambat[$month]</span>
        </li>
        <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-info'>
        WFH
        <span class='badge badge-info badge-pill'>$jumlahTotalTidakHadirWFH[$month]</span>
    </li>
</ul>";
            echo "</td>";
        } else {
            echo "<td class='text-secondary'>" . $totalHariKerja[$month] . " Hari Kerja</td>";
            echo "<td class='text-secondary'>$bulanText[$month]</td>";
            echo "<td colspan='7' class='text-center text-secondary'>Tidak ada presensi di bulan ini</td>";
        }

        echo "</tr>";
    }
}


function generateDataBulanan($year, $month)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('KaryawanModel');

    // Hari Libur Nasional
    $dataLibur = getHariLibur();

    $tanggalKerja = generateTanggalKerja($year, $month);

    // Data Presensi Nama Karyawan
    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getPresensiBulanTahun($year, $month);
    // dd($presensiList);
    $karyawanId = $presensiModel->getAllUserIds();

    //Karyawan
    $karyawanModel = new KaryawanModel();
    $karyawanList = $karyawanModel->getKaryawan();

    foreach ($tanggalKerja as $tanggal) {
        $idKaryawan = $karyawanId;
        // dd($idKaryawan);
        $namaKaryawan = array();
        $jamPresensi = array();
        $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";
        $sakit = "<span class='text-secondary font-weight-bold'><i class='ri-hospital-line'></i> Sakit</span>";

        $tanggalFormat = date('d-F-Y', strtotime($tanggal));
        $tanggalIndonesia = date('d-M-Y', strtotime($tanggalFormat));

        // Mendapatkan status hari libur
        $isLiburNasional = false;
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggal) {
                $isLiburNasional = true;
                break;
            }
        }

        $listKaryawan = count($karyawanList);

        for ($i = 0; $i < $listKaryawan; $i++) {
            echo "<tr>";
            if ($i === 0) {
                echo "<td rowspan='" . $listKaryawan . "' class='text-center'>$tanggalIndonesia</td>";
            }

            // Mengambil nama dari data karyawan dan menambahkannya ke string
            $namaKaryawan = $karyawanList[$i]->nama;
            $ID = $karyawanList[$i]->id;
            $status = $isLiburNasional ? "<span class='text-danger font-weight-bold'>Libur Nasional</span>" : $tidakHadir;
            $jamPresensi = "";
            echo "<td>" . $namaKaryawan . "</td>";


            foreach ($presensiList as $presensi) {
                $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
                $batasWaktu = strtotime('08:00:00');
                $jamTidakHadir = strtotime('00:00:00');

                $isWFH = $presensi->is_wfh; // Ambil data is_wfh
                $isSakit = $presensi->is_sakit;
                $keterangan = "";

                if ($ID == $presensi->created_by) {

                    if ($tanggal == $presensiCreated && $waktuPresensi <= strtotime('08:00:00') && $waktuPresensi != $jamTidakHadir) {
                        $status = "<span class='text-success font-weight-bold'>Hadir</span>";
                        $jamPresensi = "<span class='text-success font-weight-bold'>" . date('H:i:s', $waktuPresensi) . " Pagi</span>";
                        if ($isWFH == 1) {
                            $keterangan = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                        }
                        break;
                    } elseif ($tanggal == $presensiCreated && $waktuPresensi > strtotime('08:00:00')) {
                        $status = "<span class='text-warning font-weight-bold'>Terlambat</span>";
                        $jamPresensi = "<span class='text-warning font-weight-bold'>" . date('H:i:s', $waktuPresensi) . " (" . floor(($waktuPresensi - $batasWaktu) / 60) . " Menit)</span>";
                        if ($isWFH == 1) {
                            $keterangan = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                        }
                        break;
                    } elseif ($tanggal == $presensiCreated && $waktuPresensi == $jamTidakHadir) {
                        if ($isSakit == 1) {
                            $status = $sakit;
                        }
                    }
                }
            }

            // Periksa jika tanggal presensi lebih besar dari tanggal saat ini
            if (strtotime($tanggal) > strtotime('now')) {
                $status = "<span class='text-secondary font-weight-bold'>Belum Ada Presensi</span>";
                echo "<td colspan='2' class='text-center'>" . $status . "</td>";
                $jamPresensi = ""; // Kosongkan jam presensi
            } else {
                // Menampilkan data status dan jam presensi
                echo "<td>" . $status . "<br>" . $keterangan . "</td>";
                echo "<td>" . $jamPresensi . "</td>";
            }
            echo "</tr>";
        }
    }
}

function generateRekapBulanan($year, $month)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('KaryawanModel');
    $ci->load->model('JabatanModel');
    $ci->load->model('KonfigModel');



    // Ambil daftar karyawan
    $karyawanModel = new KaryawanModel();
    $karyawanList = $karyawanModel->getKaryawan();

    // Ambil data presensi untuk bulan dan tahun tertentu
    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getPresensiBulan($month);


    // Iterasi melalui setiap karyawan
    $no = 1;

    foreach ($karyawanList as $karyawan) {
        $userId = $karyawan->user_id;
        $totalTidakHadir = $presensiModel->tidakHadirBulanTahun($userId, $year, $month);
        $totalSakit = $presensiModel->TotalSakitBulanTahun($userId, $year, $month);
        // dd($totalTidakHadir);

        // $cuti = JabatanModel::where('id', $karyawan->jabatan_id)->first();
        // // dd($cuti);
        // if ($cuti) {
        //     $alokasiCuti = $cuti->alokasi_cuti;
        // } else {
        //     echo "-";
        // }

        $alokasiCuti = sisaCutiBulanan($userId, $month);

        $totalKehadiran = 0;
        $jumlahTotalTidakHadir = $totalTidakHadir;
        $jumlahTotalSakit = $totalSakit;
        // dd($jumlahTotalTidakHadir);
        $totalKeterlambatan = 0;
        $totalTidakHadirTerlambat = 0;
        $totalWFH = 0;
        $totalCuti = $alokasiCuti;
        $totalWaktuTerlambat = 0;

        $nilaiWFH = 0;
        $totalKeterlambatanWFH = 0;
        $totalTidakHadirWFH = 0;
        $totalWaktuWFH = 0;
        $formatWaktuTerlambat = '-';
        $formatWaktuWFH = '-';

        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for ($day = 1; $day <= $jumlahHariBulan; $day++) {
            $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

            if (strtotime($currentDate) <= strtotime(date('Y-m-d'))) {
                $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));

                foreach ($presensiList as $presensi) {
                    $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
                    $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                    // $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
                    $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
                    $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));

                    $isWFH = $presensi->is_wfh;

                    if ($currentDate == $tanggalPresensi && $karyawan->id == $presensi->created_by) {
                        //Total Kehadiran 
                        if ($waktuPresensi <= strtotime('08:00:00') || $waktuPresensi > strtotime('08:00:00')) {
                            $totalKehadiran++;
                        }
                        //Total Terlambat
                        // Menghitung selisih waktu dalam menit
                        $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
                        if ($selisihWaktu > 0) {
                            // Mengkonversi selisih waktu ke menit
                            $selisihMenit = floor($selisihWaktu / 60);
                            $totalKeterlambatan += $selisihMenit;
                            $totalWaktuTerlambat += $selisihMenit;
                            // $totalWaktuTerlambat += $totalKeterlambatanWFH;

                            // Hitung jumlah jam
                            $totalJam = floor($totalWaktuTerlambat / 60);

                            // Hitung jumlah menit sisa setelah mengurangkan jam
                            $totalMenit = $totalWaktuTerlambat  % 60;
                            // $totalMenit += $totalKeterlambatanWFH;

                            $formatWaktuTerlambat = $totalJam . " jam " . $totalMenit . " menit";


                            // Periksa apakah total keterlambatan mencapai 8 jam (480 menit)
                            if ($totalKeterlambatan >= 480) {
                                $totalTidakHadirTerlambat++;
                                $jumlahTotalTidakHadir++;
                                // dd($jumlahTotalTidakHadir);
                                if ($totalCuti > 0) {
                                    $totalCuti--;
                                }
                                // Kurangi 8 jam (480 menit) dari total keterlambatan
                                $totalKeterlambatan -= 480;
                            }
                        }

                        // Hitung jumlah data WFH
                        //Jika WFH lakukan pengurangan Menit atau menambah keterlambatan sesuai konfigurasi
                        if ($isWFH == 1) {
                            $totalWFH++;

                            // Dapatkan data konfigurasi WFH
                            $dataWFH = KonfigModel::where('nama', 'wfh')->first();

                            // Periksa apakah data konfigurasi WFH ada
                            if ($dataWFH) {
                                // Ambil nilai konfigurasi WFH
                                $nilaiWFH = $dataWFH->nilai;

                                // Hitung total keterlambatan
                                if ($isWFH == 1) {
                                    // Ubah nilai konfigurasi WFH ke dalam bentuk menit
                                    $nilaiWFH = intval($nilaiWFH); // Mengambil angka dari string

                                    // Tambahkan nilai konfigurasi WFH ke total keterlambatan
                                    $totalKeterlambatanWFH += $nilaiWFH;
                                    $totalWaktuWFH += $nilaiWFH;

                                    // Hitung jumlah jam
                                    $totalJamWFH = floor($totalWaktuWFH / 60);

                                    // Hitung jumlah menit sisa setelah mengurangkan jam
                                    $totalMenitWFH = $totalWaktuWFH  % 60;
                                    // $totalMenit += $totalKeWFHanWFH;
                                    $formatWaktuWFH = $totalJamWFH . " jam " . $totalMenitWFH . " menit";

                                    if ($totalKeterlambatanWFH >= 480) {
                                        $totalTidakHadirWFH++;
                                        $jumlahTotalTidakHadir++;

                                        if ($totalCuti > 0) {
                                            $totalCuti--;
                                        }
                                        // Kurangi 8 jam (480 menit) dari total keterlambatan
                                        $totalKeterlambatanWFH -= 480;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        // Output data rekap karyawan
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td><a class='text-info'><button type='button' class='btn toggleDetailButton text-info' data-toggle='collapse' data-target='#karyawanDetail$no'>" . $karyawan->nama . "</button></a></td>";
        echo "<td>" . $karyawan->jabatan . "</td>";
        echo "<td> Total Berhadir : " . $totalKehadiran . " Hari</td>";
        echo "<td>";
        echo "$jumlahTotalTidakHadir Hari";
        echo "<button class='btn btn-sm text-danger' data-toggle='collapse' data-target='#statusList$no'><i class='ri-error-warning-line'></i> Detail</button>";
        echo "<ul class='list-group' id='statusList$no' style='display: none'>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
               Tidak Hadir
               <span class='badge badge-danger badge-pill'>$totalTidakHadir</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
               Sakit
               <span class='badge badge-danger badge-pill'>$jumlahTotalSakit</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-warning' >
               Terlambat
               <span class='badge badge-warning badge-pill'>$totalTidakHadirTerlambat</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-info'>
               WFH
               <span class='badge badge-info badge-pill'>$totalTidakHadirWFH</span>
            </li>
         </ul>
         ";
        echo "</td>";
        // echo "<td></td>";


        echo "<td>";
        if (!$totalTidakHadirTerlambat == 0) {
            echo "<span class='text-warning d-inline-block' tabindex='0' data-toggle='tooltip' title='Dianggap Tidak Hadir : $totalTidakHadirTerlambat Hari' >" . $formatWaktuTerlambat . " <i class='ri-error-warning-line'></i></span><br> (" . $totalTidakHadirTerlambat . " Hari)";
        } else {
            echo "<span class='text-warning d-inline-block' tabindex='0' data-toggle='tooltip' title='Dianggap Tidak Hadir : $totalTidakHadirTerlambat Hari' >" . $formatWaktuTerlambat . " <i class='ri-error-warning-line'></i></span>";
        }
        echo "</td>";
        echo "<td>" . $totalWFH . " Hari <span class='text-info d-inline-block' tabindex='0' data-toggle='tooltip' title='Total WFH : $formatWaktuWFH Menit ($totalTidakHadirWFH Hari)' ><i class='ri-error-warning-line'></i></td>";
        echo "<td>" . $totalCuti . " Hari</td>";
        echo "</tr>";
    }
}

function generateRekapTahunan($year, $month)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('KaryawanModel');
    $ci->load->model('JabatanModel');

    // Ambil daftar karyawan
    $karyawanModel = new KaryawanModel();
    $karyawanList = $karyawanModel->getKaryawan();


    // Ambil data presensi untuk bulan dan tahun tertentu
    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getPresensiTahun($year);


    // Iterasi melalui setiap karyawan
    $no = 1;

    foreach ($karyawanList as $karyawan) {
        $karyawanId = $karyawan->id;
        $userId = $karyawan->user_id;
        $totalTidakHadir = 0;
        // $totalSakit = 0;
        for ($month = 1; $month <= 12; $month++) {
            // Panggil metode Anda yang sudah ada untuk menghitung ketidakhadiran bulanan
            $jumlahTidakHadirBulan = $presensiModel->tidakHadirBulanTahun($userId, $year, $month);
            $totalSakit = $presensiModel->hitungTotalSakitTahunan($userId, $year);
            // dd($totalSakit);
            // dd($jumlahTidakHadirBulan);
            // Pastikan bahwa $jumlahTidakHadirBulan adalah numerik sebelum menambahkannya ke total tahunan
            if (is_numeric($jumlahTidakHadirBulan)) {
                $totalTidakHadir += $jumlahTidakHadirBulan;
            }
        }

        // $cuti = JabatanModel::where('id', $karyawan->jabatan_id)->first();
        // if ($cuti) {
        //     $alokasiCuti = $cuti->alokasi_cuti;
        // } else {
        //     echo "Tidak Ada";
        // }

        $alokasiCuti = sisaCutiTahunan($userId, $year);


        $totalKehadiran = 0;
        $jumlahTotalTidakHadir = $totalTidakHadir;
        $jumlahSakit = $totalSakit;
        // dd($jumlahTotalTidakHadir);
        $totalKeterlambatan = 0;
        $totalTidakHadirTerlambat = 0;
        $totalWFH = 0;
        $totalCuti = $alokasiCuti;
        $totalWaktuTerlambat = 0;

        $nilaiWFH = 0;
        $totalKeterlambatanWFH = 0;
        $totalTidakHadirWFH = 0;
        $totalWaktuWFH = 0;
        $formatWaktuTerlambat = '-';
        $formatWaktuWFH = '-';

        $currentYear = $year;
        foreach ($presensiList as $presensi) {
            $tahunPresensi = date('Y', strtotime($presensi->tanggal));
            $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));

            $isWFH = $presensi->is_wfh;

            if ($currentYear == $tahunPresensi && $karyawan->id == $presensi->created_by) {
                //Total Kehadiran 
                if ($waktuPresensi <= strtotime('08:00:00') || $waktuPresensi > strtotime('08:00:00')) {
                    $totalKehadiran++;
                }
                //Total Terlambat
                // Menghitung selisih waktu dalam menit
                $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
                if ($selisihWaktu > 0) {
                    // Mengkonversi selisih waktu ke menit
                    $selisihMenit = floor($selisihWaktu / 60);
                    $totalKeterlambatan += $selisihMenit;
                    $totalWaktuTerlambat += $selisihMenit;
                    // $totalWaktuTerlambat += $totalKeterlambatanWFH;

                    // Hitung jumlah jam
                    $totalJam = floor($totalWaktuTerlambat / 60);

                    // Hitung jumlah menit sisa setelah mengurangkan jam
                    $totalMenit = $totalWaktuTerlambat  % 60;
                    // $totalMenit += $totalKeterlambatanWFH;

                    $formatWaktuTerlambat = $totalJam . " jam " . $totalMenit . " menit";


                    // Periksa apakah total keterlambatan mencapai 8 jam (480 menit)
                    if ($totalKeterlambatan >= 480) {
                        $totalTidakHadirTerlambat++;
                        $jumlahTotalTidakHadir++;
                        // dd($jumlahTotalTidakHadir);
                        if ($totalCuti > 0) {
                            $totalCuti--;
                        }
                        // Kurangi 8 jam (480 menit) dari total keterlambatan
                        $totalKeterlambatan -= 480;
                    }
                }

                // Hitung jumlah data WFH
                //Jika WFH lakukan pengurangan Menit atau menambah keterlambatan sesuai konfigurasi
                if ($isWFH == 1) {
                    $totalWFH++;

                    // Dapatkan data konfigurasi WFH
                    $dataWFH = KonfigModel::where('nama', 'wfh')->first();

                    // Periksa apakah data konfigurasi WFH ada
                    if ($dataWFH) {
                        // Ambil nilai konfigurasi WFH
                        $nilaiWFH = $dataWFH->nilai;

                        // Hitung total keterlambatan
                        if ($isWFH == 1) {
                            // Ubah nilai konfigurasi WFH ke dalam bentuk menit
                            $nilaiWFH = intval($nilaiWFH); // Mengambil angka dari string

                            // Tambahkan nilai konfigurasi WFH ke total keterlambatan
                            $totalKeterlambatanWFH += $nilaiWFH;
                            $totalWaktuWFH += $nilaiWFH;

                            // Hitung jumlah jam
                            $totalJamWFH = floor($totalWaktuWFH / 60);

                            // Hitung jumlah menit sisa setelah mengurangkan jam
                            $totalMenitWFH = $totalWaktuWFH  % 60;
                            // $totalMenit += $totalKeWFHanWFH;
                            $formatWaktuWFH = $totalJamWFH . " jam " . $totalMenitWFH . " menit";

                            if ($totalKeterlambatanWFH >= 480) {
                                $totalTidakHadirWFH++;
                                $jumlahTotalTidakHadir++;

                                if ($totalCuti > 0) {
                                    $totalCuti--;
                                }
                                // Kurangi 8 jam (480 menit) dari total keterlambatan
                                $totalKeterlambatanWFH -= 480;
                            }
                        }
                    }
                }
            }
        }
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td><a class='text-info'><button type='button' class='btn toggleDetailButton text-info' data-toggle='collapse' data-target='#karyawanDetailTahunan$no'>" . $karyawan->nama . "</button></a></td>";
        echo "<td>" . $karyawan->jabatan . "</td>";
        echo "<td> Total Berhadir : " . $totalKehadiran . " Hari</td>";
        echo "<td>";
        echo "$jumlahTotalTidakHadir Hari";
        echo "<button class='btn btn-sm text-danger p-0' data-toggle='collapse' data-target='#statusListTahunan$month'><i class='ri-error-warning-line'></i> Detail</button>";
        echo "<ul class='list-group' id='statusListTahunan$month' style='display: none'>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
               Tidak Hadir
               <span class='badge badge-danger badge-pill'>$totalTidakHadir</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-danger' >
               Sakit
               <span class='badge badge-danger badge-pill'>$jumlahSakit</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-warning' >
               Terlambat
               <span class='badge badge-warning badge-pill'>$totalTidakHadirTerlambat</span>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center iq-bg-info'>
               WFH
               <span class='badge badge-info badge-pill'>$totalTidakHadirWFH</span>
            </li>
         </ul>
         ";
        echo "</td>";
        // echo "<td></td>";
        echo "<td>";
        if (!$totalTidakHadirTerlambat == 0) {
            echo "<span class='text-warning d-inline-block' tabindex='0' data-toggle='tooltip' title='Dianggap Tidak Hadir : $totalTidakHadirTerlambat Hari' >" . $formatWaktuTerlambat . " <i class='ri-error-warning-line'></i></span><br> (" . $totalTidakHadirTerlambat . " Hari)";
        } else {
            echo "<span class='text-warning d-inline-block' tabindex='0' data-toggle='tooltip' title='Dianggap Tidak Hadir : $totalTidakHadirTerlambat Hari' >" . $formatWaktuTerlambat . " <i class='ri-error-warning-line'></i></span>";
        }
        echo "</td>";
        echo "<td>" . $totalWFH . " Hari <span class='text-info d-inline-block' tabindex='0' data-toggle='tooltip' title='Total WFH : $formatWaktuWFH Menit ($totalTidakHadirWFH Hari)' ><i class='ri-error-warning-line'></i></td>";
        echo "<td>" . $totalCuti . " Hari</td>";
        echo "</tr>";
    }
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

function totalTerlambatTahun($userId, $year)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $presensiModel = new PresensiModel();

    $totalKeterlambatan = 0;
    $totalWaktuTerlambat = 0;
    $formatWaktuTerlambat = '-';

    $presensiList = $presensiModel->getDataPresensiTahun($userId, $year);
    foreach ($presensiList as $presensi) {
        $tahunPresensi = date('Y', strtotime($presensi->tanggal));

        if ($tahunPresensi == $year) {
            $jamTanggal = date('H:i:s', strtotime($presensi->tanggal));
            $jamCreatedOn = date('H:i:s', strtotime($presensi->created_on));


            // Menghitung selisih waktu dalam menit
            $selisihWaktu = strtotime($jamCreatedOn) - strtotime($jamTanggal);
            if ($selisihWaktu > 0) {
                // Mengkonversi selisih waktu ke menit
                $selisihMenit = floor($selisihWaktu / 60);
                $totalKeterlambatan += $selisihMenit;
                $totalWaktuTerlambat += $selisihMenit;

                // Hitung jumlah jam
                $totalJam = floor($totalWaktuTerlambat / 60);

                // Hitung jumlah menit sisa setelah mengurangkan jam
                $totalMenit = $totalWaktuTerlambat  % 60;
                // $totalMenit += $totalKeterlambatanWFH;

                $formatWaktuTerlambat = $totalJam . " Jam " . $totalMenit . " Menit";
            }
        }
    }
    return $formatWaktuTerlambat;
    // dd($totalKeterlambatan);
}

function totalTidakHadirTahun($userId, $year)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $presensiModel = new PresensiModel();
    $presensi = $presensiModel->getDataPresensiTahun($userId, $year);


    for ($month = 1; $month <= 12; $month++) {
        $totalTidakHadir = $presensiModel->tidakHadirBulanTahun($userId, $year, $month);
        // dd($totalTidakHadir);
        $jumlahTotalTidakHadir = $totalTidakHadir;
    }
    return $jumlahTotalTidakHadir;
    // dd($jumlahTotalTidakHadir);
}

function sisaCutiTahunan($userId, $year)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('KaryawanModel');
    $ci->load->model('JabatanModel');
    $ci->load->model('KonfigModel');

    $presensiModel = new PresensiModel();
    $presensiTahunan = $presensiModel->getDataPresensiTahun($userId, $year);
    $tidakHadirTahunan = $presensiModel->tidakHadirTahunan($userId, $year);
    $totalSakit = $presensiModel->hitungTotalSakitTahunan($userId, $year);
    // dd($tidakHadirTahunan);
    $karyawanModel = new KaryawanModel();
    $karyawan = $karyawanModel->getByUserId($userId);
    if ($karyawan) {
        $jabatanId = $karyawan->jabatan_id;
        $cuti = JabatanModel::where('id', $jabatanId)->first();
        if ($cuti) {
            $alokasiCuti = $cuti->alokasi_cuti;
        } else {
            echo "-";
        }
        // dd($jabatanId);
    } else {
        echo "-";
    }

    // Ambil data konfigurasi Sakit
    $dataSakit = KonfigModel::where('nama', 'sakit')->first();
    $kontrolCuti = KonfigModel::where('nama', 'cuti_kurang')->first();
    // Periksa apakah data konfigurasi Sakit ada
    if ($dataSakit) {
        // Ambil batas sakit yang telah ditentukan
        $batasSakit = $dataSakit->nilai;
        $batasSakitTahunan = $batasSakit * 12;

        $kontrolPenguranganCuti = $kontrolCuti->nilai;

        // Periksa apakah jumlah sakit melebihi batas sakit
        if ($totalSakit > $batasSakitTahunan) {
            if ($kontrolPenguranganCuti == 1) {
                // Kurangi alokasi cuti jika jumlah sakit melebihi batas sakit
                $alokasiCuti -= 1; //kurangi 1 cuti
            }
        }
    }

    if (empty($tidakHadirTahunan)) {
        $totalCuti = $alokasiCuti * 12;
    } else {
        $totalCuti = $alokasiCuti * 12 - $tidakHadirTahunan;
    }

    // dd($totalCuti);
    return $totalCuti;
}

function sisaCutiBulanan($userId, $month)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');
    $ci->load->model('KaryawanModel');
    $ci->load->model('JabatanModel');
    $ci->load->model('KonfigModel');

    $presensiModel = new PresensiModel();
    $presensiBulanan = $presensiModel->getDataPresensiBulan($userId, $month);
    $tidakHadirBulanan = $presensiModel->tidakHadirBulanan($userId, $month);
    $totalSakit = $presensiModel->hitungTotalSakitBulanan($userId, $month);
    // dd($tidakHadirTahunan);
    $karyawanModel = new KaryawanModel();
    $karyawan = $karyawanModel->getByUserId($userId);
    if ($karyawan) {
        $jabatanId = $karyawan->jabatan_id;
        $cuti = JabatanModel::where('id', $jabatanId)->first();
        if ($cuti) {
            $alokasiCuti = $cuti->alokasi_cuti;
        } else {
            echo "-";
        }
        // dd($jabatanId);
    } else {
        echo "-";
    }

    $jumlahIzin = 0;
    foreach ($presensiBulanan as $presensi) {
        $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
        $jamTidakHadir = strtotime('00:00:00');

        if ($waktuPresensi == $jamTidakHadir) {
            $jumlahIzin++;
            $tidakHadirBulanan += $jumlahIzin;
        }
    }

    // Ambil data konfigurasi Sakit
    $dataSakit = KonfigModel::where('nama', 'sakit')->first();
    $kontrolCuti = KonfigModel::where('nama', 'cuti_kurang')->first();
    // Periksa apakah data konfigurasi Sakit ada
    if ($dataSakit) {
        // Ambil batas sakit yang telah ditentukan
        $batasSakit = $dataSakit->nilai;
        $kontrolPenguranganCuti = $kontrolCuti->nilai;

        // Periksa apakah jumlah sakit melebihi batas sakit
        if ($totalSakit > $batasSakit) {
            // Kurangi alokasi cuti jika jumlah sakit melebihi batas sakit
            if ($kontrolPenguranganCuti == 1) {
                // Kurangi alokasi cuti jika jumlah sakit melebihi batas sakit
                $alokasiCuti -= 1; // Kurangi 1 cuti
            }
        }
    }

    if (empty($tidakHadirBulanan)) {
        $totalCuti = $alokasiCuti;
    } elseif ($tidakHadirBulanan > $batasSakit) {
        $totalCuti = '-';
    } else {
        $totalCuti = $alokasiCuti - $tidakHadirBulanan;
    }

    // dd($totalCuti);
    return $totalCuti;
}

function totalWFH($userId, $year)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');


    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getDataPresensiTahun($userId, $year);

    $totalWFH = 0;
    foreach ($presensiList as $presensi) {
        $isWFH = $presensi->is_wfh;
        if ($isWFH == 1) {
            $totalWFH++;
        }
    }
    return $totalWFH;
}

function totalWFHBulanan($userId, $month)
{
    $ci = &get_instance();
    $ci->load->model('PresensiModel');

    $presensiModel = new PresensiModel();
    $presensiList = $presensiModel->getDataPresensiBulan($userId, $month);

    $totalWFH = 0;
    foreach ($presensiList as $presensi) {
        $isWFH = $presensi->is_wfh;
        if ($isWFH == 1) {
            $totalWFH++;
        }
    }
    return $totalWFH;
}

function keteranganBulanan($year, $month)
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

    // Ambil daftar karyawan
    $karyawanModel = new KaryawanModel();
    $karyawanList = $karyawanModel->getKaryawan();

    // Iterasi melalui setiap karyawan
    $no = 1;

    foreach ($karyawanList as $karyawan) {
        $karyawanId = $karyawan->id;
        $userId = $karyawan->user_id;
        $presensiModel = new PresensiModel();
        $presensiList = $presensiModel->getPresensiData($userId, $year, $month);
    }

    for ($day = 1; $day <= $numDays; $day++) {
        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);
        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        // $jamPresensi = strtotime(date('H:i:s', strtotime('08:00:00')));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";

        $keterangan = array();
        $statusJam = array();
        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
            // jam perbandingan dengan waktu presensinya
            $jamPresensi = strtotime('08:00:00');
            $isWFH = $presensi->is_wfh; // Ambil data is_wfh

            if ($isWeekday && $tanggalPresensi == $currentDate) {
                // Presensi ditemukan untuk tanggal ini
                $foundPresensi = true;
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));

                if ($waktuPresensi <= $jamPresensi) {
                    $keterangan[] = "<span class='text-success font-weight-bold'><i class='ri-checkbox-circle-line'></i> Berhadir</span>";
                    $statusJam[] = "<span class='text-success font-weight-bold'>Jam " .  date('H:i', $waktuPresensi) . " Pagi <i class='ri-checkbox-circle-line'></i></span>";
                    // Ubah $tidakHadir menjadi null jika ada data presensi
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                } elseif ($waktuPresensi > $jamPresensi) {
                    $keterangan[] = "<span class='text-warning font-weight-bold'><i class='ri-error-warning-line'></i> Terlambat</span>";
                    $statusJam[] = "<span class='text-warning font-weight-bold'>Terlambat (" . floor(($waktuPresensi - $jamPresensi) / 60) . "menit) <i class='ri-error-warning-line'></i></span>";
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                }
                break;
            }
            if ($isWeekday && $presensiCreated == $currentDate) {
                $tidakHadir = null;
            }
        }

        // Mendapatkan status hari libur
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggalLibur) {
                $keterangan[] = "<span class='text-danger font-weight-bold'>Libur Nasional</span>";
                $tidakHadir = null;
                break;
            } else {
                $tooltip = '';
            }
        }

        //ISI TABLE
        if (strtotime($currentDate) <= strtotime(date('Y-m-d'))) {
            echo "<tr>";
            if ($day == $isWeekday) {
                echo "<td>$day $indonesianMonthName $year</td>";
                // Tampilkan status sesuai dengan nilai $tidakHadir
                echo "<td>";
                if ($tidakHadir !== null) {
                    echo $tidakHadir;
                } elseif ($libur->holiday_date == $tanggalLibur) {
                    echo implode("  ", $keterangan);
                } else {
                    echo implode("<br>", $keterangan);
                }
                echo "</td>";
                echo "<td >";
                if (!empty($statusJam)) {
                    echo implode(", ", $statusJam);
                } else {
                    echo "-";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
    }
}

function keteranganRekapBulanan($userId, $year, $month)
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

    // mengambil data presensi per tiap bulan/tahun
    $presensiList = $presensiModel->getPresensiData($userId, $year, $month);

    for ($day = 1; $day <= $numDays; $day++) {
        // Determine if the day is a Sunday
        $isSunday = date('N', mktime(0, 0, 0, $month, $day, $year)) == 7;

        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        $isWeekday = ($dayOfWeek >= 1 && $dayOfWeek <= 6);
        // dd($day);
        // Tanggal saat ini
        $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        // $jamPresensi = strtotime(date('H:i:s', strtotime('08:00:00')));
        $tanggalLibur = date('Y-m-d', strtotime($currentDate));
        $tidakHadir = "<span class='text-secondary font-weight-bold'><i class='ri-close-circle-line'></i> Tidak Hadir</span>";
        $tidakHadirSakit = "<span class='text-secondary font-weight-bold'><i class='ri-hospital-line'></i> Sakit</span>";
        $keterangan = array();
        $statusJam = array();

        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('Y-m-d', strtotime($presensi->tanggal));
            $presensiCreated = date('Y-m-d', strtotime($presensi->created_on));
            // jam perbandingan dengan waktu presensinya
            $jamPresensi = strtotime('08:00:00');
            $jamTidakHadir = strtotime('00:00:00');
            $isWFH = $presensi->is_wfh; // Ambil data is_wfh
            $isSakit = $presensi->is_sakit;

            if ($isWeekday && $tanggalPresensi == $currentDate) {
                // Presensi ditemukan untuk tanggal ini
                $foundPresensi = true;
                $waktuPresensi = strtotime(date('H:i:s', strtotime($presensi->created_on)));
                if ($waktuPresensi == $jamTidakHadir) {
                    if ($isSakit) {
                        $keterangan[] = $tidakHadirSakit;
                        $tidakHadir = null;
                    }
                }

                if ($waktuPresensi <= $jamPresensi && $waktuPresensi != $jamTidakHadir) {
                    $keterangan[] = "<span class='text-success font-weight-bold'><i class='ri-checkbox-circle-line'></i> Berhadir</span>";
                    $statusJam[] = "<span class='text-success font-weight-bold'>Jam " .  date('H:i', $waktuPresensi) . " Pagi <i class='ri-checkbox-circle-line'></i></span>";
                    // Ubah $tidakHadir menjadi null jika ada data presensi
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                } elseif ($waktuPresensi > $jamPresensi) {
                    $keterangan[] = "<span class='text-warning font-weight-bold'><i class='ri-error-warning-line'></i> Terlambat</span>";
                    $statusJam[] = "<span class='text-warning font-weight-bold'>Terlambat (" . floor(($waktuPresensi - $jamPresensi) / 60) . "menit) <i class='ri-error-warning-line'></i></span>";
                    $tidakHadir = null;
                    // Tambahkan keterangan WFH jika is_wfh bernilai 1
                    if ($isWFH == 1) {
                        $keterangan[] = "<span class='text-info font-weight-bold'><i class='ri-home-4-line'></i> WFH</span>";
                    }
                }
                break;
            }
            if ($isWeekday && $presensiCreated == $currentDate) {
                $tidakHadir = null;
            }
        }

        // Mendapatkan status hari libur
        foreach ($dataLibur as $libur) {
            if ($libur->holiday_date == $tanggalLibur) {
                $keterangan[] = "<span class='text-danger font-weight-bold'>Libur Nasional</span>";
                $tidakHadir = null;
                break;
            } else {
                $tooltip = '';
            }
        }

        //ISI TABLE
        if (strtotime($currentDate) <= strtotime(date('Y-m-d'))) {
            echo "<tr>";
            if ($day == $isWeekday) {
                echo "<td>$day $indonesianMonthName $year</td>";
                // Tampilkan status sesuai dengan nilai $tidakHadir
                echo "<td>";
                if ($tidakHadir !== null) {
                    echo $tidakHadir;
                } elseif ($libur->holiday_date == $tanggalLibur) {
                    echo implode("  ", $keterangan);
                } else {
                    echo implode("<br>", $keterangan);
                }
                echo "</td>";
                echo "<td >";
                if (!empty($statusJam)) {
                    echo implode(", ", $statusJam);
                } else {
                    echo "-";
                }
                echo "</td>";
                echo "<td>";
                echo "<button type='button' class='btn btn-sm btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Edit
                    </button>
                    <div class='dropdown-menu ' style='z-index: 1000;'>
                        <a class='dropdown-item text-info' data-toggle='modal' data-target='#modalJamMasuk$day-$userId'> <svg xmlns='http://www.w3.org/2000/svg' width='18' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                <path stroke-linecap='round' stroke-linejoin='round' d='M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10' />
                            </svg>Jam Masuk</a>
                            <div class='dropdown-divider'></div>
                        <a class='dropdown-item text-info' data-toggle='modal' data-target='#modalWFH$day-$userId'> <svg xmlns='http://www.w3.org/2000/svg' width='18' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25' />
                            </svg>WFH</a>
                            <div class='dropdown-divider'></div>
                        <a class='dropdown-item text-info' data-toggle='modal' data-target='#modalKehadiran$day-$userId'> <svg xmlns='http://www.w3.org/2000/svg' width='18' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z' />
                            </svg>Kehadiran</a>
                    </div>
                </div>";
                echo "</td>";
            }
            echo "</tr>";
        }
    }
}

function checkBoxWFH($isWfh)
{
    $ci = &get_instance();
    // $presensiModel = new PresensiModel();
    $presensi = PresensiModel::where('is_wfh', $isWfh)->first();
    // dd($presensi);
    if ($presensi) {
        return 'checked="checked"';
    } else {
        return '';
    }
}

function countTanggal($tanggalAwal, $tanggalAkhir)
{
    $date1 = new DateTime($tanggalAwal);
    $date2 = new DateTime($tanggalAkhir);

    $interval = new DateInterval('P1D'); // P1D adalah interval 1 hari
    $dateRange = new DatePeriod($date1, $interval, $date2);

    $count = 0;

    foreach ($dateRange as $date) {
        $dayOfWeek = $date->format('N'); // Mendapatkan hari dalam format ISO (1 = Senin, 7 = Minggu)

        // Jika bukan hari Minggu (7), tambahkan ke hitungan
        if ($dayOfWeek != 7) {
            $count++;
        }
    }

    return $count;
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
