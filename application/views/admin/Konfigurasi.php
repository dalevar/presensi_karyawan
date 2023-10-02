<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="font-weight-bold"><?= $title ?></h4>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb d-flex flex-wrap">
                                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>"><i class="ri-home-4-line mr-1 float-left"></i>Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                                </ol>
                            </nav>
                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>

                            <?php elseif ($this->session->flashdata('gagal')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>

                            <?php endif; ?>
                            <!-- <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>"></div> -->
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="nav flex-column nav-pills text-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Pengaturan Jam</a>
                                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Pengaturan Hari</a>

                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="tab-content mt-0" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                            <div class="card">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">Jam Mulai Presensi</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="" method="post">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="masuk">Jam Masuk : </label>
                                                                <input type="text" id="masuk" name="masuk">
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label for="masuk">Jam Berakhir : </label>
                                                                <input type="text" id="masuk" name="masuk">
                                                            </div>
                                                            <button class="btn btn-primary btn-sm inline flex mx-auto">Simpan</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                            <div class="card">
                                                <div class="card-header d-flex">
                                                    <div class="header-title">
                                                        <h4 class="card-title">WFH</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <form action="" method="post">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="masuk">Jam Masuk : </label>
                                                                <input type="text" id="masuk" name="masuk">
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <label for="masuk">Jam Berakhir : </label>
                                                                <input type="text" id="masuk" name="masuk">
                                                            </div>
                                                            <button class="btn btn-primary btn-sm inline flex">Simpan</button>

                                                        </div>
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