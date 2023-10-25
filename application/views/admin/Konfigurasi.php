<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold"><?= $title ?></h4>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb d-flex flex-wrap">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
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
                                <div class="col-sm-2">
                                    <div class="nav flex-column nav-pills text-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Jam Mulai & Selesai</a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">WFH</a>
                                        <a class="nav-link" id="v-pills-sakit-tab" data-toggle="pill" href="#v-pills-sakit" role="tab" aria-controls="v-pills-sakit" aria-selected="false">Alokasi Sakit</a>

                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="tab-content mt-0" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="card col-md-6">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Jam Mulai Presensi</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?= base_url('admin/konfigurasi/PengaturanJam') ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'jam_masuk') : ?>
                                                                        <label for="jamMasuk">Jam Masuk : <span class="text-secondary"> <?= $kf->nilai ?></span>
                                                                        </label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                <!-- <input type="text" id="jamMasuk" name="waktuMasuk" class="form-control" placeholder="08:00" value="<?= set_value('waktuMasuk'); ?>"> -->
                                                                <input type="time" id="jamMasuk" name="waktuMasuk" class="form-control" value="<?= set_value('waktuMasuk'); ?>">
                                                                <?= form_error('waktuMasuk', '<small class="text-danger">', '</small>') ?>

                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'jam_berakhir') : ?>
                                                                        <label for="jamBerakhir">Jam Berakhir : <span class="text-secondary" id="periodeWaktuBerakhir"> <?= $kf->nilai ?></span></label>
                                                                        </label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>

                                                                <!-- <input type="text" id="jamBerakhir" name="waktuBerakhir" class="form-control" placeholder="17:00" value="<?= set_value('waktuBerakhir'); ?>"> -->
                                                                <input type="time" id="jamBerakhir" name="waktuBerakhir" class="form-control" value="<?= set_value('waktuBerakhir'); ?>">
                                                                <?= form_error('waktuBerakhir', '<small class="text-danger">', '</small>') ?>

                                                            </div>
                                                        </div>
                                                        <button type=" submit" class="btn btn-primary btn-sm mt-2 float-right">Simpan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="card col-md-6">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">WFH</h4>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?= base_url('admin/konfigurasi/PengaturanHari') ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'wfh') : ?>
                                                                        <label for="wfh">Pengurangan Menit : <span class="text-secondary"> <?= $kf->nilai ?> Menit</span></label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                <!-- <input type="time" id="wfh" name="wfh" class="form-control" step="60"> -->
                                                                <input type="text" id="wfh" name="wfh" class="form-control" placeholder="Menit" maxlength="2">
                                                                <?= form_error('wfh', '<small class="text-danger">', '</small>') ?>

                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm mt-2 float-right">Simpan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-sakit" role="tabpanel" aria-labelledby="v-pills-sakit-tab">
                                            <div class="card col-md-6">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Perizinan Sakit</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?= base_url('admin/konfigurasi/alokasiSakit') ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-md-12 mt-1">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'sakit') : ?>
                                                                        <label for="batasSakit">Batas Maksimal Sakit : <span class="text-secondary"> <?= $kf->nilai ?> Hari</span></label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                <input type="number" id="batasSakit" name="batasSakit" class="form-control col-md-4" min="0" value="<?= set_value('batasSakit'); ?>">
                                                                <?= form_error('batasSakit', '<small class="text-danger">', '</small>') ?>

                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'cuti_kurang') : ?>
                                                                        <label for="batasSakit">Mengurangi Cuti : <span class="text-secondary"> <?= $kf->nilai == 1 ? 'Ya' : 'Tidak' ?></span></label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="col-md-12 mt-1">
                                                                <div class="custom-control custom-radio custom-radio-color-checked custom-control-inline">
                                                                    <input type="radio" id="customRadio-1" name="customRadio-10" data-id="1" value='Ya' class="custom-control-input bg-primary" <?= set_radio('customRadio-10', 'Ya'); ?>>
                                                                    <label class="custom-control-label" for="customRadio-1"> Ya </label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-radio-color-checked custom-control-inline">
                                                                    <input type="radio" id="customRadio-5" name="customRadio-10" data-id="0" value='Tidak' class="custom-control-input bg-dark" <?= set_radio('customRadio-10', 'Tidak'); ?>>
                                                                    <label class="custom-control-label" for="customRadio-5"> Tidak </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm mt-2 float-right">Simpan</button>
                                                    </form>
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
</div>


<script>
    const inputJamBerakhir = document.getElementById('jamBerakhir');
    const inputJamMasuk = document.getElementById('jamMasuk');

    const periodeWaktuBerakhir = document.getElementById('periodeWaktuBerakhir');
    const periodeWaktuMasuk = document.getElementById('periodeWaktuMasuk');

    inputJamBerakhir.addEventListener('input', function() {
        const jamBerakhir = inputJamBerakhir.value;
        const jam = parseInt(jamBerakhir.split(':')[0]);
        let periodeWaktuBerakhir;

        if (jam >= 0 && jam < 6) {
            periodeWaktuBerakhir = "Malam";
        } else if (jam >= 6 && jam < 12) {
            periodeWaktuBerakhir = "Pagi";
        } else if (jam >= 12 && jam <= 15) {
            periodeWaktuBerakhir = "Siang";
        } else if (jam >= 15 && jam <= 18) {
            periodeWaktuBerakhir = "Sore";
        } else {
            periodeWaktuBerakhir = "Malam";
        }

        // Mengganti periodeWaktu dengan periodeWaktuMasuk.textContent
        periodeWaktuBerakhir.textContent = inputJamBerakhir.value + " " + periodeWaktuBerakhir;
    });
</script>

<script>
    $(document).ready(function() {
        // Ambil nilai terpilih awal
        var initialSelectedValue = $('input[name="customRadio-10"]:checked').val();
        $('input[type=radio]').change(function() {
            var selectedValue = $(this).val();
            var dataId = $(this).data('id');
            // Kirim data ke server menggunakan AJAX
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/Konfigurasi/cutiKurang'); ?>",
                data: {
                    id: dataId,
                    value: selectedValue
                },
                success: function(data) {

                    <?php
                    $selectedValue = '';
                    echo 'var selectedValue = ' . json_encode($selectedValue) . ';';
                    echo '$(\'input[name="customRadio-10"][value="\' + selectedValue + \'"]\').prop(\'checked\', true);';
                    ?>
                    // Jika perubahan berhasil, tetapkan nilai terpilih
                    // $('input[name="customRadio-10"][data-id="' + dataId + '"]').prop('checked', true);
                }
            });
        });
    });
</script>