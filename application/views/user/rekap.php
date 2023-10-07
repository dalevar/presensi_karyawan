<div class="content-page">
    <div class="container-fluid">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 mb-4 mt-1">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="font-weight-bold">Rekap Presensi
                            <br>
                            <span class="font-weight-bold text-secondary h6"><?= $monthName . ' ' . $year ?></span>
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
                            <span class="mx-1"></span>
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
                                <button onclick='updateRekap()' class='btn-sm btn-secondary inline-block'><i class='ri-calendar-fill'></i></button>
                            </span>
                        </div>
                    </div>
                    <!-- <div class="d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Rekap Presensi</h4>
                            <h6 class="text-secondary text-left"><?= $monthName . ' ' . $year ?></h6>
                        </div>
                        <div class="toolbar d-flex align-items-center">
                            <div class="d-flex mt-2 mb-4 float-right">
                                <div class="form-group mb-0 vanila-daterangepicker d-flex flex-row">
                                    <div class="col-md-6">
                                        <select class="form-control mb-3" id='bulan' name='bulan'>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <?= $selected = ($i == $month) ? 'selected' : ''; ?>
                                                <option value="<?= $i ?>" <?= $selected ?>> <?= getIndonesianMonth(date("F", mktime(0, 0, 0, $i, 1, $year))) ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control mb-3 " id="tahun" name="tahun">
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

                                    <button onclick='updateCalendar()' class='btn-sm btn-secondary'><i class='ri-calendar-fill'></i></button>

                                </div>
                            </div>
                        </div>
                    </div> -->

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
                                                    <span class="text-warning"><?= $totalTerlambat ?> Menit</span>
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
                                            <h4 class="mb-0 font-weitght-bold">Tidak Hadir</h4>
                                            <div class="justify-content-start align-items-center">
                                                <h5 class="mb-0 font-weight-bold  text-secondary">
                                                    <span class="text-danger"><?= $tidakHadir ?></span>
                                                </h5>
                                                <span class="text-warning font-weight-bold">Sisa (<?= $sisaHari ?> Hari)</span>
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
                                        <h5 class="mb-2 font-weight-bold  text-secondary">
                                            <span class="text-danger">2 Hari</span>
                                        </h5>
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
                                    <h5 class="card-title">List Presensi</h5>
                                </div>
                                <table id="datatable" class="table data-table table-striped table-bordered">
                                    <thead class="table-color-heading">
                                        <tr>
                                            <th width="20%">Tanggal</th>
                                            <th>Keterangan</th>
                                            <th width="20%">Jam Presensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
                                        $month = isset($_GET['month']) ? $_GET['month'] : date('n');
                                        $userId = $karyawan->user_id;
                                        // $tanggal = date("$year-$month");
                                        generateBodyTable($userId, $year, $month); ?>
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


<script>
    function updateRekap() {
        var selectedMonth = document.getElementById('month').value;
        var selectedYear = document.getElementById('year').value;
        window.location.href = 'rekap?year=' + selectedYear + '&month=' + selectedMonth;
    }
</script>