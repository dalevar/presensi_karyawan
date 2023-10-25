<div class="content-page">
    <div class="container-fluid">
        <div class="card-header">
            <div class="row d-flex flex-wrap justify-content-between align-items-center mx-auto mb-3">
                <ul class="nav nav-tabs" id="myTab-two" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tahunan-tab" data-toggle="tab" href="#tahunan" role="tab" aria-controls="tahunan" aria-selected="true">Tahunan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bulanan-tab" data-toggle="tab" href="#bulanan" role="tab" aria-controls="bulanan" aria-selected="false">Bulanan</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent-1">
                <div class="tab-pane fade show active" id="tahunan" role="tabpanel" aria-labelledby="tahunan-tab">
                    <div class="row">
                        <div class="col-md-12 mb-4 mt-1">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <h4 class="font-weight-bold">Rekap Presensi
                                    <br>
                                    <span class="font-weight-bold text-secondary h6"><?= $year ?></span>
                                </h4>
                                <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                                    <div class="date-icon-set">
                                        <select class="form-control mb-3 " id="year" name="year">
                                            <?php
                                            $tahunSekarang = date("Y");
                                            $tahunDipilih = isset($_GET['year']) ? $_GET['year'] : $tahunSekarang; // Ambil tahun dari permintaan HTTP jika tersedia, jika tidak, gunakan tahun saat ini
                                            for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                                $selected = ($tahun == $tahunDipilih) ? 'selected' : '';
                                                echo "<option value='$tahun' $selected>$tahun</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span class="flex-grow-0 mx-2 my-1">
                                        <button onclick='updateRekapTahunan()' class='btn-sm btn-secondary inline-block'><i class='ri-calendar-fill'></i></button>
                                    </span>
                                </div>
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
                                                    <h4 class="mb-2 font-weitght-bold">Total Terlambat</h4>
                                                    <div class="justify-content-start align-items-center">

                                                        <h5 class="mb-2 font-weight-bold  text-secondary">
                                                            <span class="text-warning"><?= $totalTerlambat ?></span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $year ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <h4 class="mb-2 font-weitght-bold">Total Tidak Hadir</h4>
                                                    <div class="justify-content-start align-items-center">
                                                        <h5 class="mb-2 font-weight-bold text-secondary">
                                                            <span class="text-danger"><?= $tidakHadirTahunan ?> Hari </span>| <span class="text-danger"><?= $tidakHadirSakitTahunan ?> Hari Sakit</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $year ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <h5 class="mb-2 font-weitght-bold">WFH </h5>
                                            <div class="justify-content-start align-items-center">
                                                <?php
                                                if (empty($wfh)) {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-info'>-</span>
                                        </h5>";
                                                } else {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-info'>"  . $wfh . " Hari <i class='ri-home-4-line'></i></span>
                                        </h5>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $year ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <h5 class="mb-2 font-weitght-bold">Sisa Cuti</h5>
                                            <div class="justify-content-start align-items-center">
                                                <?php
                                                if (empty($totalCuti)) {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-secondary'>Tidak ada</span>
                                        </h5>";
                                                } else {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-danger'>" . $totalCuti . " Hari</span>
                                        </h5>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $year ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body " style="position: relative;">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                            <h5 class="card-title">Rekap Pertahun</h5>
                                        </div>
                                        <table class="table  table-striped table-bordered">
                                            <thead class="table-color-heading">
                                                <tr>
                                                    <th width="10%">Jumlah Hari Kerja</th>
                                                    <th width="10%">Bulan</th>
                                                    <th width="10%">Berhadir</th>
                                                    <th width="15%">Tidak Hadir</th>
                                                    <th width='10%'>Terlambat</th>
                                                    <th width="10%">WFH</th>
                                                    <th width="10%">Sisa Cuti</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                                // $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                                $userId = $karyawan->user_id;
                                                // $tanggal = date("$year-$month");
                                                generateDataRekapTahunan($userId, $year);
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="bulanan" role="tabpanel" aria-labelledby="bulanan-tab">
                    <div class="row">
                        <div class="col-md-12 mb-4 mt-1">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <h4 class="font-weight-bold">Rekap Presensi
                                    <br>
                                    <span class="font-weight-bold text-secondary h6"><?= $monthName  ?></span>
                                </h4>
                                <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                                    <div class="date-icon-set">
                                        <select class="form-control mb-3" id='month' name='month'>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <?= $selected = ($i == $month) ? 'selected' : ''; ?>
                                                <option value="<?= $i ?>" <?= $selected ?>> <?= getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <span class="flex-grow-0 mx-2 my-1">
                                        <button onclick='updateRekapBulanan()' class='btn-sm btn-secondary inline-block'><i class='ri-calendar-fill'></i></button>
                                    </span>
                                </div>
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
                                                    <h4 class="mb-2 font-weitght-bold">Total Terlambat</h4>
                                                    <div class="justify-content-start align-items-center">
                                                        <h5 class="mb-2 font-weight-bold  text-secondary">
                                                            <span class="text-warning"><?= $totalTerlambatBulanan ?> </span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $monthName ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <h4 class="mb-2 font-weitght-bold">Total Tidak Hadir</h4>
                                                    <div class="justify-content-start align-items-center">
                                                        <h5 class="mb-2 font-weight-bold  text-secondary">
                                                            <span class="text-danger"><?= $tidakHadirBulanan ?> Hari</span>
                                                            |
                                                            <span class="text-danger"><?= $tidakHadirSakitBulanan ?> Hari Sakit</span>
                                                        </h5>

                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $monthName ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <h5 class="mb-2 font-weitght-bold">WFH</h5>
                                            <div class="justify-content-start align-items-center">
                                                <?php
                                                if (empty($wfhBulanan)) {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-info'>-</span>
                                        </h5>";
                                                } else {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-info'>" . $wfhBulanan . " Hari</span>
                                        </h5>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $monthName ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <h5 class="mb-2 font-weitght-bold">Sisa Cuti</h5>
                                            <div class="justify-content-start align-items-center">
                                                <?php
                                                if (empty($totalCutiBulanan)) {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-danger'>-</span>
                                        </h5>";
                                                } else {
                                                    echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                            <span class='text-danger'>" . $totalCutiBulanan . " Hari</span>
                                        </h5>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="text-secondary font-weight-bold d-flex flex-wrap justify-content-end" style="opacity: 0.5;"><?= $monthName ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body " style="position: relative;">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center pr-3">
                                            <h5 class="card-title">Rekap Bulanan</h5>
                                        </div>
                                        <table class="table  table-striped table-bordered">
                                            <thead class="table-color-heading">
                                                <tr>
                                                    <th width="10%">Tanggal</th>
                                                    <th width="10%">Status</th>
                                                    <th width="10%">Jam Presensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                                $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                                $userId = $karyawan->user_id;
                                                // $tanggal = date("$year-$month");
                                                generateRekap($userId, $year, $month);
                                                ?>
                                            </tbody>
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
</div>
</div>
</div>


<script>
    function updateRekapTahunan() {
        // var selectedMonth = document.getElementById('month').value;
        var selectedYear = document.getElementById('year').value;
        window.location.href = 'rekap?year=' + selectedYear;
    }

    function updateRekapBulanan() {
        // var selectedMonth = document.getElementById('month').value;
        var selectedMonth = document.getElementById('month').value;
        window.location.href = 'rekap?month=' + selectedMonth;
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-gc-cell').click(function() {
            $('#tahunan-tab').removeClass('active');
            $('#bulanan-tab').addClass('active');
            var targetTab = $(this).data('target-tab');
            $('#bulanan-tab').tab('show');
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Tambahkan event listener untuk tombol "Detail" pada setiap bulan
        <?php for ($month = 1; $month <= 12; $month++) { ?>
            $("#toggleDetailButton<?php echo $month; ?>").click(function() {
                $("#statusList<?php echo $month; ?>").slideToggle("slow"); // Menampilkan atau menyembunyikan elemen "Detail"
            });

            $("#waktuDetailButton<?php echo $month; ?>").click(function() {
                $("#waktu<?php echo $month; ?>").slideToggle("slow"); // Menampilkan atau menyembunyikan elemen "Detail"
            });

            $("#WFHDetailButton<?php echo $month; ?>").click(function() {
                $("#WFH<?php echo $month; ?>").slideToggle("slow"); // Menampilkan atau menyembunyikan elemen "Detail"
            });
            $("#cutiDetailButton<?php echo $month; ?>").click(function() {
                $("#cuti<?php echo $month; ?>").slideToggle("slow"); // Menampilkan atau menyembunyikan elemen "Detail"
            });
        <?php } ?>
    });
</script>


<script>
    $(document).ready(function() {
        // Ambil nilai month dari parameter URL "?month=9")
        var urlParams = new URLSearchParams(window.location.search);
        var selectedMonth = urlParams.get('month');

        if (selectedMonth) {
            // Temukan ID tab 
            var tabID = 'bulanan';
            $('.nav-tabs a[href="#' + tabID + '"]').tab('show');
        }

        // Menangani klik pada tombol dengan atribut data-month
        $('body').on('click', '.btn-gc-cell', function(e) {
            e.preventDefault();

            // Dapatkan nilai data-month dari tombol yang diklik
            var month = $(this).data('month');

            // Dapatkan nilai tahun dari elemen select tahun
            var year = $('#year').val();

            // Kirimkan ke URL yang sesuai dengan year dan month
            var url = 'http://localhost/presensi_karyawan/user/rekap?year=' + year + '&month=' + month;
            window.location.href = url;
        });

    });
</script>