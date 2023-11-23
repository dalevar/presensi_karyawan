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
                                        <a class="nav-link" id="v-pills-keterlambatan-tab" data-toggle="pill" href="#v-pills-keterlambatan" role="tab" aria-controls="v-pills-keterlambatan" aria-selected="true">Setting Keterlambatan</a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">WFH</a>
                                        <a class="nav-link" id="v-pills-sakit-tab" data-toggle="pill" href="#v-pills-sakit" role="tab" aria-controls="v-pills-sakit" aria-selected="false">Alokasi Sakit</a>
                                        <a class="nav-link" id="v-pills-secret-tab" data-toggle="pill" href="#v-pills-secret" role="tab" aria-controls="v-pills-secret" aria-selected="false">Client Secret</a>

                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="tab-content mt-0" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="row">
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
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-keterlambatan" role="tabpanel" aria-labelledby="v-pills-keterlambatan-tab">
                                            <div class="card col-md-6">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Setting Keterlambatan</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="<?= base_url('admin/konfigurasi/settingKeterlambatan') ?>" method="POST">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <?php foreach ($konfig as $kf) : ?>
                                                                    <?php if ($kf->nama == 'kali_keterlambatan') : ?>
                                                                        <label for="kali_keterlambatan">Kali Keterlambatan : <span class="text-secondary"> <?= $kf->nilai ?></span> <span class="text-secondary">x</span>
                                                                        </label>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                <input type="number" id="kali_keterlambatan" name="kali_keterlambatan" class="form-control" min="1" value="<?= set_value('settingKeterlambatan') ?>">
                                                                <?= form_error('kali_keterlambatan', '<small class="text-danger">', '</small>') ?>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-sm mt-2 float-lg-right">Simpan</button>
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
                                        <div class="tab-pane fade" id="v-pills-secret" role="tabpanel" aria-labelledby="v-pills-secret-tab">
                                            <div class="card col-md-6">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Client Secret</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="date-icon-set">
                                                        <input type="password" class="form-control" value="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">
                                                        <span class="search-link">
                                                            <button class="btn p-0 copy ml-2" data-toggle="tooltip" data-placement="top" title="Copy client secret">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                                                </svg>
                                                            </button>
                                                            <button class="btn p-0 hide">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                                                </svg>
                                                            </button>
                                                        </span>
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

<script>
    $(document).ready(function() {
        const textInput = $(".form-control");
        const copyButton = $(".copy");
        const hideButton = $(".hide");

        copyButton.on("click", function() {
            const textToCopy = textInput.val();
            navigator.clipboard.writeText(textToCopy).then(function() {
                // Berhasil menyalin teks
                console.log("Teks telah disalin ke clipboard: " + textToCopy);

                // Ubah atribut data-placement dan title
                copyButton.attr("data-placement", "top");
                copyButton.attr("title", "Teks telah disalin");
                copyButton.tooltip('dispose').tooltip();
            }).catch(function(err) {
                // Gagal menyalin teks
                console.error("Gagal menyalin teks: " + err);
            });
        });

        hideButton.on("click", function() {
            if (textInput.attr("type") === "password") {
                textInput.attr("type", "text");
                textInput.select(); // Memilih teks di dalam input
                document.execCommand("copy");
                hideButton.html('<svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>');
            } else {
                textInput.attr("type", "password");
                hideButton.html('<svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path></svg>');
            }
        });
    });
</script>