<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Rekap Presensi</h4>
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