<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Dashboard</h4>
                </div>
                <?php if ($this->session->flashdata('berhasil')) : ?>
                    <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>

                <?php elseif ($this->session->flashdata('gagal')) : ?>
                    <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>

                <?php endif; ?>
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
                                <?php if ($existAbsen) : ?>
                                    <!-- Jika absensi sudah ada, tampilkan pesan -->
                                    <?php if ($existAbsen->created_on <= $tanggalAbsen) : ?>
                                        <div class="">
                                            <h4 class="font-weight-bold text-center mb-2">Anda Sudah Absen</h4>
                                        </div>
                                        <img src="<?= base_url('assets/images/') ?>image-absen.svg" alt="" class="w-100">
                                        <h6 class="text-secondary text-center"><?= $existAbsen->created_on ?></h6>
                                    <?php elseif ($existAbsen->created_on > $tanggalAbsen) : ?>
                                        <!-- Jika absensi terlambat -->
                                        <div class="">
                                            <h4 class="font-weight-bold text-center mb-2">Anda Sudah Absen</h4>
                                        </div>
                                        <img src="<?= base_url('assets/images/') ?>image-absen-terlambat.svg" alt="" class="w-100">
                                        <h6 class="text-secondary text-center"><?= $existAbsen->created_on ?></h6>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <div class="">
                                        <h4 class="font-weight-bold text-center mb-2">Scan Presensi</h4>
                                    </div>
                                    <!-- Jika belum absen, tampilkan tautan QR Code -->
                                    <a href="<?= site_url('presensi?data=' . base64_encode($absen) . '&filename=' . $filename) ?>">Tautan QR Code</a>

                                    <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-50">
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
                                <?php endif; ?>


                                <!-- <a href="<?= site_url('presensi?data=' . base64_encode($absen) . '&filename=' . $filename) ?>">Tautan QR Code</a>

                                <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-50">
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
                                </div> -->


                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body " style="position: relative;">
                                <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                    <h5 class="card-title">Presensi Bulan ini</h5>

                                </div>

                                <div class="gc-calendar">

                                    <?php

                                    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                    $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                    $userId = $karyawan->user_id;
                                    $tanggal = date('Y-m-d');

                                    generateCalendar($userId, $year, $month, $tanggal);

                                    ?>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
    function updateCalendar() {
        var selectedMonth = document.getElementById('month').value;
        var selectedYear = document.getElementById('year').value;

        // Lakukan panggilan AJAX ke server untuk mendapatkan data presensi baru berdasarkan bulan dan tahun yang dipilih.
        $.ajax({
            type: 'POST',
            url: '<?= base_url('user/dashboard/getPresensiData') ?>', // Ganti dengan URL yang sesuai
            data: {
                userId: <?php echo $userId; ?>,
                year: selectedYear,
                month: selectedMonth
            },
            success: function(data) {
                // Di sini Anda dapat memperbarui kalender dengan data presensi baru.

                // Ubah tanggal berdasarkan bulan dan tahun yang dipilih
                var selectedMonth = document.getElementById('month').value;
                var selectedYear = document.getElementById('year').value;

                // Misalnya, jika Anda ingin memperbarui tanggal dengan tanggal 1 bulan dan tahun yang dipilih:
                var newDate = selectedYear + '-' + selectedMonth + '-01';

                // Mengganti tanggal dalam kalender dengan tanggal yang baru
                $('#tanggal').text(newDate);

                // Memperbarui isi kalender dengan data presensi baru
                $('#presensi-data').html(data);
            }

        });
    }
</script>

<script>
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