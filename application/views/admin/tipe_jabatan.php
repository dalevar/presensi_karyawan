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

                            <button type="button" class="btn btn-primary mb-2 float-right" data-toggle="modal" data-target=".bd-example-modal-xl">Tambah</button>

                            <?php
                            //$this->view('message') 
                            ?>

                            <?php if ($this->session->flashdata('berhasil')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>" data-type="success"></div>

                            <?php elseif ($this->session->flashdata('gagal')) : ?>
                                <div id="flash" data-flash="<?= $this->session->flashdata('gagal') ?>" data-type="error"></div>

                            <?php endif; ?>
                            <!-- <div id="flash" data-flash="<?= $this->session->flashdata('berhasil') ?>"></div> -->

                            <ul class="nav nav-tabs mt-5 col-md-12" id="myTab-two" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-two" data-toggle="tab" href="#Tipe" role="tab" aria-controls="home" aria-selected="true">Tipe</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-two" data-toggle="tab" href="#Jabatan" role="tab" aria-controls="profile" aria-selected="false">Jabatan</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent-1">
                                <div class="tab-pane fade show active" id="Tipe" role="tabpanel" aria-labelledby="home-tab-two">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th width="18%">No</th>
                                                <th width="30%">Tipe</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($tipe as $tp) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $tp->tipe ?></td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm mx-3" data-toggle="modal" data-target="#editTipe<?= $tp->id ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg></button>
                                                        <button class="btn btn-danger btn-sm mx-3" data-toggle="modal" data-target="#hapusTipe<?= $tp->id ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />


                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Jabatan" role="tabpanel" aria-labelledby="profile-tab-two">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th width="18%">No</th>
                                                <th width="30%">Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            foreach ($jabatan as $jb) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $jb->jabatan ?></td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm mx-3" data-toggle="modal" data-target="#editJabatan<?= $jb->id ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm mx-3" data-toggle="modal" data-target="#hapusJabatan<?= $jb->id ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

<!-- Modal Tambah -->
<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tipe & Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/tipe_jabatan/tambahTipeJabatan') ?>" method="POST">
                    <div class="form-group">
                        <label for="">Nama Tipe</label>
                        <input type="text" class="form-control" name="tipe">
                        <?= form_error('tipe', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Jabatan</label>
                        <input type="text" class="form-control" name="jabatan">
                        <?= form_error('jabatan', '<small class="text-danger">', '</small>') ?>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Tambah -->

<!-- TIPE -->
<!-- Modal Edit Tipe -->
<?php $no = 0;
foreach ($tipe as $tp) : $no++; ?>
    <div class="modal fade edit-TipeModal" id="editTipe<?= $tp->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tipe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/tipe_jabatan/EditTipe/' . $tp->id) ?>" method="POST">
                        <div class="form-group">
                            <label for="">Nama Tipe</label>
                            <input type="hidden" value="<?= $tp->id ?>" name="id">

                            <input type="text" class="form-control" name="tipe" value="<?= $tp->tipe ?>">
                            <?= form_error('tipe', '<small class="text-danger">', '</small>') ?>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Modal Edit Tipe -->

<!-- Modal Hapus Tipe -->
<?php $no = 0;
foreach ($tipe as $tp) : $no++ ?>
    <div class="modal fade bd-example-modal-sm" id="hapusTipe<?= $tp->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Tipe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/Tipe_jabatan/hapusTipe/' . $tp->id) ?>" method="POST">
                        <input type="hidden" id="editId" name="id" value="<?= $tp->id ?>">
                        <div class="form-group">
                            <label for="" class="h6">Anda Yakin Hapus Data Tipe ?</label>
                            <input type="text" class="form-control" name="tipe" value="<?= $tp->tipe; ?>" readonly>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="btnHapus" data-id="<?= $tp->id ?>">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Hapus tipe -->

<!-- JABATAN -->
<!-- Edit Jabatan -->
<?php $no = 0;
foreach ($jabatan as $jb) : $no++; ?>
    <div class="modal fade edit-TipeModal" id="editJabatan<?= $jb->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tipe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/tipe_jabatan/EditJabatan/' . $jb->id) ?>" method="POST">
                        <div class="form-group">
                            <label for="">Nama Jabatan</label>
                            <input type="hidden" value="<?= $jb->id ?>" name="id">

                            <input type="text" class="form-control" name="jabatan" value="<?= $jb->jabatan ?>">
                            <?= form_error('tipe', '<small class="text-danger">', '</small>') ?>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Jabatan -->

<!-- Modal Hapus Jabatan -->
<?php $no = 0;
foreach ($jabatan as $jb) : $no++ ?>
    <div class="modal fade bd-example-modal-sm" id="hapusJabatan<?= $jb->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Hapus Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/Tipe_jabatan/hapusJabatan/' . $jb->id) ?>" method="POST">
                        <input type="hidden" id="editId" name="id" value="<?= $jb->id ?>">
                        <div class="form-group">
                            <label for="" class="h6">Anda Yakin Hapus Data Jabatan ?</label>
                            <input type="text" class="form-control" name="jabatan" value="<?= $jb->jabatan; ?>" readonly>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="btnHapus" data-id="<?= $jb->id ?>">Hapus</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<!-- End Hapus Jabatan -->