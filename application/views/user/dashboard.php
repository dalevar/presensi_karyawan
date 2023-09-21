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
                                            <h6 class="mb-2 font-weight-bold  text-secondary">Tidak Hadir : <span class="text-danger"><?= $ketidak_hadir_bulan_ini ?></span></h6>
                                            <h6 class="mb-0 font-weight-bold  text-secondary">Terlambat : <span class="text-warning"></span></h6>
                                        </div>
                                    </div>
                                </div>
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
                                            <h6 class="mb-2 font-weight-bold  text-secondary">Tidak Hadir : <span class="text-danger"></span></h6>
                                            <h6 class="mb-0 font-weight-bold  text-secondary">Terlambat : <span class="text-warning"></span></h6>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="header-title">
                                    <h5 class="card-title">Presensi Bulan ini</h5>
                                </div>
                                <table id="datatable" class="table data-table table-striped table-bordered">
                                    <thead class="table-color-heading">
                                        <tr>
                                            <th width="15%">Tanggal Presensi</th>
                                            <th width="20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($absensi) : ?>
                                            <!-- Jika ada data presensi -->
                                            <tr>
                                                <td><?= $absensi->tanggal ?></td>
                                                <td><?= getStatusPresensi($absensi->created_on) ?></td>
                                            </tr>
                                        <?php else : ?>
                                            <!-- Jika tidak ada data presensi -->
                                            <tr>
                                                <td colspan="2">Belum melakukan absen</td>
                                            </tr>
                                        <?php endif; ?>

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

<script>
    function currentTime() {
        let date = new Date();
        let options = {
            timeZone: 'Asia/Makassar',
            hour12: false
        };
        let timeString = date.toLocaleTimeString('en-US', options);

        var status = (date.getHours() <= 8) ? 'Tidak Terlambat' : 'Terlambat';

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