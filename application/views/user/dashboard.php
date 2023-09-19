<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-4 mt-1">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold">Dashboard</h4>

                </div>
                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>"></div>

            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-2 text-secondary">Jumlah ....</p>
                                        <div class="d-flex flex-wrap justify-content-start align-items-center">
                                            <h5 class="mb-0 font-weight-bold">24</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-2 text-secondary">Jumlah ....</p>
                                        <div class="d-flex flex-wrap justify-content-start align-items-center">
                                            <h5 class="mb-0 font-weight-bold">22</h5>
                                            <p class="mb-0 ml-3 text-success font-weight-bold">+2.67%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="">
                                        <p class="mb-2 text-secondary">Jumlah .....</p>
                                        <div class="d-flex flex-wrap justify-content-start align-items-center">
                                            <h5 class="mb-0 font-weight-bold">13,984</h5>
                                            <p class="mb-0 ml-3 text-danger font-weight-bold">-9.98%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="">
                    <div class="form-group mb-0 d-flex justify-content-end">
                        <input type="date" name="start" id="dateInput" name="dateInput" class="form-control col-sm-6" value="<?= $tanggal ?>">
                    </div>

                    <div class="form-group mb-0 d-flex float-right mt-2">
                        <span><?= $tanggal ?> <div id="clock" onload="currentTime()"></div></span>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body mx-auto">
                                <div class="">
                                    <h4 class="font-weight-bold text-center mb-2">Scan QR Code</h4>
                                </div>
                                <form action="<?= base_url('presensi') ?>" method="get">
                                    <img src="<?= base_url('uploads/qrcode/' . $filename . '.png') ?>" alt="" class="d-flex mx-auto w-75">
                                    <input type="hidden" name="user_id" value="<?= $karyawan->user_id ?>">
                                    <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                                    <input type="hidden" name="created_by" value="<?= $karyawan->id ?>">
                                    <input type="hidden" name="waktuabsen" value="<?= $tanggal . ' ' . date('H:i:s') ?>">
                                </form>
                                <!-- <button class="btn btn-secondary btn-sm d-block mx-auto" data-toggle="modal" data-target="#qrCode">Scan Absen</button> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-body " style="position: relative;">
                                <table id="datatable" class="table data-table table-striped table-bordered">
                                    <thead class="table-color-heading">
                                        <tr>
                                            <th width="15%">Tanggal Presensi</th>
                                            <th width="20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($absen) : ?>
                                            <!-- Jika ada data presensi -->
                                            <tr>
                                                <td><?= $absen->tanggal ?></td>
                                                <td><?= getStatusPresensi($absen->created_on) ?></td>
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
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if (hh === 0) {
            hh = 12;
        }
        if (hh > 12) {
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;

        document.getElementById("clock").innerText = time;
        let t = setTimeout(function() {
            currentTime()
        }, 1000);
    }

    currentTime();
</script>