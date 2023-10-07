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
                                <div class="col-md-12">
                                    <h4 class="text-center">Rekap Presensi</h4>
                                </div>
                                <div class="col-md-3">
                                    <ul class="nav nav-tabs" id="myTab-1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bulanan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tahunan</a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="tab-content" id="myTabContent-2">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
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