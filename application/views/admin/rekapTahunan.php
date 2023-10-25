<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold"><?= $title ?></h4>
                </div>
                <?php if ($this->session->flashdata('berhasil')) : ?>
                    <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>
                <?php elseif ($this->session->flashdata('gagal')) : ?>
                    <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>
                <?php endif; ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex flex-wrap">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>

                <div class="col-md-12">
                    <?php $no = 1;
                    $presensi = new PresensiModel();

                    foreach ($karyawanList as $karyawan) {
                        $userId = $karyawan->user_id;
                        $tidakHadirBulanan = $presensi->tidakHadirBulanan($userId, $month);
                        $totalTerlambatBulanan = $presensi->totalTerlambatBulanTahun($userId, $year, $month);
                        $wfhBulanan = totalWFHBulanan($userId, $month);
                        $tidakHadirSakitBulanan = $presensi->hitungTotalSakitBulanan($userId, $month);


                        $wfh = totalWFH($userId, $year);
                        $totalCuti = sisaCutiTahunan($userId, $year);
                        $tidakHadirTahunan = $presensi->tidakHadirTahunan($userId, $year);
                        $totalTerlambat = totalTerlambatTahun($userId, $year);

                        $no++;
                        echo "<div class='card' id='karyawanDetail$no' style='display:none'>
                            <div class='card-header'>
                            <div class='float-right'>
                            <button type='button' class='ml-2 mb-1 close' data-dismiss='card' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>
                                <div class='row'>
                                <div class='col-md-12 mb-4 mt-1'>
                                <div class='d-flex flex-wrap justify-content-between align-items-center'>
                                    <div class='col-md-3'>
                                         <div class='card'>
                                            <div class='card-body'>
                                            <div class='d-flex flex-wrap justify-content-between'>
                                          <div class=''>
                                              <h4 class='mb-2 font-weitght-bold'>Rekap Presensi Bulan <span class='text-secondary'>$monthName</span></h4>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='card'>
                                            <div class='card-body'>
                                                <div class='d-flex align-items-end'>
                                                    <div class=''>
                                                        <h4 class='mb-2 font-weitght-bold'>Tidak Hadir</h4>
                                                        <div class='justify-content-start align-items-center'>
                                                        <h5 class='mb-2 font-weight-bold  text-secondary'>
                                                        <span class='text-danger'>$tidakHadirBulanan Hari</span>
                                                        |
                                                        <span class='text-danger'>$tidakHadirSakitBulanan Hari Sakit</span>
                                                    </h5>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                            </div>
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='card'>
                                            <div class='card-body'>
                                                <div class='d-flex align-items-end'>
                                                    <div class=''>
                                                        <h4 class='mb-2 font-weitght-bold'>Terlambat</h4>
                                                        <div class='justify-content-start align-items-center'>
                                                            <h5 class='mb-2 font-weight-bold  text-warning'>
                                                                $totalTerlambatBulanan
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                            </div>
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='card'>
                                            <div class='card-body'>
                                                <div class='d-flex align-items-end'>
                                                    <div class=''>
                                                        <h4 class='mb-2 font-weitght-bold'>WFH</h4>
                                                        <div class='justify-content-start align-items-center'> ";

                        if (empty($wfhBulanan)) {
                            echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                                    <span class='text-info'>- Hari <i class='ri-home-4-line'></i></span>
                                                </h5>";
                        } else {
                            echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                                    <span class='text-info'>" . $wfhBulanan . " Hari <i class='ri-home-4-line'></i></span>
                                                </h5>";
                        }

                        echo "</div>
                                                    </div>
                                                    
                                                </div>
                                                <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                            </div>
                                            </div>
                                        </div>
                                        <div class='col-md-3'>
                                            <div class='card'>
                                            <div class='card-body'>
                                                <div class='d-flex align-items-end'>
                                                    <div class=''>
                                                        <h4 class='mb-2 font-weitght-bold'>$karyawan->nama</h4>
                                                        <div class='justify-content-start align-items-center'>
                                                            <h5 class='mb-2 font-weight-bold  text-secondary'>
                                                                $karyawan->jabatan
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                                </div>
                                </div>
                                </div> ";
                        echo "<div class='col-lg-12 col-md-12'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='card'>
                                            <div class='card-body ' style='position: relative;'>
                                                <div class='d-flex flex-wrap justify-content-between align-items-center pr-3'>
                                                    <h5 class='card-title'>Rekap Presensi</h5>
                                                </div> ";
                        echo "<table class='table  table-striped table-bordered'>";
                        echo "<thead class='table-color-heading'>
                                <tr>
                                    <th width='10%'>Tanggal</th>
                                    <th width='10%'>Status</th>
                                    <th width='10%'>Jam Presensi</th>
                                    <th width='5%'>Action</th>
                                </tr>
                            </thead>";
                        echo "<tbody> ";
                        keteranganRekapBulanan($userId, $year, $month);
                        // dd(keteranganRekapBulanan($userId, $year, $month));
                        echo " </tbody> ";
                        echo "</table> ";
                        echo "</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";

                        echo "<div class='card' id='karyawanDetailTahunan$no' style='display:none'>
                        <div class='card-header'>
                        <div class='float-right'>
                        <button type='button' class='ml-2 mb-1 close' data-dismiss='card' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                        </button>
                        </div>
                            <div class='row'>
                            <div class='col-md-12 mb-4 mt-1'>
                            <div class='d-flex flex-wrap justify-content-between align-items-center'>
                                <div class='col-md-3'>
                                     <div class='card'>
                                        <div class='card-body'>
                                        <div class='d-flex flex-wrap justify-content-between'>
                                      <div class=''>
                                          <h4 class='mb-2 font-weitght-bold'>Keterangan Rekap Presensi Tahun <span class='text-secondary'>$year</span></h4>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='card'>
                                        <div class='card-body'>
                                            <div class='d-flex align-items-end'>
                                                <div class=''>
                                                    <h4 class='mb-2 font-weitght-bold'>Tidak Hadir</h4>
                                                    <div class='justify-content-start align-items-center'>
                                                        <h5 class='mb-2 font-weight-bold  text-danger'>
                                                            $tidakHadirTahunan Hari
                                                        </h5>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                        </div>
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='card'>
                                        <div class='card-body'>
                                            <div class='d-flex align-items-end'>
                                                <div class=''>
                                                    <h4 class='mb-2 font-weitght-bold'>Terlambat</h4>
                                                    <div class='justify-content-start align-items-center'>
                                                        <h5 class='mb-2 font-weight-bold  text-warning'>
                                                            $totalTerlambat
                                                        </h5>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                        </div>
                                        </div>
                                    </div>
                                    <div class='col-md-2'>
                                        <div class='card'>
                                        <div class='card-body'>
                                            <div class='d-flex align-items-end'>
                                                <div class=''>
                                                    <h4 class='mb-2 font-weitght-bold'>WFH</h4>
                                                    <div class='justify-content-start align-items-center'> ";

                        if (empty($wfh)) {
                            echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                                <span class='text-danger'>-</span>
                                            </h5>";
                        } else {
                            echo "<h5 class='mb-2 font-weight-bold  text-secondary'>
                                                <span class='text-info'>"  . $wfh . " Hari <i class='ri-home-4-line'></i></span>
                                            </h5>";
                        }

                        echo "</div>
                                                </div>
                                                
                                            </div>
                                            <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                        </div>
                                        </div>
                                    </div>
                                    <div class='col-md-3'>
                                        <div class='card'>
                                        <div class='card-body'>
                                            <div class='d-flex align-items-end'>
                                                <div class=''>
                                                    <h4 class='mb-2 font-weitght-bold'>$karyawan->nama</h4>
                                                    <div class='justify-content-start align-items-center'>
                                                        <h5 class='mb-2 font-weight-bold  text-secondary'>
                                                            $karyawan->jabatan
                                                        </h5>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <h6 class='text-secondary font-weight-bold d-flex flex-wrap justify-content-end' style='opacity: 0.5;'><?= $year ?></h6>
                                        </div>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            </div>
                            </div> ";
                        echo "<div class='col-lg-12 col-md-12'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='card'>
                                        <div class='card-body ' style='position: relative;'>
                                            <div class='d-flex flex-wrap justify-content-between align-items-center pr-3'>
                                                <h5 class='card-title'>Rekap Presensi</h5>
                                            </div> ";
                        echo "<table class='table  table-striped table-bordered'>";
                        echo "<thead class='table-color-heading'>
                            <tr>
                            <th width='10%'>Jumlah Hari Kerja</th>
                            <th width='10%'>Bulan</th>
                            <th width='10%'>Berhadir</th>
                            <th width='15%'>Tidak Hadir</th>
                            <th width='10%'>Terlambat</th>
                            <th width='10%'>WFH</th>
                            <th width='10%'>Sisa Cuti</th>
                            </tr>
                        </thead>";
                        echo "<tbody> ";
                        generateDataRekapTahunan($userId, $year);

                        echo " </tbody> ";
                        echo "</table> ";
                        echo "</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                        echo "  </div>
                            ";
                    }
                    ?>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>

                            <?php elseif ($this->session->flashdata('gagal')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>

                            <?php endif; ?>
                            <!-- <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>"></div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="d-flex justify-content-center">Rekap Presensi</h4>
                                    <span class="d-flex justify-content-center font-weight-bold text-secondary"><?= $monthName . ' ' . $year ?></span>

                                </div>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="bulanan-tab" data-toggle="tab" href="#bulanan" role="tab" aria-controls="home" aria-selected="true">Bulanan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tahunan-tab" data-toggle="tab" href="#tahunan" role="tab" aria-controls="profile" aria-selected="false">Tahunan</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <div class="tab-content" id="myTabContent-2">
                                        <div class="tab-pane fade show active" id="bulanan" role="tabpanel" aria-labelledby="bulanan-tab">
                                            <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row justify-content-end">
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
                                            <table id="datatable" class="table data-table table-bordered table-striped">
                                                <thead class='table-color-heading'>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Jabatan</th>
                                                        <th width='15%'>Jumlah Hadir</th>
                                                        <th width='15%'>Jumlah Tidak Hadir</th>
                                                        <th width='15%'>Total Menit Keterlambatan</th>
                                                        <th widht='5%'>WFH</th>
                                                        <th width='12%'>Sisa Alokasi Cuti (10 Hari)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $year = date('Y');
                                                    $month = isset($_GET['month']) ? $_GET['month'] : date('n');

                                                    // $tanggal = date("$year-$month");
                                                    generateRekapBulanan($year, $month); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tahunan" role="tabpanel" aria-labelledby="tahunan-tab">
                                            <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row justify-content-end">
                                                <div class="date-icon-set">
                                                    <select class="form-control mb-3 " id="year" name="year">
                                                        <?php
                                                        // Loop untuk menampilkan opsi tahun
                                                        $tahunSekarang = date("Y");
                                                        for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                                            // Tampilkan opsi tahun
                                                            $selected = ($tahun == $tahunSekarang) ? 'selected' : '';
                                                            echo "<option value='{$tahun}' $selected>{$tahun}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span class="flex-grow-0 mx-2 my-1">
                                                    <button onclick='updateRekapTahunan()' class='btn-sm btn-secondary inline-block'><i class='ri-calendar-fill'></i></button>
                                                </span>
                                            </div>
                                            <table id="datatable" class="table data-table table-bordered table-striped">
                                                <thead class='table-color-heading'>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Jabatan</th>
                                                        <th width='15%'>Jumlah Hadir</th>
                                                        <th width='15%'>Jumlah Tidak Hadir</th>
                                                        <th width='15%'>Total Menit Keterlambatan</th>
                                                        <th widht='5%'>WFH</th>
                                                        <th width='12%'>Sisa Alokasi Cuti (10 Hari)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                                    $month = date('n');

                                                    // $tanggal = date("$year-$month");
                                                    generateRekapTahunan($year, $month); ?>
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

<?php
$firstDay = mktime(0, 0, 0, $month, 1, $year);
$numDays = date('t', $firstDay);

// Ambil daftar karyawan
$karyawanModel = new KaryawanModel();
$karyawanList = $karyawanModel->getKaryawan();
//Data Presensi
$presensiModel = new PresensiModel();

// mengambil data presensi per tiap bulan/tahun
foreach ($karyawanList as $karyawan) {
    $userId = $karyawan->user_id;
    for ($day = 1; $day <= $numDays; $day++) {
        $waktuPresensi = '-';
        $isWfh = 0;
        $isSakit = 0;
        $presensiList = $presensiModel->getPresensiData($userId, $year, $month);

        foreach ($presensiList as $presensi) {
            $tanggalPresensi = date('d', strtotime($presensi->created_on));
            $tanggal = date('Y-m-d H:i:s', strtotime($presensi->tanggal));
            // $isWfh = $presensi->is_wfh;
            // $isSakit = $presensi->is_sakit;

            if ((int) $tanggalPresensi == $day) {
                // Jika tanggal presensi cocok dengan tanggal saat ini dalam loop, setel $waktuPresensi
                $waktuPresensi = date('H:i:s', strtotime($presensi->created_on));
                $isWfh = $presensi->is_wfh;
                $isSakit = $presensi->is_sakit;
            }
        }
        //EDIT JAM MASUK
        echo '<div class="modal fade" id="modalJamMasuk' . $day . '-' . $userId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Edit Jam Masuk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <div class="modal-body">
        <form action="' . base_url('admin/RekapTahunan/adminEditJamMasuk') . '" method="POST">
        <input type="hidden" name="userId" value="' . $userId . '">
        <input type="hidden" name="tanggal" value="' . $day . '">
        <input type="text" name="jam_masuk" class="form-control" placeholder="" value="' . $waktuPresensi . '">
        </div>
        <div class="modal-footer">
            <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
    </div>
</div>
</div>';

        // EDIT WFH
        echo '<div class="modal fade" id="modalWFH' . $day . '-' . $userId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Edit WFH</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <div class="modal-body">
       <input type="hidden" name="userId" value="' . $userId . '">
       <input type="hidden" name="tanggal" value="' . $day . '">
        <div class="form-check checkbox d-inline-block mr-3">
                    <input type="checkbox" class="form-check-inputWFH checkbox-input bg-info" name="iswfh" id="wfh' . $day . '-' . $userId . '" data-user-id="' . $userId . '" data-tanggal="' . $day . '" ' . ($isWfh ? 'checked' : '') . '>
                    <label for="iswfh' . $day . '-' . $userId . '">WFH</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>';

        // EDIT Kehadiran
        echo '<div class="modal fade" id="modalKehadiran' . $day . '-' . $userId . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Edit WFH</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <div class="modal-body">
       <input type="hidden" name="userId" value="' . $userId . '">
       <input type="hidden" name="tanggal" value="' . $day . '">
        <div class="form-check checkbox d-inline-block mr-3">
                    <input type="checkbox" class="form-check-inputSakit checkbox-input bg-info" name="isSakit" id="wfh' . $day . '-' . $userId . '" data-user-id="' . $userId . '" data-tanggal="' . $day . '" ' . ($isSakit ? 'checked' : '') . '>
                    <label for="isSakit' . $day . '-' . $userId . '">Sakit ?</label>
                </div>
        </div>
        <div class="modal-footer">
            <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>';
    }
}
?>

<script>
    $('.form-check-inputWFH').on('click', function() {
        const userId = $(this).data('user-id');
        const tanggal = $(this).data('tanggal');
        const isChecked = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: '<?= base_url('admin/RekapTahunan/adminEditWFH'); ?>',
            method: "POST",
            data: {
                userId: userId,
                tanggal: tanggal,
                isWfh: isChecked,
                "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
            },
            success: function(response) {
                console.log(response);
                document.location.href = '<?= base_url('admin/rekapTahunan'); ?>';
            },
            error: function(xhr, status, error) {
                console.log("AJAX error: " + error);
            }
        });
    });
</script>

<script>
    $('.form-check-inputSakit').on('click', function() {
        const userId = $(this).data('user-id');
        const tanggal = $(this).data('tanggal');
        const isChecked = $(this).prop('checked') ? 1 : 0;
        $.ajax({
            url: '<?= base_url('admin/RekapTahunan/adminEditSakit'); ?>',
            method: "POST",
            data: {
                userId: userId,
                tanggal: tanggal,
                isSakit: isChecked,
                "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
            },
            success: function(response) {
                console.log(response);
                document.location.href = '<?= base_url('admin/rekapTahunan'); ?>';
            },
            error: function(xhr, status, error) {
                console.log("AJAX error: " + error);
            }
        });
    });
</script>

<script>
    function updateRekapBulanan() {
        var selectedMonth = document.getElementById('month').value;

        window.location.href = 'rekapTahunan?month=' + selectedMonth;
    }

    function updateRekapTahunan() {

        var selectedYear = document.getElementById('year').value;
        window.location.href = 'rekapTahunan?year=' + selectedYear;
    }
</script>

<script>
    $(document).ready(function() {
        // Ketika tombol "Detail" diklik
        $('button.text-danger').click(function() {
            var targetId = $(this).data('target');
            $(targetId).slideToggle();
        });
    });

    $(document).ready(function() {
        // Ketika tombol "Detail" diklik
        $('button.btn-action').click(function() {
            var targetId = $(this).data('target');
            $(targetId).slideToggle();
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Ketika tombol "Detail" diklik
        $('button.toggleDetailButton').click(function() {
            var targetId = $(this).data('target');
            $(targetId).slideToggle();
        });
    });
    $(document).ready(function() {
        // Ketika tombol "Detail" diklik
        $('button.toggleDetailButtonTahunan').click(function() {
            var targetId = $(this).data('target');
            $(targetId).slideToggle();
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Ketika tombol "close" diklik
        $('.close').click(function() {
            var $card = $(this).closest('.card');
            $card.stop().slideUp(500); // Menghentikan animasi sebelumnya dan memulai slide baru
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Fungsi untuk menampilkan modal edit saat tombol "Edit" diklik
        $('a[data-toggle="modal"]').click(function() {
            var targetModal = $(this).attr('data-target');
            $(targetModal).modal('show');
        });
    });
</script>