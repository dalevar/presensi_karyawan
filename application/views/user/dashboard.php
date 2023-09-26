<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Dashboard</h4>
                </div>
                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>"></div>
            </div>
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h5 class="mb-2 font-weitght-bold">Tidak Hadir Bulan Ini</h5>
                                        <div class="justify-content-start align-items-center">
                                            <h6 class="mb-2 font-weight-bold  text-secondary">Tidak Hadir : <span class="text-danger"><?= $hitungBulanIni ?> Hari</span></h6>
                                            <h6 class="mb-0 font-weight-bold  text-secondary">Terlambat : <span class="text-warning"><?= $terlambatBulanIni ?> Menit</span></h6>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;">Akumulasi Bulan ini</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <h5 class="mb-2 font-weitght-bold">Tidak Hadir Tahun Ini</h5>
                                        <div class="justify-content-start align-items-center">
                                            <h6 class="mb-2 font-weight-bold  text-secondary">Tidak Hadir :
                                                <span class="text-danger"><?= $hitungTahunIni ?> Hari</span>
                                            </h6>
                                            <h6 class="mb-0 font-weight-bold  text-secondary">Terlambat :
                                                <span class="text-warning"><?= $terlambatTahunIni ?> Menit</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;">Akumulasi Tahun ini</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="">
                                <h5 class="mb-2 font-weight-bold">Jabatan : <?= $jabatan->jabatan; ?></h5>
                                <div class="d-flex flex-wrap justify-content-start align-items-center">
                                    <h5 class="mb-0 font-weight-bold text-secondary">Tahun Kerja :
                                        <?php if (isset($tahun_kerja)) : ?>
                                            <?php echo $tahun_kerja; ?> Tahun /
                                            <?php echo $bulan_kerja; ?> Bulan /
                                            <?php echo $hari_kerja; ?> Hari
                                        <?php endif; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body mx-auto">
                                <div class="">
                                    <h4 class="font-weight-bold text-center mb-2">Scan Presensi</h4>
                                </div>
                                <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-50">
                                </a>
                                <!-- <form action="<?= base_url('presensi') ?>" method="get">
                                    <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-50">
                                    <input type="hidden" name="user_id" value="<?= $karyawan->user_id ?>">
                                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                                    <input type="hidden" name="created_by" value="<?= $karyawan->id ?>">
                                    <input type="hidden" name="waktuabsen" value="<?= $tanggal . ' ' . date('H:i:s') ?>">
                                </form> -->
                                <div class="form-group mb-0 d-flex flex-row justify-content-center mt-2">
                                    <div class="date-icon-set mr-3 border pl-2 pr-2 py-2 rounded bg-secondary">
                                        <span class="">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="25" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?= $tanggal ?></span>
                                    </div>
                                    <div class="date-icon-set border pl-2 pr-2 py-2 rounded bg-secondary">
                                        <span id="clock" onload="currentTime()">
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="25" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-center mt-3 undeline-dark ">
                                    <p>Status :
                                        <span id="status">
                                            <span id="statusText"></span>
                                            <i id="statusIcon" class=""></i>

                                        </span>
                                    </p>
                                </div>
                                <!-- <button class="btn btn-secondary btn-sm d-block mx-auto" data-toggle="modal" data-target="#qrCode">Scan Absen</button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body " style="position: relative;">
                                <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                    <h5 class="card-title">Presensi Bulan ini</h5>
                                    <!-- <div class="form-group mb-0 d-flex flex-row">
                                        <div class="col-md-8">
                                            <select name="" aria-controls="" class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="">Januari</option>
                                                <option value="">Februari</option>
                                                <option value="">Maret</option>
                                                <option value="">April</option>
                                                <option value="">Mei</option>
                                                <option value="">Juni</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <select name="" aria-controls="" class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="">2023</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- <span class="text-small text-secondary">September, 2023</span> -->
                                <!-- <div class="inline float-right">
                                </div> -->
                                <!-- <table id="datatable" class="table data-table table-striped table-bordered table-responsive-sm">
                                    <thead class="table-color-heading">
                                        <tr>
                                            <th width="15%">Tanggal Presensi</th>
                                            <th width="20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($status as $st) : ?>
                                            <tr>
                                                <td><?= $st['tanggal']; ?></td>
                                                <td><?= $st['status']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <!-- <?php foreach ($tanggalBulan as $tl) : ?>
                                            <tr>
                                                <td><?= $tl; ?></td>
                                                <td>
                                                    <?php
                                                    $hari = date('N', strtotime($tl)); //hari (1 = Senin, 7 = Minggu)

                                                    if ($hari == 7) {
                                                        echo "Libur";
                                                    } else {
                                                        $status = getStatusLibur($tl);
                                                        echo $status;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?> -->
                                <!-- </tbody>
                                </table> -->
                                <!-- <div id="calendar"></div> -->
                                <div class="gc-calendar">
                                    <div class="gc-calendar-header">
                                        <span class="gc-calendar-month-year">
                                            <span class="month">September</span>
                                            <span class="year"> 2023</span>
                                        </span>
                                        <div class="d-flex flex-wrap col-sm justify-content-end">
                                            <select id="monthSelector" class="mx-1 mt-1"></select>
                                            <select id="yearSelector" class="mx-1 mt-1"></select>
                                        </div>
                                    </div>

                                    <table class="calendar slide-in-left" style="">
                                        <thead>
                                            <tr>
                                                <?php
                                                $namaHariThead = []; // Inisialisasi array untuk nama-nama hari
                                                // Tentukan hari pertama dalam seminggu (misalnya, hari Minggu)
                                                $hariPertama = strtotime('Sunday');

                                                // Loop untuk menampilkan nama hari sesuai dengan hari pertama dalam seminggu
                                                for ($i = 0; $i < 7; $i++) {
                                                    // Hitung tanggal dan nama hari sesuai dengan hari pertama
                                                    $tanggalHari = date('Y-m-d', strtotime("+$i days", $hariPertama));
                                                    $namaHari = getNamaHari($tanggalHari);
                                                    $namaHariThead[] = $namaHari; // Tambahkan nama hari ke array
                                                ?>
                                                    <th class="dayname"><?php echo $namaHari; ?></th>
                                                <?php } ?>

                                                <!-- <?php
                                                        // Tentukan hari pertama dalam seminggu (misalnya, hari Minggu)
                                                        $hariPertama = strtotime('Sunday');

                                                        // Loop untuk menampilkan nama hari sesuai dengan hari pertama dalam seminggu
                                                        for ($i = 0; $i < 7; $i++) {
                                                            // Hitung tanggal dan nama hari sesuai dengan hari pertama
                                                            $tanggalHari = date('Y-m-d', strtotime("+$i days", $hariPertama));
                                                            $namaHari = getNamaHari($tanggalHari);
                                                        ?>
                                                    <th class="dayname"><?php echo $namaHari; ?></th>
                                                <?php } ?> -->
                                            </tr>
                                        </thead>

                                        <!-- <thead>
                                            <tr>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Sunday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Monday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Tuesday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Wednesday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Thursday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Friday'))) ?></th>
                                                <th class="dayname"><?php echo getNamaHari(date('Y-m-d', strtotime('Saturday'))) ?></th>
                                            </tr>
                                        </thead> -->
                                        <!-- <tbody>
                                            <?php
                                            // Loop untuk menampilkan tanggal sesuai dengan nama hari
                                            foreach ($getTanggal as $tanggal) {
                                                // Mengambil nama hari dari tanggal menggunakan getNamaHari
                                                $namaHari = getNamaHari($tanggal);
                                                // Mengambil tanggal dalam format "d" dari tanggal
                                                $tanggalD = date('d', strtotime($tanggal));
                                            ?>
                                                <tr>
                                                    <?php
                                                    // Loop untuk menghasilkan sel-sel dengan tanggal
                                                    for ($j = 0; $j < 7; $j++) {
                                                        // Tampilkan sel kosong jika nama hari tidak sesuai dengan thead
                                                        if ($namaHari !== $namaHariThead[$j]) {
                                                    ?>
                                                            <td class="day"></td>
                                                            <?php } else {
                                                            // Periksa apakah hari ini adalah hari Minggu
                                                            $isHariMinggu = (date('D', strtotime($tanggal)) === 'Sun');
                                                            if ($isHariMinggu) {
                                                            ?>
                                                                <td class="day current-month event"><a type="button" class="btn-gc-cell"><span class="day-number" style="color:red"><?php echo $tanggalD; ?></span></a>
                                                                    <div class="gc-event badge bg-danger">Libur</div>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="day">
                                                                    <a type="button" class="btn-gc-cell">
                                                                        <span class="day-number" style=""><?php echo $tanggalD; ?></span>
                                                                    </a>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody> -->

                                        <!-- <tbody>
                                            <tr>
                                                <td class="day prev-month">
                                                    <a type="button" class="btn-gc-cell">
                                                        <span class="day-number" style="">27</span>
                                                    </a>
                                                </td>
                                                <td class="day prev-month"><a type="button" class="btn-gc-cell"><span class="day-number" style="">28</span></a></td>
                                                <td class="day prev-month"><a type="button" class="btn-gc-cell"><span class="day-number" style="">29</span></a></td>
                                                <td class="day prev-month"><a type="button" class="btn-gc-cell"><span class="day-number" style="">30</span></a></td>
                                                <td class="day prev-month"><a type="button" class="btn-gc-cell"><span class="day-number" style="">31</span></a></td>
                                                <td class="day current-month"><a type="button" class="btn-gc-cell"><span class="day-number" style="">1</span></a></td>
                                                <td class="day current-month event"><a type="button" class="btn-gc-cell"><span class="day-number" style="color:red">2</span></a>
                                                    <div class="gc-event badge bg-danger">Saturday free</div>
                                                </td>
                                            </tr>
                                        </tbody> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade bd-example-modal-lg" id="qrCode" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?= base_url('presensi') ?>" method="get">
                                <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-75">

                        </div>
                        <div class="col-md-6">
                            <input type="hidden" name="user_id" value="<?= $karyawan->user_id ?>">
                            <label for="">Nama</label>
                            <input type="text" class="form-control mb-3" value="<?= $karyawan->nama ?>" name="karyawan" readonly>
                            <label for="">Waktu Absen</label>
                            <input type="text" class="form-control mb-3" value="<?= $absen['created_on'] ?>" name="waktuabsen" readonly>
                            <label for="">Tanggal Hari Ini</label>
                            <input type="text" class="form-control mb-3" value="<?= $absen['tanggal'] ?>" name="tanggal" readonly>
                            <p>Absen nama : <?= $karyawan->nama ?></p>
                            <input type="hidden" name="created_by" value="<?= $karyawan->id ?>">
                            <button type="submit" class="btn btn-sm btn-info">Absen</button>
                        </div>
                        </form>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div> -->
<!-- <script>
    $(function(e) {
        var calendar = $("#calendar").calendarGC({
            dayBegin: 0,
            prevIcon: '&#x3c;',
            nextIcon: '&#x3e;',
            onPrevMonth: function(e) {
                console.log("prev");
                console.log(e);
            },
            onNextMonth: function(e) {
                console.log("next");
                console.log(e);
            },
            events: getHoliday(),
            onclickDate: function(e, data) {
                console.log(e, data);
            }
        });
    });

    // function getHoliday() {
    //     var d = new Date();
    //     var totalDay = new Date(d.getFullYear(), d.getMonth(), 0).getDate();
    //     var events = [];

    //     for (var i = 1; i <= totalDay; i++) {
    //         var newDate = new Date(d.getFullYear(), d.getMonth(), i);
    //         if (newDate.getDay() == 0) { //if Sunday
    //             events.push({
    //                 date: newDate,
    //                 eventName: "Libur",
    //                 className: "badge bg-danger",
    //                 onclick(e, data) {
    //                     console.log(data);
    //                 },
    //                 dateColor: "red"
    //             });
    //         }

    //     }
    //     return events;
    // }

    // getHoliday()
</script> -->

<script>
    // JavaScript untuk mengatur header kalender
    const monthSelector = document.getElementById('monthSelector');
    const yearSelector = document.getElementById('yearSelector');
    const todayButton = document.getElementById('today');

    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    let currentDate = new Date();

    // Isi dropdown bulan
    months.forEach((month, index) => {
        const option = document.createElement('option');
        option.value = index;
        option.textContent = month;
        monthSelector.appendChild(option);
    });

    // Isi dropdown tahun (sebelumnya dari tahun ini hingga 10 tahun yang lalu)
    const currentYear = currentDate.getFullYear();
    for (let year = currentYear; year >= currentYear - 10; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelector.appendChild(option);
    }

    // Fungsi untuk memperbarui tampilan kalender
    function updateCalendar() {
        const selectedMonth = parseInt(monthSelector.value);
        const selectedYear = parseInt(yearSelector.value);
        currentDate = new Date(selectedYear, selectedMonth, 1);
        renderCalendar();
    }

    // Fungsi untuk merender kalender
    function renderCalendar() {
        // Tambahkan kode untuk merender kalender sesuai dengan bulan dan tahun yang dipilih
        // ...
    }

    // Tambahkan event listener ke dropdown bulan dan tahun
    monthSelector.addEventListener('change', updateCalendar);
    yearSelector.addEventListener('change', updateCalendar);

    todayButton.addEventListener('click', () => {
        currentDate = new Date();
        monthSelector.value = currentDate.getMonth();
        yearSelector.value = currentDate.getFullYear();
        renderCalendar();
    });

    // Panggil fungsi pertama kali untuk merender kalender saat halaman dimuat
    updateCalendar();
</script>

<script>
    //FULL CALENDAR
    // $(document).ready(function() {
    //     var calendarEl = document.getElementById('calendar');

    //     var calendar = new FullCalendar.Calendar(calendarEl, {
    //         locale: 'id', // Bahasa Indonesia
    //         editable: false,
    //         // events: events, // Anda dapat menambahkan sumber acara di sini jika diperlukan
    //         businessHours: {
    //             // Hari Senin sampai Sabtu adalah hari kerja (jam kerja yang Anda inginkan)
    //             daysOfWeek: [1, 2, 3, 4, 5, 6],
    //             startTime: '08:00', // Jam mulai kerja
    //             endTime: '17:00' // Jam akhir kerja
    //         },
    //         eventRender: function(info) {
    //             if (info.event.start.getDay() === 0) {
    //                 // Hari Minggu adalah hari libur
    //                 info.el.style.backgroundColor = 'red'; // Atur latar belakang merah
    //                 info.el.style.borderColor = 'red'; // Atur warna border merah
    //             }
    //         }
    //     });

    //     calendar.render();
    // });

    //WAKTU
    function currentTime() {
        let date = new Date();
        let options = {
            timeZone: 'Asia/Makassar',
            hour12: false
        };
        let timeString = date.toLocaleTimeString('en-US', options);

        var status = (date.getHours() < 8) ? 'Tidak Terlambat' : 'Terlambat';

        // Mengganti ikon berdasarkan status
        var statusIcon = document.getElementById('statusIcon');
        statusIcon.className = (status === 'Terlambat') ? 'ri-calendar-close-fill' : 'ri-calendar-check-fill';

        // Mengganti teks status
        var statusText = document.getElementById('statusText');
        statusText.innerText = status;

        // Menambahkan class CSS berdasarkan status
        var statusElement = document.getElementById('status');
        statusElement.classList.remove('text-warning', 'text-success'); // Hapus class yang ada
        statusElement.classList.add((status === 'Terlambat') ? 'text-warning' : 'text-success'); // Tambahkan class yang sesuai

        document.getElementById('clock').innerText = timeString;

        let t = setTimeout(function() {
            currentTime()
        }, 1000);
    }

    currentTime();
</script>